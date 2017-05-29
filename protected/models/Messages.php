<?php

/**
 * This is the model class for table "messages".
 *
 * The followings are the available columns in table 'messages':
 * @property integer $FK_id_conversation
 * @property integer $FK_creator
 * @property integer $FK_receiver
 * @property string $content
 * @property string $has_read
 * @property string $date_sender
 */
class Messages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'messages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('FK_id_conversation, FK_creator, FK_receiver, content', 'required'),
			array('FK_id_conversation, FK_creator, FK_receiver', 'numerical', 'integerOnly'=>true),
			array('content', 'length', 'max'=>200),
			array('has_read', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('FK_id_conversation, FK_creator, FK_receiver, content, has_read, date_sender', 'safe', 'on'=>'search'),
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
			'FK_id_conversation' => 'Fk Id Conversation',
			'FK_creator' => 'Fk Creator',
			'FK_receiver' => 'Fk Receiver',
			'content' => 'Content',
			'has_read' => 'Has Read',
			'date_sender' => 'Date Sender',
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

		$criteria->compare('FK_id_conversation',$this->FK_id_conversation);
		$criteria->compare('FK_creator',$this->FK_creator);
		$criteria->compare('FK_receiver',$this->FK_receiver);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('has_read',$this->has_read,true);
		$criteria->compare('date_sender',$this->date_sender,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Messages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
