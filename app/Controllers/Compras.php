<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ComprasModel;

class Compras extends BaseController
{
    protected $compras;


    public function __construct()
    {
        $this->compras = new ComprasModel();
        helper(['form']);
    }

    public function index($activo = 1)
    {
        $compras = $this->compras->where('activo', $activo)->findAll();
        $data = ['titulo' => 'compras', 'datos' => $compras];

        echo view('header');
        echo view('compras/index', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        $compras = $this->compras->where('activo', $activo)->findAll();
        $data = ['titulo' => 'compras', 'datos' => $compras];

        echo view('header');
        echo view('compras/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {

        echo view('header');
        echo view('compras/nuevo');
        echo view('footer');
    }

    public function insertar()
    {
        if ($this->request->getMethod() == "POST" ) {
            $this->compras->save([
                'nombre' => $this->request->getPost('nombre'),
                'nombre_corto' => $this->request->getPost('nombre_corto')
            ]);
            return redirect()->to(base_url() . 'compras');
        } else {
            $data = ['titulo' => 'Agregar Unidad', 'validation' => $this->validator];

            echo view('header');
            echo view('compras/nuevo', $data);
            echo view('footer');
        }
    }


    public function editar($id, $valid = null)
    {
        try {
            $unidad = $this->compras->where('id', $id)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        if ($valid != null) {
            $data = ['titulo' => 'Editar Unidad', 'datos' => $unidad, 'validation' => $valid];
        } else {


            $data = ['titulo' => 'Editar Unidad', 'datos' => $unidad];
        }
        echo view('header');
        echo view('compras/editar', $data);
        echo view('footer');
    }



    public function actualizar()
    {
        if ($this->request->getMethod() == "POST" ) {
            $this->compras->update($this->request->getPost('id'), [
                'nombre' => $this->request->getPost('nombre'),
                'nombre_corto' => $this->request->getPost('nombre_corto')
            ]);
            return redirect()->to(base_url() . 'compras/editar/' . $this->request->getPost('id'));
        } else {
            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->compras->update($id, [
            'activo' => 0
        ]);
        return redirect()->to(base_url() . 'compras');
    }

    public function reingresar($id)
    {
        $this->compras->update($id, [
            'activo' => 1
        ]);
        return redirect()->to(base_url() . 'compras');
    }
}
