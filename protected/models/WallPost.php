<?php

/**
 * This is the model class for table "wall_post".
 *
 * The followings are the available columns in table 'wall_post':
 * @property string $id
 * @property integer $who
 * @property integer $whom
 * @property integer $type
 * @property string $date_post
 * @property integer $has_read
 */
class WallPost extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wall_post';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('who, whom, type', 'required'),
			array('who, whom, type, has_read', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, who, whom, type, date_post, has_read', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'who' => 'Who',
			'whom' => 'Whom',
			'type' => 'Type',
			'date_post' => 'Date Post',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('who',$this->who);
		$criteria->compare('whom',$this->whom);
		$criteria->compare('type',$this->type);
		$criteria->compare('date_post',$this->date_post,true);
		$criteria->compare('has_read',$this->has_read);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WallPost the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
