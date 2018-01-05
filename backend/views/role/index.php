<?php
/* @var $this yii\web\View */
?>
<h1>角色列表</h1>

<a href="<?=\yii\helpers\Url::to(['add'])?>" class="btn btn-primary">添加</a>

<table class="table">
    <tr>
        <th>名称</th>
        <th>描述</th>
        <th>权限</th>
        <th>操作</th>
    </tr>
    <?php foreach ($roles as $role):?>
        <tr>
<!--strpos 判断字符串中有没有另外一个字符串-->
            <td><?=$role->name?></td>
            <td><?=$role->description?></td>
            <td>
                <?php
                    $auth=Yii::$app->authManager;

                    //通过角色名得到权限
                    foreach ($auth->getPermissionsByRole($role->name) as $permission){

                        echo $permission->description."||";
                    }


                ?>



            </td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','name'=>$role->name])?>" class="btn btn-success">编辑</a>
                <a href="<?=\yii\helpers\Url::to(['delete','name'=>$role->name])?>" class="btn btn-danger">删除</a>
            </td>
        </tr> 
        
    <?php endforeach;?>



</table>