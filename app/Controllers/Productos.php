<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductosModel;
use App\Models\CategoriasModel;
use App\Models\UnidadesModel;
use App\Models\ConfiguracionModel;
use App\Models\RolesPermisosModel;

use FPDF;

class productos extends BaseController
{
    protected $productos;
    protected $unidades;
    protected $categorias, $roles_permisos;
    protected $reglas, $configuracion;

    public function __construct()
    {
        $this->productos = new ProductosModel();
        $this->unidades = new UnidadesModel();
        $this->categorias = new CategoriasModel();
        $this->configuracion = new ConfiguracionModel();
        $this->roles_permisos = new RolesPermisosModel();

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

    public function index($activo = 1, $mensaje = null)
    {
        $permiso = $this->roles_permisos->verificaPermiso($this->session->id_rol, 'ProductosListado');
        if (!$permiso) {
            echo view('header');
            echo view('roles/no_autorizado');
            echo view('footer');
            exit;
        }

        $productos = $this->productos->where('activo', $activo)->where('id_tienda', $this->session->id_tienda)->findAll();
        $data = ['titulo' => 'Productos', 'datos' => $productos, 'mensaje' => $mensaje];

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
        $unidades = $this->unidades->where('activo', 1)->where("id_tienda = " . $this->session->id_tienda . " OR id = 1")->orderBy('nombre', 'asc')->findAll();

        //llamamos categorias
        $categorias = $this->categorias->where('activo', 1)->where("id_tienda = " . $this->session->id_tienda . " OR id = 1")->orderBy('nombre', 'asc')->findAll();
        if ($valid != null) {
            $data = ['titulo' => 'Agregar Producto', 'unidades' => $unidades, 'categorias' => $categorias, 'validation' => $valid];
        } else {
            $data = ['titulo' => 'Agregar Producto', 'unidades' => $unidades, 'categorias' => $categorias];
        }
        echo view('header');
        echo view('productos/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $carpeta_base = 'img/' . $this->session->id_tienda . '/productos';
            if ($this->request->getFile('imagen')->getPath()) {

                $validacion = $this->validate([
                    'imagen' => [
                        'uploaded[imagen]',
                        'mime_in[imagen,image/png,image/jpeg]',
                        'max_size[imagen,4096]'
                    ]
                ]);
                if ($validacion) {
                    $img = $this->request->getFile('imagen');
                    $nombre_archivo = uniqid() . 'imagen.' . $img->getExtension();
                    $carpeta = './img/' . $this->session->id_tienda . '/productos';


                    $img->move($carpeta, $nombre_archivo);
                } else {
                    echo $validacion;
                }

                $ruta_bd = $carpeta_base . '/' . $nombre_archivo;
            } else {
                $ruta_bd = null;
            }



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
                'id_tienda' => $this->session->id_tienda,
                'imagen' => $ruta_bd

            ]);
            $mensaje = 'Registro almacenado!';
            $this->index(1, $mensaje);
        } else {
            $this->nuevo($this->validator);
        }
    }


    public function editar($id, $valid = null, $mensaje = null)
    {
        try {
            $unidad = $this->productos->where('id', $id)->where('id_tienda', $this->session->id_tienda)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }

        if ($unidad == null) {
            echo 'No autorizado';
        } else {

            //llamamos unidades
            $unidades = $this->unidades->where('activo', 1)->where("id_tienda = " . $this->session->id_tienda . " OR id = 1")->orderBy('nombre', 'asc')->findAll();
            //llamamos categorias
            $categorias = $this->categorias->where('activo', 1)->where("id_tienda = " . $this->session->id_tienda . " OR id = 1")->orderBy('nombre', 'asc')->findAll();

            $data = ['titulo' => 'Editar Producto', 'datos' => $unidad, 'unidades' => $unidades, 'categorias' => $categorias, 'validation' => $valid, 'mensaje' => $mensaje];

            echo view('header');
            echo view('productos/editar', $data);
            echo view('footer');
        }
    }


    public function actualizar()
    {
if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
        //comprobamos que exista imagen
            $producto = $this->productos->where('id', $this->request->getPost('id'))->first();
            $ruta_bd = null;
            if ($producto) {
                $ruta_bd = $producto['imagen'];
            }
            $carpeta_base = 'img/' . $this->session->id_tienda . '/productos';

            if ($this->request->getFile('imagen')->getPath()) {

              
                $validacion = $this->validate([
                    'imagen' => [
                        'uploaded[imagen]',
                        'mime_in[imagen,image/png,image/jpeg]',
                        'max_size[imagen,4096]'
                    ]
                ]);
                if ($validacion) {
                    $img = $this->request->getFile('imagen');
                    $nombre_archivo = uniqid() . 'imagen.' . $img->getExtension();
                    $carpeta = './img/' . $this->session->id_tienda . '/productos';
                //Borramos anterior
                    if (file_exists('./' . $producto['imagen']) && $producto['imagen'] != "") {
                        unlink('./' . $producto['imagen']);
                    }

                    $img->move($carpeta, $nombre_archivo);
                } else {
                    echo $validacion;
                }

                $ruta_bd = $carpeta_base . '/' . $nombre_archivo;
            } 



        $this->productos->update($this->request->getPost('id'), [
            'codigo' => $this->request->getPost('codigo'),
            'nombre' => $this->request->getPost('nombre'),
            'precio_venta' => $this->request->getPost('precio_venta'),
            'precio_compra' => $this->request->getPost('precio_compra'),
            'stock_minimo' => $this->request->getPost('stock_minimo'),
            'inventariable' => $this->request->getPost('inventariable'),
            'id_unidad' => $this->request->getPost('id_unidad'),
            'id_categoria' => $this->request->getPost('id_categoria'),
            'imagen' => $ruta_bd
        ]);
        $mensaje = 'Registro actualizado!';
       $this->editar($this->request->getPost('id'), null, $mensaje);
    }
    else{
         $this->editar($this->request->getPost('id'), $this->validator);
    }
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

    public function buscarPorCodigo($codigo)
    {
        $this->productos->select('*');
        $this->productos->where('codigo', $codigo);
        $this->productos->where('activo', 1);
        $this->productos->where('id_tienda', $this->session->id_tienda);
        $datos = $this->productos->get()->getRow();

        $res['existe'] = false;
        $res['datos'] = '';
        $res['error'] = '';

        if ($datos) {
            $res['datos'] = $datos;
            $res['existe'] = true;
        } else {
            $res['error'] = "No existe el producto";
            $res['existe'] = false;
        }

        echo json_encode($res);
    }

    public function autoCompleteData()
    {
        $returnData = array();
        $valor = $this->request->getGet('term');
        $productos = $this->productos->like('codigo', $valor)->where('activo', 1)->where('id_tienda', $this->session->id_tienda)->findAll();
        if (!empty($productos)) {
            foreach ($productos as $row) {
                $data['id'] = $row['id'];
                $data['value'] = $row['codigo'];
                $data['nombre'] = $row['nombre'];
                $data['label'] = $row['codigo'] . ' - ' . $row['nombre'];
                $data['precio_venta'] = $row['precio_venta'];
                $data['precio_compra'] = $row['precio_compra'];

                array_push($returnData, $data);
            }
        }
        echo json_encode($returnData);
    }


        public function autoCompletebyName()
    {
        $returnData = array();
        $valor = $this->request->getGet('term');
        $productos = $this->productos->like('nombre', $valor)->where('activo', 1)->where('id_tienda', $this->session->id_tienda)->findAll();
        
        if (!empty($productos)) {
            foreach ($productos as $row) {
                $data['id'] = $row['id'];
                $data['value'] = $row['codigo'];
                $data['nombre'] = $row['nombre'];
                $data['label'] = $row['codigo'] . ' - ' . $row['nombre'];
                $data['precio_venta'] = $row['precio_venta'];
                $data['precio_compra'] = $row['precio_compra'];

                array_push($returnData, $data);
            }
        }
        echo json_encode($returnData);
    }

    public function generaBarras($id_producto)
    {

        $pdf = new FPDF('P', 'mm', array(58, 200));
        $pdf->AddPage();
        $pdf->SetMargins(02, 05);

        $producto = $this->productos->where('id', $id_producto)->first();

        $pdf->SetTitle($producto['nombre'] . ' - Codigos de Barra');
        if (file_exists('codigo.png')) {
            unlink('codigo.png');
        }
        $generaBarCode = new \BarcodeClass();
        $generaBarCode->barcode('codigo.png', $producto['codigo'], '20', 'horizontal', 'code128', true, 1);


        for ($i = 0; $i < 11; $i++) {
            $pdf->Image('codigo.png');
        }

        $this->response->setHeader('Content-type', 'application/pdf');
        $pdf->Output('Codigo.pdf', 'I');
        unlink('codigo.png');
    }


    public function reporteMinimos()
    {
        echo view('header');
        echo view('productos/reporte_minimos');
        echo view('footer');
    }

    public function generaReporteMinimo()
    {

        $pdf = new FPDF('P', 'mm', 'letter');



        $pdf->AddPage();
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetTitle('Compra');
        $pdf->SetFont('Arial', 'B', 12);

        $productos = $this->productos->where('activo', 1)->where('id_tienda', $this->session->id_tienda)->where('inventariable', 1)
            ->where('existencias < stock_minimo')->findAll();

        if ($productos) {


            $configuracion = $this->configuracion->first();

            $pdf = new FPDF('P', 'mm', 'letter');



            $pdf->AddPage();
            $pdf->SetMargins(10, 10, 10);
            $pdf->SetTitle('Reporte Productos en Minimo Stock');
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(195, 5, "Reporte Productos Minimo Stock", 0, 1, 'C');

            $pdf->SetFont('Arial', 'B', 10);

            $pdf->Image(base_url() . $configuracion['logo'], 160, 4, 30);

            $pdf->Cell(50, 5, $configuracion['nombre'], 0, 1, 'L');
            $pdf->Cell(20, 5, mb_convert_encoding('Dirección:', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(50, 5, $configuracion['direccion'], 0, 1, 'L');
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetFont('Arial', '', 10);

            $pdf->Ln(3);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetTextColor(255, 255, 255);

            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(14, 5, 'No.', 1, 0, 'C');
            $pdf->Cell(25, 5, mb_convert_encoding('Código', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
            $pdf->Cell(77, 5, 'Nombre', 1, 0, 'C');
            $pdf->Cell(25, 5, 'Existencias', 1, 0, 'C');
            $pdf->Cell(25, 5, 'Stock Minimo', 1, 0, 'C');
            $pdf->Cell(29, 5, 'Diferencia', 1, 1, 'C');

            $pdf->SetFont('Arial', '', 8);
            $cuentaItem = 0;
            $cuentaTotal = 0;
            foreach ($productos as $row) {
                $cuentaItem++;
                $cuentaTotal = $cuentaTotal + ($row['existencias'] - $row['stock_minimo']);
                $pdf->Cell(14, 5, $cuentaItem, 1, 0, 'R');
                $pdf->Cell(25, 5, $row['codigo'], 1, 0, 'R');
                $pdf->Cell(77, 5, mb_convert_encoding($row['nombre'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
                $pdf->Cell(25, 5, number_format($row['existencias'], 0, ',', '.'), 1, 0, 'R');
                $pdf->Cell(25, 5, number_format($row['stock_minimo'], 0, ',', '.'), 1, 0, 'R');
                $pdf->Cell(29, 5, number_format($row['existencias'] - $row['stock_minimo'], 0, ',', '.'), 1, 1, 'R');
            }
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Cell(195, 5, 'Total productos faltantes: ' . number_format($cuentaTotal, 0, ',', '.'), 1, 1, 'R', 1);
            $this->response->setHeader('Content-type', 'application/pdf');
            $pdf->Output('reporteMinimos.pdf', 'I');
        } else {
            echo 'No autorizado';
        }
    }
}
