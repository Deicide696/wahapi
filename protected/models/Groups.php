<?php

/**
 * This is the model class for table "groups".
 *
 * The followings are the available columns in table 'groups':
 * @property string $_id
 * @property string $name
 * @property integer $category
 * @property string $country
 * @property string $city
 * @property string $language
 * @property string $description
 * @property string $creation_date
 * @property integer $FK_admin_id
 */
class Groups extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'groups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, category, country, language, description, FK_admin_id', 'required'),
			array('category, FK_admin_id', 'numerical', 'integerOnly'=>true),
			array('name, description', 'length', 'max'=>255),
			array('country, city, language', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('_id, name, category, country, city, language, description, creation_date, FK_admin_id', 'safe', 'on'=>'search'),
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
			'_id' => 'ID',
			'name' => 'Name',
			'category' => 'Category',
			'country' => 'Country',
			'city' => 'City',
			'language' => 'Language',
			'description' => 'Description',
			'creation_date' => 'Creation Date',
			'FK_admin_id' => 'Fk Admin',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('category',$this->category);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('creation_date',$this->creation_date,true);
		$criteria->compare('FK_admin_id',$this->FK_admin_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Groups the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
