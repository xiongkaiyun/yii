<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($articles,'name');
echo $form->field($articles,'intro')->textarea();
echo $form->field($articles,'status')->radioList(['1'=>'上架','2'=>'下架'],['value'=>'1']);
echo $form->field($articles,'sort')->textInput(['value'=>100]);
echo $form->field($articles,'is_help')->radioList(['1'=>'是','2'=>'否'],['value'=>1]);

echo \yii\bootstrap\Html::submitButton("提交",['class'=>'btn btn-success']);

\yii\bootstrap\ActiveForm::end();




?>