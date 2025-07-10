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

    public function nuevo(){

         $data = ['titulo'=>'Agregar Unidad'];

        echo view('header');
        echo view('unidades/nuevo', $data);
        echo view('footer');
    }

    public function insertar(){
        $this->unidades->save([
            'nombre'=>$this->request->getPost('nombre'),
            'nombre_corto'=>$this->request->getPost('nombre_corto')
        ]);
        return redirect()->to(base_url().'unidades');
    }


    public function editar($id){
    try{
        $unidad = $this->unidades->where('id', $id)->first();
    
    }catch (\Exception $e) {
    exit($e->getMessage());
}
         $data = ['titulo'=>'Editar Unidad', 'datos'=>$unidad];

         

        echo view('header');
        echo view('unidades/editar', $data);
        echo view('footer');
    }
}
?>