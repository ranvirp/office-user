<?php

use yii\helpers\Html;
use yii\helpers\Url;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\masterdata\models\DesignationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="designation-index">

    <?php echo $this->render('changeUsername', ['model' => $model]); ?>

  

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['attribute'=>'username',],
            ['header'=>'Change username',
            'value'=>function($model,$key,$index,$column) {
                return Html::a('<button>Change UserName</button>',Url::to(['/users/user/changeusername?id='.$model->id]));  
               },
               'format'=>'html',
            ],

           
        ],
    ]); ?>

</div>
