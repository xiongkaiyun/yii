<?php

namespace frontend\controllers;

use backend\models\Category;
use backend\models\Goods;
use frontend\components\ShopCart;
use frontend\models\Cart;
use yii\helpers\ArrayHelper;
use yii\web\Cookie;

class GoodsController extends \yii\web\Controller
{

    //关闭CSRF验证
    public $enableCsrfValidation=false;

    //商品首页
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLists($id){

        //1.找出当前分类
        $cate=Category::findOne($id);

        //2.找出当前分类的所有子类 左值>当前左值 右值<当前右值
        $cateSons=Category::find()->where(['tree'=>$cate->tree])->andWhere("lft>={$cate->lft}")->andWhere("rgt<={$cate->rgt}")->asArray()->all();
        //3.提取二维数组中的id
//        var_dump($cateSons);exit;
//        var_dump(array_column($cateSons,'id'));exit;

        $cateIds=array_column($cateSons,'id');

        //4.找出所有符合条件的商品
        $goods=Goods::find()->where(['in','category_id',$cateIds])->andWhere(['status'=>1])->all();

//        var_dump($goods);exit;

        return $this->render('list',compact('goods'));

    }

    //商品详情
    public function actionDetail($id){

        //1.找出当前的商品
        $good=Goods::findOne($id);

        //2.显示视图
        return $this->render("detail",compact('good'));

    }

    //加入购物车
    public function actionAddCart($id,$amount){


        //判断 未登录时把购物车的信息存到cookie
        if (\Yii::$app->user->isGuest) {


            //创建对象
            $shopCart=new ShopCart();

            $shopCart->add($id,$amount)->save();

            //1.怎么存?  对应商品的id  购买数量 ['3'=>10,'4'=>6,'$id'=>$amount]
            //2.1 取出cookie中的购物车数据
           /* $cartOID=\Yii::$app->request->cookies->getValue('cart',[]);
//           var_dump($cartOID);exit;

            //2.2 判断$cartOID里有没有当前商品id 这个key值
//            var_dump(array_key_exists($id,$cartOID));exit;
            if (array_key_exists($id,$cartOID)) {
                //购物车已经存在商品 在原来的商品上增加数量
                $cartOID[$id]=$cartOID[$id]+$amount;

            }else{
                //购物车不存在商品 执行新增商品
                $cartOID[$id]=(int)$amount;

            }
//            var_dump($cartOID);exit;

            //1.1得到设置cookie的对象
            $setCookie=\Yii::$app->response->cookies;
            //1.2生成一个cookie对象
            $cookie=new Cookie(
                [
                    'name'=>'cart',
                    'value'=>$cartOID,
                    'expire'=>time()+3600*24*7
                ]);

            //1.3利用$setCookie 添加一个cookie对象
            $setCookie->add($cookie);*/


        }else{
            //已登录  存数据库
            $user_id=\Yii::$app->user->id;

            $isUser=Cart::findOne(['goods_id'=>$id,'user_id'=>$user_id]);

            if ($isUser) {
                //用户存在 执行修改
                $isUser->amount +=$amount;
                //保存数据
                $isUser->save();

            }else{
                //用户不存在 执行添加
                $cart=new Cart();
                $cart->goods_id=$id;
                $cart->amount=$amount;
                $cart->user_id=$user_id;
                $cart->save();

            }
        }

        return $this->redirect("cart-lists");

    }

    //购物车列表
    public function actionCartLists(){
        //1.判断是否登录
        if (\Yii::$app->user->isGuest) {

            /*//创建对象
            $shopCart=new ShopCart();
            $shopCart->get();*/

           //未登录 cookie
            $carts=\Yii::$app->request->cookies->getValue('cart',[]);

            //1.2 取出所有商品id,也就是cookie购物车里的键

            $goodIds=array_keys($carts);
            //1.3通过商品id把所有商品取出来
            $goods=Goods::find()->where(['in','id',$goodIds])->asArray()->all();


          foreach ($goods as $k=>$good){
                $goods[$k]['amount']=$carts[$good['id']];
            }


        }else{
            //已登录 从数据库取出数据
            $user_id=\Yii::$app->user->id;
            $carts=Cart::find()->where(['user_id'=>$user_id])->asArray()->all();

            //转成键值对
            $cartGoods=ArrayHelper::map($carts,'goods_id','amount');

            $goodsIds=array_column($carts,'goods_id');

            //通过ID找出商品
            $goods=Goods::find()->where(['in','id',$goodsIds])->asArray()->all();

            //绑定amount到数组中
            foreach ($goods as $k=>$good){

                $goods[$k]['amount']=$cartGoods[$good['id']];
            }

        }

        return $this->render('cart-lists', compact('goods'));

    }

    //修改购物车数据
    public function actionUpdateCart($id,$amount){

        //如果是游客
        if (\Yii::$app->user->isGuest) {
            //创建对象
            $shopCart=new ShopCart();

            $shopCart->update($id,$amount);
            $shopCart->save();

            /*//1.取出购物车数据
            $cart=\Yii::$app->request->cookies->getValue('cart',[]);
            $cart[$id]=$amount;

            //1.1得到设置cookie的对象
            $setCookie=\Yii::$app->response->cookies;

            //1.2生成一个Cookie对象
            $cookie=new Cookie([
                'name'=>'cart',
                'value'=>$cart,
                'expire'=>time()+3600*24*7

            ]);
            //1.3 利用$setCookie添加一个Cookie对象
            $setCookie->add($cookie);*/


        }else{
            //已登录 修改到数据库
            $user_id=\Yii::$app->user->id;
            $cartOld=Cart::find()->where(['goods_id'=>$id])->andWhere(['user_id'=>$user_id])->all();
            $cartOld[0]->amount=$amount;
            $cartOld[0]->save();
        }
        return 11;
    }

    //删除购物车商品
    public function actionDelCart($id){
        //如果是游客
        if (\Yii::$app->user->isGuest) {
            //删除购物车(cookie)数据
            $setCookie = \Yii::$app->response->cookies;
            $cookie=\Yii::$app->request->cookies->getValue('cart',[]);

            unset($cookie[$id]);
            //1.2生成一个cookie对象
            $cookie=new Cookie(
                [
                    'name'=>'cart',
                    'value'=>$cookie,
                    'expire'=>time()+3600*24*7
                ]);

            //1.3利用$setCookie 添加一个cookie对象
            $setCookie->add($cookie);


        }else{
            //已登录 删除数据库数据
            Cart::findOne(['user_id'=>\Yii::$app->user->id,'goods_id'=>$id])->delete();

        }
        return $this->redirect('/goods/cart-lists');

    }


}
