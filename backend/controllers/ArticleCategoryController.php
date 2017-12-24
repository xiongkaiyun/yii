<?php

namespace backend\controllers;

use backend\models\ArticleCategory;

class ArticleCategoryController extends \yii\web\Controller
{

    //显示列表视图
    public function actionIndex()
    {
        //获取所有数据
        $articles=ArticleCategory::find()->all();
//        var_dump($articles);exit;
        //显示视图
        return $this->render('index',compact('articles'));
    }

    //添加文章
    public function actionAdd(){
        //创建模型对象
        $articles=new ArticleCategory();

        //创建request对象
        $request=\Yii::$app->request;

        //判断是不是POST提交
        if ($request->isPost){
            //绑定数据
            $articles->load($request->post());
            //后台验证
            if ($articles->validate()){
                //验证成功
                //保存数据
                if ($articles->save()) {
                    //跳转到首页
                    return $this->redirect(['index']);
                }

            }else{
                //TODO
                var_dump($articles->getErrors());exit;

            }
        }
        //显示视图
        return $this->render("add",compact('articles'));
    }


    //修改
    public function actionEdit($id){
        //获取数据
        $articles=ArticleCategory::findOne($id);

        //创建request对象
        $request=\Yii::$app->request;

        //判断是不是POST提交
        if ($request->isPost){
            //绑定数据
            $articles->load($request->post());
            //后台验证
            if ($articles->validate()){
                //验证成功
                //保存数据
                if ($articles->save()) {
                    //跳转到首页
                    return $this->redirect(['index']);
                }

            }else{
                //TODO
                var_dump($articles->getErrors());exit;

            }
        }
        //显示视图
        return $this->render("add",compact('articles'));
    }

    //删除
    public function actionDelete($id){
        if (ArticleCategory::findOne($id)->delete()) {

            return $this->redirect(['index']);
        }
    }
}
