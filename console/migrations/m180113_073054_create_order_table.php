<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m180113_073054_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->comment("用户id"),
            'name' => $this->string(20)->comment("用户名"),
            'province' => $this->string(20)->comment("省"),
            'city' => $this->string(20)->comment("市"),
            'county' => $this->string(20)->comment("区县"),
            'address' => $this->string()->comment("地址详情"),
            'mobile' => $this->char(11)->comment("联系电话"),
            'delivery_id' => $this->smallInteger(1)->comment("送货id"),
            'delivery_name' => $this->string(20)->comment("送货方式"),
            'delivery_price' => $this->decimal(7,2)->comment("运费"),
            'payment_id' => $this->smallInteger(1)->comment("支付方式id"),
            'payment_name' => $this->string(20)->comment("支付方式"),
            'price' => $this->decimal(10,2)->comment("商品价格"),
            'status' => $this->smallInteger(1)->comment("状态"),
            'num' => $this->string(20)->comment(""),
            'create_time' => $this->integer()->comment("下单时间"),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order');
    }
}
