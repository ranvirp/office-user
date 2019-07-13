<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\masterdata\models\DesignationTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Designation Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if ($model!=null):?><div class="col-lg-6">
<?=$this->render('_form',['model'=>$model]) ?></div>
<div class="col-lg-6">
<?php else:?><div class="col-lg-12">
<?php endif;?><div class="designation-type-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

['header'=>'id',
'value'=>function($model,$key,$index,$column)
{
                return $model->showValue('id');
},],['header'=>'level_id',
'value'=>function($model,$key,$index,$column)
{
                return $model->showValue('level_id');
},],['header'=>'name_hi',
'value'=>function($model,$key,$index,$column)
{
                return $model->showValue('name_hi');
},],['header'=>'name_en',
'value'=>function($model,$key,$index,$column)
{
                return $model->showValue('name_en');
},],['header'=>'shortcode',
'value'=>function($model,$key,$index,$column)
{
                return $model->showValue('shortcode');
},],
            ['class' => 'yii\grid\ActionColumn'],
        ],
        'tableOptions'=>['class'=>'small'],
   // 'containerOptions' => ['style'=>'overflow: auto','id'=>'works'], // only set when $responsive = false
   // 'headerRowOptions'=>['class'=>'kartik-sheet-style'],
    //'filterRowOptions'=>['class'=>'kartik-sheet-style'],
   
    ]); ?>

</div>
</div>