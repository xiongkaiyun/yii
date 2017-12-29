<?php
/* @var $this yii\web\View */
?>

<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span></a>
<table class="table">
    <tr>
        <th>商品名称</th>
        <th>货号</th>
        <th>商品logo</th>
        <th>商品分类</th>
        <th>品牌</th>
        <th>市场价</th>
        <th>促销价</th>
        <th>商品库存</th>
        <th>商品状态</th>
        <th>录入时间</th>
        <th>操作</th>
    </tr>

    <?php foreach ($goods as $good):?>
        <tr>
            <td><?=$good->id?></td>
            <td><?=$good->name?></td>
            <td><?=\yii\bootstrap\Html::img($good->logo,['height'=>50])?></td>
            <td><?=$good->categore_id?></td>
            <td><?=$good->brand_id?></td>
            <td><?=$good->market_price?></td>
            <td><?=$good->sale_price?></td>
            <td><?=$good->inventory?></td>
            <td><?=$good->status?></td>
            <td><?=$good->create_time?></td>
            <td>

                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$good->id])?>" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span></a>
                <a href="<?=\yii\helpers\Url::to(['delete','id'=>$good->id])?>" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></a>
            </td>

        </tr>


    <?php endforeach;?>



</table>