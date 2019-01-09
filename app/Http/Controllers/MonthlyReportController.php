<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
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
    
    public function searchByMember(Request $request){
        $search = $request->search;
        $date = $this->_GetDate();
        $startDate = Carbon::parse($date)->startOfMonth();
        $endDate = Carbon::parse($date)->endOfMonth();
        $deposits = new Collection();
        
        $members = member::where('member_number' , 'like' , '%'.$search.'%')
                            ->orWhere('name' , 'like' , '%'.$search.'%') 
                            ->orWhere('address' , 'like' , '%'.$search.'%')
                            ->orWhere('ktp_number' , 'like' , '%'.$search.'%')
                            ->orWhere('phone_number' , 'like' , '%'.$search.'%')
                            ->orWhere('birth_day' , 'like' , '%'.$search.'%')->get();
        
        foreach ($members as $member) {
            $deposits = $deposits->merge($member->deposit->whereBetween('date',[$startDate,$endDate]));
        }
        return view('monthlyReport.result',["deposits"=>$deposits]);

    }
}
