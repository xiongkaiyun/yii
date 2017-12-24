<?php

?>
<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-success">添加文章</a>
<table class="table table-responsive table-bordered">
    <tr>
        <th>文章名称</th>
        <th>文章分类</th>
        <th>文章简介</th>
        <th>文章内容</th>
        <th>状态</th>
        <th>排序</th>
        <th>上架时间</th>
        <th>操作</th>
    </tr>

    <?php foreach ($articles as $article):?>
        <tr>
            <td><?=$article->name?></td>
            <td><?=$article->article_category_id?></td>
            <td><?=$article->intro?></td>
            <td><?=$article->contentName?></td>
            <td>
                <?php if($article->status==1){
                    echo "上架";
                }else{
                    echo "下架";
                }
                ?>
            </td>

            <td><?=$article->sort?></td>
            <td><?=date("Y-m-d H:i:s",$article->inputtime)?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$article->id])?>" class="btn btn-primary">编辑</a>
                <a href="<?=\yii\helpers\Url::to(['delete','id'=>$article->id])?>" class="btn btn-danger">删除</a>
            </td>
        </tr>

    <?php endforeach;?>


</table>
