<?php

namespace backend\controllers;

use backend\models\AuthItem;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class RoleController extends Controller
{
    public function actionIndex()
    {
        //实例化authManager组件
        $auth=\Yii::$app->authManager;
        //获取所有角色
        $roles=$auth->getRoles();

        //显示视图
      return $this->render('index', ['roles' => $roles]);
    }

    //添加角色
    public function actionAdd(){

        //实例化authManager组件
        $auth=\Yii::$app->authManager;

        //实例化模型对象
        $model=new AuthItem();

        //找出所有权限
        $pers=$auth->getPermissions();

        $persArr=ArrayHelper::map($pers,'name','description');

        //判断是否post提交以及绑定数据、验证数据
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            //1.创建角色
            $role=$auth->createRole($model->name);
            //2.设置描述
            $role->description=$model->description;
            //3.如果角色添加入库
            if ($auth->add($role)) {
                if ($model->permissions) {
                    //4.给角色添加权限
                    foreach ($model->permissions as $perName){
                        //4.1通过权限名称找到对应的权限对象
                        $permission=$auth->getPermission($perName);
                        //4.2把权限加入到角色中
                        $auth->addChild($role,$permission);
                    }
                }
                \Yii::$app->session->setFlash("success",'添加角色'.$model->name."成功");
                //刷新
                return $this->refresh();
            }
        }
        return $this->render('add',compact('model','persArr'));
    }

    //修改权限
    public function actionEdit($name){

        //实例化authManager组件
        $auth=\Yii::$app->authManager;

        //找到要修改的角色
        $model=AuthItem::findOne($name);

        //找出所有权限
        $pers=$auth->getPermissions();

        $persArr=ArrayHelper::map($pers,'name','description');


        //判断是否post提交以及绑定数据、验证数据
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            //1.找到角色
            $role=$auth->getRole($name);

            //2.设置描述
            $role->description=$model->description;
            //3.判断是否调用修改
            if ($auth->update($name,$role)) {
                //删除当前角色所对应的权限
                $auth->removeChildren($role);

                if ($model->permissions) {
                    //4.给角色添加权限
                    foreach ($model->permissions as $perName){

                        //4.1通过权限名称找到对应的权限对象
                        $permission=$auth->getPermission($perName);
                        //4.2把权限加入到角色中
                        $auth->addChild($role,$permission);

                    }
                }
                \Yii::$app->session->setFlash("success",'修改角色'.$model->name."成功");

                //刷新
                return $this->refresh();

            }

        }
        //当前角色所对应的权限 通过角色找权限
        $roles=$auth->getPermissionsByRole($name);

        //var_dump($roles);exit;

        //取出所有权限的key值
        $model->permissions=array_keys($roles);
        //$model->description="111";
        return $this->render('add', compact('model','persArr'));

    }

    //删除权限
    public function actionDelete($name){
        //实例化authManager组件
        $auth=\Yii::$app->authManager;

        //1.找到要删除的对象
        $role=$auth->getRole($name);

        //2.删除角色所对应的所有权限
        $auth->removeChildren($role);

        //3.删除角色
        if ($auth->remove($role)) {

            return $this->redirect(['index']);
        }


    }

}
