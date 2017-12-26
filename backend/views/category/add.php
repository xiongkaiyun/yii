<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Category */
/* @var $form ActiveForm */
?>
<a href="<?=\yii\helpers\Url::to(['category/index'])?>" class="glyphicon glyphicon-home">返回首页</a>

<div class="container">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'parent_id')->hiddenInput(['value'=>0]) ?>
    <?= \liyuze\ztree\ZTree::widget([
        'setting' => '{
			data: {
				simpleData: {
					enable: true,
					pIdKey:"parent_id"
				},
			},
			callback: {
				onClick: function(e,treeId,treeNode){
				    //找到父类id的框框
				    $("#category-parent_id").val(treeNode.id);
				    
				    console.log(treeNode.id);
				
				}
			
			}
		}',
        'nodes' => $cates
    ]);
    ?>
        <?= $form->field($model, 'intro') ?>
    
        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- category-add -->

<?php
//定义js代码块
$js=<<<EOF

    var treeObj = $.fn.zTree.getZTreeObj("w1");
    treeObj.expandAll(true);

EOF;

//把js代码块加载到Jquery之后
$this->registerJs($js);

?>
