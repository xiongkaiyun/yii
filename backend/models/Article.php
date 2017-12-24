<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $name
 * @property integer $article_category_id
 * @property string $intro
 * @property integer $status
 * @property integer $sort
 * @property integer $inputtime
 */
class Article extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'article';
    }

    //设置属性
    public function rules()
    {
        return [
            [['name', 'article_category_id', 'status', 'sort'], 'required'],
            [['article_category_id', 'status', 'sort', 'inputtime'], 'integer'],
            [['intro'], 'string'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    //lable
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章名称',
            'article_category_id' => '文章分类',
            'intro' => '文章简介',
            'article_id'=>'文章内容',
            'status' => '状态',
            'sort' => '排序',
            'inputtime' => '上架时间',
        ];
    }

    //设置一对一的关系
    public function getContent(){
        //return $this->hasOne(需要关联的类的名字,['相关联的类中的字段'=>'当前类的字段']);
        return $this->hasOne(ArticleDetail::className(),['article_id'=>"id"]);
    }

    //得到文章内容
    public function getContentName(){

        return ArticleDetail::findOne($this->article_category_id)->content;
    }
}
