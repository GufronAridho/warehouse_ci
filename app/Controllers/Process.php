<?php

namespace App\Controllers;

use CodeIgniter\Shield\Entities\User;
use App\Models\MaterialModel;
use App\Models\LocationModel;
use App\Models\StockModel;
use App\Models\GrHeaderModel;
use App\Models\GrDetailModel;
use App\Models\GrTempModel;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class Process extends BaseController
{
    protected $MstUser;
    protected $MaterialModel;
    protected $LocationModel;
    protected $StockModel;
    protected $GrHeaderModel;
    protected $GrDetailModel;
    protected $GrTempModel;

    public function __construct()
    {
        $this->MstUser = auth()->getProvider();
        $this->MaterialModel = new MaterialModel();
        $this->LocationModel = new LocationModel();
        $this->StockModel = new StockModel();
        $this->GrHeaderModel = new GrHeaderModel();
        $this->GrDetailModel = new GrDetailModel();
        $this->GrTempModel = new GrTempModel();
    }

    private function _json_response($status, $message, $is_validation = false)
    {
        return $this->response->setJSON([
            'status' => $status,
            'message' => $message,
            'is_validation' => $is_validation,
            // 'csrfHash' => csrf_hash()
        ]);
    }

    public function empty_post($key, $default = null)
    {
        $value = $this->request->getPost($key);
        return (isset($value) && trim($value) !== '') ? $value : $default;
    }

    public function good_receipt()
    {
        return view('process/good_receipt', [
            'title' => 'Good Receipt',
        ]);
    }

    public function put_away()
    {
        return view('process/put_away', [
            'title' => 'Put Away',
        ]);
    }

    public function picking()
    {
        return view('process/picking', [
            'title' => 'Picking',
        ]);
    }

    public function cycle_count()
    {
        return view('process/cycle_count', [
            'title' => 'Cycle Count',
        ]);
    }

    public function gr_temp_material_table()
    {
        $user = auth()->user();
        $username = $user->username;
        $delivery_number = $this->request->getGet('delivery_number');
        $item = $this->GrTempModel->select('tbl_gr_temp.*, b.material_desc')
            ->join('mst_material b', 'tbl_gr_temp.material_number = b.material_number', 'left')
            ->where('tbl_gr_temp.delivery_number', $delivery_number)
            ->findAll();
        $data = [
            'item' => $item
        ];
        return view('process/partial/gr_temp_material_table', $data);
    }

    public function gr_print_detail()
    {
        $delivery_number = $this->request->getGet('delivery_number');
        $item = $this->GrDetailModel->select('tbl_gr_detail.*, b.material_desc')
            ->join('mst_material b', 'tbl_gr_detail.material_number = b.material_number', 'left')
            ->where('tbl_gr_detail.delivery_number', $delivery_number)
            ->findAll();
        $data = [
            'item' => $item
        ];
        return view('process/partial/gr_print_detail_table', $data);
    }

    public function modal_material_detail()
    {
        $material_number = $this->request->getGet('material_number');
        $data = $this->MaterialModel->material_detail($material_number);
        return $this->response->setJSON([
            'success' => true,
            'data' => $data
        ]);
    }

    public function scan_delivery_number()
    {
        if ($this->request->is('post')) {

            $user = auth()->user();
            $username = $user->username;

            $items = $this->request->getPost('items');

            if (!$items || !is_array($items)) {
                return $this->_json_response(false, 'Invalid data format');
            }

            try {
                foreach ($items as $row) {
                    $delivery_number = $row['delivery_number'];
                    $material_number = $row['material'];
                    $exists = $this->GrTempModel
                        ->where('delivery_number', $delivery_number)
                        ->where('material_number', $material_number)
                        ->first();
                    if ($exists) {
                        continue;
                    }
                    $data = [
                        'delivery_number' =>  $delivery_number,
                        'material_number' =>  $material_number,
                        'qty_received' => 0,
                        'qty_order' => $row['qty'] ?? 0,
                        'uom' => $row['uom'] ?? '',
                        'vendor' => $row['vendor'] ?? null,
                        'status' => 'OPEN',
                        'created_by' => $username,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];

                    $this->GrTempModel->insert($data);
                }

                return $this->_json_response(true, 'Materials inserted successfully');
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method');
    }

    public function scan_material()
    {
        if ($this->request->is('post')) {
            $user = auth()->user();
            $username = $user->username;

            $material = $this->request->getPost('material');
            $qty = $this->request->getPost('qty');
            $uom = $this->request->getPost('uom');
            $delivery_number = $this->request->getPost('delivery_number');

            if (!$material || !$qty || !$uom || !$delivery_number) {
                return $this->_json_response(false, "Missing fields");
            }

            $exists = $this->GrTempModel
                ->where('material_number', $material)
                ->where('delivery_number', $delivery_number)
                ->first();

            if (!$exists) {
                return $this->_json_response(false, "Material not found in DO list");
            }

            $this->GrTempModel->where('material_number', $material)
                ->where('delivery_number', $delivery_number)
                ->set('qty_received', "qty_received + $qty", false)
                ->set('validated_by', $username)
                ->set('validated_at', date('Y-m-d H:i:s'))
                ->update();

            $updated = $this->GrTempModel
                ->where('material_number', $material)
                ->where('delivery_number', $delivery_number)
                ->first();

            $status = "OPEN";
            if ($updated['qty_received'] > 0 && $updated['qty_received'] < $updated['qty_order']) {
                $status = "PARTIAL";
            } elseif ($updated['qty_received'] >= $updated['qty_order']) {
                $status = "COMPLETE";
            }

            $this->GrTempModel
                ->where('material_number', $material)
                ->where('delivery_number', $delivery_number)
                ->set('status', $status)
                ->update();

            return $this->_json_response(true, "Material validated successfully");
        }

        return $this->_json_response(false, "Invalid request");
    }

    public function submit_gr()
    {
        if ($this->request->is('post')) {
            $user = auth()->user();
            $username = $user->username;
            $delivery_number = $this->request->getPost('delivery_number');

            $temp_gr = $this->GrTempModel
                ->where('delivery_number', $delivery_number)
                ->first();

            $staging = $this->LocationModel
                ->where('storage_type', 'STAGING')
                ->where('is_active', 1)
                ->first();
            if (empty($staging)) {
                return $this->_json_response(false, 'No active staging location found. 
                Please configure a staging location first.');
            }
            $staging_location =  $staging['location_code'];
            $rack =  $staging['rack'];
            $bin =  $staging['bin'];

            $data = [
                'delivery_number' => $delivery_number,
                'vendor' => $temp_gr['vendor'],
                'gr_date' => date('Y-m-d'),
                'status' => 'OPEN',
                'submited_by' => $username,
                'submited_at' => date('Y-m-d H:i:s'),
            ];

            $db = \Config\Database::connect();
            $db->transStart();

            try {
                if ($this->GrHeaderModel->insert($data)) {
                    $insert_detail = $this->GrTempModel->save_detail(
                        $delivery_number,
                        $staging_location
                    );
                    if ($insert_detail) {
                        $detail = $this->GrDetailModel
                            ->where('delivery_number', $delivery_number)
                            ->findAll();
                        if (empty($detail)) {
                            $db->transRollback();
                            return $this->_json_response(false, 'No GR Detail found after insert.');
                        }
                        foreach ($detail as $item) {
                            $this->StockModel->update_stock(
                                $item['material_number'],
                                $item['qty_received'],
                                $staging_location,
                                $rack,
                                $bin,
                            );
                        }
                    }
                    $db->transComplete();
                    if ($db->transStatus() === false) {
                        return $this->_json_response(false, 'Transaction failed.');
                    }
                    return $this->_json_response(true, 'Goods Receipt submitted successfully.');
                }
                $errors = $this->GrHeaderModel->errors();
                $message = implode(', ', $errors);
                return $this->_json_response(false, $message);
            } catch (\Exception $e) {
                $db->transRollback();
                return $this->_json_response(false, $e->getMessage());
            }
        }
        return $this->_json_response(false, 'Invalid request method');
    }

    public function label()
    {
        $material = $this->request->getGet('material');
        $qty = $this->request->getGet('qty');
        $uom = $this->request->getGet('uom');

        if (!$material || !$qty || !$uom) {
            return "Missing parameters!";
        }

        $qr_content = "{$material};{$qty};{$uom}";

        $builder = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $qr_content,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin
        );

        $result = $builder->build();

        $qrImage = base64_encode($result->getString());

        return view('process/print/label', [
            'material' => $material,
            'qty' => $qty,
            'uom' => $uom,
            'qrImage' => $qrImage
        ]);
    }
}
