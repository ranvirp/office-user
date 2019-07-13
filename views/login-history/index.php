<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\users\models\LoginHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Login Histories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-12">
<div class="login-history-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <div class="form-title">
        <div class="form-title-span">
         <span>List of LoginHistory</span>
        </div>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

['header'=>'username',
'attribute'=>'username',
'value'=>function($model,$key,$index,$column)
{
                return $model->showValue('username');
},],['header'=>'Login Time',
'attribute'=>'logintime',
'value'=>function($model,$key,$index,$column)
{
                return date('d/m/Y G:i:s ',$model->showValue('logintime'));
},],['header'=>'Log Out Time',
'attribute'=>'logouttime',
'value'=>function($model,$key,$index,$column)
{
    $time=$model->showValue('logouttime');
                return $time?date('d/m/Y G:i:s ',$model->showValue('logouttime')):'Active Login';
},],
          
        ],
        'tableOptions'=>['class'=>'table table-hover small'],
        ]); ?>

</div>
</div>