<?php

namespace backend\controllers;

use backend\models\Brand;
use backend\models\Category;
use backend\models\Goods;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use flyok666\qiniu\Qiniu;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class GoodsController extends \yii\web\Controller
{
    //富文本框
    public function actions()
    {
        return [
          'upload'=>[
              'class'=>'kucha\ueditor\UEditorAction',
          ]
        ];
    }


    public function actionIndex()
    {
        //获取数据
        $goods=Goods::find();
        //创建request对象
        $request=\Yii::$app->request;

        //根据搜索条件
        $minPrice=$request->get('minPrice');
        $maxPrice=$request->get('maxPrice');
        $keyword=$request->get('keyword');
        $status=$request->get('status');

        //最低价格
        if ($minPrice) {
            $goods->andWhere("market_price>={$minPrice}");
        }
        //最高价格
        if ($maxPrice) {
            $goods->andWhere("market_price>={$maxPrice}");
        }

        //名称或货号
        if ($keyword) {
            $goods->andWhere("name like '%{$keyword}%' or num like '%{$keyword}%'");
        }

        //判断状态 $status==='0' or $status==='1'  必需是全等号 接收的值都是字符串
        if (in_array($status,['0','1'])) {

            $goods->andWhere(['status'=>$status]);
        }

        //实例化分页对象
        $pages=new Pagination(
            [
                'totalCount' => $goods->count(),//总条数
                'pageSize' => 2//每页显示的条数
            ]

        );
        // select * from goods limit 4,2;
        $goods=$goods->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', ['pages' => $pages, 'goods' => $goods]);

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
        $brandsArr=ArrayHelper::map($brands,'id','name');

        //查出所有分类数据
        $cates=Category::find()->orderBy('tree,lft')->all();
        //将数组转化为键值对
        $catesArr=ArrayHelper::map($cates,'id','name');

        //创建request对象
        $request=\Yii::$app->request;

        //判断是否是post传值
        if ($request->isPost) {
            //绑定数据
            $goods->load($request->post());

            //验证数据
            if($goods->validate()) {
                //判断货号sn是否有值
                if (empty($goods->sn)){
                    //自动生成   201712110001   20171211+今天上传商品数量
                    //date('Ymd') 20171229000000
                    $timeStart=strtotime(date('Ymd'));
                    //查出今天创建的所有商品数量
                    $count=Goods::find()->where("create_time>={$timeStart}")->count();
                    $count=$count+1;
                    //拼接4位货号 1=>0001    9999=>0009999
                    $count=substr("000".$count,-4);
                    //得到最终的货号
                    $goods->num=date("Ymd").$count;

                }
                //保存商品数据
                if ($goods->save()) {
                    //保存商品详情
                    $goodsIntro->load($request->post());
                    $goodsIntro->goods_id = $goods->id;
                    $goodsIntro->save();

                    //保存多图
                    foreach ($goods->imgFiles as $img) {

                        //一定要在这里new
                        $goodsGallery = new GoodsGallery();
                        //批量赋值
                        $goodsGallery->goods_id = $goods->id;
                        $goodsGallery->path = $img;
                        //保存
                        $goodsGallery->save();

                    }

                    return $this->redirect(['index']);
                    }

                }


            }

        //显示添加视图
            return $this->render('add', ['goodsIntro' => $goodsIntro, 'goods' => $goods, 'brandsArr' => $brandsArr, 'catesArr' => $catesArr]);
    }

    //修改
        public function actionEdit($id){
            //创建商品模型对象
            $goods=Goods::findOne($id);

            //创建商品详情模型
            $goodsIntro=GoodsIntro::findOne($id);

            //查出当前商品所对应的所有图片
            $goodsImgs=GoodsGallery::find()->where(['goods_id'=>$id])->asArray()->all();

            //把处理好的一维数组赋值给imgFiles属性
            $goods->imgFiles=array_column($goodsImgs,'path');

            //把所有商品分类给传过来
            $cates=Category::find()->orderBy('tree,lft')->all();
            //转化成键值对
            $catesArr=ArrayHelper::map($cates,'id','nameText');


            //把所有商品品牌给传过来
            $brands=Brand::find()->orderBy('id')->all();
            //转化成键值对
            $brandsArr=ArrayHelper::map($brands,'id','name');


            $request=\Yii::$app->request;
            if ($request->isPost){

                //商品数据绑定
                $goods->load($request->post());
                //数据验证
                if ($goods->validate()){
                    //判断货号sn是否有值
                    if (empty($goods->sn)){
                        //自动生成   201712110001   20171211+今天上传商品数量
                        //date('Ymd') 20171229000000
                        $timeStart=strtotime(date('Ymd'));
                        //查出今天创建的所有商品数量
                        $count=Goods::find()->where("create_time>={$timeStart}")->count();
                        $count=$count+1;
                        //拼接4位货号 1=>0001    9999=>0009999
                        $count=substr("000".$count,-4);
                        //得到最终的货号
                        $goods->num=date("Ymd").$count;

                    }

                    //保存商品数据
                    if ($goods->save()) {
                        //保存商品详情
                        $goodsIntro->load($request->post());
                        $goodsIntro->goods_id=$goods->id;
                        $goodsIntro->save();

                        //保存多图
                        //删除所有图片
                        GoodsGallery::deleteAll(['goods_id'=>$id]);
                        foreach ($goods->imgFiles as $img){
                            //一定要在这里new
                            $goodsGallery=new GoodsGallery();
                            //批量赋值
                            $goodsGallery->goods_id=$goods->id;
                            $goodsGallery->path=$img;
                            //保存
                            $goodsGallery->save();


                        }

                        return $this->redirect(['index']);

                    }

                }

            }
            //修改视图
            return $this->render('add', ['goodsIntro' => $goodsIntro, 'goods' => $goods, 'brandsArr' => $brandsArr, 'catesArr' => $catesArr]);
        }

    //删除
    public function actionDelete($id){
        if (Goods::findOne($id)->delete()) {
            \Yii::$app->session->setFlash("success","删除成功");
            //跳转首页
            return $this->redirect(['index']);
        }

    }


}
