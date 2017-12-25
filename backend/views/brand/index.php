<?php
/* @var $this yii\web\View */
?>
<h1>品牌列表</h1>
<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-primary">添加品牌</a>
<table class="table table-bordered">
    <tr>
        <th>品牌名称</th>
        <th>品牌图片</th>
        <th>品牌简介</th>
        <th>品牌状态</th>
        <th>品牌排序</th>
        <th colspan="2">操作</th>
    </tr>
    <?php foreach ($brands as $brand):?>
        <tr>
            <td><?=$brand->name?></td>
            <td><?=\yii\bootstrap\Html::img($brand->logo,['height'=>50])?></td>
            <td><?=$brand->intro?></td>
            <td>
                <?php

                if ($brand->status==1) {
                    echo "上架";
                } else{
                    echo "下架";
                }
                ?>
            </td>
            <td><?=$brand->sort?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$brand->id])?>" class="btn btn-info">编辑</a>
                <a href="<?=\yii\helpers\Url::to(['delete','id'=>$brand->id])?>" class="btn btn-danger">删除</a>
            </td>
        </tr>
        
    <?php endforeach;?>
    <tr>
        
    </tr>
</table>

