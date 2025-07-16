<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\clientesModel;
use App\Models\categoriasModel;
use App\Models\unidadesModel;

class clientes extends BaseController
{
    protected $clientes;
    protected $unidades;
    protected $categorias;
    protected $reglas;

    public function __construct()
    {
        $this->clientes = new clientesModel();
        $this->unidades = new unidadesModel();
        $this->categorias = new categoriasModel();

        helper(['form']);

        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'telefono' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ]
        ];
    }

    public function index($activo = 1)
    {
        $clientes = $this->clientes->where('activo', $activo)->orderBy('nombre', 'ASC')->findAll();
        $data = ['titulo' => 'clientes', 'datos' => $clientes];

        echo view('header');
        echo view('clientes/index', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        $clientes = $this->clientes->where('activo', $activo)->findAll();
        $data = ['titulo' => 'clientes', 'datos' => $clientes];

        echo view('header');
        echo view('clientes/eliminados', $data);
        echo view('footer');
    }

    public function nuevo($valid = null)
    {
       
if($valid!=null){
            $data = ['titulo' => 'Agregar Cliente', 'validation' => $valid];

    
}
else{
        $data = ['titulo' => 'Agregar Cliente'];
}
        echo view('header');
        echo view('clientes/nuevo', $data);
        echo view('footer');
    }

        public function insertar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->clientes->save([
                'nombre' => $this->request->getPost('nombre'),
                'direccion' => $this->request->getPost('direccion'),
                'region' => $this->request->getPost('region'),
                'comuna' => $this->request->getPost('comuna'),
                'telefono' => $this->request->getPost('telefono'),
                'correo' => $this->request->getPost('correo'),
                'activo' => 1

                 ]);
                 return redirect()->to(base_url() . 'clientes');
        }else{
            $this->nuevo($this->validator);
        }
        
    }


    public function editar($id, $valid=null)
    {
        try {
            $cliente = $this->clientes->where('id', $id)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
         if ($valid != null) {
            $data = ['titulo' => 'Editar Cliente', 'datos' => $cliente, 'validation' => $valid];
        } else {
        $data = ['titulo' => 'Editar Cliente', 'datos' => $cliente];
        }


        echo view('header');
        echo view('clientes/editar', $data);
        echo view('footer');
    }


    public function actualizar()
    {
 if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
        $this->clientes->update($this->request->getPost('id'), [
                 'nombre' => $this->request->getPost('nombre'),
                'direccion' => $this->request->getPost('direccion'),
                'region' => $this->request->getPost('region'),
                'comuna' => $this->request->getPost('comuna'),
                'telefono' => $this->request->getPost('telefono'),
                'correo' => $this->request->getPost('correo')
        ]);
        return redirect()->to(base_url() . 'clientes/editar/' . $this->request->getPost('id'));
        } else {
            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->clientes->update($id, [
            'activo' => 0
        ]);
        return redirect()->to(base_url() . 'clientes');
    }

    public function reingresar($id)
    {
        $this->clientes->update($id, [
            'activo' => 1
        ]);
        return redirect()->to(base_url() . 'clientes');
    }


    public function autoCompleteData(){
        $returnData = array();
        $valor = $this->request->getGet('term');
        $clientes = $this->clientes->like('nombre', $valor)->where('activo', 1)->findAll();
        if(!empty($clientes)){
            foreach($clientes as $row){
                $data['id'] = $row['id'];
                $data['value'] = $row['nombre'];
                array_push($returnData, $data);
            }
        }
        echo json_encode($returnData);
    }
}
