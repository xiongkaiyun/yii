<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/26
 * Time: 14:19
 */

namespace backend\components;


use creocoder\nestedsets\NestedSetsBehavior;

class MenuQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsBehavior::className(),
        ];
    }
}