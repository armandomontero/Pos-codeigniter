<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuariosModel;
use App\Models\CajasModel;
use App\Models\RolesModel;

class Usuarios extends BaseController
{
    protected $usuarios, $cajas, $roles;
    protected $reglas, $reglasLogin;

    public function __construct()
    {
        $this->usuarios = new UsuariosModel();
        $this->cajas = new CajasModel();
        $this->roles = new RolesModel();

        helper(['form']);

        $this->reglas = [
            'usuario' => [
                'rules' => 'required|is_unique[usuarios.usuario]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.',
                    'required' => 'El usuario ingresado ya está registrado.'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'repassword' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.',
                    'matches' => 'La contraseña no coincide.'
                ]
            ],
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'id_caja' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'id_rol' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ]
        ];

        $this->reglasLogin = [
            'usuario' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ]

        ];
    }

    public function index($activo = 1)
    {
        $usuarios = $this->usuarios->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Usuarios', 'datos' => $usuarios];

        echo view('header');
        echo view('usuarios/index', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        $usuarios = $this->usuarios->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Usuarios', 'datos' => $usuarios];

        echo view('header');
        echo view('usuarios/eliminados', $data);
        echo view('footer');
    }

    public function nuevo($valid = null)
    {
        //llamamos cajas
        $cajas = $this->cajas->where('activo', 1)->orderBy('nombre', 'asc')->findAll();
        //llamamos roles
        $roles = $this->roles->where('activo', 1)->orderBy('nombre', 'asc')->findAll();

        if ($valid != null) {
            $data = ['titulo' => 'Agregar Usuario', 'cajas' => $cajas, 'roles' => $roles, 'validation' => $valid];
        } else {
            $data = ['titulo' => 'Agregar Usuario', 'cajas' => $cajas, 'roles' => $roles];
        }


        echo view('header');
        echo view('usuarios/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {

            $hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

            $this->usuarios->save([
                'usuario' => $this->request->getPost('usuario'),
                'nombre' => $this->request->getPost('nombre'),
                'password' => $hash,
                'id_caja' => $this->request->getPost('id_caja'),
                'id_rol' => $this->request->getPost('id_rol'),
                'activo' => 1
            ]);
            return redirect()->to(base_url() . 'usuarios');
        } else {
            $this->nuevo($this->validator);
        }
    }


    public function editar($id, $valid = null)
    {
        try {
            $unidad = $this->usuarios->where('id', $id)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        if ($valid != null) {
            $data = ['titulo' => 'Editar Unidad', 'datos' => $unidad, 'validation' => $valid];
        } else {


            $data = ['titulo' => 'Editar Unidad', 'datos' => $unidad];
        }
        echo view('header');
        echo view('usuarios/editar', $data);
        echo view('footer');
    }



    public function actualizar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->usuarios->update($this->request->getPost('id'), [
                'nombre' => $this->request->getPost('nombre'),
                'nombre_corto' => $this->request->getPost('nombre_corto')
            ]);
            return redirect()->to(base_url() . 'usuarios/editar/' . $this->request->getPost('id'));
        } else {
            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->usuarios->update($id, [
            'activo' => 0
        ]);
        return redirect()->to(base_url() . 'usuarios');
    }

    public function reingresar($id)
    {
        $this->usuarios->update($id, [
            'activo' => 1
        ]);
        return redirect()->to(base_url() . 'usuarios');
    }

    public function login()
    {
        //comprobamos si ya no habia iniciado sesion
        $session = session();
        if ($session->user != null) {
            return redirect()->to(base_url() . 'index');
        }
        echo view('login');
    }

    public function valida()
    {

        if ($this->request->getMethod() == "POST" && $this->validate($this->reglasLogin)) {
            $usuario = $this->request->getPost('usuario');
            $password = $this->request->getPost('password');
            $datosUsuario = $this->usuarios->where('usuario', $usuario)->first();
            if ($datosUsuario != null) {
                if (password_verify($password, $datosUsuario['password'])) {
                    $datosSesion = [
                        'id_usuario' => $datosUsuario['id'],
                        'nombre' => $datosUsuario['nombre'],
                        'user' => $datosUsuario['usuario'],
                        'id_caja' => $datosUsuario['id_caja'],
                        'id_rol' => $datosUsuario['id_rol']
                    ];

                    $session = session();
                    $session->set($datosSesion);

                    return redirect()->to(base_url() . 'index');
                } else {
                    $data['error'] = 'Usuario o contraseña incorrecta';
                    echo view('login', $data);
                }
            } else {
                $data['error'] = 'Usuario o contraseña incorrecta';
                echo view('login', $data);
            }
        } else {
            $data = ['validation' => $this->validator];

            echo view('login', $data);
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url());
    }
}
