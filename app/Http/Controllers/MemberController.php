<?php

namespace App\Http\Controllers;

use App\member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\deposit;
use _File;

class MemberController extends Controller
{
    
    private $rule = [
        'name'=> 'required|string|max:191',
        'ktp_number' => 'required|numeric|unique:members',
        'address' => 'required|max:191',
        'phone_number' => 'required',
        'gender' => 'required',
        'picture' => 'required',
        'birth_day' => 'required|date',
    ];
    
    
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
        $members = member::paginate(10);

        foreach($members as $member){
            $member['balance'] = $member->_Balance();
        }

        $date = carbon::now(); 
        $labels[0] =  date("F", mktime(0, 0, 0, $date->month, 10));
        $datas[0] = member::whereMonth('created_at',$date->month)->count();
        for($loop=1;$loop<7;$loop++){
           $labels[$loop] = date("F", mktime(0, 0, 0, $date->subMonth()->month, 10)); 
           $datas[$loop] = member::whereMonth('created_at',$date->month)->count();
        } 

        return view('member.index' , ['members'=> $members , 'labels'=>array_reverse($labels), 'datas'=>array_reverse($datas)] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('member.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,$this->rule); 
        $image = _File::_StoreImage($request,'members'); 
        $member = member::create([ 
            'ktp_number' => $request->ktp_number , 
            'name' => $request->name , 
            'address' => $request->address , 
            'phone_number' => $request->phone_number , 
            'gender' => $request->gender , 
            'birth_day' => $request->birth_day , 
            'user_id' => Auth::user()->id , 
            'profile_picture'=> $image
        ]);

        $member->member_number = $member->_makeMemberNumber(); 
        $member->save();

        return redirect(route('member.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(member $member)
    {
        $date = carbon::now(); 
        $history = deposit::where('member_id', $member->id)
                            ->paginate(10);
        $data=[];
        $label = [];
        $iterate = 0;
        foreach($history as $transaction){
            $data[$iterate] = $member->_BalanceAt($transaction->id); 
            $label[$iterate] = Carbon::parse($transaction->date)->toDateString();
            $iterate++;
        }
        return view('member.show' , ['member'=> $member , 'labels'=>$label , 'datas' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(member $member)
    {
        return view('member.edit' , ['member'=>$member]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, member $member)
    {
        $this->rule['ktp_number'] = $this->rule['ktp_number'].',id,'.$member->id;
        $this->validate($request,$this->rule);

        _File::_DeleteImage($member->profile_picture,'members');
        $image = _File::_StoreImage($request,'members');

        $member->name = $request->name;
        $member->ktp_number = $request->ktp_number; 
        $member->address = $request->address; 
        $member->phone_number = $request->phone_number; 
        $member->gender = $request->gender; 
        $member->birth_day = $request->birth_day; 
        $member->profile_picture = $image; 
        $member->user_id = Auth::user()->id; 
        $member->save();
        return redirect(route('member.show',['id'=>$member->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(member $member)
    {
        $member->delete();

        return redirect(route('member.index'));
    }
}
