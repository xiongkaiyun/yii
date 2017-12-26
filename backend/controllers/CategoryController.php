<?php

namespace backend\controllers;

use backend\models\Category;
use yii\helpers\Json;

class CategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //获取所有数据
        $cates=Category::find()->orderBy('id')->all();

        return $this->render('index', ['cates' => $cates]);
    }


    //添加
    public function actionAdd(){

        //创建一个分类模型
        $model=new Category();

        //获取所有分类数据
        $cates=Category::find()->all();

//        var_dump(Json::encode($cates));exit;

        $cates=Json::encode($cates);

        //创建request
        $request=\Yii::$app->request;

        //判断是否是post
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            //后端数据验证
            if ($model->validate()) {

                if ($model->parent_id==0){
                    //1.父类id为0的时候 创建一级分类

                    $model->makeRoot();

                    \Yii::$app->session->setFlash("success","添加一级分类".$model->name."成功");

                }else{
                    //2.否则追加对应的父类
                        //找到父节点
                    $cateParent=Category::findOne($model->parent_id);

                    //3.把新节点加入到父节点
                    $model->prependTo($cateParent);

                    \Yii::$app->session->setFlash("success","把".$model->name."添加到".$cateParent->name."成功");

                }
                //刷新当前页
                return $this->refresh();
            }
        }
        //引入视图
        return $this->render('add', ['model' => $model,'cates'=>$cates]);
    }

    //修改
    public function actionEdit($id){

        //获取要修改的数据
        $model=Category::findOne($id);

        //获取所有分类数据
        $cates=Category::find()->all();
//        var_dump(Json::encode($cates));exit;

        $cates=Json::encode($cates);

        //创建request
        $request=\Yii::$app->request;

        //判断是否是post
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            //后端数据验证
            if ($model->validate()) {

                if ($model->parent_id==0){
                    //1.父类id为0的时候 创建一级分类

//                    $model->makeRoot();
                    $model->name=$request->post()['Category']['name'];
                    $model->intro=$request->post()['Category']['intro'];
                    $model->save();

                    \Yii::$app->session->setFlash("success","添加一级分类".$model->name."成功");

                }else{
                    //2.否则追加对应的父类
                    //找到父节点
                    $cateParent=Category::findOne($model->parent_id);

                    //把新节点加入到父节点
                    $model->prependTo($cateParent);

                    \Yii::$app->session->setFlash("success","把".$model->name."添加到".$cateParent->name."成功");

                }
                //刷新当前页
                return $this->refresh();
            }

        }
        //引入视图
        return $this->render('add', ['model' => $model,'cates'=>$cates]);
    }

    public function actionDelete($id){
        if (Category::findOne($id)->deleteWithChildren()) {
            \Yii::$app->session->setFlash("success","删除成功");
            $this->redirect(['category/index']);
        }

    }
}
