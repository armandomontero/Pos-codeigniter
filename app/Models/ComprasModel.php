<?php
namespace App\Models;
use CodeIgniter\Model;

class ComprasModel extends Model{
    protected $table      = 'compras';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true; 

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['folio', 'total', 'id_usuario', 'activo', 'id_tienda'];

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


    public function insertarCompra($id_compra, $total, $id_usuario, $id_tienda){


         $this->insert([
            'folio' => $id_compra,
            'total' => $total,
            'id_usuario' => $id_usuario,
            'activo' => 1,
            'id_tienda' => $id_tienda
        ]);

        return $this->insertID();
    }
}

?>
