<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_detail`.
 */
class m180113_085830_create_order_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order_detail', [
            'id' => $this->primaryKey(),
            'order_info_id'=>$this->integer()->comment("订单id"),
            'goods_id'=>$this->integer()->comment("商品id"),
            'amount'=>$this->integer()->comment("商品数量"),
            'goods_name'=>$this->string(20)->comment("商品名称"),
            'logo'=>$this->string(20)->comment("商品图片"),
            'price'=>$this->decimal(10,2)->comment("商品价格"),
            'total_price'=>$this->decimal(10,2)->comment("总价"),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order_detail');
    }
}
