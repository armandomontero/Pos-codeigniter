<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriasModel;

class Categorias extends BaseController
{

    protected $categorias;
    protected $reglas;

    public function __construct()
    {
        $this->categorias = new CategoriasModel();

        helper(['form']);

        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'

                ]
            ]
        ];
    }

    public function index($activo = 1)
    {
        $categorias = $this->categorias->where('activo', $activo)->where("id_tienda = " . $this->session->id_tienda . " OR id = 1")->orderBy('nombre', 'asc')->findAll();
        $data = ['titulo' => 'Categorias', 'datos' => $categorias];

        echo view('header');
        echo view('categorias/index', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        $categorias = $this->categorias->where('activo', $activo)->where('id_tienda', $this->session->id_tienda)->findAll();
        $data = ['titulo' => 'Categorías', 'datos' => $categorias];

        echo view('header');
        echo view('categorias/eliminados', $data);
        echo view('footer');
    }

    public function nuevo($valid = null)
    {
        if ($valid != null) {
            $data = ['titulo' => 'Agregar Categoría', 'validation' => $valid];
        } else {
            $data = ['titulo' => 'Agregar Categoría'];
        }
        echo view('header');
        echo view('categorias/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->categorias->save([
                'nombre' => $this->request->getPost('nombre'),
                'id_tienda' => $this->session->id_tienda
            ]);
            return redirect()->to(base_url() . 'categorias');
        } else {
            $this->nuevo($this->validator);
        }
    }


    public function editar($id, $valid = null)
    {
        if ($id == 1) {
            echo 'No se puede editar este registro!';
            exit;
        }
        try {
            $categoria = $this->categorias->where('id', $id)->where('id_tienda', $this->session->id_tienda)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        if ($categoria == null) {
            echo 'No se puede editar este registro!';
            exit;
        }
        if ($valid != null) {
            $data = ['titulo' => 'Editar Categoría', 'datos' => $categoria, 'validation' => $valid];
        } else {

            $data = ['titulo' => 'Editar Categoría', 'datos' => $categoria];
        }


        echo view('header');
        echo view('categorias/editar', $data);
        echo view('footer');
    }


    public function actualizar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->categorias->update($this->request->getPost('id'), [
                'nombre' => $this->request->getPost('nombre')
            ]);
            return redirect()->to(base_url() . 'categorias/editar/' . $this->request->getPost('id'));
        } else {
            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        if ($id == 1) {
            echo 'No se puede editar este registro!';
            exit;
        }

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
