<?php

/**
 * This is the model class for table "user_profile".
 *
 * The followings are the available columns in table 'user_profile':
 * @property integer $FK_id
 * @property string $names
 * @property string $last_names
 * @property string $email
 * @property string $country
 * @property string $city
 * @property string $birth_date
 * @property string $profile_image
 * @property string $level
 */
class UserProfile extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('FK_id, names, last_names, email, country, city, birth_date', 'required'),
			array('FK_id', 'numerical', 'integerOnly'=>true),
			array('names, last_names, email, country, city, profile_image', 'length', 'max'=>255),
			array('level', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('FK_id, names, last_names, email, country, city, birth_date, profile_image, level', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'FK_id' => 'Fk',
			'names' => 'Names',
			'last_names' => 'Last Names',
			'email' => 'Email',
			'country' => 'Country',
			'city' => 'City',
			'birth_date' => 'Birth Date',
			'profile_image' => 'Profile Image',
			'level' => 'Level',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('FK_id',$this->FK_id);
		$criteria->compare('names',$this->names,true);
		$criteria->compare('last_names',$this->last_names,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('birth_date',$this->birth_date,true);
		$criteria->compare('profile_image',$this->profile_image,true);
		$criteria->compare('level',$this->level,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserProfile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
