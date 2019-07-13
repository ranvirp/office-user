<?php
namespace rp\users\controllers;
use Yii;
use rp\users\models\LoginForm;
use rp\users\models\PasswordResetRequestForm;
use rp\users\models\ResetPasswordForm;
use rp\users\models\User;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

/**
 * User controller
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','changepassword'],
                'rules' => [

                    [
                        'actions' => ['logout','changepassword'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex($id=2)
    {
        $query=User::find();
        $usersearch = new User;
        $model=User::findOne($id);
        if ($usersearch->load(Yii::$app->request->queryParams))
        {
          $query=$query->andFilterWhere(['like','username',$usersearch->username]);
        }
        $dp = new ActiveDataProvider(['query'=>$query]);
        return $this->render('index',['dataProvider'=>$dp,'searchModel'=>$usersearch,'model'=>$model]);
    }

    public function actionLogin($returnurl='')
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
         if ($returnurl!='')
           return $this->redirect($returnurl);
           else
            return $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
     public function actionChangepassword()
    {
       $user = Yii::$app->user->identity;

       $user->scenario='passwordchange';
       $user->oldpassword=null;
      if ( $user->load(Yii::$app->request->post()) && $user->changePassword())

          return $this->render('passwordchanged');

        return $this->render('ChangePassword',['model'=>$user]);
    }
    public function actionChangeusername($id)
    {
      if (!Yii::$app->user->can('webadmin'))
        throw new BadRequestHttpException('Not Allowed!!!');
      $user = new User;
      $user->scenario='usernamepasswordchange';
      if ( $user->load(Yii::$app->request->post()) )
      {
        $user1 = User::findOne($id);
        if ($user1)
         {
          $user1->username=$user->username;
          if ($user->newpassword!='')
          $user1->setPassword($user->newpassword);
          if ($user1->validate())
          $user1->save();
          else
           print_r($user1->errors);
         }
      }
      return $this->redirect(['/users/user?id='.$id]);
    }

}
