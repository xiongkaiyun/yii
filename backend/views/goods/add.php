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
        <?= $form->field($goods, 'logo')->label("商品logo")->widget('manks\FileInput', [
        ]);?>
        <?= $form->field($goods, 'category_id')->dropDownList($catesArray) ?>
        <?= $form->field($goods, 'brand_id')->dropDownList($brandsArray) ?>
        <?= $form->field($goods, 'market_price') ?>
        <?= $form->field($goods, 'sale_price') ?>
        <?= $form->field($goods, 'inventory') ?>
        <?= $form->field($goods, 'status')->radioList(['1'=>'上架','0'=>'下架'],['value'=>1]) ?>
    <?= $form->field($goods, 'sort')->textInput(['value'=>100]) ?>
    <?= $form->field($goodsIntro, 'content')->widget('kucha\ueditor\UEditor',[])?>
    
        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- goods-add -->
