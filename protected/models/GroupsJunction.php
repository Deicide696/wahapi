<?php

/**
 * This is the model class for table "groups_junction".
 *
 * The followings are the available columns in table 'groups_junction':
 * @property integer $FK_user_id
 * @property integer $FK_group_id
 * @property string $registered_on
 */
class GroupsJunction extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'groups_junction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('FK_user_id, FK_group_id', 'required'),
			array('FK_user_id, FK_group_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('FK_user_id, FK_group_id, registered_on', 'safe', 'on'=>'search'),
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
			'FK_user_id' => 'Fk User',
			'FK_group_id' => 'Fk Group',
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

		$criteria->compare('FK_user_id',$this->FK_user_id);
		$criteria->compare('FK_group_id',$this->FK_group_id);
		$criteria->compare('registered_on',$this->registered_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GroupsJunction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
