<a href="<?=\yii\helpers\Url::to(['admin/add'])?>" class="btn btn-primary">注册</a>
<table class="table">
    <tr>
        <th>管理员名称</th>
        <th>管理员邮箱</th>
        <th>注册时间</th>
        <th>最后登录时间</th>
        <th>最后登录ip</th>
        <th>操作</th>
    </tr>

    <?php foreach ($admins as $admin):?>
        <tr>
            <td><?=$admin->username?></td>
            <td><?=$admin->email?></td>
            <td><?=date("Y-m-d H:i:s",$admin->created_at)?></td>
            <td><?=date("Y-m-d H:i:s",$admin->last_login_at)?></td>
            <td><?=$admin->last_login_ip?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$admin->id])?>" class="btn btn-success">编辑</a>
                <a href="<?=\yii\helpers\Url::to(['delete','id'=>$admin->id])?>" class="btn btn-danger">删除</a>

            </td>
        </tr>
    <?php endforeach;?>

</table>


