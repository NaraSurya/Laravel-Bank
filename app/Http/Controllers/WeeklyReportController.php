<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\deposit;
use App\member;
use Carbon\Carbon;
use Session;

class WeeklyReportController extends Controller
{
    private $date;
    
    public function __construct(){
        $this->middleware('auth');   
    }

    private function _GetDate(){
        
        if(Session::has('weeklyReport')){
            $month = Session::get('weeklyReport');
            $week = Session::get('week');
            return $month->addWeek($week);
        }
        return Carbon::now();
    }

    public function index(){
        $this->date = $this->_GetDate();
        $startDate = Carbon::parse($this->date)->startOfWeek();
        $endDate = Carbon::parse($this->date)->endOfWeek();
        
        $deposits = deposit::whereBetween('date', [$startDate , $endDate])
                            ->paginate(10);

        return view('weeklyReport.index',["deposits"=>$deposits , "startDate"=>$startDate , "endDate"=>$endDate]);
    }

    public function search(Request $request){
        $this->date = Carbon::parse($request->date); 
        Session::put('weeklyReport', $this->date);
        Session::put('week',$request->week); 
        
        return redirect(route('weeklyReport.index'));
    }

    public function searchByMember(Request $request){
        $search = $request->search;
        $date = $this->_GetDate();
        $startDate = Carbon::parse($date)->startOfWeek();
        $endDate = Carbon::parse($date)->endOfWeek();
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
        return view('weeklyReport.result',["deposits"=>$deposits , "startDate"=>$startDate , "endDate"=>$endDate]);
    }

}
