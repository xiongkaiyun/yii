<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $logo
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 */
class Brand extends \yii\db\ActiveRecord
{
    //设置属性
    //public $logoFile;

    public static function tableName()
    {
        return 'brand';
    }

    //设置规则
    public function rules()
    {
        return [
            [['name','status','sort'], 'required'],
            [['intro','logo'],'safe'],
            //[['logoFile'],'image','skipOnEmpty' =>true,'extensions' => 'jpg,gif,png']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '品牌名称',
            'logo' => '品牌图片',
            'intro' => '品牌简介',
            'status' => '品牌状态',
            'sort' => '排序',
        ];
    }
}
