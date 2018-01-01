<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $goods backend\models\Goods */
/* @var $form ActiveForm */
?>
<div class="goods-add">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($goods, 'name') ?>
        <?= $form->field($goods, 'num') ?>
        <?= $form->field($goods, 'logo')->widget(\manks\FileInput::className(),['clientOptions' => [ 'server' => \yii\helpers\Url::to(['brand/upload'])]]) ?>
    <?= $form->field($goods, 'category_id')->dropDownList($catesArr,['prompt'=>'请选择一个分类']
    ) ?>
    <?= $form->field($goods, 'brand_id')->dropDownList($brandsArr) ?>
        <?= $form->field($goods, 'market_price') ?>
        <?= $form->field($goods, 'sale_price') ?>
        <?= $form->field($goods, 'inventory') ?>
        <?= $form->field($goods, 'status')->radioList(['1'=>'上架','0'=>'下架'],['value'=>1]) ?>
    <?= $form->field($goods, 'sort')->label("排序")->textInput(['value'=>100]) ?>
    <?= $form->field($goods, 'imgFiles')->label("多图上传")->widget('manks\FileInput', [
        'clientOptions' => [
            'pick' => [
                'multiple' => true,
            ],

            'server' => \yii\helpers\Url::to(['brand/upload']),
            // 'accept' => [
            // 	'extensions' => 'png',
            // ],
        ],
    ]); ?>
    <?= $form->field($goodsIntro, 'content')->widget(kucha\ueditor\UEditor::className(),[]) ?>


    <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- goods-add -->
