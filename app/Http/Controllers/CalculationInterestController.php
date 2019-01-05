<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\calculationInterest;
use Carbon\Carbon;
use App\member;
use App\masterInterest;
use App\deposit;
class CalculationInterestController extends Controller
{
    public function __construct(){
        $this->middleware('auth');   
    }

    public function index(){
        $calculationInterest = calculationInterest::all(); 
        return view('calculationInterest.index',['calculationInterest'=>$calculationInterest]);
    }

    public function store(Request $request){

        $dateTwoMonthAgo= Carbon::parse($request->transaction_month)->subMonth(2);
        $transactionMonth = explode('-',$request->transaction_month,2);
        $date = Carbon::now();
        $masterInterest = masterInterest::where('start_date','<=',$date)->get();
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
}
