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
        echo 121;
    }
}
