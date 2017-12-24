<?php

use yii\db\Migration;

/**
 * Handles the creation of table `brand`.
 */
class m171222_073912_create_brand_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('品牌名称'),
            'logo'=>$this->string(100)->notNull()->comment('品牌图片'),
            'intro'=>$this->text()->comment('品牌简介'),
            'status'=>$this->smallInteger()->comment('品牌状态'),
            'sort'=>$this->smallInteger()->comment('排序')


        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('brand');
    }
}
