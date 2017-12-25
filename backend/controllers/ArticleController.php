<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleDetail;

class ArticleController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
    }

    public function actionIndex()
    {
        //显示所有数据
        $articles = Article::find()->orderBy('id')->all();
        //显示页面
        return $this->render('index',compact('articles'));
    }

    ///添加
    public function actionAdd()
    {
        //new一个文章
        $model = new Article();
        //new一个文章内容
        $contents = new ArticleDetail();
        //实例化
        $request = \Yii::$app->request;
        //获取所有图书分类
        $article = ArticleCategory::find()->all();
        if ($request->isPost){
            //绑定数据库
            $model->load($request->post());
            //后端验证
            if ($model->validate()) {
                //自动获取当前时间作为文章添加时间
                $model->inputtime=time();
                $model->save();
                //文章详情入库
                if ($contents->load($request->post())) {
                    $contents->article_id=$model->id;
                    if ($contents->save()) {
                        //友情提示
                        \Yii::$app->session->setFlash("success",'添加成功');
                        return $this->redirect(['index']);
                    }
                }
            }else{
                //TODO
                var_dump($model->errors);exit;
            }
        }
        //显示视图
        return $this->render('add', ['model' => $model,'article'=>$article,'contents'=>$contents]);
    }

    //修改
    public function actionEdit($id)
    {
        //new一个文章
        $model = Article::findOne($id);
        //new一个文章内容
        $contents = ArticleDetail::findOne($id);
        //实例化
        $request = \Yii::$app->request;
        //获取所有图书分类
        $article = ArticleCategory::find()->all();
        if ($request->isPost){
            //绑定数据库
            $model->load($request->post());
            //后端验证
            if ($model->validate()) {
                $model->save();
                //文章详情入库
                if ($contents->load($request->post())) {
                    if ($contents->save()) {
                        //友情提示
                        \Yii::$app->session->setFlash("success",'修改成功');
                        return $this->redirect(['index']);
                    }
                }
            }else{
                //TODO
                var_dump($model->errors);exit;
            }
        }
        //显示视图
        return $this->render('add', ['model' => $model,'article'=>$article,'contents'=>$contents]);
    }


    //删除
    public function actionDel($id)
    {
        //获取删除的id
        $brand = Article::findOne($id);
        $article = ArticleDetail::findOne($id);
        if ($brand->delete()) {
            if ($article->delete()) {
                //友情提示
                \Yii::$app->session->setFlash("success",'删除成功');
                //跳转
                return $this->redirect(['index']);
            }
        }
    }
}
