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
        //文章管理表
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'title'=>$this->string(100)->notNull()->comment("文章标题"),
            'create_time'=>$this->integer()->notNull()->comment("创建时间"),
            'status'=>$this->smallInteger()->notNull()->defaultValue(1)->comment("状态 1显示 2隐藏"),
            'sort'=>$this->integer()->notNull()->defaultValue(100)->comment("排序"),
            'intro'=>$this->string()->comment("简介"),
            'cate_id'=>$this->integer()->notNull()->comment("分类id"),
        ]);

        //文章内容表
        $this->createTable('detail', [
            'id' => $this->primaryKey(),
            'content'=>$this->text()->notNull()->comment("文章内容"),
            'article_id'=>$this->integer()->notNull()->comment("文章id"),

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
