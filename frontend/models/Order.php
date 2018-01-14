<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $county
 * @property string $address
 * @property string $mobile
 * @property integer $delivery_id
 * @property string $delivery_name
 * @property string $delivery_price
 * @property integer $payment_id
 * @property string $payment_name
 * @property string $price
 * @property integer $status
 * @property string $num
 * @property integer $create_time
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'delivery_id', 'payment_id', 'status', 'create_time'], 'integer'],
            [['delivery_price', 'price'], 'number'],
            [['name', 'province', 'city', 'county', 'delivery_name', 'payment_name', 'num'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'name' => '用户名',
            'province' => '省',
            'city' => '市',
            'county' => '区县',
            'address' => '地址详情',
            'mobile' => '联系电话',
            'delivery_id' => '送货id',
            'delivery_name' => '送货方式',
            'delivery_price' => '运费',
            'payment_id' => '支付方式id',
            'payment_name' => '支付方式',
            'price' => '商品价格',
            'status' => '状态',
            'num' => 'Num',
            'create_time' => '下单时间',
        ];
    }
}
