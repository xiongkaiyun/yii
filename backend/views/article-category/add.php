<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ArticleCategory */
/* @var $form ActiveForm */
?>
<div class="article-category-add">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'content')->textarea() ?>
        <?= $form->field($model, 'status')->radioList(['0'=>'禁用','1'=>'激活'],['value'=>1]) ?>
        <?= $form->field($model, 'sort')->textInput(['value'=>100]) ?>
    
        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- article-category-add -->
