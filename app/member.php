<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class member extends Model
{
    protected $fillable = [
        'name' , 'ktp_number' , 'address' , 'phone_number' , 'gender' , 'profile_picture' , 'user_id' , 'birth_day'
    ];

     
    
    /*
    * Custom Function
    */


    /**
     * Generate the member number where member was created
     *
     * @return string
     */
    public function _MakeMemberNumber(){
        $serialNumber = $this->id % 1000; 
        $date = carbon::now()->format('dmy');
        $memberNumber = $date*1000 + $serialNumber; 
        return (string)$memberNumber; 
    }



    public function _Balance(){
        return $this->_GetTotalDeposits() - $this->_GetTotalWithdrawal() + $this->_GetTotalInterest() - $this->_GetTotalTaxs();
    }

    public function _BalanceAt($transaction_id){
        return $this->_GetTotalDepositsAt($transaction_id) - $this->_GetTotalWithdrawalAt($transaction_id) + $this->_GetTotalInterestAt($transaction_id) - $this->_GetTotalTaxsAt($transaction_id);
    }

    public function _GetTotalDeposits(){
        return $this->deposit->where('deposit_type_id','1')->sum('nominal_transaction');
    }
    public function _GetTotalDepositsAt($transaction_id){
        return $this->deposit->where('deposit_type_id','1')
                             ->where('id','<=', $transaction_id)
                             ->sum('nominal_transaction');
    }

    public function _GetTotalWithdrawal(){
        return $this->deposit->where('deposit_type_id','2')->sum('nominal_transaction');
    }
    public function _GetTotalWithdrawalAt($transaction_id){
        return $this->deposit->where('deposit_type_id','2')
                             ->where('id','<=',$transaction_id)
                             ->sum('nominal_transaction');
    }
    
    public function _GetTotalInterest(){
        return $this->deposit->where('deposit_type_id','3')->sum('nominal_transaction');
    }
    public function _GetTotalInterestAt($transaction_id){
        return $this->deposit->where('deposit_type_id','3')
                             ->where('id','<=',$transaction_id)
                             ->sum('nominal_transaction');
    }

    public function _GetTotalTaxs(){
        return $this->deposit->where('deposit_type_id','4')->sum('nominal_transaction');
    }
    public function _GetTotalTaxsAt($transaction_id){
        return $this->deposit->where('deposit_type_id','4')
                             ->where('id','<=',$transaction_id)
                             ->sum('nominal_transaction');
    }



    /*
    * Relathionship Function
    */

    public function deposit_type()
    {
        return $this->belongsToMany('App\deposit_type')->withPivot('nominal_transaction','date');
    }

    public function deposit()
    {
        return $this->hasMany('App\deposit');
    }

}
