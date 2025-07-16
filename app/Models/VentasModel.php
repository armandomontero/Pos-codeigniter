<?php
namespace App\Models;
use CodeIgniter\Model;

class VentasModel extends Model{
    protected $table      = 'ventas';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true; 

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['folio', 'total', 'id_usuario', 'id_caja', 'id_cliente', 'forma_pago', 'activo', 'id_tienda'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
   protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function insertarVenta($id_venta, $total, $id_usuario, $id_caja, $id_cliente, $forma_pago, $id_tienda){
         $this->insert([
            'folio' => $id_venta,
            'total' => $total,
            'id_usuario' => $id_usuario,
            'id_caja' => $id_caja,
            'id_cliente' => $id_cliente,
            'forma_pago' => $forma_pago,
            'activo' => 1,
            'id_tienda' => $id_tienda
        ]);

        return $this->insertID();
    }


    public function obtener($activo = 1, $id_tienda){
        $this->select('ventas.*, u.nombre AS cajero, c.nombre AS cliente');
        $this->join('usuarios AS u', 'ventas.id_usuario = u.id');
        $this->join('clientes AS c', 'ventas.id_cliente = c.id');
        $this->where('ventas.activo', $activo);
        $this->where('ventas.id_tienda', $id_tienda);
        $this->orderBy('ventas.created_at', 'DESC');
        $datos = $this->findAll();

        return $datos;
    }
}

?>
