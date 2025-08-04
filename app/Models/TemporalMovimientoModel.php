<?php
namespace App\Models;
use CodeIgniter\Model;

class TemporalMovimientoModel extends Model{
    protected $table      = 'temporal_movimiento';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true; 

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['folio', 'id_producto', 'codigo', 'nombre', 'cantidad', 'precio', 'subtotal', 'tipo_movimiento', 'id_caja'];

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


    public function porIdProductoCompra($id_producto, $folio, $precio){
        $this->select('*');
        $this->where('folio', $folio);
        $this->where('id_producto', $id_producto);
        $this->where('precio', $precio);
        $datos = $this->get()->getRow();

        return $datos;
    }

     public function porCompra( $folio){
        $this->select('*');
        $this->where('folio', $folio);
        $datos = $this->findAll();

        return $datos;
    }

    public function updProdCompra( $id_producto, $folio, $precio, $cantidad, $subtotal){
        $this->set('cantidad', $cantidad);
        $this->set('subtotal', $subtotal);
        $this->where('id_producto', $id_producto);
        $this->where('folio', $folio);
        $this->where('precio', $precio);
        $this->update();

    }

        public function delProdCompra( $id_producto, $folio, $precio){
        
        $this->where('id_producto', $id_producto);
        $this->where('folio', $folio);
        $this->where('precio', $precio);
        $this->delete();

    }

     public function eliminarCompra( $folio){
       $this->where('folio', $folio);
        $this->delete();

    }
}

?>
