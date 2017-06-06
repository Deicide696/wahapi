<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $_id
 * @property string $email
 * @property string $pwd
 * @property string $name
 * @property string $last_name
 * @property string $country
 * @property string $city
 * @property string $birth_date
 * @property string $genre
 * @property string $profile_image
 * @property integer $cellphone
 * @property string $emotional_status
 * @property integer $pets
 * @property integer $religion
 * @property integer $childs
 * @property integer $level
 * @property integer $accept_terms
 * @property integer $email_validation
 * @property integer $hide_age
 * @property integer $hide_email
 * @property string $registered_on
 *
 * The followings are the available model relations:
 * @property UserProfile[] $userProfiles
 */
class Users extends CActiveRecord
{
    public $reEmail;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, pwd, name, last_name, country, city, birth_date, genre, accept_terms', 'required'),
			array('cellphone, pets, childs, level, accept_terms, email_validation, hide_age, hide_email', 'numerical', 'integerOnly'=>true),
			array('email, pwd, name, last_name, country, city, profile_image, emotional_status', 'length', 'max'=>255),
			array('accept_terms','boolean'),
            array('reEmail', 'compare', 'compareAttribute'=>'email', 'operator'=>'==', 'message'=>'Ingrese nuevamente el correo. No coincide con el correo de confirmación'),
            array('email', 'email','message'=>"El formato del email es incorrecto"),
        	array('email', 'unique','message'=>'Ya existe un usuario registrado con este correo'),
			array('accept_terms', 'required', 'requiredValue' => 1, 'message' => 'Debe aceptar terminos y condiciones para poder registrarse'),
			array('genre', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('_id, email, pwd, name, last_name, country, city, birth_date, genre, profile_image, cellphone, emotional_status, pets, religion, childs, level, accept_terms, email_validation, hide_age, hide_email, registered_on', 'safe', 'on'=>'search'),
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
			'userProfiles' => array(self::HAS_MANY, 'UserProfile', 'FK_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'_id' => 'ID',
			'email' => 'Email',
			'pwd' => 'Contraseña',
			'name' => 'Nombre',
			'last_name' => 'Apellido',
			'country' => 'Pais',
			'city' => 'Ciudad',
			'birth_date' => 'Nacimiento',
			'genre' => 'Genero',
			'profile_image' => 'Profile Image',
			'cellphone' => 'Celular',
			'emotional_status' => 'Situacion sentimental',
			'pets' => 'Pets',
			'religion' => 'Religion',
			'childs' => 'Hijos',
			'level' => 'Level',
			'accept_terms' => 'Aceptar Terminos',
			'email_validation' => 'Email Validation',
			'hide_age' => 'Hide Age',
			'hide_email' => 'Hide Email',
			'registered_on' => 'Registered On',
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

		$criteria->compare('_id',$this->_id,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('pwd',$this->pwd,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('birth_date',$this->birth_date,true);
		$criteria->compare('genre',$this->genre,true);
		$criteria->compare('profile_image',$this->profile_image,true);
		$criteria->compare('cellphone',$this->cellphone);
		$criteria->compare('emotional_status',$this->emotional_status,true);
		$criteria->compare('pets',$this->pets);
		$criteria->compare('religion',$this->religion);
		$criteria->compare('childs',$this->childs);
		$criteria->compare('level',$this->level);
		$criteria->compare('accept_terms',$this->accept_terms);
		$criteria->compare('email_validation',$this->email_validation);
		$criteria->compare('hide_age',$this->hide_age);
		$criteria->compare('hide_email',$this->hide_email);
		$criteria->compare('registered_on',$this->registered_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
