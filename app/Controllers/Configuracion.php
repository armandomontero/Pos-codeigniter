<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ConfiguracionModel;

class Configuracion extends BaseController
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
            $ruta_bd = '/';
            if ($configuracion) {
                $ruta_bd = $configuracion['logo'];
            }
            $carpeta_base = 'img/' . $this->session->id_tienda . '/logo';

            if ($this->request->getFile('tienda_logo')->getPath()) {

                $validacion = $this->validate([
                    'tienda_logo' => [
                        'uploaded[tienda_logo]',
                        'mime_in[tienda_logo,image/png,image/jpeg]',
                        'max_size[tienda_logo,4096]'
                    ]
                ]);
                if ($validacion) {
                    $img = $this->request->getFile('tienda_logo');
                    $nombre_archivo = uniqid() . 'logo.' . $img->getExtension();
                    $carpeta = './img/' . $this->session->id_tienda . '/logo';



                    //Borramos anterior
                    if (file_exists('./' . $configuracion['logo']) && $configuracion['logo'] != "") {
                        unlink('./' . $configuracion['logo']);
                    }

                    $img->move($carpeta, $nombre_archivo);
                } else {
                    echo $validacion;
                }

                $ruta_bd = $carpeta_base . '/' . $nombre_archivo;
            }

            if ($configuracion) {
                //actualizamos
                $this->configuracion->update($this->request->getPost('id'), [
                    'nombre' => $this->request->getPost('nombre'),
                    'direccion' => $this->request->getPost('direccion'),
                    'mensaje' => $this->request->getPost('mensaje'),
                    'logo' => $ruta_bd
                ]);
            } else {
                //insertamos
                $this->configuracion->save([
                    'nombre' => $this->request->getPost('nombre'),
                    'direccion' => $this->request->getPost('direccion'),
                    'mensaje' => $this->request->getPost('mensaje'),
                    'id_tienda' => $this->session->id_tienda,
                    'logo' => $ruta_bd
                ]);
            }
            return redirect()->to(base_url() . 'configuracion');
        } else {
            return $this->index($this->request->getPost('id'), $this->validator);
        }
    }

    public function getLogo()
    {
        $logo_header = $this->configuracion->select('logo')->where('id_tienda', $this->session->id_tienda)->first();
        echo $logo_header['logo'];
    }
}
