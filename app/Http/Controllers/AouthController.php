<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AouthController extends Controller
{
    /*
     * github登录回调
     * */
    public function github(){
        $code   = request()->get('code');
        //通过code换取token
        $token=$this->getToken($code);
        //用token换取用户基本信息
        $userInfo=$this->getuserInfo($token);
        dd($userInfo);
        //将换取到的用户信息存入数据库

    }
    /*
     * 用code换取token
     * */
    public function getToken($code){
        $url="https://github.com/login/oauth/access_token";
        $client= new Client();
        $data=[
            'client_id'        =>  '54bc9dd812ae4d68e333',
            'client_secret'    =>  'b8a764c4b7fcc2d3ff253cf4e796827135e5b33b',
            'code'             =>  $code
        ];
        $res= $client->request('POST', $url,[
            'form_params'  => $data,
        ]);
        $body = $res->getBody();
        $body=explode('&',$body);
        $token=$body[0];
        $token=explode('=',$token);
        $token=$token[1];
        return $token;
    }
    /*
     * 用token换取用户基本信息
     * */
    public function getuserInfo($token){
        $url="https://api.github.com/user";
        $client=new Client();
        $res=$client->request('GET',$url, [
            'headers' => [
                'Authorization' => 'token '.$token,
            ]
        ]);
        $body = $res->getBody();
        $body=json_decode($body,true);
        return $body;
    }

}
