<?php

/**
 * This is the model class for table "friend_requests".
 *
 * The followings are the available columns in table 'friend_requests':
 * @property integer $receiver_id
 * @property integer $requester_id
 * @property string $date
 * @property string $has_read
 */
class FriendRequests extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'friend_requests';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('receiver_id, requester_id', 'required'),
			array('receiver_id, requester_id', 'numerical', 'integerOnly'=>true),
			array('has_read', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('receiver_id, requester_id, date, has_read', 'safe', 'on'=>'search'),
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
			'receiver_id' => 'Receiver',
			'requester_id' => 'Requester',
			'date' => 'Date',
			'has_read' => 'Has Read',
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

		$criteria->compare('receiver_id',$this->receiver_id);
		$criteria->compare('requester_id',$this->requester_id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('has_read',$this->has_read,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FriendRequests the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
