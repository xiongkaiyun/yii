<?php

use yii\db\Migration;

/**
 * Handles the creation of table `delivery`.
 */
class m180114_082517_create_delivery_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('delivery', [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->comment("送货方式"),
            'price'=>$this->integer()->comment("运费"),
            'intro'=>$this->string()->comment("简介")
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('delivery');
    }
}
