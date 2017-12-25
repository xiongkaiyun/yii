<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_category`.
 */
class m171224_061437_create_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(100)->notNull()->comment("名称"),
            'status'=>$this->smallInteger()->notNull()->defaultValue(1)->comment("状态:1 显示  2 隐藏"),
            'sort'=>$this->integer()->notNull()->defaultValue(100)->comment("排序"),
            'intro'=>$this->string()->comment("简介"),
            'is_help'=>$this->smallInteger()->notNull()->defaultValue(0)->comment("是否帮助类别"),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_category');
    }
}
