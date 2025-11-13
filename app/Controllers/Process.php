<?php

namespace App\Controllers;

use CodeIgniter\Shield\Entities\User;
use App\Models\MaterialModel;
use App\Models\LocationModel;
use App\Models\StockModel;
use App\Models\GrHeaderModel;
use App\Models\GrDetailModel;
use App\Models\GrTempModel;

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
        $item = $this->GrTempModel->select('tbl_gr_temp.*, b.material_desc')
            ->join('mst_material b', 'tbl_gr_temp.material_number = b.material_number', 'left')
            ->where('tbl_gr_temp.username', $username)
            ->findAll();
        $data = [
            'item' => $item
        ];
        return view('process/partial/gr_temp_material_table', $data);
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

    public function create_gr_temp_material()
    {
        if ($this->request->is('post')) {
            $user = auth()->user();
            $username = $user->username;

            $qty_order = $this->empty_post('qty_order', 0);
            $qty_received = $this->empty_post('qty_received', 0);
            // $qty_remaining = max(0, $qty_order - $qty_received);

            $data = [
                'username'  => $username,
                'material_number' => $this->request->getPost('material_number'),
                'qty_order' => $qty_order,
                'qty_received' => $qty_received,
                // 'qty_remaining' => $qty_remaining,
                'uom' => $this->request->getPost('uom'),
            ];

            try {
                if ($this->GrTempModel->insert($data)) {
                    return $this->_json_response(true, 'Material created successfully');
                } else {
                    $errors = $this->GrTempModel->errors();
                    $message = implode(', ', $errors);
                    return $this->_json_response(false, $message);
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }

        return $this->_json_response(false, 'Invalid request method');
    }

    public function update_gr_temp_material()
    {
        if ($this->request->is('post')) {
            $id = $this->request->getPost('id');
            if (empty($id)) {
                return $this->_json_response(false, 'Missing ID.');
            }

            $qty_order = $this->empty_post('qty_order', 0);
            $qty_received = $this->empty_post('qty_received', 0);
            // $qty_remaining = max(0, $qty_order - $qty_received);

            $data = [
                'material_number' => $this->request->getPost('material_number'),
                'qty_order' => $qty_order,
                'qty_received' => $qty_received,
                // 'qty_remaining' => $qty_remaining,
                'uom' => $this->request->getPost('uom'),
            ];
            try {
                if ($this->GrTempModel->update($id, $data)) {
                    return $this->_json_response(true, 'Material update successfully');
                } else {
                    $errors = $this->GrTempModel->errors();
                    $message = implode(', ', $errors);
                    return $this->_json_response(false, $message);
                }
            } catch (\Exception $e) {
                return $this->_json_response(false, $e->getMessage());
            }
        }
        return $this->_json_response(false, 'Invalid request method');
    }

    public function delete_gr_temp_material()
    {
        if ($this->request->is('post')) {
            $id = $this->request->getPost('id');
            if (empty($id)) {
                return $this->_json_response(false, 'Missing ID.');
            }
            try {
                if ($this->GrTempModel->delete($id)) {
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

            $temp = $this->GrTempModel->where('username', $username)->findAll();
            if (empty($temp)) {
                return $this->_json_response(false, 'Please add at least one material 
                before submitting the GR.');
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

            $delivery_number = $this->request->getPost('delivery_number');
            $data = [
                'delivery_number' => $delivery_number,
                'vendor' => $this->request->getPost('vendor'),
                'gr_date' => $this->request->getPost('gr_date'),
                'status' => 'OPEN',
                'created_by' => $username,
            ];

            $db = \Config\Database::connect();
            $db->transStart();

            try {
                if ($this->GrHeaderModel->insert($data)) {
                    $insert_detail = $this->GrTempModel->save_detail(
                        $delivery_number,
                        $username,
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
}
