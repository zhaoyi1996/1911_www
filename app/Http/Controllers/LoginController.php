<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;
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
        $data=request()->except('_token');
        $url='api.1911api.com/reg';
        //调用注册接口
        $client=new Client();
        $response=$client->request('POST',$url,[
            'form_params'=>$data
        ]);
        $res=$response->getBody();
        $res=json_decode($res,true);
        if($res['errno']===0){
            return redirect('login');
        }else{
            return back()->with(['msg'=>$res['msg']]);
        }
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
            'form_params'=>$data
        ]);
        $res=$response->getBody();
        $res=json_decode($res,true);
        if($res['errno']===0){
            $userLogin=Redis::hgetall($res['data']['key_id']);
            if(empty($userLogin)){
                //将获取到的信息存入redis
                Redis::hmset($res['data']['key_id'],$res['data']);
            }
            return redirect('goods/index');
        }else{
            return back()->with(['msg'=>$res['data']['error']]);
        }
    }
}
