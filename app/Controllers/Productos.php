<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\productosModel;

class productos extends BaseController
{
    protected $productos;

    public function __construct()
    {
        $this->productos = new productosModel();
    }

    public function index($activo = 1)
    {
        $productos = $this->productos->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Productos', 'datos' => $productos];

        echo view('header');
        echo view('productos/index', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        $productos = $this->productos->where('activo', $activo)->findAll();
        $data = ['titulo' => 'productos', 'datos' => $productos];

        echo view('header');
        echo view('productos/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {

        $data = ['titulo' => 'Agregar Producto'];

        echo view('header');
        echo view('productos/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        $this->productos->save([
            'nombre' => $this->request->getPost('nombre'),
            'nombre_corto' => $this->request->getPost('nombre_corto')
        ]);
        return redirect()->to(base_url() . 'productos');
    }


    public function editar($id)
    {
        try {
            $unidad = $this->productos->where('id', $id)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        $data = ['titulo' => 'Editar Unidad', 'datos' => $unidad];



        echo view('header');
        echo view('productos/editar', $data);
        echo view('footer');
    }


    public function actualizar()
    {
        $this->productos->update($this->request->getPost('id'), [
            'nombre' => $this->request->getPost('nombre'),
            'nombre_corto' => $this->request->getPost('nombre_corto')
        ]);
        return redirect()->to(base_url() . 'productos/editar/' . $this->request->getPost('id'));
    }

    public function eliminar($id)
    {
        $this->productos->update($id, [
            'activo' => 0
        ]);
        return redirect()->to(base_url() . 'productos');
    }

    public function reingresar($id)
    {
        $this->productos->update($id, [
            'activo' => 1
        ]);
        return redirect()->to(base_url() . 'productos');
    }
}
