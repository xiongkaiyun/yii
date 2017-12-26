<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m171226_034650_create_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'tree' => $this->integer()->notNull()->comment("树状"),
            'lft' => $this->integer()->notNull()->comment("左值"),
            'rgt' => $this->integer()->notNull()->comment("右值"),
            'depth' => $this->integer()->notNull()->comment("深度"),
            'name' => $this->string()->notNull()->comment("分类名称"),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('category');
    }
}
