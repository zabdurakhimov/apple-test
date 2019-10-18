<?php
/**
 * @var $model \backend\forms\EatForm
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>
<div class="orders-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php echo $form->errorSummary($model); ?>
    <?= $form->field($model, 'size')->textInput(['type' => 'number']) ?>
    <div class="form-group">
        <?php echo Html::submitButton('Eat' , ['class'=>'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>