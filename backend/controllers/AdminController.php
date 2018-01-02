<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\LoginForm;

class AdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //获取数据
        $admins=Admin::find()->all();

        //显示视图
        return $this->render('index', ['admins' => $admins]);
    }

    //添加管理员
    public function actionAdd()
    {
        //创建管理员
        $admins=new Admin();
        //创建request组件
        $request=\Yii::$app->request;
        //判定是否post提交
        if ($request->isPost) {
            //绑定数据
            $admins->load($request->post());
            //验证数据
            if ($admins->validate()) {

                //加盐加蜜
                $admins->password_hash=\Yii::$app->security->generatePasswordHash($admins->password_hash);
                //随机字符串生成令牌
                $admins->auth_key=\Yii::$app->security->generateRandomString();
                //保存数据
                $admins->save();

                \Yii::$app->session->setFlash("success","注册成功");
                //注册成功自动登录
                \Yii::$app->user->login($admins,3600*24*7);
                //获取最后登录时间
                $admins->last_login_at=time();
                //获取最后登录ip
                $admins->last_login_ip=\Yii::$app->request->userIP;
                $admins->save();
                //跳转主页
                return $this->redirect(['admin/index']);

            }else{

                var_dump($admins->getErrors());
            }

        }

        return $this->render('add', compact('admins'));

    }


    //修改管理员信息
    public function actionEdit($id)
    {
        //找到要修改的信息
        $admins=Admin::findOne($id);
        //创建request组件
        $request=\Yii::$app->request;
        //判定是否post提交
        if ($request->isPost) {
            //绑定数据
            $admins->load($request->post());
            //验证数据
            if ($admins->validate()) {

                //加盐加蜜
                $admins->password_hash=\Yii::$app->security->generatePasswordHash($admins->password_hash);
                //随机字符串生成令牌
                $admins->auth_key=\Yii::$app->security->generateRandomString();
                //保存数据
                $admins->save();

                \Yii::$app->session->setFlash("success","修改成功");
                //修改成功自动登录
                \Yii::$app->user->login($admins,3600*24*7);
                //跳转主页
                return $this->redirect(['admin/index']);

            }else{

                var_dump($admins->getErrors());
            }

        }

        return $this->render('add', compact('admins'));

    }

    //删除
    public function actionDelete($id){
        if (Admin::findOne($id)->delete()) {
            \Yii::$app->session->setFlash("success","删除成功");

            //跳转首页
            $this->redirect(['admin/index']);
        }

    }


    //登录
    public function actionLogin(){

        //判定是否是游客
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        //创建表单模型对象
        $admins=new LoginForm();

        //创建request对象
        $request=\Yii::$app->request;

        //判断是否是post提交
        if ($request->isPost) {
            //绑定数据
            $admins->load($request->post());
            //验证数据
            if ($admins->validate()) {

                //根据用户名把用户对象查出来
                $admin=Admin::findOne(['username'=>$admins->username]);
                //如果用户名存在，验证密码
                if ($admin) {
                    //验证密码，正确执行登录
                    if (\Yii::$app->security->validatePassword($admins->password,$admin->password_hash)) {
                        //执行登录
                        \Yii::$app->user->login($admin,$admins->rememberMe?3600*24*7:0);
                        //获取最后登录时间
                        $admin->last_login_at=time();
                        //获取最后登录ip
                        $admin->last_login_ip=\Yii::$app->request->userIP;
                        //保存
                        $admin->save();
                        //跳转

                        \Yii::$app->session->setFlash("success","登录成功");
                        return $this->redirect(['index']);


                    }else{
                        //提示密码错误
                        $admins->addError("password","密码错误");
                    }

                }else{

                    //提示用户不存在
                    $admins->addError("username","用户名不存在,请先注册");

                }
            }
        }

        //显示视图
        return $this->render("login", ['admins' => $admins]);

    }

    //注销
    public function actionLogout(){

        \Yii::$app->user->logout();

        return $this->redirect(['admin/login']);

    }


}
