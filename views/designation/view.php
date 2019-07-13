<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\masterdata\models\Designation */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Designations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="designation-view">

    <h1><?= Html::encode($this->title) ?></h1>

   
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name_en',
            'name_hi',
            'officer_name_hi',
            'officer_name_en',
            'officer_mobile',
            'officer_mobile1',
            'officer_email:email',
            ['attribute'=>'officer_userid','value'=>\app\modules\users\models\User::findOne($model->officer_userid)->username]
        ],
    ]) ?>

</div>
