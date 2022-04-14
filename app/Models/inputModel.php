<?php

namespace App\Models;

use CodeIgniter\Model;

class inputModel extends Model
{
    protected $table = 'input_manual';
    protected $primaryKey = 'id_panen';
    protected $allowedFields = [
        'nilaiX',
        'nilaiY'
    ];

    public function totalX(){
        $var = $this->db->query("SELECT SUM(nilaiX) AS totalX FROM input_manual");
        return $var->getResult();
    }

    public function totalY(){
        $var = $this->db->query("SELECT SUM(nilaiY) AS totalY FROM input_manual ");
        return $var->getResult();
    }

    public function XKuadrat(){
        $var = $this->db->query("SELECT SUM(POWER(nilaiX, 2)) AS xKuadrat FROM input_manual");
        return $var->getResult();
    }

    public function YKuadrat(){
        $var = $this->db->query("SELECT SUM(POWER(nilaiY, 2)) AS yKuadrat FROM input_manual");
        return $var->getResult();
    }

    public function XtimesY(){
        $var = $this->db->query("SELECT SUM(nilaiX * nilaiY) AS xKaliy FROM input_manual");
        return $var->getResult();
    }

    public function total_panen(){
        $var = $this->db->query("SELECT COUNT(id_panen) AS n FROM input_manual");
        return $var->getResult();
    }

    public function totalX_kuadrat(){
        $var = $this->db->query("SELECT POWER(SUM(nilaiX),2) AS totalX_kuadrat FROM input_manual");
        return $var->getResult();
    }

    public function totalY_kuadrat(){
        $var = $this->db->query("SELECT POWER(SUM(nilaiY),2) AS totalY_kuadrat FROM input_manual");
        return $var->getResult();
    }


}
