<?php

namespace App\Http\Controllers;

use App\deposit;
use App\member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DepositController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deposits = deposit::all();
        $balance = $deposits->where('deposit_type_id','1')->sum('nominal_transaction') + $deposits->where('deposit_type_id','4')->sum('nominal_transaction') - $deposits->where('deposit_type_id','2')->sum('nominal_transaction') - $deposits->where('deposit_type_id','3')->sum('nominal_transaction');
        return view('deposit.index',['deposits'=>$deposits , 'balance'=>$balance]);
    }

   

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = member::find($id);
        $data=[];
        $label = [];
        $iterate = 0;
        foreach($member->deposit as $transaction){
            $data[$iterate] = $member->_BalanceAt($transaction->id); 
            $label[$iterate] = Carbon::parse($transaction->date)->toDateString();
            $iterate++;
        }
        return view('deposit.show',['member'=>$member , 'datas'=>$data , 'labels'=>$label]);
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function edit(deposit $deposit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, deposit $deposit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function destroy(deposit $deposit)
    {
        //
    }

    public function search(Request $request){
        $search = $request->search;
        $members = member::where('member_number' , 'like' , '%'.$search.'%')
                            ->orWhere('name' , 'like' , '%'.$search.'%') 
                            ->orWhere('address' , 'like' , '%'.$search.'%')
                            ->orWhere('ktp_number' , 'like' , '%'.$search.'%')
                            ->orWhere('phone_number' , 'like' , '%'.$search.'%')
                            ->orWhere('birth_day' , 'like' , '%'.$search.'%')->get();
        if($members->count() == 1){
           return $this->show($members->first()->id);
        }
        return view('deposit.multipleResult',['members'=>$members]);
    }

    public function deposit(Request $request){
        $deposit = deposit::create([
            'date' => Carbon::now(),
            'nominal_transaction' => $request->nominal_transaction , 
            'member_id' => $request->member_id ,
            'user_id' => Auth::user()->id,
            'deposit_type_id' => 1 
        ]);
        return redirect()->back();
    }
    public function withdrawal(Request $request){
        $deposit = deposit::create([
            'date' => Carbon::now(),
            'nominal_transaction' => $request->nominal_transaction , 
            'member_id' => $request->member_id ,
            'user_id' => Auth::user()->id,
            'deposit_type_id' => 2 
        ]);
        return redirect()->back();
    }
}
