<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VentasModel;
use App\Models\TemporalMovimientoModel;
use App\Models\DetalleVentaModel;
use App\Models\ProductosModel;
use App\Models\ConfiguracionModel;
use App\Models\CajasModel;
use App\Models\ArqueoCajaModel;
//use FPDF;

class Ventas extends BaseController
{
    protected $ventas, $temporal_compra, $detalle_venta, $productos, $configuracion, $cajas;


    public function __construct()
    {
        $this->ventas = new VentasModel();
        $this->detalle_venta = new DetalleVentaModel();
        $this->configuracion = new configuracionModel();
        $this->productos = new ProductosModel();
        $this->cajas = new CajasModel();
        helper(['form']);
    }

    public function index($activo = 1)
    {
        $ventas = $this->ventas->obtener($activo, $this->session->id_tienda);
        
        $data = ['titulo' => 'Ventas', 'datos' => $ventas];

        echo view('header');
        echo view('ventas/index', $data);
        echo view('footer');
    }


    public function eliminar($id)
    {
         $this->detalle_venta->select('*');
         $this->detalle_venta->where('id_venta', $id);
        $productos = $this->detalle_venta->findAll();
        
        foreach($productos as $producto){
          $this->productos->actualizaStock($producto['id_producto'], $producto['cantidad']);
        }


        $this->ventas->update($id, [
            'activo' => 0
        ]);
        return redirect()->to(base_url() . 'ventas');
    }


        public function reingresar($id)
    {

         $this->detalle_venta->select('*');
         $this->detalle_venta->where('id_venta', $id);
        $productos = $this->detalle_venta->findAll();
        foreach($productos as $producto){
          $this->productos->actualizaStock($producto['id_producto'], -$producto['cantidad']);
        }

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
      //comprobamos si hay arqueo inicial de caja que inició sesión
      $arqueo = new ArqueoCajaModel();
      if($arqueo->cajaAbierta($this->session->id_caja)){


        
        //comprobamos si la caja ya tiene movimientos temporales de venta almacenados y los limpiamos (eliminamos)
        $this-> temporal_compra = new TemporalMovimientoModel();
        $cuenta_movimientos = $this->temporal_compra->where('id_caja', $this->session->id_caja)->where('tipo_movimiento', 'venta')->countAllResults();
        if($cuenta_movimientos>0){
           $this->temporal_compra->where('id_caja', $this->session->id_caja);
            $this->temporal_compra->where('tipo_movimiento', 'venta');
            $this->temporal_compra->delete();
        }

        echo view('header');
        echo view('ventas/venta');
        echo view('footer');
      }
      else{
        $caja = $this->cajas->where('id', $this->session->id_caja)->first();
        $mensaje = 'Debe hacer apertura de caja, una vez realizado podrá realizar ventas, 
        favor indicar el monto inicial y luego click en botón "Guardar".';
        $redirige = 'ventas/venta';
        $data = ['titulo' => 'Apertura de Caja', 'datos' => $caja, 'mensaje' => $mensaje, 'redirige' => $redirige];
        echo view('header');
        echo view('cajas/nuevo_arqueo', $data);
        echo view('footer');
      }
    }

    public function guardar()
    {
        $id_venta = $this->request->getPost('id_venta');
        $total = $this->request->getPost('total_numero');
        $id_cliente = $this->request->getPost('id_cliente');
        $forma_pago = $this->request->getPost('forma_pago');

       
        
        $id_usuario = $this->session->id_usuario;
        $id_caja = $this->session->id_caja;

        $resultadoId = $this->ventas->insertarVenta($id_venta, $total, $id_usuario, $id_caja, $id_cliente, $forma_pago, $this->session->id_tienda);

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
        $datosCompra = $this->ventas->where('id', $id_venta)->where('id_tienda', $this->session->id_tienda)->first();
        if($datosCompra==null){
          echo 'No autorizado';
          return 0;
        }
         $this->detalle_venta->select('*');
         $this->detalle_venta->where('id_venta', $id_venta);
        $detalleVenta = $this->detalle_venta->findAll();

        $configuracion = $this->configuracion->where('id_tienda', $this->session->id_tienda)->first();


?>
<!DOCTYPE html>
<html>
<head>
<title>Impresión 58mm</title>
<style>
  @page {
    size: 58mm 200mm; /* Ancho 58mm, alto adaptable */
    margin: 0; /* Sin márgenes */
  }
  body {
    width: 58mm;
    margin: 0;
    font-family: Arial, Helvetica, sans-serif; /* O la fuente que desees */
  }
  .ticket {
    width: 100%; /* Ocupa todo el ancho */
  }
  .header, .item, .footer {
    text-align: center;
    margin-bottom: 5px; /* Espacio entre secciones */
  }
  .item {
     display: flex;
     justify-content: space-between;
  }
  .item-name {
    text-align: left;
   
  }
  .item-price {
    text-align: right;
  }
  .item-cant {
    text-align: right;
  }

    .item-head {
    text-align: center;
    font-weight: bold;
  }

    .item-importe {
    text-align: right;
  }
  .footer {
    margin-top: 10px;
  }


.boleta thead th {
  border-bottom: 1px solid black; /* Borde para todo el thead */
}


.cabeza thead th{
  font-size: 0.7em;
  font-weight: normal;
}

.fecha{
  font-size: 0.6em !important;
}

.direccion{
  font-size: 0.7em !important;
}

.tienda{
  font-weight: bold !important;
}

  .boleta{font-size: 0.7em;
margin: 0 auto;}

  h1{font-size: 0.8em;}
  p{font-size: 0.8em;}
</style>
     <script src="<?=base_url()?>vendor/jquery/jquery.min.js"></script>

</head>
<body>
  <div class="ticket">

    <div class="header">
        <img width="100px;" src="<?=base_url().$configuracion['logo']?>"/>
        <table  class="cabeza" style="table-layout: fixed; width: 90%;">
          <thead>
            <tr>
            <th class="tienda"><?=$configuracion['nombre']?></th>
            </tr>
             <tr>
            <th class="direccion"><?=$configuracion['direccion']?></th>
            </tr>
            
               <tr>
            <th class="fecha"><?=date('d-m-Y H:i:s', strtotime($datosCompra['created_at']))?></th>
            </tr>
             <tr>
            <th class="direccion">Folio: <?=$datosCompra['folio']?></th>
            </tr>
          </thead>
        </table>
     
    </div>
   
<table  class="boleta" style="table-layout: fixed; width: 90%;">
      <thead>
        <tr>
        <th style="width: 40%;">Producto</th>
        <th style="width: 25%;">Precio</th>
        <th style="width: 10%;">Cant</th>
         <th style="width: 25%;">Total</th>
        </tr>
      </thead>
      <!-- Filas con datos -->
       <?php
      $cuentaItem = 0;
      $cuentaTotal = 0;
      foreach($detalleVenta as $row){
            $cuentaItem++;
            $cuentaTotal = $cuentaTotal+($row['precio']*$row['cantidad']);?>
            <tr>
        <td class="item-name"><?=$row['nombre']?></td>
        <td class="item-price"><?=$row['precio']?></td>
        <td class="item-cant"><?=$row['cantidad']?></td>
        <td class="item-importe">$<?=number_format($row['precio']*$row['cantidad'], 0, ',', '.')?></td>
            </tr>
      <?php } ?>
    </table>
    
       
    </div>

    <div class="footer">
      <p>Total: $<?=number_format($cuentaTotal, 0, ',', '.')?></p>
      <p>Gracias por su compra!</p>
    </div>
  </div>
</body>
<script type="text/javascript">

$(document).ready(function () {
    window.print();
});

</script>
</html>
<?php


        
    }
}
