<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\users\models\LoginHistory */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Login History',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Login Histories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="login-history-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
