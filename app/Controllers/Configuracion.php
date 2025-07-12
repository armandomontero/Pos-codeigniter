<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\configuracionModel;

class configuracion extends BaseController
{
    protected $configuracion;
    protected $reglas;

    public function __construct()
    {
        $this->configuracion = new configuracionModel();
        helper(['form']);

        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'valor' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ]
        ];
    }

    public function index($activo = 1)
    {
        //$configuracion = $this->configuracion->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Configuracion'];

        echo view('header');
        echo view('configuracion/index', $data);
        echo view('footer');
    }

    

    


    public function actualizar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->configuracion->update($this->request->getPost('id'), [
                'nombre' => $this->request->getPost('nombre'),
                'nombre_corto' => $this->request->getPost('nombre_corto')
            ]);
            return redirect()->to(base_url() . 'configuracion/editar/' . $this->request->getPost('id'));
        } else {
           // return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    
}
