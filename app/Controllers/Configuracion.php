<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\configuracionModel;

class configuracion extends BaseController
{
    protected $configuracion;
    protected $reglas;

    public function __construct()
    {
        $this->configuracion = new configuracionModel();
        helper(['form']);

        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'direccion' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ]
        ];
    }

    public function index()
    {
        $configuracion = $this->configuracion->where('id_tienda', $this->session->id_tienda)->first();
        $data = ['titulo' => 'Configuracion', 'datos' => $configuracion];

        echo view('header');
        echo view('configuracion/index', $data);
        echo view('footer');
    }

    

    


    public function actualizar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            //comprobamos que exista
            $configuracion = $this->configuracion->where('id', $this->request->getPost('id'))->first();
           
            $validacion = $this->validate([
                'tienda_logo' => [
                    'uploaded[tienda_logo]',
                    'mime_in[tienda_logo,image/png,image/jpeg]',
                    'max_size[tienda_logo,4096]'
                ]
            ]);
            if($validacion){
            $img = $this->request->getFile('tienda_logo');
            $nombre_archivo = 'logo.'.$img->getExtension();
            $carpeta = './img/'.$this->session->id_tienda.'/logo';
            $carpeta_base = 'img/'.$this->session->id_tienda.'/logo';

            
            //Borramos anterior
            if (file_exists('./'.$configuracion['logo'])){
            unlink('./'.$configuracion['logo']); 
            }

            $img->move($carpeta, $nombre_archivo);
            }
            else{
                echo $validacion;
            }

            
            if($configuracion){
                //actualizamos
            $this->configuracion->update($this->request->getPost('id'), [
                'nombre' => $this->request->getPost('nombre'),
                'direccion' => $this->request->getPost('direccion'),
                'mensaje' => $this->request->getPost('mensaje'),
                'logo' => $carpeta_base.'/'.$nombre_archivo
            ]);
        }
        else{
            //insertamos
            $this->configuracion->save([
                'nombre' => $this->request->getPost('nombre'),
                'direccion' => $this->request->getPost('direccion'),
                'mensaje' => $this->request->getPost('mensaje'),
                'id_tienda' => $this->session->id_tienda
            ]);
        }
            return redirect()->to(base_url() . 'configuracion');
        } else {
           return $this->index($this->request->getPost('id'), $this->validator);
        }
    }
    

    
}
