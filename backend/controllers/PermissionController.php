<?php

namespace backend\controllers;

use backend\models\AuthItem;

class PermissionController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //实例化authManager组件
        $auth=\Yii::$app->authManager;
        //获取所有权限
        $permissions=$auth->getPermissions();

        //显示视图
        return $this->render('index',compact('permissions'));
    }

    //添加权限
    public function actionAdd(){

        //实例化authManager组件
        $auth=\Yii::$app->authManager;

        //实例化模型对象
        $model=new AuthItem();

        //判断是否post提交以及绑定数据、验证数据
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            //1.创建权限
            $permission=$auth->createPermission($model->name);
            //2.设置权限
            $permission->description=$model->description;
            //3.添加入库
            if ($auth->add($permission)) {
                \Yii::$app->session->setFlash("success","添加权限".$model->name."成功");
                //4.添加完成刷新页面
                return $this->refresh();
            }

        }
        return $this->render('add',compact('model'));
    }

    //修改权限
    public function actionEdit($name){

        //实例化authManager组件
        $auth=\Yii::$app->authManager;

        //找到要修改的对象
        $model=AuthItem::findOne($name);

        //判断是否post提交以及绑定数据、验证数据
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            //1.根据名字找到对应权限
            $permission=$auth->createPermission($model->name);

            //如果是对应权限
            if ($permission) {
                //2.设置权限
                $permission->description=$model->description;
                //3.修改后入库
                if ($auth->update($name,$permission)) {
                    \Yii::$app->session->setFlash("success","修改权限".$model->name."成功");
                    //4.修改完成跳转列表
                    return $this->redirect(['index']);
                }
            }else{
                //提示不能修改名称
                \Yii::$app->session->setFlash("danger","不能修改名称".$model->name);

                //刷新
                return $this->refresh();

            }


        }
        //显示页面
        return $this->render('edit',compact('model'));

    }

    //删除权限
    public function actionDelete($name){
        //实例化authManager组件
        $auth=\Yii::$app->authManager;

        //找到要删除的对象
        $permission=$auth->getPermission($name);

        //删除对象
        if ($auth->remove($permission)) {

            return $this->redirect(['index']);
        }


    }

}
