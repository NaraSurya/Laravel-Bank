<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use _File;
use Gate;
use App\User;

class UserController extends Controller
{
    
    public $rule = [
        'name' => 'required|string|max:191',
        'email'=> 'required|email|unique:users',
        'nik'=>'required|unique:users'
    ];
    
    public function __construct(){
        $this->middleware('auth');   
    }

    

    public function index(){
        if(!Gate::allows('isAdmin')){
            abort(403);
        }

        $users = User::all();
        return view('user.index',['users'=>$users]);
    }

    public function store(Request $request){
        if(!Gate::allows('isAdmin')){
            abort(403);
        }  
        $this->validate($request,$this->rule);
        $image = _File::_StoreImage($request,'users');
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nik' => $request->nik,
            'user_role'=> $request->user_role,
            'profile_picture'=>$image
        ]);

        return redirect('/users/index');
    }

    public function fired($id){
        if(!Gate::allows('isAdmin')){
            abort(403);
        }

        $user = User::find($id);
        $user->status_aktif = '0'; 
        $user->save();
        return redirect()->back();
    }

    public function edit(){
        $user = Auth::user();
        return view('user.edit',['user'=>$user]);
    }

    public function update(Request $request){

        $user = User::find(Auth::user()->id);
        $this->rule['email'] = $this->rule['email'].',id,'.$user->id;
        $this->rule['nik'] = $this->rule['nik'].',id,'.$user->id;
        $this->validate($request,$this->rule);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nik = $request->nik;
        $user->save();

        if(!Gate::allows('isAdmin')){
            return redirect('/home');
        }
        return redirect('users/index');
    }

    public function showFired(){
        if(!Gate::allows('isAdmin')){
            abort(403);
        }

        $users = User::where('status_aktif','0')->get();
        return view('user.fired',['users'=>$users]);
    }

    public function changePicture(Request $request , User $user){
        _File::_DeleteImage($user->profile_picture,'users');
        $image = _File::_StoreImage($request,'users');
        $user->profile_picture = $image; 
        $user->save();
        return redirect()->back();
    }

    public function changePassword(Request $request , User $user){
        $this->validate($request,[
            'password'=>'required|confirmed|string|min:6'
        ]);
        $user->password = Hash::make($request->password);
        $user->save();
        if(!Gate::allows('isAdmin')){
            return redirect('/home');
        }
        return redirect('users/index');
    }
}
