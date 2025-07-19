<?php

namespace App\Controllers;

use App\Models\ProductosModel;
use App\Models\VentasModel;

class Home extends BaseController
{
  protected $productosModel, $ventasModel;

     public function __construct() {
      $this->productosModel = new ProductosModel();
      $this->ventasModel = new VentasModel();
    }

    public function index()
    {
      $total_productos = $this->productosModel->totalProductos($this->session->id_tienda);

      $ventas_dia = $this->ventasModel->cuentaDia($this->session->id_tienda, date('Y-m-d'));
      $total_dia = $this->ventasModel->totalDia($this->session->id_tienda, date('Y-m-d'));
      $productos_minimo = $this->productosModel->productosMinimo($this->session->id_tienda);
      
      $datos = ['total_productos' => $total_productos, 'total_dia' => $total_dia, 'ventas_dia' => $ventas_dia, 'productos_minimo' => $productos_minimo];


      echo view('header');
      echo view('index', $datos);
      echo view('footer');
    }
}
