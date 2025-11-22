<?php

namespace App\Controllers;

use CodeIgniter\Shield\Entities\User;
use App\Models\MaterialModel;
use App\Models\LocationModel;
use App\Models\StockModel;
use App\Models\GrHeaderModel;
use App\Models\GrDetailModel;

class Summary extends BaseController
{
    protected $MstUser;
    protected $MaterialModel;
    protected $LocationModel;
    protected $StockModel;
    protected $GrHeaderModel;
    protected $GrDetailModel;

    public function __construct()
    {
        $this->MstUser = auth()->getProvider();
        $this->MaterialModel = new MaterialModel();
        $this->LocationModel = new LocationModel();
        $this->StockModel = new StockModel();
        $this->GrHeaderModel = new GrHeaderModel();
        $this->GrDetailModel = new GrDetailModel();
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

    public function good_receipt_summary()
    {
        return view('summary/good_receipt_summary', [
            'title' => 'Good Receipt',
        ]);
    }

    public function gr_header()
    {
        $item = $this->GrHeaderModel->findAll();
        $data = [
            'item' => $item
        ];
        return view('summary/partial/gr_table_header', $data);
    }

    public function gr_detail()
    {
        $item = $this->GrDetailModel->select('tbl_gr_detail.*, b.material_desc')
            ->join('mst_material b', 'tbl_gr_detail.material_number = b.material_number', 'left')
            ->findAll();
        $data = [
            'item' => $item
        ];
        return view('summary/partial/gr_table_detail', $data);
    }
}
