<?php

namespace backend\models;

use backend\compoents\MenuQuery;
use creocoder\nestedsets\NestedSetsBehavior;
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $name
 */
class Category extends \yii\db\ActiveRecord
{
    //设置行为
    public function behaviors() {
        return [
            'tree' => [

                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
                // 'leftAttribute' => 'lft',
                // 'rightAttribute' => 'rgt',
                // 'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new \backend\components\MenuQuery(get_called_class());
    }



    //设置规则
    public function rules()
    {
        return [
            [[ 'name','parent_id'], 'required'],//lft tree 等都是自动算的，可有可无
            [['intro'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tree' => '树状',
            'lft' => '左值',
            'rgt' => '右值',
            'depth' => '深度',
            'name' => '分类名称',
            'parent_id'=>'父类id',
            'intro'=>'简介'
        ];
    }
}
