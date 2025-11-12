<?php

namespace App\Controllers;

use App\Models\MaterialModel;
use App\Models\LocationModel;

class Select_form extends BaseController
{
    protected $MaterialModel;
    protected $LocationModel;

    public function __construct()
    {
        $this->MaterialModel = new MaterialModel();
        $this->LocationModel = new LocationModel();
    }

    public function materialNumberSelect()
    {
        $q = $this->request->getGet('q');

        $results = $this->MaterialModel->search_material_number($q);

        $items = [];
        foreach ($results as $row) {
            $items[] = [
                'id' => $row->material_number,
                'name' => $row->material_number . ' - ' . $row->material_desc
            ];
        }
        return $this->response->setJSON(['items' => $items]);
    }

    public function storageTypeSelect()
    {
        $q = $this->request->getGet('q');
        $results = $this->LocationModel->search_storage_type($q);

        $items = [];
        foreach ($results as $row) {
            $items[] = [
                'id'   => $row->storage_type,
                'name' => $row->storage_type
            ];
        }

        return $this->response->setJSON(['items' => $items]);
    }

    public function rackSelect()
    {
        $q = $this->request->getGet('q');
        $storage_type = $this->request->getGet('storage_type');
        $results = $this->LocationModel->search_rack($q, $storage_type);

        $items = [];
        foreach ($results as $row) {
            $items[] = [
                'id'   => $row->rack,
                'name' => $row->rack
            ];
        }

        return $this->response->setJSON(['items' => $items]);
    }

    public function binSelect()
    {
        $q = $this->request->getGet('q');
        $storage_type = $this->request->getGet('storage_type');
        $rack = $this->request->getGet('rack');
        $results = $this->LocationModel->search_bin($q, $storage_type, $rack);

        $items = [];
        foreach ($results as $row) {
            $items[] = [
                'id'   => $row->bin,
                'name' => $row->bin
            ];
        }

        return $this->response->setJSON(['items' => $items]);
    }
}
