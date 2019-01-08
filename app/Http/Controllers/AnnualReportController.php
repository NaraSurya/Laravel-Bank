<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
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

    public function searchByMember(Request $request){
        $search = $request->search;
        $date = $this->_GetDate();
        $startDate = Carbon::create($date, 1,1)->startOfYear();
        $endDate = Carbon::create($date,1,1)->endOfYear();
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
        return view('annualReport.result',["deposits"=>$deposits]);

    }
}
