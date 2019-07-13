<?php
namespace app\modules\users\models;

use Yii;

/**
 * This is the model class for table "login_history".
 *
 * @property integer $id
 * @property string $username
 * @property integer $logintime
 * @property string $sessionid
 * @property integer $logouttime
 */
class LoginHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'login_history';
    }
   

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'sessionid'], 'required'],
            [['logintime', 'logouttime'], 'integer'],
            [['username', 'sessionid'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'logintime' => 'Logintime',
            'sessionid' => 'Sessionid',
            'logouttime' => 'Logouttime',
        ];
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
									
			case 'username':
			   return  $form->field($this,$attribute)->textInput();
			    
			    break;
									
			case 'logintime':
			   return  $form->field($this,$attribute)->textInput();
			    
			    break;
									
			case 'sessionid':
			   return  $form->field($this,$attribute)->textInput();
			    
			    break;
									
			case 'logouttime':
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
									
			case 'username':
			   return $this->username;			    break;
									
			case 'logintime':
			   return $this->logintime;			    break;
									
			case 'sessionid':
			   return $this->sessionid;			    break;
									
			case 'logouttime':
			   return $this->logouttime;			    break;
			 
			default:
			break;
		  }
    }
	
}
