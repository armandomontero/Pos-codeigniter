<?php
namespace App\Models;
use CodeIgniter\Model;

class RolesPermisosModel extends Model{
    protected $table      = 'roles_permisos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true; 

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_rol', 'id_permiso', 'id_tienda'];

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


    public function verificaPermiso($id_rol, $permiso){
        $acceso = false;

        $this->select('*');
        $this->join('permisos', 'roles_permisos.id_permiso = permisos.id');
        $existe = $this->where(['id_rol'=> $id_rol, 'permisos.nombre'=> $permiso])->first();

        if($existe!=null){
            $acceso = true;
        }

        return $acceso;
    }
}

?>
