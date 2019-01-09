<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gate;
use App\MasterInterest;

class MasterInterestController extends Controller
{
    public function __construct(){
        $this->middleware('auth');   
    }

    public function index(){

        if(!Gate::allows('isAdmin')){
            abort(403);
        }
        $masterInterest = MasterInterest::all();
        return view('MasterInterest.index', ['masterInterest'=>$masterInterest]); 
    }

    public function store(Request $request){
        $masterInterest = MasterInterest::create($request->all());
        return redirect()->back();
    }

    public function destroy(MasterInterest $masterInterest){
        $masterInterest->delete();
        return redirect()->back();
    }
    public function update(Request $request , MasterInterest $masterInterest){
        $masterInterest->start_date = $request->start_date;
        $masterInterest->percentage = $request->percentage;
        $masterInterest->save();
        return redirect()->back();
    }
}
