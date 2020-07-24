<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Puser;
use Illuminate\Support\Str;

class TestController extends Controller
{
    //测试获取微信公众号access_token
    public function getToken(){
        $appid="wx4d62ce195d3535fb";
        $secret="feb4b5c996f0afd2eee7fc1c6127c5b8";
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
        $cont=file_get_contents($url);
        echo $cont;
    }
    //curl方式获取
    public function getCurltoken(){
        $appid="wx4d62ce195d3535fb";
        $secret="feb4b5c996f0afd2eee7fc1c6127c5b8";
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
        //curl初始化
        $curl = curl_init();
        //设置要爬取的网页的网址
        curl_setopt($curl, CURLOPT_URL, $url);
        //将 curl_exec()获取的信息以文件流的形式返回，而不是直接输出。设置为0是直接输出
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        //如果你想把一个头包含在输出中，设置这个选项为一个非零值，我这里是不要输出，所以为 0
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //执行curl,抓取内容
        $content = curl_exec($curl);
        //关闭会话
        curl_close($curl);
        dd($content);
    }
    //guzzle获取access_token
    public function getGuzzleToken(){
        $appid="wx4d62ce195d3535fb";
        $secret="feb4b5c996f0afd2eee7fc1c6127c5b8";
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
        $client= new Client();
        $response = $client->get($url);
        $body = $response->getBody();
        echo $body;
    }
    //调用api里面的access_token
    public function getapitoken(){
        phpinfo();
//        $url="http://api.1911api.com/accesstoken";
//        $data=file_get_contents($url);
//        dd($data);
    }
    /*
     * 向api加密请求
     * */
    public function enc(){
        //加密
        $data="holle ...";
        $method="AES-256-CBC";
        $key="1911";
        $option=OPENSSL_RAW_DATA;
        $iv='aaaabbbbccccdddd';
        $url="api.1911api.com/test/dec";
        $enc_data=openssl_encrypt($data,$method,$key,$option,$iv);
        //base64加密
        $enc_base=base64_encode($enc_data);
        $client=new Client();
        $response=$client->request('POST',$url,[
            'form_params'=>[
                'data' =>$enc_base
            ],
        ]);
        echo $response->getBody();
    }
    /*
     * 加密数据，给www传输数据
     * */
    public function dec(){
        $data="我是www";
        //调用私钥
        $priv_key=file_get_contents(storage_path('key/www_priv.php'));
        //调用公钥
        $key=file_get_contents(storage_path('key/pub.php'));
        //公钥加密
        openssl_public_encrypt($data,$crypted,$key);
        $url="api.1911api.com/test/enc";
        //base64加密
        $b64_data=base64_encode($crypted);
        //生成签名
        openssl_sign($b64_data,$signature,$priv_key);
        $client=new Client();
        $response=$client->request('POST',$url,[
            'form_params'=>[
                'data' =>$b64_data,
                'key'=>$signature,
            ],
        ]);
        //回调信息解密
        $info=$response->getBody();
        //base64解密
        $b64_info=base64_decode($info);
        //公钥解密
        $keys=file_get_contents(storage_path('key/www_pub.php'));
        openssl_public_decrypt($b64_info,$decrypted,$keys);
        echo $decrypted;
    }
    //测试签名
    public function signature(){
        //设置签名

    }




}
