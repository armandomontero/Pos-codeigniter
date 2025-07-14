<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TemporalComprasModel;
use App\Models\ProductosModel;

class TemporalCompras extends BaseController
{
    protected $temporal_compras, $productos;


    public function __construct()
    {
        $this->temporal_compras = new TemporalComprasModel();
        $this->productos = new ProductosModel();
        helper(['form']);
    }




    public function insertar($id_producto, $cantidad, $id_compra)
    {

        $error = '';

        $producto = $this->productos->where('id', $id_producto)->first();

        if ($producto) {
            $datosExiste = $this->temporal_compras->porIdProductoCompra($id_producto, $id_compra);

            if ($datosExiste) {
                $cantidad = $datosExiste->cantidad + $cantidad;
                $subtotal = $cantidad * $datosExiste->precio;

                //actualizamos temporal ya existente
                $this->temporal_compras->updProdCompra($id_producto, $id_compra, $cantidad, $subtotal);

            } else {
                $subtotal = $cantidad * $producto['precio_compra'];

                //insertamos temporal
                $this->temporal_compras->save([
                    'folio' => $id_compra,
                    'id_producto' => $id_producto,
                    'codigo' => $producto['codigo'],
                    'nombre' => $producto['nombre'],
                    'cantidad' => $cantidad,
                    'precio' => $producto['precio_compra'],
                    'subtotal' => $subtotal
                ]);
            }
        } else {
            $error = 'No existe el producto';
        }

        $res['error'] = $error;
        $res['datos'] = $this->cargaProductos($id_compra);
        $res['total'] = $this->totalProductos($id_compra);
        echo json_encode($res);
    }

    public function cargaProductos($id_compra){
        $resultado = $this->temporal_compras->porCompra($id_compra);
        $fila = '';
        $numFila = 0;

        foreach($resultado as $row) {
            $numFila++;

            $fila .= "<tr id='fila".$numFila."'>";
            $fila .= "<td>".$numFila."</td>";
            $fila .="<td>".$row['codigo']."</td>";
            $fila .="<td>".$row['nombre']."</td>";
            $fila .="<td>".$row['precio']."</td>";
            $fila .="<td>".$row['cantidad']."</td>";
            $fila .="<td>".$row['subtotal']."</td>";
            $fila .="<td> <a class='borrar btn btn-danger btn-sm' onClick=\"eliminaProducto(".$row['id'].")\"><i class='fas fa-trash-alt sm'></i></a> </td>";
            $fila .= "</tr>";

        }
       return $fila;
    }


    public function totalProductos($id_compra){
        $resultado = $this->temporal_compras->porCompra($id_compra);
        $total = 0;

        foreach($resultado as $row) {
            $total +=$row['subtotal'];

        }
       return $total;
    }
}
