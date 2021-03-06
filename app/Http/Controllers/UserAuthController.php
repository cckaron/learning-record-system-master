<?php
namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserAuthController extends Controller
{
    public function signInPage(){
        return view('auth.signIn');
    }

    public function postSignIn(Request $request){
        $user_data = array(
            'account' => $request->input('account'),
            'password' => $request->input('password')
        );

        if (Auth::attempt($user_data)){ //登入成功, 跳轉到主頁面
            DB::table('users')
                ->where('account', $request->input('account'))
                ->update([
                    'last_login_at' => Carbon::now()->toDateTimeString(),
                    'last_login_ip' => $request->getClientIp()
                ]);
            return redirect()->route('dashboard.get');
        } else {
            return back()->with('message', '帳號或密碼錯誤');
        }
    }

    public function getSignOut(){
        Auth::logout();
        return redirect()->route('auth.signIn');
    }

}
