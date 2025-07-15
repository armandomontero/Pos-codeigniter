<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ComprasModel;
use App\Models\TemporalComprasModel;
use App\Models\DetalleCompraModel;
use App\Models\ProductosModel;
use App\Models\configuracionModel;



class Compras extends BaseController
{
    protected $compras, $temporal_compra, $detalle_compra, $productos, $configuracion;


    public function __construct()
    {
        $this->compras = new ComprasModel();
        $this->detalle_compra = new DetalleCompraModel();
        $this->configuracion = new configuracionModel();
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

    public function guardar()
    {
        $id_compra = $this->request->getPost('id_compra');
        $total = $this->request->getPost('total_numero');

        $session = session();
        $id_usuario = $session->id_usuario;

        $resultadoId = $this->compras->insertarCompra($id_compra, $total, $id_usuario);

        $this->temporal_compra = new TemporalComprasModel();

        if ($resultadoId) {
            $resultadoCompra = $this->temporal_compra->porCompra($id_compra);

            foreach ($resultadoCompra as $row) {
                $this->detalle_compra->save([
                    'id_compra' => $resultadoId,
                    'id_producto' => $row['id_producto'],
                    'nombre' => $row['nombre'],
                    'cantidad' => $row['cantidad'],
                    'precio' => $row['precio'],
                ]);

                $this->productos = new ProductosModel();
            $this->productos->actualizaStock($row['id_producto'], $row['cantidad']);
            }
            $this->temporal_compra->eliminarCompra($id_compra);
        }

        return redirect()->to(base_url().'productos');
    }

    function muestraCompraPdf($id_compra){
        $data['id_compra'] = $id_compra;
        echo view('header');
         echo view('compras/ver_compra_pdf', $data);
          echo view('footer');
    }

    function generaCompraPdf($id_compra){
        $datosCompra = $this->compras->where('id', $id_compra)->first();

         $this->detalle_compra->select('*');
         $this->detalle_compra->where('id_compra', $id_compra);
        $detalleCompra = $this->detalle_compra->findAll();

        $configuracion = $this->configuracion->first();
    }
}
