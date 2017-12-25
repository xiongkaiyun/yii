<?php
/* @var $this yii\web\View */
?>
<h1>文章管理</h1>

<a href="<?= \yii\helpers\Url::to(['add']) ?>" class="btn btn-info">添加文章</a>
<table class="table">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th>分类</th>
        <th>简介</th>
        <th>状态</th>
        <th>排序</th>
        <th>录入时间</th>
        <th>操作</th>
    </tr>
    <?php
    const STATUS = [0=>'禁用',1=>'激活'];
    foreach ($articles as $article): ?>
        <tr>
            <td><?= $article->id?></td>
            <td><?= $article->name?></td>
            <td><?= $article->articleCategory->name?></td>
            <td><?= $article->content?></td>
            <td>
                <?php
                    if ($article->status==1){
                        echo "<i class='glyphicon glyphicon-ok'></i>";
                    }else{
                        echo "<i class='glyphicon glyphicon-remove'></i>";
                    }
                ?>
            </td>
            <td><?= $article->sort?></td>
            <td><?= date('Y-m-d H:i:s',$article->inputtime)?></td>
            <td>
                <a href="<?= \yii\helpers\Url::to(['edit', 'id' => $article->id]) ?>" class="btn btn-success">编辑</a>
                <?= \yii\bootstrap\Html::a("删除", ['del', 'id' => $article->id], ["class" => "btn btn-danger"]) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
