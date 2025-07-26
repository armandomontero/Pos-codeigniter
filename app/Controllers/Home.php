<?php

namespace App\Controllers;

use App\Models\ProductosModel;
use App\Models\VentasModel;
use CodeIgniter\I18n\Time;

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


      //grafico
      $string_grafico = "[";
      for($i=6; $i>=0; $i--){
        $fecha = date("Y-m-d", strtotime("-".$i." day"));
        $time = Time::parse($fecha, 'America/Santiago');
        $dia =  $time->toLocalizedString('EEE');
        $total = $this->ventasModel->totalDia($this->session->id_tienda, $fecha);
        if($total==null){
          $total = 0;
        }
        
        $string_grafico .="{ dia: '".$dia."' , count: $total },";
      
      }
      $string_grafico .="]";
     
      $datos = ['total_productos' => $total_productos, 'total_dia' => $total_dia, 'ventas_dia' => $ventas_dia, 'productos_minimo' => $productos_minimo, 'string_grafico' => $string_grafico];


      echo view('header');
      echo view('index', $datos);
      echo view('footer');
    }
}
