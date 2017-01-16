<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile("@web/css/style.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
], 'general-style');

$this->registerJsFile(
    '@web/js/main.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>

<h1>Images</h1>
	<?php
		$form = ActiveForm::begin([
	    'id' => 'login-form',
	    'options' => ['class' => 'form-horizontal'],
		]);
	?>

	<?= $form->field($model, 'fileUpload')->fileInput() ?>
	<div class="form-group">
        <div class="col-lg-12">
            <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>


<?php foreach ($images as $image): ?>
	<div class="img-row">
		<?php
			$options = ['alt' => 'My Image', 'style' => ['height' => "200px", ], 'data-id' => $image->id];
			if(!is_null($image->angle) && $image->angle > 0)
				Html::addCssStyle($options, 'transform: rotate(' . $image->angle . 'deg)');
		?>
		<?= Html::img('@web/uploads/' . $image->path, $options) ?>
		<div>
			<?= Html::button("Rotate", ['class' => 'btn btn-success rotate']) ?>
			<?= Html::button("Delete", ['class' => 'btn btn-danger delete']) ?>
		</div>
	</div>
<?php endforeach; ?>