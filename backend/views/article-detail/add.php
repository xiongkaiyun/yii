<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($details,'content')->textarea();
echo \yii\bootstrap\Html::submitButton("提交",['class'=>'btn btn-success']);

\yii\bootstrap\ActiveForm::end();