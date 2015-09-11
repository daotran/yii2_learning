<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;
?>
 
<?php $form = ActiveForm::begin(array(
    'options' => array('class' => 'form-horizontal', 'role' => 'form'),
)); ?>
	<div class="form-group">
	    <?php echo $form->field($model, 'title')->textInput(array('class' => 'form-control')); ?>
	</div>
	<div class="form-group">
	    <?php echo $form->field($model, 'data')->textArea(array('class' => 'form-control')); ?>
	</div>
	<div class="form-group">
	    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
        	'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
        ]) ?>
	</div>
	
    <?php echo Html::submitButton('Submit', array('class' => 'btn btn-primary pull-right')); ?>
<?php ActiveForm::end(); ?>