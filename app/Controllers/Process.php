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
use App\Models\PutawayDetailModel;
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
    protected $PutawayDetailModel;
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
        $this->PutawayDetailModel = new PutawayDetailModel();
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
        $temp_headers = $this->TempGrHeaderModel->where('username', $username)->findAll();
        if (!empty($temp_headers)) {
            foreach ($temp_headers as $header) {
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

    public function putaway_pallet_table()
    {
        $invoice_no = $this->request->getGet('invoice_no');

        $item = $this->GrDetailModel->select('tbl_gr_detail.*, b.material_desc')
            ->join('mst_material b', 'tbl_gr_detail.material_number = b.material_number', 'left')
            ->where('invoice_no', $invoice_no)
            ->findAll();

        $data = [
            'item' => $item,
        ];

        return view('process/partial/putaway_pallet_table', $data);
    }

    public function putaway_material_table()
    {
        $invoice_no = $this->request->getGet('invoice_no');

        $item = $this->PutawayDetailModel
            ->select("
            tbl_putaway_detail.*,
            tbl_gr_detail.delivery_number,
            tbl_gr_detail.staging_location,
            b.material_desc
        ")
            ->join("tbl_gr_detail", "tbl_gr_detail.gr_detail_id = tbl_putaway_detail.gr_detail_id", "left")
            ->join('mst_material b', 'tbl_gr_detail.material_number = b.material_number', 'left')
            ->where("tbl_gr_detail.invoice_no", $invoice_no)
            ->orderBy("tbl_putaway_detail.putaway_detail_id", "DESC")
            ->findAll();

        $data = [
            'item' => $item,
        ];

        $transfer_ids = array_column(
            array_filter($item, fn($row) => $row['status'] === 'TRANSFER'),
            'putaway_detail_id'
        );

        return $this->response->setJSON([
            'html' => view('process/partial/putaway_material_table', $data),
            'ids' => $transfer_ids
        ]);
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
            $temp_header = $this->TempGrHeaderModel->where('temp_id', $temp_gr_id)->first();
            if (!$temp_header) {
                return $this->_json_response(false, 'Temporary GR header not found.');
            }
            $temp_detail = $this->TempGrDetailModel->where('temp_id', $temp_gr_id)->findAll();
            if (empty($temp_detail)) {
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
                'vendor' => $temp_header['vendor'],
                'invoice_no' => $temp_header['invoice_no'],
                'gr_date' => $temp_header['gr_date'],
                'lorry_date' => $temp_header['lorry_date'],
                'type' => $temp_header['type'],
                'received_by' => $username,
                'status' => 'RECEIVED',
                'record_date' => $temp_header['record_date'],
            ];

            $db = \Config\Database::connect();
            $db->transStart();

            try {
                if ($this->GrHeaderModel->insert($headerData)) {
                    $gr_header_id = $this->GrHeaderModel->getInsertID();
                    foreach ($temp_detail as $item) {

                        $detailData = [
                            'gr_id' => $gr_header_id,
                            'invoice_no' => $temp_header['invoice_no'],
                            'delivery_number' => $item['delivery_number'],
                            'material_number' => $item['material_number'],
                            'qty_order' => $item['qty_order'],
                            'qty_received' => $item['qty_received'],
                            'qty_remaining' => $item['qty_received'],
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
                        $temp_header['invoice_no']
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

    public function check_location()
    {
        $location_code = $this->request->getPost('location_code');

        $location = $this->LocationModel
            ->where('location_code', $location_code)
            ->where('is_active', 1)
            ->first();

        if ($location) {
            return $this->_json_response(
                true,
                'Location exist.'
            );
        }

        return $this->_json_response(
            false,
            'Location not found or inactive.'
        );
    }

    public function scan_putaway_detail()
    {
        $delivery = $this->request->getPost('delivery');
        $material = $this->request->getPost('material');
        $qty = (float) $this->request->getPost('qty');
        $uom = $this->request->getPost('uom');
        $invoice_no = $this->request->getPost('invoice_no');

        $user = auth()->user();
        $username = $user->username;

        if (!$delivery || !$material || !$qty || !$invoice_no) {
            return $this->_json_response(false, 'Missing required fields.');
        }

        $gr = $this->GrDetailModel
            ->where('invoice_no', $invoice_no)
            ->where('delivery_number', $delivery)
            ->where('material_number', $material)
            ->first();

        if (!$gr) {
            return $this->_json_response(false, 'Material not found in GR detail.');
        }
        if ($gr['qty_remaining'] <= 0) {
            return $this->_json_response(false, 'Quantity already completed for this material.');
        }

        if ($qty > $gr['qty_remaining']) {
            return $this->_json_response(false, 'Scanned qty exceeds remaining qty.');
        }

        $existing = $this->PutawayDetailModel
            ->where('gr_detail_id', $gr['gr_detail_id'])
            ->where('material_number', $material)
            ->where('status', 'TRANSFER')
            ->first();

        if ($existing) {
            $updatedQty = (float) $existing['qty'] + $qty;

            $this->PutawayDetailModel->update($existing['putaway_detail_id'], [
                'qty' => $updatedQty,
                'uom' => $uom,
                'status' => 'TRANSFER',
                'transfer_by' => $username,
                'transfer_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            $this->PutawayDetailModel->insert([
                'gr_detail_id' => $gr['gr_detail_id'],
                'material_number' => $material,
                'from_location' => $gr['staging_location'] ?? 'STAGING',
                'to_location' => null,
                'to_rack' => null,
                'to_bin' => null,
                'qty' => $qty,
                'uom' => $uom,
                'status' => 'TRANSFER',
                'transfer_by' => $username,
                'transfer_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $new_remaining = $gr['qty_remaining'] - $qty;
        $new_status = ($new_remaining <= 0) ? 'STORED' : 'TRANSFER';

        $this->GrDetailModel->update($gr['gr_detail_id'], [
            'qty_remaining' => $new_remaining,
            'status' => $new_status,
        ]);

        return $this->_json_response(true, 'Material scanned and updated successfully.');
    }


    public function submit_putaway()
    {
        if (!$this->request->is('post')) {
            return $this->_json_response(false, 'Invalid request method.');
        }

        $user = auth()->user();
        $username = $user->username;

        $rack = $this->request->getPost('rackValue');
        $bin = $this->request->getPost('binValue');
        $expectedQR = $this->request->getPost('expectedQR');
        $scan_storage_confirm = $this->request->getPost('scan_storage_confirm');
        $idsJson = $this->request->getPost('putaway_detail_ids');
        $putawayIds = json_decode($idsJson, true);

        if (empty($putawayIds) || !is_array($putawayIds)) {
            return $this->_json_response(false, 'No putaway detail IDs received.');
        }

        if (!$rack || !$bin) {
            return $this->_json_response(false, 'Rack or Bin missing.');
        }

        if ($scan_storage_confirm !== $expectedQR) {
            return $this->_json_response(false, 'Scanned QR does not match expected location.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            foreach ($putawayIds as $id) {
                $detail = $this->PutawayDetailModel->find($id);
                if (!$detail) {
                    continue;
                }

                if (strtoupper($detail['status']) !== 'TRANSFER') {
                    continue;
                }

                $moveQty = (float) $detail['qty'];
                if ($moveQty <= 0) {
                    continue;
                }

                $fromParts = explode("|", $detail['from_location']);
                $fromLocationCode = $detail['from_location'];
                $fromRack = $fromParts[1] ?? null;
                $fromBin = $fromParts[2] ?? null;

                $stockWhere = [
                    'material_number' => $detail['material_number'],
                    'location_id' => $fromLocationCode,
                    'rack' => $fromRack,
                    'bin'  => $fromBin,
                ];

                $stockExist = $this->StockModel
                    ->where($stockWhere)
                    ->first();

                if (!$stockExist || (float)$stockExist['qty'] < $moveQty) {
                    $db->transRollback();
                    return $this->_json_response(false, "Insufficient stock for material {$detail['material_number']} at source location.");
                }

                $updateData = [
                    'to_rack' => $rack,
                    'to_bin' => $bin,
                    'to_location' => $scan_storage_confirm,
                    'status' => 'STORED',
                    'stored_by' => $username,
                    'stored_at' => date('Y-m-d H:i:s'),
                ];
                $this->PutawayDetailModel->update($id, $updateData);

                $this->StockModel->deduct_stock(
                    $detail['material_number'],
                    $moveQty,
                    $fromLocationCode,
                    $fromRack,
                    $fromBin
                );

                $this->StockModel->update_stock(
                    $detail['material_number'],
                    $moveQty,
                    $scan_storage_confirm,
                    $rack,
                    $bin
                );
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->_json_response(false, 'Transaction failed.');
            }

            return $this->_json_response(true, 'Putaway stored successfully.');
        } catch (\Exception $e) {
            $db->transRollback();
            return $this->_json_response(false, $e->getMessage());
        }
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

        $qr_content = "{$delivery};{$material};{$qty};{$uom};";

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
        ob_clean();
        $dompdf->stream("{$delivery}_{$material}_label.pdf");
        exit();
    }

    public function print_pallet_id()
    {
        $invoice_no = $this->request->getGet('invoice_no');
        $vendor = $this->request->getGet('vendor');

        if (!$invoice_no || !$vendor) {
            return "Missing parameters!";
        }


        $qr_content = "{$invoice_no};{$vendor};";

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

        $customPaper = [0, 0, 510, 200];
        $dompdf->setPaper($customPaper);

        $dompdf->render();
        ob_clean();
        $dompdf->stream("{$invoice_no}_pallet_label.pdf");
        exit();
    }
}
