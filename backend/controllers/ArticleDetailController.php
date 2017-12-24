<?php

namespace backend\controllers;

use backend\models\ArticleDetail;

class ArticleDetailController extends \yii\web\Controller
{
    public function actionIndex()
    {   
        //获取数据
        $details=ArticleDetail::find()->all();

        return $this->render('index',compact('details'));
    }

    //添加
    public function actionAdd(){
        //创建模型对象
        $details=new ArticleDetail();

        //创建request对象
        $request=\Yii::$app->request;

        //判断是否是post提交
        if ($request->isPost) {
            //绑定数据
            $details->load($request->post());
            //后台验证
            if ($details->validate()) {
                //验证成功 保存数据
                if ($details->save()) {
                    //跳转到首页
                    return $this->redirect(['index']);
                }
            }else{
                //TODO
                var_dump($details->getErrors());exit;

            }
        }

        return $this->render("add",compact("details"));

    }

    //修改

    public function actionEdit($id){
        //获取要修改的数据
       $details=ArticleDetail::findOne($id);

        //创建request对象
        $request=\Yii::$app->request;

        //判断是否是post提交
        if ($request->isPost) {
            //绑定数据
            $details->load($request->post());
            //后台验证
            if ($details->validate()) {
                //验证成功 保存数据
                if ($details->save()) {
                    //跳转到首页
                    return $this->redirect(['index']);
                }
            }else{
                //TODO
                var_dump($details->getErrors());exit;

            }
        }

        return $this->render("add",compact("details"));

    }

    //删除
    public function actionDelete($id){

        if (ArticleDetail::findOne($id)->delete()) {
            //找到要删除的对象
            return $this->redirect("index");
        }
    }

}
