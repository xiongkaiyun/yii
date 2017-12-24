<?php

?>
<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-success">添加文章</a>
<table class="table table-bordered">
    <tr>
        <th>文章名称</th>
        <th>文章简介</th>
        <th>状态</th>
        <th>排序</th>
        <th>是否是帮助类</th>
        <th>操作</th>
    </tr>

    <?php foreach ($articles as $article):?>
        <tr>
            <td><?=$article->name?></td>
            <td><?=$article->intro?></td>
            <td><?=$article->status?></td>
            <td><?=$article->sort?></td>
            <td><?=$article->is_help?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$article->id])?>" class="btn btn-primary">编辑</a>
                <a href="<?=\yii\helpers\Url::to(['delete','id'=>$article->id])?>" class="btn btn-danger">删除</a>
            </td>
        </tr>

    <?php endforeach;?>
    
    
</table>
