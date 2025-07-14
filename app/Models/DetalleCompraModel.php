<?php
namespace App\Models;
use CodeIgniter\Model;

class DetalleCompraModel extends Model{
    protected $table      = 'detalle_compra';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true; 

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_compra', 'id_producto', 'nombre', 'cantidad', 'precio'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';

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


    public function porIdProductoCompra($id_producto, $folio){
        $this->select('*');
        $this->where('folio', $folio);
        $this->where('id_producto', $id_producto);
        $datos = $this->get()->getRow();

        return $datos;
    }

     public function porCompra( $folio){
        $this->select('*');
        $this->where('folio', $folio);
        $datos = $this->findAll();

        return $datos;
    }

    public function updProdCompra( $id_producto, $folio, $cantidad, $subtotal){
        $this->set('cantidad', $cantidad);
        $this->set('subtotal', $subtotal);
        $this->where('id_producto', $id_producto);
        $this->where('folio', $folio);
        $this->update();

    }

        public function delProdCompra( $id_producto, $folio){
        
        $this->where('id_producto', $id_producto);
        $this->where('folio', $folio);
        $this->delete();

    }
}

?>
