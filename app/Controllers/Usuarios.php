<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuariosModel;
use App\Models\CajasModel;
use App\Models\RolesModel;
use App\Models\LogsModel;
use App\Models\ConfiguracionModel;
use App\Models\TiendasModel;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Firebase\JWT\JWT;


class Usuarios extends BaseController
{
    protected $usuarios, $cajas, $roles, $log;
    protected $reglas, $reglasLogin, $reglasCambiaPassword, $reglasUpdate, $reglasRegistro;
    use ResponseTrait;

    public function __construct()
    {
        $this->usuarios = new UsuariosModel();
        $this->cajas = new CajasModel();
        $this->roles = new RolesModel();
        $this->log = new LogsModel();

        helper(['form']);

        $this->reglas = [
            'usuario' => [
                'rules' => 'required|is_unique[usuarios.usuario,]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.',
                    'is_unique' => 'El usuario ingresado ya está registrado, favor cambiar nombre de usuario'
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

        $this->reglasUpdate = [
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

        $this->reglasCambiaPassword = [
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
            ]
        ];

        $this->reglasRegistro = [
            'usuario' => [
                'rules' => 'required|is_unique[usuarios.usuario,]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.',
                    'is_unique' => 'El usuario ingresado ya está registrado, favor cambiar nombre de usuario'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[4]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.',
                    'min_length' => 'La contraseña debe tener, al menos 4 caracteres.'
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
            'correo' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ],
            'nombre_tienda' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Debe ingresar el Nombre o Razón Social del comercio.'
                ]
                ],
            'region' => [
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
                ],
            'comuna' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
                ],
            'fono' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'
                ]
            ]
        ];
    }

    public function index($activo = 1)
    {
        $usuarios = $this->usuarios->where('activo', $activo)->where('id_tienda', $this->session->id_tienda)->findAll();
        $data = ['titulo' => 'Usuarios', 'datos' => $usuarios];

        echo view('header');
        echo view('usuarios/index', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        $usuarios = $this->usuarios->where('activo', $activo)->where('id_tienda', $this->session->id_tienda)->findAll();
        $data = ['titulo' => 'Usuarios', 'datos' => $usuarios];

        echo view('header');
        echo view('usuarios/eliminados', $data);
        echo view('footer');
    }

    public function nuevo($valid = null)
    {
        //llamamos cajas
        $cajas = $this->cajas->where('activo', 1)->where('id_tienda', $this->session->id_tienda)->orderBy('nombre', 'asc')->findAll();
        //llamamos roles
        $roles = $this->roles->where('activo', 1)->where('id_tienda', $this->session->id_tienda)->orderBy('nombre', 'asc')->findAll();

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
                'activo' => 1,
                'id_tienda' => $this->session->id_tienda
            ]);
            return redirect()->to(base_url() . 'usuarios');
        } else {
            $this->nuevo($this->validator);
        }
    }


    public function editar($id, $valid = null)
    {
        //llamamos cajas
        $cajas = $this->cajas->where('activo', 1)->where('id_tienda', $this->session->id_tienda)->orderBy('nombre', 'asc')->findAll();
        //llamamos roles
        $roles = $this->roles->where('activo', 1)->where('id_tienda', $this->session->id_tienda)->orderBy('nombre', 'asc')->findAll();

        try {
            $usuario = $this->usuarios->where('id', $id)->where('id_tienda', $this->session->id_tienda)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }
        if ($valid != null) {
            $data = ['titulo' => 'Editar Usuario', 'datos' => $usuario, 'cajas' => $cajas, 'roles' => $roles, 'validation' => $valid];
        } else {


            $data = ['titulo' => 'Editar Usuario', 'datos' => $usuario, 'cajas' => $cajas, 'roles' => $roles];
        }
        echo view('header');
        echo view('usuarios/editar', $data);
        echo view('footer');
    }



    public function actualizar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglasUpdate)) {

            //actualiza password?
            $edit_pwd = $this->request->getPost('edit_pwd');
            if ($edit_pwd == 1) {
                $hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
                $this->usuarios->update($this->request->getPost('id'), [
                    'usuario' => $this->request->getPost('usuario'),
                    'nombre' => $this->request->getPost('nombre'),
                    'id_caja' => $this->request->getPost('id_caja'),
                    'id_rol' => $this->request->getPost('id_rol'),
                    'password' => $hash
                ]);
            } else {
                $this->usuarios->update($this->request->getPost('id'), [
                    'usuario' => $this->request->getPost('usuario'),
                    'nombre' => $this->request->getPost('nombre'),
                    'id_caja' => $this->request->getPost('id_caja'),
                    'id_rol' => $this->request->getPost('id_rol')
                ]);
            }

            return $this->editar($this->request->getPost('id'));
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

                    //para llamar logo
                    $configuracion = new configuracionModel();
                    $logo = $configuracion->select('logo')->where('id_tienda', $datosUsuario['id_tienda'])->first();

                    $datosSesion = [
                        'id_usuario' => $datosUsuario['id'],
                        'nombre' => $datosUsuario['nombre'],
                        'user' => $datosUsuario['usuario'],
                        'id_caja' => $datosUsuario['id_caja'],
                        'id_rol' => $datosUsuario['id_rol'],
                        'id_tienda' => $datosUsuario['id_tienda'],
                        'ruta_logo' => $logo['logo']
                    ];

                    $this->log->save([
                        'id_usuario' => $datosUsuario['id'],
                        'evento' => 'Inicia Sesión',
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'device' => $_SERVER['HTTP_USER_AGENT']
                    ]);

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
        $this->log->save([
            'id_usuario' => $this->session->id_usuario,
            'evento' => 'Cierra Sesión',
            'ip' => $_SERVER['REMOTE_ADDR'],
            'device' => $_SERVER['HTTP_USER_AGENT']
        ]);
        $session = session();
        $session->destroy();
        return redirect()->to(base_url());
    }

    public function cambia_password($valid = null)
    {
        //recuperamos datos de la sesion
        $session = session();
        //llamamos usuario
        $usuario = $this->usuarios->where('id', $session->id_usuario)->first();

        if ($valid != null) {
            $data = ['titulo' => 'Cambiar Contraseña', 'usuario' => $usuario, 'validation' => $valid];
        } else {
            $data = ['titulo' => 'Cambiar Contraseña', 'usuario' => $usuario];
        }


        echo view('header');
        echo view('usuarios/cambia_password', $data);
        echo view('footer');
    }

    public function actualizar_password()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglasCambiaPassword)) {

            $hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            $this->usuarios->update($this->request->getPost('id'), [
                'password' => $hash
            ]);
            //llamamos usuario
            $usuario = $this->usuarios->where('id', $this->request->getPost('id'))->first();

            $data = ['titulo' => 'Cambiar Contraseña', 'usuario' => $usuario, 'mensaje' => 'Contraseña actualizada'];
            echo view('header');
            echo view('usuarios/cambia_password', $data);
            echo view('footer');
        } else {
            $this->cambia_password($this->validator);
        }
    }



    public function authAPI()
    {

        if ($this->request->getMethod() == "POST" && $this->validate($this->reglasLogin)) {
            $usuario = $this->request->getPost('usuario');
            $password = $this->request->getPost('password');

            $datosUsuario = $this->usuarios->where('usuario', $usuario)->first();
            if ($datosUsuario != null) {
                if (password_verify($password, $datosUsuario['password'])) {

                    // $resultado = $datosUsuario['usuario'].' autenticado!';
                    // return $this->respond($resultado);
                    $jwt = $this->generateJWT($datosUsuario['usuario']);
                    return $this->respond(['Token' => $jwt], 201);
                } else {
                    $resultado = 'contraseña incorrecta';
                    return $this->failValidationErrors($resultado);
                }
            } else {
                $resultado = 'Usuario o contraseña incorrecta';
                return $this->failNotFound($resultado);
            }
        } else {
            $resultado = 'Error en el servidor';
            return $this->failServerError($resultado);
        }
    }


    protected function generateJWT($usuario)
    {

        $datosUsuario = $this->usuarios->where('usuario', $usuario)->first();
        $key = Services::getSecretKey();

        $payload = [
            'aud' => base_url(),
            'iat' => time(),
            'exp' => time() + 60,
            'data' => [
                'username' => $usuario,
                'nombre' => $datosUsuario['nombre'],
                'rol' => $datosUsuario['id_rol']
            ]
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        return $jwt;
    }


    public function registro()
    {
        if ($this->request->getMethod() == "POST") {
            if ($this->validate($this->reglasRegistro)) {

                if (!validarRut($this->request->getPost('rut'))) {
                    $data = ['mensaje_error' => 'El RUT Ingresado no es válido'];
                    echo view('registro', $data);
                    exit;
                } else {
                    //limpiamos rut
                    $rut = str_replace('.', '', $this->request->getPost('rut'));
                    //primero creamos la tienda
                    $tienda = new TiendasModel();
                    $insertTienda = [
                        'rut' => $rut,
                        'nombre' => $this->request->getPost('nombre_tienda'),
                        'direccion' => $this->request->getPost('direccion'),
                        'comuna' => $this->request->getPost('comuna'),
                        'region' => $this->request->getPost('region'),
                        'encargado' => $this->request->getPost('nombre'),
                        'fono' => $this->request->getPost('fono'),
                        'correo' => $this->request->getPost('correo')
                    ];
                    $tienda->insert($insertTienda);
                    $id_tienda = $tienda->getInsertID();

                    //Luego creamos caja nueva
                    $caja = new CajasModel();
                    $insertCaja = [
                        'numero_caja' => 'Caja 1',
                        'nombre' => 'Caja Principal',
                        'folio' => 1,
                        'activo' => 1,
                        'id_tienda' => $id_tienda

                    ];
                    $caja->insert($insertCaja);
                    $id_caja = $caja->getInsertID();

                    $hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

                    $this->usuarios->save([
                        'usuario' => $this->request->getPost('usuario'),
                        'nombre' => $this->request->getPost('nombre'),
                        'password' => $hash,
                        'id_caja' => $id_caja,
                        'id_rol' => 1, //admin
                        'activo' => 1,
                        'id_tienda' => $id_tienda
                    ]);
                    $email = \Config\Services::email();
                    $email->setFrom('cleverpos@infoclever.cl', 'CleverPOS');
                    $email->setTo($this->request->getPost('correo'));
                    $email->setSubject('Bienvenido/a al sistema CleverPOS');
                    $email->setMessage('Para acceder debe entrar en este <a href="' . base_url() . '">link</a> e ingresar con los datos que definió al registrarse.');
                    $email->setMailType('html');
                    if ($email->send()) {
                        // Correo enviado correctamente
                        $enviado = 'OK';
                    } else {
                        // Error al enviar el correo
                        $enviado =  'Error al enviar el correo: ' . $email->printDebugger();
                        // exit;
                    }
                    $data = [
                        'mensaje_success' => 'Se ha registrado con éxito, le enviamos un correo electrónico con las instrucciones para ingresar al sistema',
                        'mail_enviado' => $enviado
                    ];
                    echo view('registro', $data);
                }
            } else {
                $data = ['validation' => $this->validator];
                echo view('registro', $data);
            }
        } else {
            echo view('registro');
        }
    }
}
