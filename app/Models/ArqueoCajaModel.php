<?php

namespace App\Models;

use CodeIgniter\Model;

class ArqueoCajaModel extends Model
{
    protected $table      = 'arqueo_caja';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_caja',
        'id_usuario',
        'fecha_inicio',
        'fecha_fin',
        'monto_inicial',
        'monto_final',
        'total_efectivo',
        'total_tarjeta',
        'total_transferencia',
        'total_ventas',
        'diferencia',
        'status'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = false;
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


    public function getDatos($id_caja)
    {
        $this->select('arqueo_caja.*, cajas.nombre');
        $this->join('cajas', 'arqueo_caja.id_caja = cajas.id');
        $this->where('arqueo_caja.id_caja', $id_caja);
        $this->orderBy('arqueo_caja.id', 'DESC');
        $datos = $this->findAll();

        return $datos;
    }

    public function cajaAbierta($id_caja)
    {

        $existe = $this->where('id_caja', $id_caja)->where('status', 1)->countAllResults();
        if ($existe > 0) {
            return true;
        } else {
            return false;
        }
    }
}
