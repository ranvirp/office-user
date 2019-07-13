<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
$this->title = 'Change Username';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-changeusername">
    
    <p>Please fill out the following fields to Change Username:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'changeusername-form','action'=>Url::to(['/users/user/changeusername?id='.$model->id])]); ?>
                <p>Old Username:<?=$model->username?></p>
                <?= $form->field($model,'username')->textInput()->label('New Username') ?>
                <?= $form->field($model,'newpassword')->textInput()->label('New Password') ?>
                
                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
