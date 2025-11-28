<?php

namespace App\Controllers;

use App\Models\MaterialModel;
use App\Models\LocationModel;
use App\Models\ProdModel;

class Select_form extends BaseController
{
    protected $MaterialModel;
    protected $LocationModel;
    protected $ProdModel;

    public function __construct()
    {
        $this->MaterialModel = new MaterialModel();
        $this->LocationModel = new LocationModel();
        $this->ProdModel = new ProdModel();
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

    public function grTempMaterialNumberSelect()
    {
        $q = $this->request->getGet('q');
        $user = auth()->user();
        $username = $user->username;

        $results = $this->MaterialModel->grTempMaterialNumberSelect($q, $username);

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

    public function plantSelect()
    {
        $q = $this->request->getGet('q');
        $results = $this->ProdModel->search_plant($q);

        $items = [];
        foreach ($results as $row) {
            $items[] = [
                'id'   => $row->plant_code,
                'name' => $row->plant_code . ' - ' . $row->plant_name
            ];
        }

        return $this->response->setJSON(['items' => $items]);
    }

    public function lineSelect()
    {
        $q = $this->request->getGet('q');
        $plant_code = $this->request->getGet('plant_code');

        $results = $this->ProdModel->search_line($q, $plant_code);

        $items = [];
        foreach ($results as $row) {
            $items[] = [
                'id'   => $row->line_code,
                'name' => $row->line_code . ' - ' . $row->line_name
            ];
        }

        return $this->response->setJSON(['items' => $items]);
    }

    public function cellSelect()
    {
        $q = $this->request->getGet('q');
        $plant_code = $this->request->getGet('plant_code');
        $line_code = $this->request->getGet('line_code');

        $results = $this->ProdModel->search_cell($q, $plant_code, $line_code);

        $items = [];
        foreach ($results as $row) {
            $items[] = [
                'id'   => $row->cell_name,
                'name' => $row->cell_name
            ];
        }

        return $this->response->setJSON(['items' => $items]);
    }
}
