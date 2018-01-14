<?php

namespace frontend\controllers;

use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\User;

class AddressController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //获取列表数据
        $address=Address::find()->all();

        return $this->render('index');
    }


    public function actionAdd(){

       //创建对象
        $address=new Address();

        //创建request组件
        $request=\Yii::$app->request;

        //判断是否post提交
        if ($request->isPost) {
            //绑定数据
            $address->load($request->post());

            //验证数据
            if ($address->validate()) {

                $address->member_id=\Yii::$app->user->id;


                //保存数据
                $address->save();

                return $this->redirect('/address/index');

            }else{

                var_dump($address->getErrors());
            }

        }

        return $this->render('index');

    }

    //修改地址
    public function actionEdit($id)
    {
        //找到修改对象
        $address=Address::findOne($id);

        //创建request组件
        $request=\Yii::$app->request;

        //判断是否post提交
        if ($request->isPost) {
            //绑定数据
            $address->load($request->post());

            //验证数据
            if ($address->validate()) {

                $address->member_id=\Yii::$app->user->id;


                //保存数据
                $address->save();

                return $this->redirect('/address/index');

            }else{

                var_dump($address->getErrors());
            }

        }

        return $this->render('edit',['address'=>$address]);

    }

    //删除地址

    public function actionDel($id){

        if (Address::findOne($id)->delete()) {
            return $this->redirect('/address/index');
        }


    }

}
