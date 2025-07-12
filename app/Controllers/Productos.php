<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\productosModel;
use App\Models\categoriasModel;
use App\Models\unidadesModel;

class productos extends BaseController
{
    protected $productos;
    protected $unidades;
    protected $categorias;
    protected $reglas;

    public function __construct()
    {
        $this->productos = new productosModel();
        $this->unidades = new unidadesModel();
        $this->categorias = new categoriasModel();

        helper(['form']);

        $this->reglas = [
            'codigo' => [
                'rules' => 'required|is_unique[productos.codigo]',
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
        echo view('productos/nuevo', $data);
        echo view('footer');
    }

        public function insertar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->productos->save([
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
                 return redirect()->to(base_url() . 'productos');
        }else{
            $this->nuevo($this->validator);
        }
        
    }


    public function editar($id)
    {
        try {
            $unidad = $this->productos->where('id', $id)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
         //llamamos unidades
        $unidades = $this->unidades->where('activo', 1)->orderBy('nombre', 'asc')->findAll();

        //llamamos categorias
        $categorias = $this->categorias->where('activo', 1)->orderBy('nombre', 'asc')->findAll();

        $data = ['titulo' => 'Editar Producto', 'datos' => $unidad, 'unidades' => $unidades, 'categorias' => $categorias];



        echo view('header');
        echo view('productos/editar', $data);
        echo view('footer');
    }


    public function actualizar()
    {

        $this->productos->update($this->request->getPost('id'), [
                'codigo' => $this->request->getPost('codigo'),
                'nombre' => $this->request->getPost('nombre'),
                'precio_venta' => $this->request->getPost('precio_venta'),
                'precio_compra' => $this->request->getPost('precio_compra'),
                'stock_minimo' => $this->request->getPost('stock_minimo'),
                'inventariable' => $this->request->getPost('inventariable'),
                'id_unidad' => $this->request->getPost('id_unidad'),
                'id_categoria' => $this->request->getPost('id_categoria')
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
