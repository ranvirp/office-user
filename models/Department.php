<?php
namespace rp\users\models;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property integer $id
 * @property string $name_hi
 * @property string $name_en
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Level[] $levels
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_hi', 'name_en'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['name_hi', 'name_en'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_hi' => 'Name Hi',
            'name_en' => 'Name En',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevels()
    {
        return $this->hasMany(Level::className(), ['dept_id' => 'id']);
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

			case 'name_hi':
			   return  $form->field($this,$attribute)->textInput();

			    break;

			case 'name_en':
			   return  $form->field($this,$attribute)->textInput();

			    break;

			case 'created_at':
			   return  $form->field($this,$attribute)->textInput();

			    break;

			case 'updated_at':
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

			case 'name_hi':
			   return $this->name_hi;			    break;

			case 'name_en':
			   return $this->name_en;			    break;

			case 'created_at':
			   return $this->created_at;			    break;

			case 'updated_at':
			   return $this->updated_at;			    break;

			default:
			break;
		  }
    }

}
