<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleDetail;
use yii\helpers\ArrayHelper;

class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //获取数据
        $articles=Article::find()->all();
        //显示视图
        return $this->render('index',compact('articles'));
    }

    //添加
    public function actionAdd(){
        //创建模型对象
        $articles=new Article();

        //获取文章内容表数据
        $details=ArticleDetail::find()->asArray()->all();

        //把数组转化为键值对
        $detailsArray=ArrayHelper::map($details,'article_id','content');


        //创建request对象
        $request=\Yii::$app->request;
        //判断是否是post提交
        if ($request->isPost) {
            //绑定数据
            $articles->inputtime=time();
            $articles->load($request->post());
            //后台验证
            if ($articles->validate()) {
                //验证成功 保存数据
                if ($articles->save()) {
                    //跳转到首页
                    return $this->redirect(['index']);
                }
            }else{
                //TODO
                var_dump($articles->getErrors());exit;

            }
        }

        return $this->render("add",compact("articles","detailsArray"));

    }

    //修改
    public function actionEdit($id){
        //获取要修改的数据
        $articles=Article::findOne($id);

        //获取文章内容表数据
        $details=ArticleDetail::find()->asArray()->all();

        //把数组转化为键值对
        $detailsArray=ArrayHelper::map($details,'article_id','content');


        //创建request对象
        $request=\Yii::$app->request;
        //判断是否是post提交
        if ($request->isPost) {
            //绑定数据
            $articles->inputtime=time();
            $articles->load($request->post());
            //后台验证
            if ($articles->validate()) {
                //验证成功 保存数据
                if ($articles->save()) {
                    //跳转到首页
                    return $this->redirect(['index']);
                }
            }else{
                //TODO
                var_dump($articles->getErrors());exit;

            }
        }

        return $this->render("add",compact("articles","detailsArray"));

    }

    //删除
    public function actionDelete($id){
        //找到要删除的对象
        if(Article::findOne($id)->delete()){
            return $this->redirect(['index']);
        }
    }

}
