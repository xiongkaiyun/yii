<?php

namespace backend\controllers;

use backend\models\Brand;
use flyok666\qiniu\Qiniu;
use yii\web\UploadedFile;


class BrandController extends \yii\web\Controller
{
    //显示视图
    public function actionIndex()
    {
        //获取列表数据
        $brands=Brand::find()->all();

        return $this->render('index',compact('brands'));
    }

    //添加品牌
    public function actionAdd(){
        //生成模型对象
        $model=new Brand();

        $request=\Yii::$app->request;
        if ($request->isPost){

            //绑定数据库
            $model->load($request->post());
            //验证
            if ($model->validate()) {
                //保存数据
                $model->save();
                \Yii::$app->session->setFlash("success","添加成功");
                return $this->redirect(['index']);
            }

            /*//得到上传图片对象
            $model->logoFile=UploadedFile::getInstance($model,'logoFile');
            //后端验证
            if ($model->validate()) {
                //定义上传后路径
                $path="";
                //判断是否上传了图片
                if ($model->logoFile) {
                    //路径
                    $path="images/brand".uniqid().".".$model->logoFile->extension;
                    //移动图片
                    $model->logoFile->saveAs($path,false);
                }
                //给logo赋值
                $model->logo=$path;
                //保存数据
                if ($model->save()) {
                    //提示
                    \Yii::$app->session->setFlash("success",'添加成功');
                    //跳转
                    return $this->redirect(['index']);

                }


            }else{
                //TODO
                var_dump($model->errors);exit;
            }*/


        }
        //显示视图
        return $this->render('add', ['model' => $model]);

    }


    //修改品牌
    public function actionEdit($id){
        //获取数据
        $model=Brand::findOne($id);
        //创建request对象
        $request=\Yii::$app->request;

        //判断是否是post传值
        if ($request->isPost) {

            //绑定数据库
            $model->load($request->post());
            //验证
            if ($model->validate()) {
                //保存数据
                $model->save();
                \Yii::$app->session->setFlash("success","修改成功");
                return $this->redirect(['index']);
            }


            /*//得到上传图片对象
            $model->logoFile=UploadedFile::getInstance($model,'logoFile');

            //后端验证
            if ($model->validate()) {
                //定义上传后路径
                $path=$model->logo;
                //判断是否上传了图片
                if ($model->logoFile) {
                    //删除之前的图片
                    unlink($path);
                    //路径
                    $path="images/brand/".uniqid().".".$model->logoFile->extension;
                    //移动图片
                    $model->logoFile->saveAs($path,false);
                }

                //给logo赋值
                $model->logo=$path;
                //保存数据
                if ($model->save()) {
                    //提示
                    \Yii::$app->session->setFlash("success","修改成功");
                    //跳转
                    return $this->redirect(['brand/index']);
                }

            }else{

                //TODO
                var_dump($model->errors);exit;
            }*/


        }

        //显示视图
        return $this->render('add',['model'=>$model]);

    }

    //删除品牌
    public function actionDelete($id){
        if (Brand::findOne($id)->delete()) {
            \Yii::$app->session->setFlash("success","删除成功");
            return $this->redirect(['brand/index']);
        }
    }

    //webuploader 图片上传
    public function actionUpload(){

      /*  //得到上传文件的实例对象
       $file= UploadedFile::getInstanceByName("file");
        if ($file) {
            //路径
            $path="images/brand/".time().".".$file->extension;
            //移动图片
            if ($file->saveAs($path,false)) {

                $result=[
                    'code'=>0,
                    'url'=>"/".$path,
                    'attachment'=>$path
                ];

                return json_encode($result);
            }
        }*/
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
