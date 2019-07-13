<?php

namespace app\modules\users;

use Yii;
use \yii\helpers\ArrayHelper;


class Utility 
{
  public static function getLevelsByType($id)
  {
	  $lang=Yii::$app->language;
	  $dt=  \app\modules\users\models\DesignationType::findOne($id);
	  $classname= $dt->level->class_name;
	  return ArrayHelper::map($classname::find()->orderBy('name_en asc')->asArray()->all(),$classname::primaryKey(),'name_en');
	  
  
}
}
?>