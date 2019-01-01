<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class deposit extends Model
{

    public function _Kredit(){
        if($this->deposit_type_id == 2 or $this->deposit_type_id == 3){
            return $this->nominal_transaction;
        }
        return "-";
    }

    public function _Debit(){
        if($this->deposit_type_id == 1 or $this->deposit_type_id == 4){
            return $this->nominal_transaction;
        }
        return "-";
    }
}
