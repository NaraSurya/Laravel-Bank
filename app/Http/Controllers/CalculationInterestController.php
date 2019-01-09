<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\calculationInterest;
use Carbon\Carbon;
use App\member;
use App\masterInterest;
use App\deposit;
use Gate;
class CalculationInterestController extends Controller
{
    public function __construct(){
        $this->middleware('auth');   
    }

    public function index(){
        if(!Gate::allows('isAdmin') && !Gate::allows('isDepositEmployee') ){
            abort(403);
        }
        $calculationInterest = calculationInterest::all(); 
        return view('calculationInterest.index',['calculationInterest'=>$calculationInterest]);
    }

    public function store(Request $request){
        if(!Gate::allows('isAdmin') && !Gate::allows('isDepositEmployee') ){
            abort(403);
        }
        $transactionMonth = explode('-',$request->transaction_month,2);
        $date = Carbon::now();
        $masterInterest = masterInterest::where('start_date','<=',$date)->get();
        
        if($error = $this->_Validate($transactionMonth , $masterInterest)){
            return redirect()->back()->withErrors(['msg'=>$error])->withInput();
        }

       

        $dateTwoMonthAgo= Carbon::parse($request->transaction_month)->subMonth(2);
        $percentage = $masterInterest->sortByDesc('start_date')->first()->percentage;
        $interestId = $masterInterest->sortByDesc('start_date')->first()->id;
        $user = Auth::user()->id;
        $lastDateToMonthAgo = $dateTwoMonthAgo->endOfMonth();
        $members = member::where('aktive',1)->get();
        $totalInterest = 0;

       

        $calculationInterest = calculationInterest::create([
            'transaction_month'=>$transactionMonth[1],
            'transaction_year'=>$transactionMonth[0],
            'calculation_date'=>$date,
            'master_interest_id'=>$interestId,
            'user_id'=>$user
        ]);

        foreach($members as $member){
            $balance = $member->_BalanceAtDate($lastDateToMonthAgo);
            $nominal_transaction = $balance * $percentage / 100; 
            $deposits = deposit::create([
                'date' => $date ,
                'nominal_transaction' => $nominal_transaction , 
                'member_id' => $member->id , 
                'deposit_type_id'=>3,
                'user_id'=>$user
            ]);
            $totalInterest += $nominal_transaction;
        }
        $calculationInterest->total_interests = $totalInterest;
        $calculationInterest->save();

        return redirect()->back();
    }

    private function _Validate($transactionMonth , $masterInterest){
        $checkCalculationInterest = calculationInterest::where('transaction_year',$transactionMonth[0])
                                                        ->where('transaction_month',$transactionMonth[1])
                                                        ->count();
        if($checkCalculationInterest > 0){
            return "perhitungan bunga sudah dilakukan"; 
        }
        if($masterInterest->isEmpty()){
            return "tidak ada bunga";
        }
    }
}
