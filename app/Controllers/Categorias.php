<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\categoriasModel;

class Categorias extends BaseController{

    protected $categorias;

    public function __construct()
    {
        $this->categorias = new categoriasModel();
    
    }

    public function index($activo = 1)
    {
        $categorias = $this->categorias->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Categorias', 'datos' => $categorias];

        echo view('header');
        echo view('categorias/index', $data);
        echo view('footer');
    }

        public function eliminados($activo = 0)
    {
        $categorias = $this->categorias->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Categorías', 'datos' => $categorias];

        echo view('header');
        echo view('categorias/eliminados', $data);
        echo view('footer');
    }

        public function nuevo()
    {

        $data = ['titulo' => 'Agregar Categoría'];

        echo view('header');
        echo view('categorias/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        $this->categorias->save([
            'nombre' => $this->request->getPost('nombre')
        ]);
        return redirect()->to(base_url() . 'categorias');
    }


    public function editar($id)
    {
        try {
            $categoria = $this->categorias->where('id', $id)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        $data = ['titulo' => 'Editar Categoría', 'datos' => $categoria];



        echo view('header');
        echo view('categorias/editar', $data);
        echo view('footer');
    }


    public function actualizar()
    {
        $this->categorias->update($this->request->getPost('id'), [
            'nombre' => $this->request->getPost('nombre')
        ]);
        return redirect()->to(base_url() . 'categorias/editar/' . $this->request->getPost('id'));
    }

    public function eliminar($id)
    {
        $this->categorias->update($id, [
            'activo' => 0
        ]);
        return redirect()->to(base_url() . 'categorias');
    }

    public function reingresar($id)
    {
        $this->categorias->update($id, [
            'activo' => 1
        ]);
        return redirect()->to(base_url() . 'categorias');
    }
}