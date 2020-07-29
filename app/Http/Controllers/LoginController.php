<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
class LoginController extends Controller
{
    /*
     * 注册--渲染页面
     * */
    public function register(){
        return view('register');
    }
    /*
     * 注册-确认注册
     * */
    public function registerDo(){
        //
    }
    /*
     * 登录--渲染页面
     * */
    public function login(){
        return view('login');
    }
    /*
     * 登录--确认登录
     * */
    public function loginDo(){
        $data=request()->except('_token');
        $data['user_pwd']=password_hash($data['user_pwd'],PASSWORD_BCRYPT);
        $url="http://api.1911api.com/login";
        //用第三方类库调用接口
        $client=new Client();
        $response=$client->request('POST',$url,[
            'form_params'=>$data
        ]);
        $res=$response->getBody();
        $res=json_decode($res,true);
        if($res['errno']===0){
            echo 111;
        }else{
            return back()->with(['msg'=>$res['data']['error']]);
        }
    }
}
