<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RolesModel;

class roles extends BaseController
{

    protected $roles;
    protected $reglas;

    public function __construct()
    {
        $this->roles = new RolesModel();

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

    public function index($activo = 1)
    {
        $roles = $this->roles->where('activo', $activo)->findAll();
        $data = ['titulo' => 'Roles', 'datos' => $roles];

        echo view('header');
        echo view('roles/index', $data);
        echo view('footer');
    }

    public function eliminados($activo = 0)
    {
        $roles = $this->roles->where('activo', $activo)->findAll();
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
                'activo' => 1
            ]);
            return redirect()->to(base_url() . 'roles');
        } else {
            $this->nuevo($this->validator);
        }
    }


    public function editar($id, $valid=null)
    {
        try {
            $categoria = $this->roles->where('id', $id)->first();
        } catch (\Exception $e) {
            exit($e->getMessage());
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
    }else{
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
}
