<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\deposit;
use App\member;
use Carbon\Carbon;
use Session;

class MonthlyReportController extends Controller
{
    private $date;
    
    public function __construct(){
        $this->middleware('auth');   
    }


    public function index(){
        $this->date = $this->_GetDate();

        $deposits = deposit::whereYear('date', $this->date->year)
                            ->whereMonth('date',$this->date->month)
                            ->paginate(10);
        return view('monthlyReport.index',['deposits'=>$deposits]);
    }

    public function search(Request $request){
        $this->date = Carbon::parse($request->date); 
        Session::put('MonthlyReport', $this->date); 
        
        return redirect(route('monthlyReport.index'));
    }


    private function _GetDate(){
        $this->date = Carbon::now();

        if(Session::has('MonthlyReport')){
            $this->date = Session::get('MonthlyReport');
        }

        return $this->date;
    } 
}
