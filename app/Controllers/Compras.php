<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ComprasModel;
use App\Models\TemporalMovimientoModel;
use App\Models\DetalleCompraModel;
use App\Models\ProductosModel;
use App\Models\ConfiguracionModel;
use FPDF;

class Compras extends BaseController
{
    protected $compras, $temporal_compra, $detalle_compra, $productos, $configuracion;


    public function __construct()
    {
        $this->compras = new ComprasModel();
        $this->detalle_compra = new DetalleCompraModel();
        $this->configuracion = new configuracionModel();
        $this->productos = new ProductosModel();
        helper(['form']);
    }

    public function index($activo = 1)
    {
        $compras = $this->compras->select('compras.id, folio, total, compras.created_at, nombre')->join('usuarios', 'compras.id_usuario = usuarios.id')
        ->where('compras.activo', $activo)->where('compras.id_tienda', $this->session->id_tienda)
        ->orderBy('compras.id', 'DESC')->findAll();
        $data = ['titulo' => 'compras', 'datos' => $compras];

        echo view('header');
        echo view('compras/index', $data);
        echo view('footer');
    }


    public function eliminar($id)
    {

        $this->detalle_compra->select('*');
        $this->detalle_compra->where('id_compra', $id);
        $productos = $this->detalle_compra->findAll();
        
        foreach($productos as $producto){
          $this->productos->actualizaStock($producto['id_producto'], -$producto['cantidad']);
        }


        $this->compras->update($id, [
            'activo' => 0
        ]);
        return redirect()->to(base_url() . 'compras');
    }


        public function reingresar($id)
    {
        $this->detalle_compra->select('*');
        $this->detalle_compra->where('id_compra', $id);
        $productos = $this->detalle_compra->findAll();
        
        foreach($productos as $producto){
          $this->productos->actualizaStock($producto['id_producto'], $producto['cantidad']);
        }


        $this->compras->update($id, [
            'activo' => 1
        ]);
        return redirect()->to(base_url() . 'compras');
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

        //comprobamos si la caja ya tiene movimientos temporales de compra almacenados y los limpiamos (eliminamos)
        $this-> temporal_compra = new TemporalMovimientoModel();
        $cuenta_movimientos = $this->temporal_compra->where('id_caja', $this->session->id_caja)->where('tipo_movimiento', 'compra')->countAllResults();
        if($cuenta_movimientos>0){
           $this->temporal_compra->where('id_caja', $this->session->id_caja);
            $this->temporal_compra->where('tipo_movimiento', 'compra');
            $this->temporal_compra->delete();
        }
        

        echo view('header');
        echo view('compras/nuevo');
        echo view('footer');
    }

    public function guardar()
    {
        $id_compra = $this->request->getPost('id_compra');
        $total = $this->request->getPost('total_numero');

        
        $id_usuario = $this->session->id_usuario;

        $resultadoId = $this->compras->insertarCompra($id_compra, $total, $id_usuario, $this->session->id_tienda);

        $this->temporal_compra = new TemporalMovimientoModel();

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

                
            $this->productos->actualizaStock($row['id_producto'], $row['cantidad']);
            }
            $this->temporal_compra->eliminarCompra($id_compra);
        }

        return redirect()->to(base_url().'compras/muestraCompraPdf/'.$resultadoId);
    }

    function muestraCompraPdf($id_compra){
        $data['id_compra'] = $id_compra;
        echo view('header');
         echo view('compras/ver_compra_pdf', $data);
          echo view('footer');
    }

    function generaCompraPdf($id_compra){
        $datosCompra = $this->compras->where('id', $id_compra)->where('id_tienda', $this->session->id_tienda)->first();
         $this->detalle_compra->select('*');
         $this->detalle_compra->where('id_compra', $id_compra);
        $detalleCompra = $this->detalle_compra->findAll();

        if($datosCompra){
           

        $configuracion = $this->configuracion->first();
        $pdf = new FPDF('P', 'mm', 'letter');
        

        
        $pdf -> AddPage();
        $pdf -> SetMargins(10, 10, 10);
        $pdf -> SetTitle('Compra');
        $pdf -> SetFont('Arial', 'B', 12);
        $pdf -> Cell(195, 5, "Compra ".$id_compra."", 0, 1, 'C');

        $pdf -> SetFont('Arial', 'B', 10);

        $pdf -> Image(base_url().'img/logo.png', 170, 4, 40);

        $pdf -> Cell(50, 5, $configuracion['nombre'], 0, 1, 'L');
        $pdf -> Cell(20, 5, mb_convert_encoding('Dirección', 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
        $pdf -> SetFont('Arial', '', 10);
        $pdf -> Cell(50, 5, $configuracion['direccion'], 0, 1, 'L');
        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(35, 5, 'Fecha de Compra:', 0, 0, 'L');
        $pdf -> SetFont('Arial', '', 10);
        $pdf -> Cell(50, 5, $datosCompra['created_at'], 0, 1, 'L');

        $pdf->Ln(3);
        $pdf -> SetFont('Arial', 'B', 8);
        $pdf -> SetTextColor(255, 255, 255);
        $pdf -> Cell(195, 5, 'Detalle de Compra', 1, 1, 'C', 1);

        $pdf -> SetTextColor(0, 0, 0);
        $pdf -> Cell(14, 5, 'No.', 1, 0, 'C');
        $pdf -> Cell(25, 5, mb_convert_encoding('Código', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $pdf -> Cell(77, 5, 'Nombre', 1, 0, 'C');
        $pdf -> Cell(25, 5, 'Precio', 1, 0, 'C');
        $pdf -> Cell(25, 5, 'Cantidad', 1, 0, 'C');
        $pdf -> Cell(29, 5, 'Importe', 1, 1, 'C');

        $pdf -> SetFont('Arial', '', 8);
        $cuentaItem = 0;
        $cuentaTotal = 0;
        foreach($detalleCompra as $row){
            $cuentaItem++;
            $cuentaTotal = $cuentaTotal+($row['precio']*$row['cantidad']);
        $pdf -> Cell(14, 5, $cuentaItem, 1, 0, 'R');
        $pdf -> Cell(25, 5, $row['id_producto'], 1, 0, 'R');
        $pdf -> Cell(77, 5, mb_convert_encoding($row['nombre'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $pdf -> Cell(25, 5, '$'.number_format($row['precio'], 0, ',', '.'), 1, 0, 'R');
        $pdf -> Cell(25, 5, $row['cantidad'], 1, 0, 'R');
        $pdf -> Cell(29, 5, '$'.number_format($row['precio']*$row['cantidad'], 0, ',', '.'), 1, 1, 'R');

        }
        $pdf -> SetFont('Arial', 'B', 8);
        $pdf -> SetTextColor(255, 255, 255);
        $pdf -> Cell(195, 5, 'Total: $'.number_format($cuentaTotal, 0, ',', '.'), 1, 1, 'R', 1);
        $this->response->setHeader('Content-type', 'application/pdf');
        $pdf -> Output('compraPdf.pdf', 'I');

    }
else{
    echo 'No autorizado';
}
}
}
