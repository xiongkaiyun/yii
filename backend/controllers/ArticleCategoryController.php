<?php

namespace backend\controllers;

use backend\models\ArticleCategory;

class ArticleCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //显示所有数据
        $articles = ArticleCategory::find()->all();
        //显示页面
        return $this->render('index',compact('articles'));
    }

    ///添加
    public function actionAdd()
    {
        //new一个模型对象
        $model = new ArticleCategory();
        //实例化
        $request = \Yii::$app->request;
        if ($request->isPost){
            //绑定数据库
            $model->load($request->post());
            //后端验证
            if ($model->validate()) {
                //保存数据
                if ($model->save()) {
                    //友情提示
                    \Yii::$app->session->setFlash("success",'添加成功');
                    //跳转
                    return $this->redirect(['index']);
                }
            }else{
                //TODO
                var_dump($model->errors);exit;
            }
        }
        //显示视图
        return $this->render('add', ['model' => $model]);
    }

    //修改
    public function actionEdit($id)
    {
        //获取一条数据
        $model=ArticleCategory::findOne($id);
        //实例化
        $request=\Yii::$app->request;
        if ($request->isPost){
            //绑定数据库
            $model->load($request->post());
            //后端验证
            if ($model->validate()) {
                //保存数据
                if ($model->save()) {
                    //友情提示
                    \Yii::$app->session->setFlash("success",'修改成功');
                    //跳转
                    return $this->redirect(['index']);
                }
            }else{
                //TODO
                var_dump($model->errors);exit;
            }
        }
        //显示视图
        return $this->render('add', ['model' => $model]);
    }

    //删除
    public function actionDel($id)
    {
        //获取删除的id
        $brand = ArticleCategory::findOne($id);
        if ($brand->delete()) {
            //友情提示
            \Yii::$app->session->setFlash("success",'删除成功');
            //跳转
            return $this->redirect(['index']);
        }
    }
}
