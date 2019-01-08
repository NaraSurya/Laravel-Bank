<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\deposit;
use App\member;
use Carbon\Carbon;
use Session;


class AnnualReportController extends Controller
{
    private $year;
    
    public function __construct(){
        $this->middleware('auth');   
    }

    public function index(){
        $this->year = $this->_GetDate();

        $deposits = deposit::whereYear('date', $this->year)
                            ->paginate(10);
        return view('annualReport.index',['deposits'=>$deposits]);
    }

    public function search(Request $request){
        $this->year = $request->date;
        Session::put('annualReport', $this->year); 
        return redirect(route('annualReport.index'));
    }


    private function _GetDate(){
        $this->year = Carbon::now()->year;

        if(Session::has('annualReport')){
            $this->year = Session::get('annualReport');
        }

        return $this->year;
    } 
}
