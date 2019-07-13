<?php

namespace rp\users\controllers;

use yii\web\Controller;
use Yii;
use rp\users\Utility;


class UtilityController extends Controller
{
    public function actionIndex1()
    {
        return $this->render('index');
    }
    public function actionGetdesignation($dt)
    {
    $query=\app\modules\users\models\Designation::find()->where(['designation_type_id'=>$dt]);
    $user=Yii::$app->user->identity;

    if (($district_code=\app\modules\users\models\Designation::getDistrictCode($user))!=null)
    {

      $blocksanddistrict=array_keys(\yii\helpers\ArrayHelper::map(\app\modules\mnrega\models\Block::find()->where(['district_code'=>$district_code])->asArray()->all(),'code','name_en'));
      $blocksanddistrict[]=$district_code;
      $query->andWhere(['level_id'=>$blocksanddistrict]);
     }
    return json_encode(\yii\helpers\ArrayHelper::map($query->asArray()->all(),'id','name_'.Yii::$app->language));
    }
	public function actionIndex()
	{
		if (Yii::$app->request->get('at')) //at===action type
		{//at=>action type
			$at=Yii::$app->request->get('at');
			switch ($at)
			{
				case 'glt': //get level type
				 $id=Yii::$app->request->get('id');
				 	if (!is_numeric(trim($id)))
						return json_encode([]);
					else
					{
					return json_encode(Utility::getLevelsByType($id));
				 }
			     break;
			 case 'gltk'://as per requirement of krajee depdropwidget
				 $lang=Yii::$app->language;
		         $designation_type=Yii::$app->request->post('depdrop_parents')[0];
		         $y=[];
		         foreach (Utility::getLevelsByType($designation_type) as $id=>$name)
		           {
			         $x['id']=$id;
			         $x['name']=$name;
			         $y[]=$x;
		           }
		           return \yii\helpers\Json::encode(['output'=>$y,'selected'=>'']);


			     break;
			}
		}
	}
}
