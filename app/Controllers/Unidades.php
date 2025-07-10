<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\unidadesModel;

class Unidades extends BaseController{
    protected $unidades;

    public function __construct()
    {
        $this->unidades = new unidadesModel();
    }

    public function index($activo = 1){
        $unidades = $this->unidades->where('activo', $activo)->findAll();
        $data = ['titulo'=>'Unidades', 'datos'=>$unidades];

        echo view('header');
        echo view('unidades/index', $data);
        echo view('footer');
    }
}
?>