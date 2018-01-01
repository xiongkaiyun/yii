<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_intro`.
 */
class m171229_075006_create_goods_intro_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_intro', [
            'id' => $this->primaryKey(),
            'goods_id'=>$this->integer()->notNull()->comment("商品id"),
            'content'=>$this->text()->comment("商品描述")

        ]);

        $this->createTable('goods_gallery', [
            'id' => $this->primaryKey(),
            'goods_id'=>$this->integer()->notNull()->comment("商品id"),
            'path'=>$this->string()->comment("商品图片地址")

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_intro');
    }
}
