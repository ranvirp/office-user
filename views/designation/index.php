<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\assets\AppAssetGoogle;
use app\modules\users\models\DesignationType;
use app\modules\mnrega\models\District;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\masterdata\models\DesignationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
 
  $js="

$(\"#toggleButton\").click(function () {
 
    // Set the effect type
    var effect = 'slide';
 
    // Set the options for the effect type chosen
    var options = { direction: 'right' };
 
    // Set the duration (default: 400 milliseconds)
    var duration = 700;
 
    $('#designation-grid').toggle(effect, options, duration);
  //  $('#designation-form').removeClass();
    
    //$('#designation-form').addClass('col-lg-12');
    $(this).text('Show Grid');
});
";
$this->registerJs($js);
AppAssetGoogle::register($this);

$this->title = Yii::t('app', 'Designations');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-12" id="designation-form">
<?php
//$this->render('_form',['model'=>$model]) 
?>
</div>
<div class="col-md-12" id="designation-grid">
<div class="designation-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\SerialColumn'],

['header'=>'id',
'value'=>function($model,$key,$index,$column)
{
                return $model->showValue('id');
},],['header'=>'Designation Type',
'attribute'=>'designation_type_id',
'value'=>function($model,$key,$index,$column)
{
                return $model->showValue('designation_type_id');
},
'filter'=>\yii\helpers\ArrayHelper::map(DesignationType::find()->asArray()->all(),'id','name_'.Yii::$app->language)
,],
['header'=>'Place',
'attribute'=>'level_id',
'value'=>function($model,$key,$index,$column)
{
                return $model->designationType->level?$model->designationType->level->name_en:'Not Found'
                //.print_r($model->level,true);
                .':'.($model->level)?$model->level->name_en:'Not Found';
                ;
},
'filter'=>\yii\helpers\ArrayHelper::map(District::find()->orderBy('name_en asc')->asArray()->all(),'code','name_en'),
],['header'=>'Officer Name in Hindi',
'value'=>function($model,$key,$index,$column)
{
                return $model->showValue('officer_name_hi');
},],['header'=>'Officer Name in English',
'value'=>function($model,$key,$index,$column)
{
                return $model->showValue('officer_name_en');
},],             'officer_mobile',
            // 'officer_mobile1',
            'officer_email:email',
            ['header'=>'Username',
            'attribute'=>'officer_userid',
'value'=>function($model,$key,$index,$column)
{
                return $model->officer_userid.' '.$model->user->username;
},],

            
        ],
        'tableOptions'=>['class'=>'table table-striped small'],
    
    ]); ?>

</div>
</div>