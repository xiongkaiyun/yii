<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/12
 * Time: 14:04
 */

namespace frontend\components;


use frontend\models\Cart;
use yii\base\Component;
use yii\web\Cookie;

class ShopCart extends Component
{
    //定义cart 用来存储cookie中的购物车数据
    private $_cart=[];

    public function __construct(array $config = [])
    {
        $this->_cart=\Yii::$app->request->cookies->getValue('cart',[]);

        parent::__construct($config);
    }

    //增加
    public function add($id,$amount){

        if (array_key_exists($id,$this->_cart)) {
            //购物车已经存在商品 在原来的商品上增加数量
            $this->_cart[$id]=$this->_cart[$id]+$amount;

        }else{
            //购物车不存在商品 执行新增商品
            $this->_cart[$id]=(int)$amount;

        }

        return $this;

    }

    //修改
    public function update($id,$amount){

        if (isset($this->_cart[$id])) {
            $this->_cart[$id]=$amount;
        }

        return $this;

    }

    //查
    public function get(){

        return $this->_cart;
    }

    //删除
    public function del($id){


        unset($this->_cart[$id]);

        return $this;
    }

    //保存
    public function save(){

        //1.1得到设置cookie的对象
        $setCookie=\Yii::$app->response->cookies;

        //1.2生成一个cookie对象
        $cookie=new Cookie(
            [
                'name'=>'cart',
                'value'=>$this->_cart,
                'expire'=>time()+3600*24*7
            ]);

        //1.3利用$setCookie 添加一个cookie对象
        $setCookie->add($cookie);

    }

    //本地数据同步到数据库
    public function synDb(){

        foreach ($this->_cart as $goodId=>$amount){
            //判断当前商品在数据库中是否存在
            $userId=\Yii::$app->user->id;

            //取出商品id对应购物车数据
            $cart=Cart::findOne(['goods_id'=>$goodId,'user_id'=>$userId]);

            if ($cart){

                //如果存在  修改+$amount
                $cart->amount+=$amount;
                $cart->save();

            }else{
                //新增
                $cart=new Cart();
                $cart->amount=$amount;
                $cart->goods_id=$goodId;
                $cart->user_id=$userId;
                $cart->save();
            }

        }

    }

    //清空购物车
    public function flush(){

        $this->_cart=[];

        return $this;

    }

}