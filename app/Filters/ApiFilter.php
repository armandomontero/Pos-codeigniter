<?php

namespace App\Filters;

use App\Models\UsuariosModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use CodeIgniter\API\ResponseTrait;
use Exception;
use Firebase\JWT\JWT;

use function PHPUnit\Framework\isNull;

class ApiFilter implements FilterInterface
{
    use ResponseTrait;
    

    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getServer(index:'HTTP_AUTHORIZATION');
        if($authHeader==null){
            $mensaje = ['Mensaje'=> 'No se ha enviado JWT',
            'status'=>201];
             return Services::response()->setJSON($mensaje);
            
        }
        $user = new UsuariosModel();

        $key = Services::getSecretKey();
        
            
        
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No es necesario realizar ninguna acción después de la ejecución del controlador.
    }
}