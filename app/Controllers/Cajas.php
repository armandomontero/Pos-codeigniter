<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CajasModel;

class Cajas extends BaseController
{

    protected $cajas;
    protected $reglas;

    public function __construct()
    {
        $this->cajas = new CajasModel();

        helper(['form']);

        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                'required' => 'El campo {field} es obligatorio.'

                ]
            ],
            'numero_caja' => [
                'rules' => 'required',
                'errors' => [
                'required' => 'El campo {field} es obligatorio.'
                    

                ]
            ],
            'folio' => [
                'rules' => 'required|is_natural',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.',
                    'is_natural' => 'El campo {field} debe ser un número.'

                ]
            ]
        ];
    }

    public function index($activo = 1)
    {
        $cajas = $this->cajas->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Cajas', 'datos' => $cajas];

        echo view('header');
        echo view('cajas/index', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        $cajas = $this->cajas->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Cajas', 'datos' => $cajas];

        echo view('header');
        echo view('cajas/eliminados', $data);
        echo view('footer');
    }

    public function nuevo($valid = null)
    {
        if ($valid != null) {
            $data = ['titulo' => 'Agregar Caja', 'validation' => $valid];
        } else {
            $data = ['titulo' => 'Agregar Caja'];
        }
        echo view('header');
        echo view('cajas/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->cajas->save([
                'numero_caja' => $this->request->getPost('numero_caja'),
                'nombre' => $this->request->getPost('nombre'),
                'folio' => $this->request->getPost('folio')
            ]);
            return redirect()->to(base_url() . 'cajas');
        } else {
            $this->nuevo($this->validator);
        }
    }


    public function editar($id, $valid = null)
    {
        try {
            $categoria = $this->cajas->where('id', $id)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        if ($valid != null) {
            $data = ['titulo' => 'Editar Caja', 'datos' => $categoria, 'validation' => $valid];
        } else {

            $data = ['titulo' => 'Editar Caja', 'datos' => $categoria];
        }


        echo view('header');
        echo view('cajas/editar', $data);
        echo view('footer');
    }


    public function actualizar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->cajas->update($this->request->getPost('id'), [
                'numero_caja' => $this->request->getPost('numero_caja'),
                'nombre' => $this->request->getPost('nombre'),
                'folio' => $this->request->getPost('folio')
            ]);
            return redirect()->to(base_url() . 'cajas/editar/' . $this->request->getPost('id'));
        } else {
            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->cajas->update($id, [
            'activo' => 0
        ]);
        return redirect()->to(base_url() . 'cajas');
    }

    public function reingresar($id)
    {
        $this->cajas->update($id, [
            'activo' => 1
        ]);
        return redirect()->to(base_url() . 'cajas');
    }
}
