<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function login_process(Request $request){
        $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ]);
        // dd(md5($request->password));

        $login_credetials =
        [
            'phone' => $request->phone,
            'password' => md5($request->password),
        ];

        $user = User::where($login_credetials)->first();
        // dd($user);
        if(!empty($user)){
            Auth::login($user);
            if (Auth::user()->user_type == 1)
            {
                return redirect()->route('root.index');
            }
            elseif (Auth::user()->user_type == 2)
            {
                if(Auth::user()->status == 0){
                    Auth::logout();
                    session()->flash('type', 'danger');
                    session()->flash('message', 'Your Account is Inactive');
                    return redirect()->back();
                }else{
                    return redirect()->route('company.index');
                }
            }
            
        }
        else {
            session()->flash('type', 'danger');
            session()->flash('message', 'Information Wrong');
            return redirect()->back();
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        session()->flash('type', 'success');
        session()->flash('message', 'You have logged successfully');
        return redirect('/');
    }
}
