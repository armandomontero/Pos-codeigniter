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
            'codigo' => [
                'rules' => 'required|is_unique[clientes.codigo]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.',
                     'is_unique' => 'El código ya está registrado.'
                ]
            ],
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
        $clientes = $this->clientes->where('activo', $activo)->findAll();
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
        //llamamos unidades
        $unidades = $this->unidades->where('activo', 1)->orderBy('nombre', 'asc')->findAll();

        //llamamos categorias
        $categorias = $this->categorias->where('activo', 1)->orderBy('nombre', 'asc')->findAll();
if($valid!=null){
            $data = ['titulo' => 'Agregar Producto', 'unidades' => $unidades, 'categorias' => $categorias, 'validation' => $valid];

    
}
else{
        $data = ['titulo' => 'Agregar Producto', 'unidades' => $unidades, 'categorias' => $categorias];
}
        echo view('header');
        echo view('clientes/nuevo', $data);
        echo view('footer');
    }

        public function insertar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->clientes->save([
                'codigo' => $this->request->getPost('codigo'),
                'nombre' => $this->request->getPost('nombre'),
                'precio_venta' => $this->request->getPost('precio_venta'),
                'precio_compra' => $this->request->getPost('precio_compra'),
                'stock_minimo' => $this->request->getPost('stock_minimo'),
                'inventariable' => $this->request->getPost('inventariable'),
                'id_unidad' => $this->request->getPost('id_unidad'),
                'id_categoria' => $this->request->getPost('id_categoria'),
                'activo' => 1

                 ]);
                 return redirect()->to(base_url() . 'clientes');
        }else{
            $this->nuevo($this->validator);
        }
        
    }


    public function editar($id)
    {
        try {
            $unidad = $this->clientes->where('id', $id)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
         //llamamos unidades
        $unidades = $this->unidades->where('activo', 1)->orderBy('nombre', 'asc')->findAll();

        //llamamos categorias
        $categorias = $this->categorias->where('activo', 1)->orderBy('nombre', 'asc')->findAll();

        $data = ['titulo' => 'Editar Producto', 'datos' => $unidad, 'unidades' => $unidades, 'categorias' => $categorias];



        echo view('header');
        echo view('clientes/editar', $data);
        echo view('footer');
    }


    public function actualizar()
    {

        $this->clientes->update($this->request->getPost('id'), [
                'codigo' => $this->request->getPost('codigo'),
                'nombre' => $this->request->getPost('nombre'),
                'precio_venta' => $this->request->getPost('precio_venta'),
                'precio_compra' => $this->request->getPost('precio_compra'),
                'stock_minimo' => $this->request->getPost('stock_minimo'),
                'inventariable' => $this->request->getPost('inventariable'),
                'id_unidad' => $this->request->getPost('id_unidad'),
                'id_categoria' => $this->request->getPost('id_categoria')
        ]);
        return redirect()->to(base_url() . 'clientes/editar/' . $this->request->getPost('id'));
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
}
