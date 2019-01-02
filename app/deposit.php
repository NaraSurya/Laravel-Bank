<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class deposit extends Model
{

    protected $fillable = [
        'date' , 'nominal_transaction' , 'member_id' , 'user_id' , 'deposit_type_id'
    ];

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

    public function deposit_type()
    {
        return $this->belongsTo('App\deposit_type');
    }

    public function member()
    {
        return $this->belongsTo('App\member');
    }
}
