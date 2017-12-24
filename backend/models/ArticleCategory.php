<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_category".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 * @property integer $is_help
 */
class ArticleCategory extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'article_category';
    }

    //设置规则
    public function rules()
    {
        return [
            [['name', 'status', 'sort', 'is_help'], 'required'],
            [['intro'], 'string'],
            [['status', 'sort', 'is_help'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    //lable
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章名称',
            'intro' => '文章简介',
            'status' => '状态',
            'sort' => '排序',
            'is_help' => '是否是帮助的相关分类',
        ];
    }
}
