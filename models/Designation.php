<?php
namespace rp\users\models;

use Yii;

/**
 * This is the model class for table "designation".
 *
 * @property integer $id
 * @property integer $designation_type_id
 * @property integer $level_id
 * @property string $officer_name_hi
 * @property string $officer_name_en
 * @property string $officer_mobile
 * @property string $officer_mobile1
 * @property string $officer_email
 * @property string $officer_userid
 *
 * @property DesignationType $designationType
 */
class Designation extends \app\modules\users\MyActiveRecord
{
 public $resetpasswd=0;
 public $createuser=1;
 public $randpasswd=0;
 public $inactiveuser=0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'designation';
    }
 /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['designation_type_id','officer_userid'], 'integer'],
            [['officer_name_hi', 'officer_name_en'], 'string', 'max' => 100],
            [['officer_mobile', 'officer_mobile1'], 'string', 'max' => 12],
            [['officer_email'], 'email'],
            [['name_hi','name_en'],'required'],
            [['level_id'],'required'],
            [['officer_email'],'required' ,'on'=>'randpasswd'],
            [['resetpasswd','randpasswd','createuser','inactiveuser'],'safe'],
           // [['officer_userid'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'designation_type_id' => Yii::t('app', 'Designation Type'),
            'level_id' => Yii::t('app', 'Level/Place of Posting'),
            'officer_name_hi' => Yii::t('app', 'Officer Name in Hindi'),
            'officer_name_en' => Yii::t('app', 'Officer Name in English'),
            'officer_mobile' => Yii::t('app', 'Officer Mobile'),
            'officer_mobile1' => Yii::t('app', 'Officer Mobile1'),
            'officer_email' => Yii::t('app', 'Officer Email'),
            'officer_userid' => Yii::t('app', 'Officer Userid'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDesignationType()
    {
        return $this->hasOne(DesignationType::className(), ['id' => 'designation_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'officer_userid']);
    }

	/*
	*@return form of individual elements
	*/
	public function showForm($form,$attribute)
	{
		switch ($attribute)
		  {


			case 'id':
			   return  $form->field($this,$attribute)->textInput();

			    break;

			case 'designation_type_id':
			   return  $form->field($this,$attribute)->dropDownList(\yii\helpers\ArrayHelper::map(DesignationType::find()->asArray()->all(),"id","name_".Yii::$app->language));

			    break;

			case 'level_id':
			   return  $form->field($this,$attribute)->textInput();

			    break;

			case 'officer_name_hi':
			   return  $form->field($this,$attribute)->textInput();

			    break;

			case 'officer_name_en':
			   return  $form->field($this,$attribute)->textInput();

			    break;

			case 'officer_mobile':
			   return  $form->field($this,$attribute)->textInput();

			    break;

			case 'officer_mobile1':
			   return  $form->field($this,$attribute)->textInput();

			    break;

			case 'officer_email':
			   return  $form->field($this,$attribute)->textInput();

			    break;

			case 'officer_userid':
			   return  $form->field($this,$attribute)->textInput();

			    break;

			default:
			break;
		  }
    }
	/*
	*@return form of individual elements
	*/
	public function showValue($attribute)
	{
	    $name='name_'.Yii::$app->language;
		switch ($attribute)
		  {


			case 'id':
			   return $this->id;			    break;

			case 'designation_type_id':
			   return DesignationType::findOne($this->designation_type_id)->$name;			    break;

			case 'level_id':
			   return $this->level_id;			    break;

			case 'officer_name_hi':
			   return $this->officer_name_hi;			    break;

			case 'officer_name_en':
			   return $this->officer_name_en;			    break;

			case 'officer_mobile':
			   return $this->officer_mobile;			    break;

			case 'officer_mobile1':
			   return $this->officer_mobile1;			    break;

			case 'officer_email':
			   return $this->officer_email;			    break;

			case 'officer_userid':
			   return $this->officer_userid;			    break;

			default:
			break;
		  }
    }
 /*
    */
    public function getDesignationtypes()
    {
      return \app\modules\users\models\DesignationType::findOne($this->designation_type_id);
    }
    public function getLevel()
    {
      $classname= $this->designationType->level->class_name;
      if (class_exists($classname))
      return $classname::findOne($this->level_id);
      else
       return "Level does not exist\n";
    }
    public function createUserAndRole()
     {


        $role=$this->designationType->shortcode;
        $username=$role.'_'.strtolower($this->level->name_en);
        $auth = Yii::$app->authManager;
        $username=preg_replace("/\s+/","",$username);
        $username=strtolower($username);
        $rolecreated=$auth->getRole($role);
		if (!$rolecreated)
		{
        // add "author" role and give this role the "createPost" permission
           $rolecreated= $auth->createRole($role);
		   $auth->add($rolecreated);
		}

		//$userclass=Yii::$app->getModule('user')->modelClasses['User'];
		//$usermodel=$userclass::find()->where('username=:username',[':username'=>$username])->one();
		//$usermodel=null;
		$existinguserexists=0;
		if (!$this->officer_userid)
		{
		 $usermodel = User::findOne([
           // 'status' => User::STATUS_ACTIVE,
           // 'email' => $this->email,
              'username'=>$username,
        ]);
        if ($usermodel)  $existinguserexists=1;
        }
        else
        {
         $designations=self::find()->andWhere(['officer_userid'=>$this->officer_userid])->asArray()->all();
         if (count($designations)>1) {//duplicate userid assigned
         //we shall create a new user
         print_r($designations);

         $username=$username.'_'.($this->level->code);
         $usermodel=null;
         }

         else
         $usermodel=User::findOne($this->officer_userid);

        }
       // if ($usermodel && !$this->resetpasswd)
        //return;


        $password=$username."$$$";
        if ($this->randpasswd)
           $password=Yii::$app->security->generateRandomString();

		if (!$usermodel)
		  {
		  //$usermodel->delete();
		     $usermodel=new \app\modules\users\models\User;

		     $usermodel->username=$username;
		    // if ($existinguserexists)
		      //  $usermodel->username=$username.'_'.($this->level->code);
		      $usermodel->setPassword($password);
		    // $usermodel->email=$username.'@test.com';
		     //$usermodel->role_id=2;

		  }
		   $usermodel->email=$this->officer_email;
		     //$usermodel->newPassword=$username;
		     if ($this->resetpasswd)
		        $usermodel->setPassword($password);
		    if ($this->inactiveuser)
		      $usermodel->status=User::STATUS_DISABLED;
		    else
		      $usermodel->status=User::STATUS_ACTIVE;
		      $usermodel->scenario='login';
		      if ($this->randpasswd)
		       {
		          $passwordresetform=new PasswordResetRequestForm;
		          $passwordresetform->email=$this->officer_email;
		          $passwordresetform->sendEmail();
		          $usermodel->scenario='email';
		       }

		     if (!$usermodel->save())
		      {
		        print_r($usermodel->errors);
		        exit;
		      }
		      else {
		      //$this=Designation::findOne($this->id);
		     // $desig->officer_userid=$usermodel->id;
		     $this->officer_userid=$usermodel->id;
		     if (!$auth->checkAccess($usermodel->id,$role))
		     $auth->assign($rolecreated,$usermodel->id);
		     // print_r($desig);
		      //exit;
		     if (! $this->save())
		      {
		        print_r($this->errors);exit;
		      }

		    }

     }
 public static function getDesignationByUser($userid,$returnobj=false)
 {
 if ($returnobj)
     return Designation::find()->where(['officer_userid'=>$userid])->one();
 else
   return Designation::find()->where(['officer_userid'=>$userid])->one()->id;
 }
  public static function getDistrictCode($user)
 {
   $designation=Designation::find()->where(['officer_userid'=>$user->id])->one();
   if ($designation->designationType->level->name_en=='District')
         return $designation->level->code;
    else
       if ($designation->designationType->level->name_en=='Block')
         return $designation->level->district_code;
 }
  public function profileEmpty()
  {
    return ($this->officer_name_hi=='')||($this->officer_name_en=='')||
    ($this->officer_mobile=='') ||($this->officer_email=='');
  }

}
