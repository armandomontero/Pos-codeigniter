<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UsuariosModel;

class Clientes extends ResourceController
{
    protected $usuarios;

     public function __construct() {
        $this -> usuarios = new UsuariosModel();
    }

    public function index()
    {
        $list_users = $this->usuarios->findAll();
        //print_r($this->usuarios->getLastQuery());
        return $this->respond($list_users);
    }
}
