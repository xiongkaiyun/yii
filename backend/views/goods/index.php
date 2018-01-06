<?php
/* @var $this yii\web\View */
?>
    <h1>商品列表</h1>

    <div class="row">
        <div class="pull-left">
            <?=\yii\bootstrap\Html::a("添加",['add'],['class'=>"btn btn-info"])?>
        </div>
        <div class="pull-right">
            <form class="form-inline">
                <select class="form-control" name="status">
                    <option>选择状态</option>
                    <option value="1" <?=Yii::$app->request->get('status')==="1"?"selected":""?>>上架</option>
                    <option value="0" <?=Yii::$app->request->get('status')==="0"?"selected":""?>>下架</option>
                </select>
                <div class="form-group">
                    <input type="text" size="3" class="form-control" name='minPrice' placeholder="最低价" value="<?=Yii::$app->request->get('minPrice')?>">
                </div>
                -
                <div class="form-group">
                    <input type="text" size="3" class="form-control" name="maxPrice" placeholder="最高价" value="<?=Yii::$app->request->get('maxPrice')?>">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="keyword" placeholder="请输入名称或货号" value="<?=Yii::$app->request->get('keyword')?>">
                </div>
                <button type="submit" class="btn btn-default">搜索</button>
            </form>
        </div>
    </div>


    <div class="table-responsive">


<table class="table">
    <tr>
        <th>ID</th>
        <th>商品名称</th>
        <th>货号</th>
        <th>商品logo</th>
        <th>商品分类</th>
        <th>品牌</th>
        <th>市场价</th>
        <th>促销价</th>
        <th>商品库存</th>
        <th>商品状态</th>
        <th>排序</th>
        <th>录入时间</th>
        <th>操作</th>
    </tr>

    <?php foreach ($goods as $good):?>
        <tr>
            <td><?=$good->id?></td>
            <td><?=$good->name?></td>
            <td><?=$good->num?></td>
            <td><?=$good->logo?></td>
            <td><?=$good->category_id?></td>
            <td><?=$good->brand_id?></td>
            <td><?=$good->market_price?></td>
            <td><?=$good->sale_price?></td>
            <td><?=$good->inventory?></td>
            <td>
                <?php
                if ($good->status==1) {
                    echo '<i class="glyphicon glyphicon-ok"></i>';
                } else{
                    echo '<i class="glyphicon glyphicon-remove"></i>';
                }
                ?>


            </td>
            <td><?=$good->sort?></td>
            <td><?=date("Y-m-d H:i:s","$good->create_time")?></td>
            <td>

                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$good->id])?>" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span></a>
                <a href="<?=\yii\helpers\Url::to(['delete','id'=>$good->id])?>" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a>
            </td>

        </tr>

    <?php endforeach;?>

</table>

    </div>
<?=\yii\widgets\LinkPager::widget(
    ['pagination' => $pages]
)?>