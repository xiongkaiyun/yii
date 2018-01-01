<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/1
 * Time: 16:59
 */

namespace backend\models;


use yii\base\Model;

class LoginForm extends Model
{
    //声明用户名，密码
    public $username;

    public $password;

    //默认勾选
    public $rememberMe=true;


    //规则
    public function rules()
    {
        return [
            [['username','password'],'required'],
            [['rememberMe'],'safe']

        ];
    }

    //lable属性
    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码',
            'rememberMe'=>'记住我'
        ];
    }

}