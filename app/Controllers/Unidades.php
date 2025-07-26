<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UnidadesModel;

class Unidades extends BaseController
{
    protected $unidades;
    protected $reglas;

    public function __construct()
    {
        $this->unidades = new unidadesModel();
        helper(['form']);

        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'nombre_corto' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ]
        ];
    }

    public function index($activo = 1)
    {
        $unidades = $this->unidades->where('activo', $activo)->where("id_tienda = " . $this->session->id_tienda . " OR id = 1")->
        orderBy('nombre', 'asc')->findAll();
        $data = ['titulo' => 'Unidades', 'datos' => $unidades];

        echo view('header');
        echo view('unidades/index', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        $unidades = $this->unidades->where('activo', $activo)->where('id_tienda', $this->session->id_tienda)->findAll();
        $data = ['titulo' => 'Unidades', 'datos' => $unidades];

        echo view('header');
        echo view('unidades/eliminados', $data);
        echo view('footer');
    }

    public function nuevo()
    {

        $data = ['titulo' => 'Agregar Unidad'];

        echo view('header');
        echo view('unidades/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->unidades->save([
                'nombre' => $this->request->getPost('nombre'),
                'nombre_corto' => $this->request->getPost('nombre_corto'),
                'id_tienda' => $this->session->id_tienda
            ]);
            return redirect()->to(base_url() . 'unidades');
        } else {
            $data = ['titulo' => 'Agregar Unidad', 'validation' => $this->validator];

            echo view('header');
            echo view('unidades/nuevo', $data);
            echo view('footer');
        }
    }


    public function editar($id, $valid = null)
    {
        if ($id == 1) {
            echo 'No se puede editar este registro!';
            exit;
        }
        try {
            $unidad = $this->unidades->where('id', $id)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        if ($valid != null) {
            $data = ['titulo' => 'Editar Unidad', 'datos' => $unidad, 'validation' => $valid];
        } else {


            $data = ['titulo' => 'Editar Unidad', 'datos' => $unidad];
        }
        echo view('header');
        echo view('unidades/editar', $data);
        echo view('footer');
    }



    public function actualizar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->unidades->update($this->request->getPost('id'), [
                'nombre' => $this->request->getPost('nombre'),
                'nombre_corto' => $this->request->getPost('nombre_corto')
            ]);
            return redirect()->to(base_url() . 'unidades/editar/' . $this->request->getPost('id'));
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
        $this->unidades->update($id, [
            'activo' => 0
        ]);
        return redirect()->to(base_url() . 'unidades');
    }

    public function reingresar($id)
    {
        $this->unidades->update($id, [
            'activo' => 1
        ]);
        return redirect()->to(base_url() . 'unidades');
    }

    
}
