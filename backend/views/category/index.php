<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span></a>

<table class="table table-hover">
    <tr>
        <th>ID</th>
        <th>分类名称</th>
        <th>父类id</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach ($cates as $cate):?>
        <tr>
            <td><?=$cate->id?></td>
            <td><?=$cate->name?></td>
            <td><?=$cate->parent_id?></td>
            <td><?=$cate->intro?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$cate->id])?>" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span></a>
                <a href="<?=\yii\helpers\Url::to(['delete','id'=>$cate->id])?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
            </td>
        </tr>
    <?php endforeach;?>


</table>