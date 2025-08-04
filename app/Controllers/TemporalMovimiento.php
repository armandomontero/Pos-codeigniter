<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductosModel;
use App\Models\TemporalMovimientoModel;

class TemporalMovimiento extends BaseController
{
    protected $temporal_movimiento, $productos;


    public function __construct()
    {
        $this->temporal_movimiento = new TemporalMovimientoModel();
        $this->productos = new ProductosModel();
        helper(['form']);
        helper('number');

    }




    public function insertar($id_producto, $cantidad, $precio, $id_compra, $tipo_movimiento)
    {

        $error = '';

        $producto = $this->productos->where('id', $id_producto)->first();

        if ($producto) {
            $datosExiste = $this->temporal_movimiento->porIdProductoCompra($id_producto, $id_compra, $precio);

            if ($datosExiste) {
                $cantidad = $datosExiste->cantidad + $cantidad;
                $subtotal = round($cantidad * $datosExiste->precio, 0);

                //actualizamos temporal ya existente
                $this->temporal_movimiento->updProdCompra($id_producto, $id_compra, $precio, $cantidad, $subtotal);

            } else {
                
                $subtotal = round($cantidad * $precio, 0);

                //insertamos temporal
                $this->temporal_movimiento->save([
                    'folio' => $id_compra,
                    'id_producto' => $id_producto,
                    'codigo' => $producto['codigo'],
                    'nombre' => $producto['nombre'],
                    'cantidad' => $cantidad,
                    'precio' => $precio,
                    'subtotal' => $subtotal,
                    'tipo_movimiento' => $tipo_movimiento,
                    'id_caja' => $this->session->id_caja
                ]);
            
        }
        } else {
            $error = 'No existe el producto';
        }

        $res['error'] = $error;
        $res['datos'] = $this->cargaProductos($id_compra);
        $res['total'] = number_to_currency($this->totalProductos($id_compra), 'USD', 'en_US', 0);
        $res['total_numero'] = $this->totalProductos($id_compra);

        echo json_encode($res);
    }

    public function cargaProductos($id_compra){
        $resultado = $this->temporal_movimiento->porCompra($id_compra);
        $fila = '';
        $numFila = 0;

        foreach($resultado as $row) {
            $numFila++;

            $fila .= "<tr id='fila".$numFila."'>";
            $fila .= "<td align='right'>".$numFila."</td>";
            $fila .="<td align='right'>".$row['codigo']."</td>";
            $fila .="<td align='center'>".$row['nombre']."</td>";
            $fila .="<td align='right'>".number_format($row['precio'], 0, ',', '.')."</td>";
            $fila .="<td align='right'>".$row['cantidad']."</td>";
            $fila .="<td align='right'>".number_format($row['subtotal'], 0, ',', '.')."</td>";
            $fila .="<td> <a class='borrar btn btn-danger btn-sm' onClick=\"eliminarProducto(".$row['id_producto'].", '".$row['folio']."', '".$row['precio']."')\"><i class='fas fa-trash-alt sm'></i></a> </td>";
            $fila .= "</tr>";

        }
       return $fila;
    }


    


    public function totalProductos($id_compra){
        $resultado = $this->temporal_movimiento->porCompra($id_compra);
        $total = 0;

        foreach($resultado as $row) {
            $total +=$row['subtotal'];

        }
       return $total;
    }


    public function eliminar($id_producto, $id_compra, $precio)
    {
        $datosExiste = $this->temporal_movimiento->porIdProductoCompra($id_producto, $id_compra, $precio);
        if($datosExiste){
           if($datosExiste->cantidad>1){
            $cantidad = $datosExiste->cantidad - 1;
            $subtotal = $datosExiste->precio*$cantidad;

            //actualizamos
            $this->temporal_movimiento->updProdCompra($id_producto, $id_compra, $precio, $cantidad, $subtotal);
           }
           else{
            $this->temporal_movimiento->delProdCompra($id_producto, $id_compra, $precio);
           }
        }

        $res['error'] = '';
        $res['datos'] = $this->cargaProductos($id_compra);
        $res['total'] = number_to_currency($this->totalProductos($id_compra), 'USD', 'en_US', 0);
        $res['total_numero'] = $this->totalProductos($id_compra);
        echo json_encode($res);
    }
}
