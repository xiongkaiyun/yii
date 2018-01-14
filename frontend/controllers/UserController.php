<?php

namespace frontend\controllers;

use frontend\components\ShopCart;
use frontend\models\User;
use Mrgoon\AliSms\AliSms;
use yii\helpers\Json;

class UserController extends \yii\web\Controller
{
    //关闭csrf
    public $enableCsrfValidation=false;

    //短信验证
    public function actionSms($mobile){
        $code =rand(10000,99999);
        $config = [
            'access_key' => 'LTAIzeqkAO7eSP2C',
            'access_secret' => 'XqlCn2o2g6BfwVmaoDHMqEUKWcx482',
            'sign_name' => 'xky后台管理员系统',
        ];

        $aliSms = new AliSms();
        $response = $aliSms->sendSms($mobile, 'SMS_120410829', ['code'=>$code], $config);

        \Yii::$app->session->set("tel_".$mobile,$code);

        return $code;

    }


   //验证码
    public function actions()
    {
        return [
            'captcha'=>[
              'class'=>'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST?'testme':null,
                'minLength' => 4,
                'maxLength' => 4,
            ],


        ];
    }


    public function actionIndex()
    {
        return $this->render('index');
    }

    //注册
    public function actionReg(){

        //创建用户
        $users=new User();
        //绑定场景
        $users->setScenario('reg');
        //创建request组件
        $request=\Yii::$app->request;

        //判断是否post提交
        if ($request->isPost) {
            //绑定数据
            $users->load($request->post());


            //验证数据
            if ($users->validate()) {
//var_dump($users->email);exit;
                //加严加密
//                var_dump($users->password);exit;
                $users->password_hash=\Yii::$app->security->generatePasswordHash($users->password);
                //生成令牌
                $users->auth_key=\Yii::$app->security->generateRandomString();
                //获取最后登录ip
                $users->login_ip=ip2long($users->login_ip);
                //保存数据
                if ($users->save(false)) {
                    return Json::encode([
                        'status'=>1,
                        'msg'=>'注册成功'
                    ]);
                }

            }else{
               var_dump($users->errors);exit;
            }
            return Json::encode([
                'status'=>0,
                'msg'=>'注册失败',
                'data'=>$users->errors
            ]);
        }

        //引入视图
        return $this->render('reg');

    }

    //登录
    public function actionLogin(){
        //判定是否是游客
       /* if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }*/
        //创建用户
        $model=new User();
        //调用场景
        $model->setScenario('login');


        //创建request对象
        $request=\Yii::$app->request;
        //判断是否post提交
        if ($request->isPost) {

            //绑定数据
            $model->load($request->post());

            //验证数据
            if ($model->validate()) {


            //找到当前用户
            $user=User::findOne(['username'=>$model->username]);
//                var_dump($user);exit;
            //判断用户
            if ($user) {
                //验证密码
//                var_dump($model->password);
//                var_dump($user->password_hash);exit;
//                var_dump(\Yii::$app->security->validatePassword($model->password,$user->password_hash));

                if (\Yii::$app->security->validatePassword($model->password,$user->password_hash)) {

                    //登录用户
                    \Yii::$app->user->login($user,$model->checked?3600*24*1:0);

                    //创建对象
                    $shopCart=new ShopCart();
                    //同步到数据库
                    $shopCart->synDb();
                    //清空本地购物车数据
                    $shopCart->flush()->save();

                    //跳转
                    return $this->redirect(['user/index']);

                }else{
                    //提示密码错误
                    echo "<script>alert('密码错误');window.history.back();</script>";
                }

            }else{
                //提示用户名不存在
                echo "<script>alert('用户名错误');window.history.back();</script>";

                }
            }

        }

        //引入视图
        return $this->render('login',compact('model'));

    }

    //注销
    public function actionLogout(){
        if (\Yii::$app->user->logout()) {

            return $this->redirect(['user/login']);
        }


    }


}
