<?php



/* @var $this yii\web\View */
/* @var $model app\modules\users\models\LoginHistory */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Login History',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Login Histories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-history-create">
<?=  $this->render('_form');
	   ?>
</div>
