<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property string $num
 * @property string $logo
 * @property integer $category_id
 * @property integer $brand_id
 * @property string $market_price
 * @property string $sale_price
 * @property integer $inventory
 * @property integer $status
 * @property integer $create_time
 */
class Goods extends \yii\db\ActiveRecord
{
    //显示多图
    public $imgFiles;

    //
    public function behaviors()
    {
        return [
          [
              'class'=>TimestampBehavior::className(),
              'attributes' => [
                  ActiveRecord::EVENT_BEFORE_INSERT=>['create_time']
              ]
          ]
        ];
    }

    //设置规则
    public function rules()
    {
        return [
            [['name','logo', 'category_id', 'brand_id', 'market_price', 'sale_price', 'inventory','status','sort'], 'required'],
            [['num'],'unique'],
            [['imgFiles'],'safe']

        ];
    }

    //属性
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'num' => '商品货号',
            'logo' => '商品图片',
            'category_id' => '商品分类',
            'brand_id' => '品牌',
            'market_price' => '市场价格',
            'sale_price' => '促销价格',
            'inventory' => '库存',
            'status' => '商品状态',
            'create_time' => '上架时间',
        ];
    }
   //获取商品详情 1对1
   public function getIntro(){
        return $this->hasOne(GoodsIntro::className(),['goods_id'=>'id']);
   }
   //获取商品图片 1对多
   public function getGallery(){
        return $this->hasMany(GoodsGallery::className(),['goods_id'=>'id']);
   }
}
