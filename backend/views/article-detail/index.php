
<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-primary">添加文章内容</a>

<table class="table table-bordered">
    <tr>
        <td>文章分类</td>
        <td>文章内容</td>
        <td>操作</td>
    </tr>
    <?php foreach ($details as $detail):?>
        <tr>
            <td><?=$detail->article_id?></td>
            <td><?=$detail->content?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$detail->article_id])?>" class="btn btn-success">编辑</a>
                <a href="<?=\yii\helpers\Url::to(['delete','id'=>$detail->article_id])?>" class="btn btn-danger">删除</a>
            </td>
        </tr>

    <?php endforeach;?>

</table>