<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Pgoods;
use Illuminate\Contracts\Redis;
class GoodsController extends Controller
{
   /*
    * 商品详情
    * */
    public function show(Request $request)
    {
        //根据商品id查询商品数据
        $id=$request->get('goods_id');
        $key="goods_id:".$id;
        //从redis中获取商品信息
        $goods_info=Redis::hgetall($key);
        if(empty($goods_info)){
            echo '数据库';
            //根据商品id查询商品数据
            $goods_info=Pgoods::where('goods_id',$id)->first()->toArray();
            //将查询到的数据存入redis
            Redis::hmset($key,$goods_info);
        }else{
            echo 'redis';
        }
        return $goods_info;
    }
}
