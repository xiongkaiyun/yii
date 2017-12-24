<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_detail".
 *
 * @property integer $article_id
 * @property string $content
 */
class ArticleDetail extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'article_detail';
    }

    //规则
    public function rules()
    {
        return [

            [['content'], 'string']
        ];
    }

    //lable
    public function attributeLabels()
    {
        return [

            'content' => '文章内容',
        ];
    }

}
