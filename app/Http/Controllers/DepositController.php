<?php

namespace App\Http\Controllers;

use App\deposit;
use App\member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Session;
use Gate;

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
        $stats = deposit::all();
        if(!Gate::allows('isAdmin') && !Gate::allows('isDepositEmployee') ){
            abort(403);
        }
        
        $deposits = deposit::paginate(10);

        if(Session::has('searchByDate')){
            $deposits = deposit::whereDate('date',Session::get('searchByDate'))->paginate(10);
        }

        $balance = $stats->where('deposit_type_id','1')->sum('nominal_transaction') + $stats->where('deposit_type_id','4')->sum('nominal_transaction') - $stats->where('deposit_type_id','2')->sum('nominal_transaction') - $stats->where('deposit_type_id','3')->sum('nominal_transaction');
        return view('deposit.index',['deposits'=>$deposits , 'balance'=>$balance , 'stats'=>$stats]);
    
    }

   

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Gate::allows('isAdmin') && !Gate::allows('isDepositEmployee') ){
            abort(403);
        }
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
        if(!Gate::allows('isAdmin') && !Gate::allows('isDepositEmployee') ){
            abort(403);
        }
        $deposit->delete();
        return redirect()->back();
    }

    public function search(Request $request){
        if(!Gate::allows('isAdmin') && !Gate::allows('isDepositEmployee') ){
            abort(403);
        }
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
        if(!Gate::allows('isAdmin') && !Gate::allows('isDepositEmployee') ){
            abort(403);
        }
        $this->validate($request,[
            'nominal_transaction'=>'numeric'
        ]);

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
        if(!Gate::allows('isAdmin') && !Gate::allows('isDepositEmployee') ){
            abort(403);
        }
        $this->validate($request,[
            'nominal_transactions'=>'numeric'
        ]);

        if(($request->balance) > ($request->nominal_transactions)){
            $deposit = deposit::create([
                'date' => Carbon::now(),
                'nominal_transaction' => $request->nominal_transactions , 
                'member_id' => $request->member_id ,
                'user_id' => Auth::user()->id,
                'deposit_type_id' => 2 
            ]);
            return redirect()->back();
        }
        else{
            $this->validate($request,[
                'withDrawl'=>'required'
            ]);
            return redirect()->back();
        }
       

      
    }

    public function menu(Request $request){
        if(!Gate::allows('isAdmin') && !Gate::allows('isDepositEmployee') ){
            abort(403);
        }
        $stats = deposit::all();
        $deposits = deposit::get();
       
        if(Session::has('searchByDate')){
            $deposits = deposit::whereDate('date',Session::get('searchByDate'))->paginate(10);
        }

        $balance = $stats->where('deposit_type_id','1')->sum('nominal_transaction') + $stats->where('deposit_type_id','4')->sum('nominal_transaction') - $stats->where('deposit_type_id','2')->sum('nominal_transaction') - $stats->where('deposit_type_id','3')->sum('nominal_transaction');

        if ($request->menu == 1) {
          
            $deposits = deposit::where('deposit_type_id',1)->whereDate('date',Session::get('searchByDate'))->paginate(10);
            
            return view('deposit.index',['deposits'=>$deposits , 'balance'=>$balance,'stats'=>$stats]);
        } 
        else if  ($request->menu == 2){
            $deposits = deposit::where('deposit_type_id',2)->whereDate('date',Session::get('searchByDate'))->paginate(10);
            
            return view('deposit.index',['deposits'=>$deposits , 'balance'=>$balance,'stats'=>$stats]);
        }
        else if  ($request->menu == 3){
            $deposits = deposit::where('deposit_type_id',3)->whereDate('date',Session::get('searchByDate'))->paginate(10);
            
            return view('deposit.index',['deposits'=>$deposits , 'balance'=>$balance,'stats'=>$stats]);
        }
        else{
            $deposits = deposit::where('deposit_type_id',4)->whereDate('date',Session::get('searchByDate'))->paginate(10);
           
            return view('deposit.index',['deposits'=>$deposits , 'balance'=>$balance , 'stats'=>$stats]);
        }
       
        
    }

    public function searchByDate(Request $request){
        if(!Gate::allows('isAdmin') && !Gate::allows('isDepositEmployee') ){
            abort(403);
        }
        $dailyDate = Carbon::parse($request->dateNow);
        $dailyString = $dailyDate->toDateString();
        Session::put('searchByDate', $dailyString);
        return redirect(route('deposit.index'));
    }
}

  