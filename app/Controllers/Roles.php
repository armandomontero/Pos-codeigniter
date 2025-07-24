<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RolesModel;
use App\Models\PermisosModel;
use App\Models\RolesPermisosModel;

class roles extends BaseController
{

    protected $roles, $permisos, $rolesPermisos;
    protected $reglas;

    public function __construct()
    {
        $this->roles = new RolesModel();
        $this->permisos = new PermisosModel();
        $this->rolesPermisos = new RolesPermisosModel();

        helper(['form']);

        $this->reglas = [
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.'

                ]
            ]
        ];
    }

    public function index($activo = 1, $mensaje = null)
    {
        $roles = $this->roles->where('activo', $activo)->where('id_tienda', $this->session->id_tienda)->findAll();
        $data = ['titulo' => 'Roles', 'datos' => $roles, 'mensaje' => $mensaje];

        echo view('header');
        echo view('roles/index', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        $roles = $this->roles->where('activo', $activo)->where('id_tienda', $this->session->id_tienda)->findAll();
        $data = ['titulo' => 'Roles', 'datos' => $roles];

        echo view('header');
        echo view('roles/eliminados', $data);
        echo view('footer');
    }

    public function nuevo($valid = null)
    {
        if ($valid != null) {
            $data = ['titulo' => 'Agregar Rol', 'validation' => $valid];
        } else {
            $data = ['titulo' => 'Agregar Rol'];
        }
        echo view('header');
        echo view('roles/nuevo', $data);
        echo view('footer');
    }

    public function insertar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->roles->save([
                'nombre' => $this->request->getPost('nombre'),
                'activo' => 1,
                'id_tienda' => $this->session->id_tienda
            ]);
            $mensaje = 'Registro almacenado!';
            $this->index(1, $mensaje);
        } else {
            $this->nuevo($this->validator);
        }
    }


    public function editar($id, $valid = null)
    {
        try {
            $categoria = $this->roles->where('id', $id)->where('id_tienda', $this->session->id_tienda)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }

        if ($categoria == null) {
            echo 'No autorizado';
            return 0;
        }
        if ($valid != null) {
            $data = ['titulo' => 'Editar Rol', 'datos' => $categoria, 'validation' => $valid];
        } else {
           
            $data = ['titulo' => 'Editar Rol', 'datos' => $categoria];
        }


        echo view('header');
        echo view('roles/editar', $data);
        echo view('footer');
    }


    public function actualizar()
    {
        if ($this->request->getMethod() == "POST" && $this->validate($this->reglas)) {
            $this->roles->update($this->request->getPost('id'), [
                'nombre' => $this->request->getPost('nombre')
            ]);
            return redirect()->to(base_url() . 'roles/editar/' . $this->request->getPost('id'));
        } else {
            return $this->editar($this->request->getPost('id'), $this->validator);
        }
    }

    public function eliminar($id)
    {
        $this->roles->update($id, [
            'activo' => 0
        ]);
        return redirect()->to(base_url() . 'roles');
    }

    public function reingresar($id)
    {
        $this->roles->update($id, [
            'activo' => 1
        ]);
        return redirect()->to(base_url() . 'roles');
    }


    public function permisos($id)
    {

        $permisos = $this->permisos->findAll();
        // $rolesPermisos = $this->

        $count = 0;
        foreach ($permisos as $permiso) {

            $permisos[$count]['checked'] = false;
            $permiso_asignado = $this->rolesPermisos->where('id_rol', $id)->where('id_permiso', $permiso['id'])->where('id_tienda', $this->session->id_tienda)->first();
            if ($permiso_asignado) {
                $permisos[$count]['checked'] = true;
            }
            $count++;
        }



        $data = ['titulo' => 'Editar Permisos', 'id_rol' => $id, 'permisos' => $permisos];



        echo view('header');
        echo view('roles/permisos', $data);
        echo view('footer');
    }

    public function guardaPermisos()
    {
        if ($this->request->getMethod() == 'POST') {
            $idRol = $this->request->getPost('id_rol');
            $permisos = $this->request->getPost('permisos');

            $this->rolesPermisos->where('id_rol', $idRol)->where('id_tienda', $this->session->id_tienda)->delete();

            foreach ($permisos as $permiso) {
                $this->rolesPermisos->save([
                    'id_rol' => $idRol,
                    'id_permiso' => $permiso,
                    'id_tienda' => $this->session->id_tienda
                ]);
                //print_r($this->rolesPermisos->getLastQuery());
            }

            $this->permisos($idRol);
        }
    }
}
