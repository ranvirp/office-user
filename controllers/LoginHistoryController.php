<?php

namespace rp\users\controllers;

use Yii;
use app\common\Utility;
use rp\users\models\LoginHistory;
use rp\users\models\LoginHistorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LoginHistoryController implements the CRUD actions for LoginHistory model.
 */
class LoginHistoryController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all LoginHistory models.
     * @return mixed
     */
    public function actionIndex()
    {
       if (!Yii::$app->user->can('Administrator'))
               throw new NotFoundHttpException('The requested page does not exist for you.');


        $searchModel = new LoginHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>new \app\modules\users\models\LoginHistory        ]);
    }

    /**
     * Displays a single LoginHistory model.
     * @param integer $id
     * @return mixed
     */
    public function action1View($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LoginHistory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function action1Create()
    {


        $model = new LoginHistory();

        if ($model->load(Yii::$app->request->post()))
        {

            if ($model->save())
            $model = new LoginHistory();; //reset model
        }

        $searchModel = new LoginHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,

        ]);

    }

    /**
     * Updates an existing LoginHistory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
        public function action1Update($id)
    {
         $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post()))
        {
        if (array_key_exists('app\modules\users\models\LoginHistory',Utility::rules()))

            foreach ($model->attributes as $attribute)
            if (array_key_exists($attribute,Utility::rules()['app\modules\users\models\LoginHistory']))
            $model->validators->append(
               \yii\validators\Validator::createValidator('required', $model, Utility::rules()['app\modules\users\models\LoginHistory'][$model->$attribute]['required'])
            );
            if ($model->save())
            $model = new LoginHistory();; //reset model
        }

       $searchModel = new LoginHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,

        ]);

    }
    /**
     * Deletes an existing LoginHistory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LoginHistory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LoginHistory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LoginHistory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
