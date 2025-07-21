<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CajasModel;
use App\Models\ArqueoCajaModel;
use App\Models\VentasModel;


class Cajas extends BaseController
{

    protected $cajas, $arqueoCaja, $ventas;
    protected $reglas;
    

    public function __construct()
    {
        $this->cajas = new CajasModel();
        $this->arqueoCaja = new ArqueoCajaModel();
        $this->ventas = new VentasModel();

        helper(['form']);

        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                'required' => 'El campo {field} es obligatorio.'

                ]
            ],
            'numero_caja' => [
                'rules' => 'required',
                'errors' => [
                'required' => 'El campo {field} es obligatorio.'
                    

                ]
            ],
            'folio' => [
                'rules' => 'required|is_natural',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.',
                    'is_natural' => 'El campo {field} debe ser un número.'

                ]
            ]
        ];
    }

    public function index($activo = 1)
    {

        

        $cajas = $this->cajas->where('activo', $activo)->where('id_tienda', $this->session->id_tienda )->findAll();
        $data = ['titulo' => 'Cajas', 'datos' => $cajas];

        echo view('header');
        echo view('cajas/index', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        $cajas = $this->cajas->where('activo', $activo)->where('id_tienda', $this->session->id_tienda )->findAll();
        $data = ['titulo' => 'Cajas', 'datos' => $cajas];

        echo view('header');
        echo view('cajas/eliminados', $data);
        echo view('footer');
    }

    public function nuevo($valid = null)
    {
        if ($valid != null) {
            $data = ['titulo' => 'Agregar Caja', 'validation' => $valid];
        } else {
            $data = ['titulo' => 'Agregar Caja'];
        }
        echo view('header');
        echo view('cajas/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->cajas->save([
                'numero_caja' => $this->request->getPost('numero_caja'),
                'nombre' => $this->request->getPost('nombre'),
                'folio' => $this->request->getPost('folio'),
                'id_tienda' => $this->session->id_tienda
            ]);
            return redirect()->to(base_url() . 'cajas');
        } else {
            $this->nuevo($this->validator);
        }
    }


    public function editar($id, $valid = null)
    {
        try {
            $categoria = $this->cajas->where('id', $id)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        if ($valid != null) {
            $data = ['titulo' => 'Editar Caja', 'datos' => $categoria, 'validation' => $valid];
        } else {

            $data = ['titulo' => 'Editar Caja', 'datos' => $categoria];
        }


        echo view('header');
        echo view('cajas/editar', $data);
        echo view('footer');
    }


    public function actualizar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->cajas->update($this->request->getPost('id'), [
                'numero_caja' => $this->request->getPost('numero_caja'),
                'nombre' => $this->request->getPost('nombre'),
                'folio' => $this->request->getPost('folio')
            ]);
            return redirect()->to(base_url() . 'cajas/editar/' . $this->request->getPost('id'));
        } else {
            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->cajas->update($id, [
            'activo' => 0
        ]);
        return redirect()->to(base_url() . 'cajas');
    }

    public function reingresar($id)
    {
        $this->cajas->update($id, [
            'activo' => 1
        ]);
        return redirect()->to(base_url() . 'cajas');
    }

    public function arqueos($id_caja){
        $arqueos = $this->arqueoCaja->getDatos($id_caja);
        $data = ['titulo' => 'Cierres de Caja', 'datos' => $arqueos];

        echo view('header');
        echo view('cajas/arqueos', $data);
        echo view('footer');
    }


    public function nuevo_arqueo(){
        if($this->request->getMethod()=='POST'){
            $fecha = date('Y-m-d H:i:s');
            $redirige = $this->request->getPost('redireccion');
            $existe = 0;

            $existe = $this->arqueoCaja->where('id_caja', $this->session->id_caja)->where('status', 1)->countAllResults();

            if($existe>0){
                echo 'La Caja ya está abierta!';
                exit;
               //return redirect()->to(base_url().'cajas/arqueos/'.$this->session->id_caja);
            }
            $this->arqueoCaja->save([
                'id_caja' => $this->session->id_caja,
                'id_usuario' => $this->session->id_usuario,
                'fecha_inicio' => $fecha,
                'monto_inicial' => $this->request->getPost('monto_inicial'),
                'status' => 1
            ]);

            return redirect()->to(base_url().$redirige);
        }
        else{
            $caja = $this->cajas->where('id', $this->session->id_caja)->first();
            $data = ['titulo' => 'Apertura de Caja', 'datos' => $caja];
        echo view('header');
        echo view('cajas/nuevo_arqueo', $data);
        echo view('footer');
        }
    }

    public function cerrar(){
        if($this->request->getMethod()=='POST'){
            $fecha = date('Y-m-d H:i:s');



            $this->arqueoCaja->update($this->request->getPost('id_arqueo'), [
                'fecha_fin' => $fecha,
                'monto_final' => $this->request->getPost('monto_final'),
                'status' => 0,
                'total_efectivo' => $this->request->getPost('total_efectivo'),
                'total_transferencia' => $this->request->getPost('total_transferencia'),
                'total_tarjeta' => $this->request->getPost('total_tarjeta'),
                'total_ventas' => $this->request->getPost('total_total'),
                'diferencia' => $this->request->getPost('diferencia')
            ]);

            return redirect()->to(base_url().'cajas');
        }
        else{
$arqueo = $this->arqueoCaja->where('id_caja', $this->session->id_caja)->where('status', 1)->first();

            $montoTotalEfectivo = $this->ventas->totalDiaCaja($this->session->id_tienda, $this->session->id_caja, $arqueo['fecha_inicio'],  date('Y-m-d H:i:s'), '001');
            $montoTransferencia = $this->ventas->totalDiaCaja($this->session->id_tienda, $this->session->id_caja, $arqueo['fecha_inicio'], date('Y-m-d H:i:s'), '003');
            $montoTotalTarjeta = $this->ventas->totalDiaCaja($this->session->id_tienda, $this->session->id_caja, $arqueo['fecha_inicio'], date('Y-m-d H:i:s'), '002');


            
            $caja = $this->cajas->where('id', $this->session->id_caja)->first();
            $data = ['titulo' => 'Cierre de Caja', 'datos' => $caja, 'arqueo' => $arqueo,
             'montoTotalEfectivo' => $montoTotalEfectivo, 'montoTransferencia' => $montoTransferencia,
            'montoTotalTarjeta' => $montoTotalTarjeta];
        echo view('header');
        echo view('cajas/cerrar', $data);
        echo view('footer');
        }
    }
}
