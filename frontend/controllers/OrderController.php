<?php

namespace frontend\controllers;

use backend\models\Goods;
use dosamigos\qrcode\lib\Enum;
use dosamigos\qrcode\QrCode;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Delivery;
use frontend\models\Order;
use frontend\models\OrderDetail;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use \EasyWeChat\Foundation\Application;

class OrderController extends \yii\web\Controller
{
    public $enableCsrfValidation=false;
    public function actionIndex()
    {
        //判断 是游客就跳到登录页面
        if (\Yii::$app->user->isGuest) {

            return $this->redirect(['user/login','back'=>'order/index']);
        }

        //1.取出当前用户地址
        $userId=\Yii::$app->user->id;
        $address=Address::find()->where(['member_id'=>$userId])->all();

        //2.取出所有送货方式
        $deliverys=Delivery::find()->all();


        //3.查出商品
        //3.1从数据库得到当前用户的所有购物车数据
        $carts=Cart::find()->where(['user_id'=>$userId])->asArray()->all();
        //3.2取出所有商品id
        $cartGoods=ArrayHelper::map($carts,'goods_id','amount');
        //提取所有商品id
        $goodIds=array_column($carts,'goods_id');

        //3.3通过商品id把所有商品取出来
        $goods=Goods::find()->where(['in','id',$goodIds])->asArray()->all();

        //定义一个总金额
        $totalMoney=0;
        //默认的运费
        $yunFei=Delivery::findOne(['status'=>1])->price;

        foreach ($goods as $k=>$good) {
           //追加购物车每个商品数量
            $goods[$k]['num']=$cartGoods[$good['id']];

            //计算商品总金额 商品价格*商品数量
            $totalMoney+=$good['sale_price']*$cartGoods[$good['id']];
        }
        //应付总金额(含运费)
        $allMoney=$totalMoney+$yunFei;

        //创建request组件
        $request=\Yii::$app->request;
        //判断是否post提交
        if ($request->post()) {

            $db=\Yii::$app->db;
            //开启事务
            $transaction=$db->beginTransaction();

            try{
                //取出送货地址
                $address=Address::findOne($request->post('address_id'));
                //取出送货方式
                $delivery=Delivery::findOne($request->post('delivery'));

                //取出支付方式
                $payType=ArrayHelper::map(\Yii::$app->params['payType'],'id','name');

                //1.创建订单表对象
                $order=new Order();
                //2.给订单表一一赋值
                $order->user_id=$userId;
                $order->name=$address->name;
                $order->province=$address->province;
                $order->city=$address->city;
                $order->county=$address->county;
                $order->address=$address->address;
                $order->mobile=$address->mobile;
                //送货方式赋值
                $order->delivery_id=$delivery->id;
                $order->delivery_name = $delivery->name;
                $order->delivery_price = $delivery->price;
                //支付方式赋值
                $order->payment_id = $request->post("pay");
                $order->payment_name = $payType[$order->payment_id];//取出支付名称
                $order->price=$totalMoney+$delivery->price; //应付金额=商品总价+运费
                $order->status=1; //0 取消 1 等待支付 2 等待发货 3 等待收货
                //订单号生成
                $order->num=date("ymdHis").rand(1000,9999);
                $order->create_time=time();
                //保存订单数据
                $order->save();

                //2.订单详情入库
                foreach ($goods as $good){
                    //取出当前商品库存
                    $stock=Goods::findOne($good['id'])->inventory;

                    //判断库存是否充足 不足就退出
                    if ($good['num']>$stock) {
                        //抛出异常
                        throw new Exception("库存不足，请重新下单");
                    }

                    //订单详情一一赋值
                    $orderDetail = new OrderDetail();

                    $orderDetail->order_info_id = $order->id;//订单Id
                    $orderDetail->goods_id = $good['id'];
                    $orderDetail->amount = $good['num'];
                    $orderDetail->goods_name = $good['name'];
                    $orderDetail->logo = $good['logo'];
                    $orderDetail->price = $good['sale_price'];
                    $orderDetail->total_price = $good['sale_price'] * $good['num'];

                    //保存
                    if ($orderDetail->save()) {
                        Goods::updateAllCounters(['inventory'=>-$good['num']],['id'=>$good['id']]);
                    }

                }

                //3.清空购物车
                Cart::deleteAll(['user_id'=>$userId]);
                //提交事务
                $transaction->commit();

            }catch (Exception $e){
                $transaction->rollBack();//事务回滚

                exit($e->getMessage());//错误信息
            }

            //事务成功跳到微信二维码
            return  $this->render('wxpay', ['id' => $order->id]);

        }
  
        return $this->render('index',compact('address','deliverys','goods','totalMoney','yunFei','allMoney'));
    }


    //微信支付
    public function actionWxPay($id){

        //把订单查出来
        $goodsOrder=Order::findOne($id);

        //easywechat全局对象
        $app=new Application(\Yii::$app->params['easyWechat']);
        //支付对象
        $payment=$app->payment;

        //订单详情信息
        $attributes=[
          'trade_type' =>'NATIVE',//原生二维码支付  JSAPI，NATIVE，APP...
            'body'     =>'京南商城订单',//订单标题
            'detail'   =>'价值9999元大礼包',//详情
            'out_trade_no' =>$goodsOrder->num,//订单编号
            'total_fee'    =>$goodsOrder->price*100, //单位：分 支付金额
            'notify_url'   =>Url::to(['order/wx-pay'],true),//支付结果通知网址，如果不设置则会使用配置里的默认地址

        ];

        //创建订单
        $order=new \EasyWeChat\Payment\Order($attributes);

        //统一下单
        $result=$payment->prepare($order);

        if ($result->return_code== 'SUCCESS' && $result->result_code =='SUCCESS') {
            //生成二维码
            return QRCode::png($result->code_url,false,Enum::QR_ECLEVEL_H,6);

        }else{

            var_dump($result);
        }

    }



    public function actionNotify(){

        //easyWechat全局对象
        $app=new Application(\Yii::$app->params['easyWechat']);

        $response=$app->payment->handleNotify(function ($notify,$successful){
            //使用通知里的“微信支付订单号” 或者 “商户订单号” 去自己的数据库找到订单
            $order=Order::findOne(['num'=>$notify->out_trade_no]);
            //如果订单不存在
            if (!$order) {
                return 'Order not exist.';  //通知微信，我已经处理完了，订单没找到，别再通知我了

            }

            //如果订单存在
            //检查订单是否已经更新过支付状态
            if ($order->status!=1) {//假设订单字段"支付时间"  不为空代表已经支付
                return true;  //已经支付成功就不再更新了
            }

            //用户是否支付成功
            if ($successful) {
                //不是已经支付状态改为已经支付状态
                //$order->paid_at=time(); //更新支付时间为当前时间
                $order->status=2;
            }

            $order->save();  //保存订单

            return true; //返回处理完成

        });

        return $response;
    }

}
