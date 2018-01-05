<?php

$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput(['disabled'=>"disabled"]);
echo $form->field($model,'description')->textarea();
echo \yii\bootstrap\Html::submitButton("提交",['class'=>'btn btn-primary']);

\yii\bootstrap\ActiveForm::end();