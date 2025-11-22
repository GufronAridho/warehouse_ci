<?php

namespace App\Controllers;

use CodeIgniter\Shield\Entities\User;
use App\Models\MaterialModel;
use App\Models\LocationModel;
use App\Models\StockModel;
use App\Models\TempGrHeaderModel;
use App\Models\TempGrDetailModel;
use App\Models\GrHeaderModel;
use App\Models\GrDetailModel;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Dompdf\Dompdf;

class Process extends BaseController
{
    protected $MstUser;
    protected $MaterialModel;
    protected $LocationModel;
    protected $StockModel;
    protected $GrHeaderModel;
    protected $GrDetailModel;
    protected $TempGrHeaderModel;
    protected $TempGrDetailModel;

    public function __construct()
    {
        $this->MstUser = auth()->getProvider();
        $this->MaterialModel = new MaterialModel();
        $this->LocationModel = new LocationModel();
        $this->StockModel = new StockModel();
        $this->GrHeaderModel = new GrHeaderModel();
        $this->GrDetailModel = new GrDetailModel();
        $this->TempGrHeaderModel = new TempGrHeaderModel();
        $this->TempGrDetailModel = new TempGrDetailModel();
    }

    private function _json_response($status, $message, $temp_gr_id = null, $invoice_no = null, $vendor = null)
    {
        return $this->response->setJSON([
            'status' => $status,
            'message' => $message,
            'temp_gr_id' => $temp_gr_id,
            'invoice_no' => $invoice_no,
            'vendor' => $vendor,
            // 'csrfHash' => csrf_hash()
        ]);
    }

    public function empty_post($key, $default = null)
    {
        $value = $this->request->getPost($key);
        return (isset($value) && trim($value) !== '') ? $value : $default;
    }

    public function good_receipt_image()
    {
        return view('process/good_receipt_image', [
            'title' => 'Good Receipt',
        ]);
    }

    public function good_receipt_input()
    {
        $user = auth()->user();
        $username = $user->username;
        $tempHeaders = $this->TempGrHeaderModel->where('username', $username)->findAll();
        if (!empty($tempHeaders)) {
            foreach ($tempHeaders as $header) {
                $this->TempGrDetailModel->where('temp_id', $header['temp_id'])->delete();
            }
            $this->TempGrHeaderModel->where('username', $username)->delete();
        }
        return view('process/good_receipt_input', [
            'title' => 'Good Receipt',
            'username' => $username,
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
        $temp_gr_id = $this->request->getGet('temp_gr_id');
        $type = $this->request->getGet('type');
        $item = $this->TempGrDetailModel->select('tbl_temp_gr_detail.*, b.material_desc')
            ->join('mst_material b', 'tbl_temp_gr_detail.material_number = b.material_number', 'left')
            ->where('tbl_temp_gr_detail.temp_id', $temp_gr_id)
            ->findAll();
        $data = [
            'item' => $item,
            'type' => $type
        ];
        return view('process/partial/gr_temp_material_table', $data);
    }

    public function gr_print_detail()
    {
        $invoice_no = $this->request->getGet('invoice_no');
        $item = $this->GrDetailModel->select('tbl_gr_detail.*, b.material_desc')
            ->join('mst_material b', 'tbl_gr_detail.material_number = b.material_number', 'left')
            ->where('tbl_gr_detail.invoice_no', $invoice_no)
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

    public function create_temp_gr_header()
    {
        if ($this->request->is('post')) {
            $user = auth()->user();
            $username = $user->username;
            $invoice_no = $this->request->getPost('invoice_no');
            $vendor = $this->request->getPost('vendor');

            $data = [
                'username' => $username,
                'invoice_no' => $invoice_no,
                'vendor' => $vendor,
                'gr_date' => $this->request->getPost('gr_date'),
                'lorry_date' => $this->request->getPost('lorry_date'),
                'type' => $this->request->getPost('type'),
                'status' => 'OPEN',
                'record_date' => date('Y-m-d H:i:s')
            ];
            try {
                if ($this->TempGrHeaderModel->insert($data)) {
                    $temp_gr_id = $this->TempGrHeaderModel->getInsertID();
                    return $this->_json_response(
                        true,
                        'Temporary GR header created.',
                        $temp_gr_id,
                        $invoice_no,
                        $vendor
                    );
                } else {
                    $errors = $this->TempGrHeaderModel->errors();
                    $message = implode(', ', $errors);
                    return $this->_json_response(false, $message);
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }
        return $this->_json_response(false, 'Invalid request method');
    }

    public function scan_delivery_number()
    {
        if ($this->request->is('post')) {

            $user = auth()->user();
            $username = $user->username;

            $items = $this->request->getPost('items');
            $temp_gr_id = $this->request->getPost('temp_gr_id');
            $invoice_no = $this->request->getPost('invoice_no');

            if (!$temp_gr_id) {
                return $this->_json_response(false, 'temp_gr_id is required.');
            }

            if (!$items || !is_array($items)) {
                return $this->_json_response(false, 'Invalid data format');
            }

            try {

                foreach ($items as $row) {

                    $delivery_number = $row['delivery_number'];
                    $material_number = $row['material_number'];
                    $qty_order = floatval($row['qty_order'] ?? 0);

                    $exists = $this->TempGrDetailModel
                        ->where('temp_id', $temp_gr_id)
                        ->where('delivery_number', $delivery_number)
                        ->where('material_number', $material_number)
                        ->first();

                    if ($exists) {
                        continue;
                    }

                    $data = [
                        'temp_id' => $temp_gr_id,
                        'delivery_number' => $delivery_number,
                        'material_number' => $material_number,
                        'qty_order' => $qty_order,
                        'qty_received' => 0,
                        'uom' => $row['uom'] ?? '',
                        'shipment_id' => $row['shipment_id'] ?? null,
                        'customer_po' => $row['customer_po'] ?? null,
                        'customer_po_line' => $row['customer_po_line'] ?? null,
                        'scanned_by' => $username,
                        'scanned_at' => date('Y-m-d H:i:s'),
                        // 'validated_at' => date('Y-m-d H:i:s'),
                    ];

                    $this->TempGrDetailModel->insert($data);
                }

                return $this->_json_response(true, "Temp GR: {$invoice_no} has been recorded. You may proceed to material validation.");
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }
        return $this->_json_response(false, 'Invalid request method');
    }

    // public function scan_delivery_number()
    // {
    //     if ($this->request->is('post')) {

    //         $user = auth()->user();
    //         $username = $user->username;

    //         $items = $this->request->getPost('items');

    //         if (!$items || !is_array($items)) {
    //             return $this->_json_response(false, 'Invalid data format');
    //         }

    //         try {
    //             foreach ($items as $row) {
    //                 $delivery_number = $row['delivery_number'];
    //                 $material_number = $row['material'];
    //                 $exists = $this->GrTempModel
    //                     ->where('delivery_number', $delivery_number)
    //                     ->where('material_number', $material_number)
    //                     ->first();
    //                 if ($exists) {
    //                     continue;
    //                 }
    //                 $data = [
    //                     'delivery_number' =>  $delivery_number,
    //                     'material_number' =>  $material_number,
    //                     'qty_received' => 0,
    //                     'qty_order' => $row['qty'] ?? 0,
    //                     'uom' => $row['uom'] ?? '',
    //                     'vendor' => $row['vendor'] ?? null,
    //                     'status' => 'OPEN',
    //                     'created_by' => $username,
    //                     'created_at' => date('Y-m-d H:i:s'),
    //                 ];

    //                 $this->GrTempModel->insert($data);
    //             }

    //             return $this->_json_response(true, "Delivery {$delivery_number} has been recorded. You may proceed to material validation.");
    //         } catch (\Exception $e) {
    //             return $this->_json_response(false, $e->getMessage());
    //         }
    //     }

    //     return $this->_json_response(false, 'Invalid request method');
    // }

    public function scan_material()
    {
        if ($this->request->is('post')) {
            $user = auth()->user();
            $username = $user->username;

            $material = $this->request->getPost('material');
            $qty = $this->request->getPost('qty');
            $uom = $this->request->getPost('uom');
            $delivery_number = $this->request->getPost('delivery');

            if (!$material || !$qty || !$uom || !$delivery_number) {
                return $this->_json_response(false, "Missing fields");
            }

            $exists = $this->TempGrDetailModel
                ->where('material_number', $material)
                ->where('delivery_number', $delivery_number)
                ->first();

            if (!$exists) {
                return $this->_json_response(false, "Material not found in DO list");
            }

            $this->TempGrDetailModel->where('material_number', $material)
                ->where('delivery_number', $delivery_number)
                ->set('qty_received', "qty_received + $qty", false)
                ->set('validated_at', date('Y-m-d H:i:s'))
                ->update();

            $updated = $this->TempGrDetailModel
                ->where('material_number', $material)
                ->where('delivery_number', $delivery_number)
                ->first();

            return $this->_json_response(true, "Material validated successfully");
        }

        return $this->_json_response(false, "Invalid request");
    }

    public function delete_temp_detail()
    {
        if ($this->request->is('post')) {
            $id = $this->request->getPost('id');
            if (empty($id)) {
                return $this->_json_response(false, 'Missing ID.');
            }
            try {
                if ($this->TempGrDetailModel->delete($id)) {
                    return $this->_json_response(true, 'Material deleted successfully');
                } else {
                    return $this->_json_response(false, 'Failed to delete Material');
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method');
    }

    public function submit_gr()
    {
        if ($this->request->is('post')) {
            $user = auth()->user();
            $username = $user->username;
            $temp_gr_id = $this->request->getPost('temp_gr_id');
            if (!$temp_gr_id) {
                return $this->_json_response(false, 'Missing temporary GR ID.');
            }
            $tempHeader = $this->TempGrHeaderModel->where('temp_id', $temp_gr_id)->first();
            if (!$tempHeader) {
                return $this->_json_response(false, 'Temporary GR header not found.');
            }
            $tempDetails = $this->TempGrDetailModel->where('temp_id', $temp_gr_id)->findAll();
            if (empty($tempDetails)) {
                return $this->_json_response(false, 'No scanned materials found.');
            }
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

            $headerData = [
                'vendor' => $tempHeader['vendor'],
                'invoice_no' => $tempHeader['invoice_no'],
                'gr_date' => $tempHeader['gr_date'],
                'lorry_date' => $tempHeader['lorry_date'],
                'type' => $tempHeader['type'],
                'received_by' => $username,
                'status' => 'RECEIVED',
                'record_date' => $tempHeader['record_date'],
            ];

            $db = \Config\Database::connect();
            $db->transStart();

            try {
                if ($this->GrHeaderModel->insert($headerData)) {
                    $gr_header_id = $this->GrHeaderModel->getInsertID();
                    foreach ($tempDetails as $item) {

                        $detailData = [
                            'gr_id' => $gr_header_id,
                            'invoice_no' => $tempHeader['invoice_no'],
                            'delivery_number' => $item['delivery_number'],
                            'material_number' => $item['material_number'],
                            'qty_order' => $item['qty_order'],
                            'qty_received' => $item['qty_received'],
                            'qty_remaining' => $item['qty_order'] - $item['qty_received'],
                            'uom' => $item['uom'],
                            'shipment_id' => $item['shipment_id'],
                            'customer_po' => $item['customer_po'],
                            'customer_po_line' => $item['customer_po_line'],
                            'staging_location' => $staging_location,
                            'status' => 'RECEIVED',
                            'scanned_by' => $item['scanned_by'],
                            'scanned_at' => $item['scanned_at'],
                            'validated_at' => $item['validated_at'],
                        ];

                        $this->GrDetailModel->insert($detailData);

                        $this->StockModel->update_stock(
                            $item['material_number'],
                            $item['qty_received'],
                            $staging_location,
                            $rack,
                            $bin
                        );
                    }
                    $db->transComplete();
                    if ($db->transStatus() === false) {
                        return $this->_json_response(false, 'Transaction failed.');
                    }
                    return $this->_json_response(
                        true,
                        'Goods Receipt submitted successfully.',
                        null,
                        $tempHeader['invoice_no']
                    );
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

    public function gr_detail_label()
    {
        $material = $this->request->getGet('material');
        $qty = $this->request->getGet('qty');
        $uom = $this->request->getGet('uom');
        $delivery = $this->request->getGet('delivery');

        if (!$material || !$qty || !$uom || !$delivery) {
            return "Missing parameters!";
        }

        $qr_content = "{$delivery};{$material};{$qty};{$uom}";

        $builder = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $qr_content,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 200,
            margin: 5,
            roundBlockSizeMode: RoundBlockSizeMode::Margin
        );

        $result = $builder->build();
        $qrImage = base64_encode($result->getString());
        $data = [
            'material' => $material,
            'qty' => $qty,
            'uom' => $uom,
            'qrImage' => $qrImage,
        ];
        $html = view('process/print/gr_detail_label', $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $customPaper = [0, 0, 130, 38];
        $dompdf->setPaper($customPaper);
        $dompdf->render();
        $dompdf->stream("{$delivery}_{$material}_label.pdf", ['Attachment' => true]);
    }

    public function print_pallet_id()
    {
        $invoice_no = $this->request->getGet('invoice_no');
        $vendor = $this->request->getGet('vendor');

        if (!$invoice_no || !$vendor) {
            return "Missing parameters!";
        }


        $qr_content = "{$invoice_no};{$vendor}";

        $builder = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $qr_content,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 380,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin
        );

        $result = $builder->build();
        $qrImage = base64_encode($result->getString());

        $data = [
            'invoice_no' => $invoice_no,
            'vendor' => $vendor,
            'qrImage' => $qrImage,
        ];

        $html = view('process/print/pallet_id_label', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // Bigger label = 180mm × 70mm
        $customPaper = [0, 0, 510, 200];
        $dompdf->setPaper($customPaper);

        $dompdf->render();
        $dompdf->stream("{$invoice_no}_pallet_label.pdf", ['Attachment' => true]);
    }
}
