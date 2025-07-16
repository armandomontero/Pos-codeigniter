<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductosModel;
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
        $this->productos = new ProductosModel();
        $this->unidades = new unidadesModel();
        $this->categorias = new categoriasModel();

        helper(['form']);

        $this->reglas = [
            'codigo' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
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
        $productos = $this->productos->where('activo', $activo)->where('id_tienda', $this->session->id_tienda)->findAll();
        $data = ['titulo' => 'Productos', 'datos' => $productos];

        echo view('header');
        echo view('productos/index', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        $productos = $this->productos->where('activo', $activo)->where('id_tienda', $this->session->id_tienda)->findAll();
        $data = ['titulo' => 'productos', 'datos' => $productos];

        echo view('header');
        echo view('productos/eliminados', $data);
        echo view('footer');
    }

    public function nuevo($valid = null)
    {
        //llamamos unidades
        $unidades = $this->unidades->where('activo', 1)->where('id_tienda', $this->session->id_tienda)->orderBy('nombre', 'asc')->findAll();

        //llamamos categorias
        $categorias = $this->categorias->where('activo', 1)->where('id_tienda', $this->session->id_tienda)->orderBy('nombre', 'asc')->findAll();
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
                'activo' => 1,
                'id_tienda' => $this->session->id_tienda

                 ]);
                 return redirect()->to(base_url() . 'productos');
        }else{
            $this->nuevo($this->validator);
        }
        
    }


    public function editar($id)
    {
        try {
            $unidad = $this->productos->where('id', $id)->where('id_tienda', $this->session->id_tienda)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }

        if($unidad==null){
            echo 'No autorizado';
            
        }else{

         //llamamos unidades
        $unidades = $this->unidades->where('activo', 1)->where('id_tienda', $this->session->id_tienda)->orderBy('nombre', 'asc')->findAll();

        //llamamos categorias
        $categorias = $this->categorias->where('activo', 1)->where('id_tienda', $this->session->id_tienda)->orderBy('nombre', 'asc')->findAll();

        $data = ['titulo' => 'Editar Producto', 'datos' => $unidad, 'unidades' => $unidades, 'categorias' => $categorias];



        echo view('header');
        echo view('productos/editar', $data);
        echo view('footer');
        }
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

    public function buscarPorCodigo($codigo){
        $this->productos->select('*');
        $this->productos->where('codigo', $codigo);
        $this->productos->where('activo', 1);
        $this->productos->where('id_tienda', $this->session->id_tienda);
        $datos = $this->productos->get()->getRow();

        $res['existe'] = false;
        $res['datos'] = '';
        $res['error'] = '';

        if($datos){
            $res['datos'] = $datos;
            $res['existe'] = true;
        }
        else{
            $res['error'] = "No existe el producto";
            $res['existe'] = false;
        }

        echo json_encode($res);
    }

    public function autoCompleteData(){
        $returnData = array();
        $valor = $this->request->getGet('term');
        $productos = $this->productos->like('codigo', $valor)->where('activo', 1)->where('id_tienda', $this->session->id_tienda)->findAll();
        if(!empty($productos)){
            foreach($productos as $row){
                $data['id'] = $row['id'];
                $data['value'] = $row['codigo'];
                $data['nombre'] = $row['nombre'];
                $data['label'] = $row['codigo'].' - '.$row['nombre'];
                
                array_push($returnData, $data);
            }
        }
        echo json_encode($returnData);
    }
}
