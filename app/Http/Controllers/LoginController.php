<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
class LoginController extends Controller
{
    //注册
    public function register(){

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
        $url="http://api.1911api.com/login";
        //用第三方类库调用接口
        $client=new Client();
        $response=$client->request('POST',$url,[
            'data'=>$data
        ]);
        $res=$response->getBody();
        echo $res;
    }
}
