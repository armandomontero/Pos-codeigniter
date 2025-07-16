<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VentasModel;
use App\Models\TemporalMovimientoModel;
use App\Models\DetalleVentaModel;
use App\Models\ProductosModel;
use App\Models\configuracionModel;
use FPDF;

class Ventas extends BaseController
{
    protected $ventas, $temporal_compra, $detalle_venta, $productos, $configuracion;


    public function __construct()
    {
        $this->ventas = new VentasModel();
        $this->detalle_venta = new DetalleVentaModel();
        $this->configuracion = new configuracionModel();
        helper(['form']);
    }

    public function index($activo = 1)
    {
        $ventas = $this->ventas->where('activo', $activo)->findAll();
        $data = ['titulo' => 'ventas', 'datos' => $ventas];

        echo view('header');
        echo view('ventas/index', $data);
        echo view('footer');
    }


    public function eliminar($id)
    {
        $this->ventas->update($id, [
            'activo' => 0
        ]);
        return redirect()->to(base_url() . 'ventas');
    }


        public function reingresar($id)
    {
        $this->ventas->update($id, [
            'activo' => 1
        ]);
        return redirect()->to(base_url() . 'ventas');
    }


    public function eliminados($activo = 0)
    {
        $ventas = $this->ventas->where('activo', $activo)->findAll();
        $data = ['titulo' => 'ventas', 'datos' => $ventas];

        echo view('header');
        echo view('ventas/eliminados', $data);
        echo view('footer');
    }

    public function venta()
    {

        echo view('header');
        echo view('ventas/venta');
        echo view('footer');
    }

    public function guardar()
    {
        $id_venta = $this->request->getPost('id_venta');
        $total = $this->request->getPost('total_numero');
        $id_cliente = $this->request->getPost('id_cliente');
        $forma_pago = $this->request->getPost('forma_pago');

        $session = session();
        $id_usuario = $session->id_usuario;
        $id_caja = $session->id_caja;

        $resultadoId = $this->ventas->insertarVenta($id_venta, $total, $id_usuario, $id_caja, $id_cliente, $forma_pago);

        $this->temporal_compra = new TemporalMovimientoModel();

        if ($resultadoId) {
            $resultadoCompra = $this->temporal_compra->porCompra($id_venta);

            foreach ($resultadoCompra as $row) {
                $this->detalle_venta->save([
                    'id_venta' => $resultadoId,
                    'id_producto' => $row['id_producto'],
                    'nombre' => $row['nombre'],
                    'cantidad' => $row['cantidad'],
                    'precio' => $row['precio'],
                ]);

                $this->productos = new ProductosModel();
            $this->productos->actualizaStock($row['id_producto'], -$row['cantidad']);
            }
            $this->temporal_compra->eliminarCompra($id_venta);
        }

        return redirect()->to(base_url().'ventas/muestraTicket/'.$resultadoId);
    }

    function muestraTicket($id_venta){
        $data['id_venta'] = $id_venta;
        echo view('header');
         echo view('ventas/ver_ticket', $data);
          echo view('footer');
    }

    function generaTicket($id_venta){
        $datosCompra = $this->ventas->where('id', $id_venta)->first();

         $this->detalle_venta->select('*');
         $this->detalle_venta->where('id_venta', $id_venta);
        $detalleVenta = $this->detalle_venta->findAll();

        $configuracion = $this->configuracion->first();

        $pdf = new FPDF('P', 'mm', array(80, 200));
        

        
        $pdf -> AddPage();
        $pdf -> SetMargins(5, 5, 5);
        $pdf -> SetTitle('Venta');

        $pdf -> Image(base_url().'img/logo.png', 10, 3, 30);
        $pdf->Ln(5);
        $pdf -> SetFont('Arial', 'B', 10);
        $pdf -> Cell(70, 5, "Venta ".$id_venta."", 0, 1, 'C');

        $pdf -> SetFont('Arial', 'B', 8);

        

        $pdf -> Cell(50, 5, $configuracion['nombre'], 0, 1, 'L');
        $pdf -> SetFont('Arial', '', 8);
        $pdf -> Cell(30, 5, $configuracion['direccion'], 0, 1, 'L');
        $pdf -> SetFont('Arial', 'B', 8);
        $pdf -> SetFont('Arial', '', 8);
        $pdf -> Cell(10, 5, 'Folio:', 0, 0, 'L');
        $pdf -> Cell(30, 5, $datosCompra['folio'], 0, 1, 'L');
        $pdf -> Cell(30, 5, $datosCompra['created_at'], 0, 1, 'L');

        $pdf->Ln(3);
        $pdf -> SetFont('Arial', 'B', 8);
        $pdf->Line(6, 43, 75, 43);
        $pdf->Line(6, 48, 75, 48);

        $pdf -> Cell(35, 5, 'Nombre', 0, 0, 'C');
        $pdf -> Cell(15, 5, 'Precio', 0, 0, 'C');
        $pdf -> Cell(7, 5, 'Cant', 0, 0, 'C');
        $pdf -> Cell(15, 5, 'Importe', 0, 1, 'C');

        $pdf -> SetFont('Arial', '', 8);
        $cuentaItem = 0;
        $cuentaTotal = 0;
        foreach($detalleVenta as $row){
            $cuentaItem++;
            $cuentaTotal = $cuentaTotal+($row['precio']*$row['cantidad']);
        $pdf -> Cell(35, 5, mb_convert_encoding($row['nombre'], 'ISO-8859-1', 'UTF-8'), 0, 0, 'L');
        $pdf -> Cell(15, 5, '$'.number_format($row['precio'], 0, ',', '.'), 0, 0, 'R');
        $pdf -> Cell(7, 5, $row['cantidad'], 0, 0, 'R');
        $pdf -> Cell(15, 5, '$'.number_format($row['precio']*$row['cantidad'], 0, ',', '.'), 0, 1, 'R');

        }
        $pdf -> SetFont('Arial', 'B', 8);
        $pdf -> Cell(72, 5, 'Total: $'.number_format($cuentaTotal, 0, ',', '.'), 0, 1, 'R');
        $this->response->setHeader('Content-type', 'application/pdf');
        $pdf -> Output('ventaPdf.pdf', 'I');

    }
}
