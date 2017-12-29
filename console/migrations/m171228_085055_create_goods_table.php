<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m171228_085055_create_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment("商品名称"),
            'num'=>$this->string(50)->notNull()->comment("商品货号"),
            'logo'=>$this->string()->notNull()->comment("商品图片"),
            'category_id'=>$this->integer()->notNull()->comment("商品分类"),
            'brand_id'=>$this->integer()->notNull()->comment("品牌"),
            'market_price'=>$this->decimal()->notNull()->comment("市场价格"),
            'sale_price'=>$this->decimal()->notNull()->comment("促销价格"),
            'inventory'=>$this->integer()->notNull()->comment("库存"),
            'status'=>$this->integer()->defaultValue(1)->notNull()->comment("商品状态"),
            'create_time'=>$this->integer()->notNull()->comment("上架时间")

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods');
    }
}
