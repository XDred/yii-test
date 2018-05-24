<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php if(isset($referrer)):?>
<p class="lead">Вы пришли от <?=$referrer->username;?></p>
<?php endif;?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<div class="form-group">
 <div>
 <?= Html::submitButton('Регистрация', ['class' => 'btn btn-success']) ?>
 </div>
</div>
<?php ActiveForm::end() ?>