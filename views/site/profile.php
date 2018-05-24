<?php
	
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
?>

<div>
	<label class="col-lg-2 control-label" for="loginform-username">Реферальная ссылка</label>
	<div class="col-lg-5">
		<input type="text" class="form-control" value="<?=$url?>">
	</div>
</div>
<?php $form = ActiveForm::begin() ?>
<?=Html::hiddenInput('new_referral_link', "true");?>
<div class="form-group">
	<div>
		<?= Html::submitButton('Генерация новой реферальной ссылки', ['class' => 'btn btn-success']) ?>
	</div>
</div>
<?php ActiveForm::end() ?>

<?php if(isset($referrer)):?>
<p class="lead">Вы пришли от <?=$referrer->username;?></p>
<?php endif;?>

<?php if(isset($referrals)):?>
<p class="lead">От вас пришли:</p>
<?php foreach($referrals as $user):?>
	<?=$user->username;?><br />
<?php endforeach; endif;?>