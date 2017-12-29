<?php

namespace backend\controllers;

use backend\models\Brand;
use backend\models\Category;
use backend\models\Goods;
use flyok666\qiniu\Qiniu;
use yii\helpers\ArrayHelper;

class GoodsController extends \yii\web\Controller
{
    //富文本框
    public function actions()
    {
        return [
          'upload'=>[
              'class'=>'kucha\uedit\UEditorAction',
          ]
        ];
    }


    public function actionIndex()
    {
        //获取数据
        $goods=Goods::find()->orderBy('id')->all();
        //显示视图
        return $this->render('index',compact('goods'));
    }

    //添加
    public function actionAdd(){

        //创建模型对象
        $goods=new Goods();
        //创建商品详情对象
        $goodsIntro=new GoodsIntro();

        //查出所有品牌数据
        $brands=Brand::find()->all();
        //将数组转化为键值对
        $brandsArray=ArrayHelper::map($brands,'id','name');

        //查出所有分类数据
        $cates=Category::find()->orderBy('tree,lft')->all();
        //将数组转化为键值对
        $catesArray=ArrayHelper::map($cates,'id','nameText');

        //创建request对象
        $request=\Yii::$app->request;

        //判断是否是post传值
        if ($request->isPost) {
            //绑定数据
            $goods->load($request->post());
            $times=date("Y-m-d",time());

            //验证数据
            if($goods->validate()) {
                //保存数据
                $goods->save();
                //提示信息
                \Yii::$app->session->setFlash("success","添加成功");
                //跳转首页
                return $this->redirect(['index']);
            }

        }

        //显示添加视图
        return $this->render('add', ['goodsIntro' => $goodsIntro, 'goods' => $goods, 'brandsArray' => $brandsArray, 'catesArray' => $catesArray]);
    }

    //修改
    public function actionEdit($id){

        //获取要修改的数据
        $goods=Goods::findOne($id);

        //创建request对象
        $request=\Yii::$app->request;
        //判断是否是post传值
        if ($request->isPost) {
            //绑定数据
            $goods->load($request->post());
            //验证数据
            if($goods->validate()) {
                //保存数据
                $goods->save();
                //提示信息
                \Yii::$app->session->setFlash("success","添加成功");
                //跳转首页
                return $this->redirect(['index']);
            }

        }

        //显示添加视图
        return $this->render('add',compact('model'));
    }

    //删除
    public function actionDelete($id){
        if (Goods::findOne($id)->delete()) {
            \Yii::$app->session->setFlash("success","删除成功");
            //跳转首页
            return $this->redirect(['index']);
        }

    }

    //webuploader 图片上传
    public function actionUpload(){


        //七牛云配置
        $config = [
            'accessKey' => 'u4hczG8b6j6R66DmVlygkyORGLwXNWppKLL3ZxHr',//AK
            'secretKey' => 'HR7mwuobEUl1yEqK-0IjgTvvWHe-vw5DZd2TJ_xU',//SK
            'domain' => 'http://p1hydf34h.bkt.clouddn.com',//临时域名
            'bucket' => 'xiongkaiyun',//空间名称
            'area' => Qiniu::AREA_HUANAN//区域

        ];

        $qiniu = new Qiniu($config);//实例化对象
        $key = time();//上传后的文件名  多文件上传有坑
        $qiniu->uploadFile($_FILES['file']["tmp_name"], $key);//调用上传方法上传文件
        $url = $qiniu->getLink($key);//得到上传后的地址

        //返回的结果
        $result = [
            'code' => 0,
            'url' => $url,
            'attachment' => $url
        ];
        return json_encode($result);
    }


}
