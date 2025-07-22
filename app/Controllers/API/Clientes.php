<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UsuariosModel;

class Clientes extends ResourceController
{
    protected $usuarios;
    protected $format = 'json';

    public function __construct()
    {
        $this->usuarios = new UsuariosModel();
    }

    public function index()
    {
        $list_users = $this->usuarios->findAll();
        //print_r($this->usuarios->getLastQuery());
        return $this->respond($list_users);
    }

    public function show($id = null)
    {
        $user = $this->usuarios->find($id);
        //print_r($this->usuarios->getLastQuery());
        if ($user) {
            return $this->respond($user, 200);
        } else {
            return $this->failNotFound('No encontrado');
        }
    }
}
