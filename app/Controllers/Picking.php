<?php

namespace App\Controllers;

use CodeIgniter\Shield\Entities\User;
use App\Models\MaterialModel;
use App\Models\LocationModel;
use App\Models\StockModel;
use App\Models\SAFGModel;
use App\Models\PickingHeaderModel;
use App\Models\PickingDetailModel;
use App\Models\GrHeaderModel;
use App\Models\GrDetailModel;
use App\Models\PutawayDetailModel;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

class Picking extends BaseController
{
    protected $MstUser;
    protected $MaterialModel;
    protected $LocationModel;
    protected $StockModel;
    protected $GrHeaderModel;
    protected $GrDetailModel;
    protected $PutawayDetailModel;
    protected $PickingHeaderModel;
    protected $PickingDetailModel;

    public function __construct()
    {
        $this->MstUser = auth()->getProvider();
        $this->MaterialModel = new MaterialModel();
        $this->LocationModel = new LocationModel();
        $this->StockModel = new StockModel();
        $this->GrHeaderModel = new GrHeaderModel();
        $this->GrDetailModel = new GrDetailModel();
        $this->PutawayDetailModel = new PutawayDetailModel();
        $this->PickingHeaderModel = new PickingHeaderModel();
        $this->PickingDetailModel = new PickingDetailModel();
    }

    private function _json_response($status, $message, $is_validation = false)
    {
        return $this->response->setJSON([
            'status' => $status,
            'message' => $message,
            'is_validation' => $is_validation,
        ]);
    }

    public function empty_post($key, $default = null)
    {
        $value = $this->request->getPost($key);
        return (isset($value) && trim($value) !== '') ? $value : $default;
    }

    public function create_po()
    {
        return view('picking/create_po', [
            'title' => 'Create PO',
        ]);
    }

    public function list()
    {
        return view('picking/list', [
            'title' => 'Picking list',
        ]);
    }

    public function picking_header_table()
    {
        $item = $this->PickingHeaderModel->findAll();
        $data = [
            'item' => $item
        ];
        return view('picking/partial/picking_header_table', $data);
    }

    public function importExcel()
    {
        $user = auth()->user();
        $username = $user->username;
        if (!$this->request->is('post')) {
            return $this->_json_response(false, 'Invalid request method');
        }

        $validationRules = [
            'excel_file' => [
                'rules' => 'uploaded[excel_file]|mime_in[excel_file,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet]',
                'errors' => [
                    'uploaded' => 'Please select an Excel file to upload.',
                    'mime_in' => 'Only .xls and .xlsx files are allowed.',
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            $errors = $this->validator->getErrors();
            $message = implode('<br>', $errors);
            return $this->_json_response(false, $message);
        }

        $file = $this->request->getFile('excel_file');

        if (!$file->isValid() || $file->hasMoved()) {
            return $this->_json_response(false, 'File upload failed.');
        }

        $newName = $file->getRandomName();
        $file->move(FCPATH . 'uploads', $newName);
        $filePath = FCPATH . 'uploads/' . $newName;

        try {
            $spreadsheet = IOFactory::load($filePath);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            $SAFGModel = new SAFGModel();
            $PickingHeaderModel = new PickingHeaderModel();

            $validData = [];
            $errors = [];
            $rowCount = 0;

            foreach ($sheetData as $i => $row) {

                if ($i == 1) continue;

                $sa_fg = trim_excel($row['A']);
                $order_qty = trim_excel($row['B']);
                $plant = trim_excel($row['C']);
                $line = trim_excel($row['D']);
                $cell = trim_excel($row['E']);

                if (!$sa_fg || !$order_qty || !$plant || !$line || !$cell) {

                    $errors[] = [
                        'row' => $i,
                        'data' => [
                            'sa_fg' => $sa_fg,
                            'order_quantity' => $order_qty,
                            'plant_code' => $plant,
                            'line_code' => $line,
                            'cell_name' => $cell,
                        ],
                        'errors' => ['Missing mandatory field']
                    ];

                    continue;
                }

                $bom = $SAFGModel
                    ->where('safg_number', $sa_fg)
                    ->where('plant_code', $plant)
                    ->where('line_code', $line)
                    ->where('cell_name', $cell)
                    ->first();

                if (!$bom) {

                    $errors[] = [
                        'row' => $i,
                        'data' => [
                            'sa_fg' => $sa_fg,
                            'order_quantity' => $order_qty,
                            'plant_code' => $plant,
                            'line_code' => $line,
                            'cell_name' => $cell,
                        ],
                        'errors' => ["BOM not found for SA FG '$sa_fg'"]
                    ];

                    continue;
                }

                $data = [
                    'order_number' => $PickingHeaderModel->generateOrderNumber(),
                    'sa_fg' => $sa_fg,
                    'order_quantity' => $order_qty,
                    'plant_code' => $plant,
                    'line_code' => $line,
                    'cell_name' => $cell,
                    'status' => 'Draft',
                    'created_by' => $username,
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $validData[] = $data;
            }

            if (!empty($errors)) {

                $html = view('picking/partial/upload_validation', [
                    'errors' => $errors
                ]);

                return $this->_json_response(false, $html, true);
            }

            if (!empty($validData)) {
                $PickingHeaderModel->insertBatch($validData);
                $rowCount = count($validData);
            }

            return $this->_json_response(true, "Upload success. $rowCount rows inserted.");
        } catch (Exception $e) {
            return $this->_json_response(false, $e->getMessage());
        }
    }

    public function updateStatus()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        if (!$id || !$status) {
            return $this->_json_response(false, "Invalid request");
        }

        $header = $this->PickingHeaderModel->find($id);
        if (!$header) {
            return $this->_json_response(false, "Picking header not found");
        }

        if ($status === "In Progress") {

            $SAFGModel = new SAFGModel();
            $PickingDetailModel = new PickingDetailModel();

            $bom = $SAFGModel
                ->select('mst_safg_bom.*, mst_material.material_desc, mst_material.uom')
                ->join('mst_material', 'mst_material.material_number = mst_safg_bom.material_number', 'left')
                ->where('safg_number', $header['sa_fg'])
                ->where('plant_code', $header['plant_code'])
                ->where('line_code', $header['line_code'])
                ->where('cell_name', $header['cell_name'])
                ->findAll();


            if (empty($bom)) {
                return $this->_json_response(false, "BOM not found. Cannot start kitting.");
            }

            $details = [];
            foreach ($bom as $item) {

                $details[] = [
                    'picking_id' => $id,
                    'material_number' => $item['material_number'],
                    'material_desc' => $item['material_desc'],
                    'qty_required' => $item['qty'] * $header['order_quantity'],
                    'location_id' => null,
                    'rack' => null,
                    'bin' => null,
                    'status' => 'Pending',
                    'created_at' => date('Y-m-d H:i:s'),
                ];
            }

            $PickingDetailModel->insertBatch($details);
        }

        $this->PickingHeaderModel->update($id, [
            'status' => $status,
            'picking_date' => date('Y-m-d'),
        ]);

        return $this->_json_response(true, "Status updated to $status");
    }
}
