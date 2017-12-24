<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m171224_080139_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment("文章名称"),
            'article_category_id'=>$this->smallInteger()->notNull()->comment("文章分类"),
            'intro'=>$this->text()->comment("文章简介"),
            'status'=>$this->smallInteger()->notNull()->comment("状态"),
            'sort'=>$this->smallInteger()->notNull()->comment("排序"),
            'inputtime'=>$this->integer()->comment("上架时间")
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
