<?php
namespace App\Models;
use CodeIgniter\Model;

class ProductosModel extends Model{
    protected $table      = 'productos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['codigo', 'nombre', 'precio_venta', 'precio_compra', 'existencias', 
    'stock_minimo', 'inventariable', 'id_unidad', 'id_categoria', 'activo', 'id_tienda', 'imagen'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

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


    public function actualizaStock($id_producto, $cantidad){
        $this->set('existencias', "existencias + $cantidad", FALSE);
        $this->where('id', $id_producto);
        $this->update();
    }

    public function totalProductos($id_tienda){
        $total = $this->where('activo', 1)->where('id_tienda', $id_tienda)->countAllResults();
        return $total;
    }

    public function productosMinimo($id_tienda){
        $total = $this->where('activo', 1)->where('id_tienda', $id_tienda)->where('inventariable', 1)
        ->where('existencias < stock_minimo')->countAllResults();
    return $total;
    }
}

?>