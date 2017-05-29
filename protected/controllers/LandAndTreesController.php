<?php

class LandAndTreesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='profile';

	public $friendsRequest;
	public $friendsConfirmation;
	public $wallPostNotifications;
	public $groupNotifications;
	public $newGroupNotifications;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new LandAndTrees;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LandAndTrees']))
		{
			$model->attributes=$_POST['LandAndTrees'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LandAndTrees']))
		{
			$model->attributes=$_POST['LandAndTrees'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$myId = Yii::app()->user->getState('userId');

		$profileImage = self::getProfileImage($myId);

		// $this->friendsRequest = self::getFriendRequests($myId);
		// $this->wallPostNotifications = self::getWallpostNotifications($myId);
		// $this->groupNotifications = self::getFeedGroupNotifications($myId);
		// $this->newGroupNotifications = self::getNewGroupNotifications($myId);

		// Get All Notifications
		self::getAllNotifications($myId);

		//Get new message
		$newMessage = Messages::model()->findAll(array("condition"=>"FK_receiver = $myId and has_read = 0"));

		$this->render('//landAndTrees/index', array(
			'profileImage' => $profileImage,
			'newMessage' => $newMessage)
		);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LandAndTrees('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LandAndTrees']))
			$model->attributes=$_GET['LandAndTrees'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LandAndTrees the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LandAndTrees::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LandAndTrees $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='land-and-trees-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/*-------------------------------------------------------------------*/
	/*-------------------------------------------------------------------*/
	/*-------------------METODS FOR EVERY VIEWS--------------------------*/
	/*-------------------------------------------------------------------*/
	/*-------------------------------------------------------------------*/

	public function getFriendRequests ($id)
	{
		$friendRequests = FriendRequests::model()->findAll(array("condition"=>"receiver_id =  $id and has_read = 0"));

		$idFriendRequests = array();

		foreach($friendRequests as $requests)
		{
			$idFriendRequests [] = ($requests->requester_id);
		}

		$friendsRequests = array();

		foreach($idFriendRequests as $idFriend)
		{
			$friendsRequests [] = Users::model()->findByPk($idFriend);
		}

		return $friendsRequests;
	}


	public function getWallpostNotifications ($id)
	{
		$wallPostNotifications = WallPost::model()->findAll(array("condition"=>"whom =  $id and who != $id and has_read = 0", 'order'=>'id DESC'));

		$wNotifications = array();

		foreach ($wallPostNotifications as $wallPostNotification) 
		{
			$idWallPostNotification = $wallPostNotification->id;

			$friend = Users::model()->findByPk($wallPostNotification->who);
			$typeFeed = $wallPostNotification->type;

			$wNotifications [] = array('friend' => $friend, 'feed' => $idWallPostNotification, 'type' => $typeFeed);
		}

		return $wNotifications;
	}


	public function getFeedGroupNotifications ($id)
	{
		$myGroups = GroupsJunction::model()->findAll("FK_user_id = $id");

		$gNotifications = array();

		foreach ($myGroups as $myGroup)
		{
			$groupNotifications = GroupFeedNotifications::model()->findAll(array("condition"=>"FK_group_id = $myGroup->FK_group_id and FK_user_id = $id and has_read = 0", 'order'=>'id DESC'));
			
			foreach ($groupNotifications as $groupNotification) 
			{
				$wallpostGroup = WallPostGroups::model()->find("id = $groupNotification->FK_feed_id");

				$group = Groups::model()->find("_id = $wallpostGroup->which");
				$userGroup = Users::model()->findByPk($wallpostGroup->who);
				$gNotifications [] = array('userGroup' => $userGroup, 'feed' => $groupNotification, 'group' => $group);
			}	
		}

		return $gNotifications;
	}


	public function getNewGroupNotifications ($id)
	{
		$newGroupNotifications = GroupRequest::model()->findAll(array("condition"=>"receiver_id =  $id and has_read = 0"));

		$idNewGroupNotifications = array();
		$newGNotifications = array();

		foreach($newGroupNotifications as $groupNotification)
		{
			$idNewGroupNotifications [] = $groupNotification->group_id;
		}

		$newGNotifications = array();

		foreach($idNewGroupNotifications as $idGroup)
		{
			$newGNotifications [] = Groups::model()->findByPk($idGroup);
		}

		return $newGNotifications;
	}

	public function getFriendsConfirmation($id)
	{
		$friendsConfirmation = FriendsJunction::model()->findAll(array("condition"=>"friend_id =  $id and has_read = 0"));

		$idFriendsConfirmation = array();

		foreach($friendsConfirmation as $confirmation)
		{
			$idFriendsConfirmation [] = ($confirmation->user_id);
		}

		$friendsConfirmations = array();

		foreach($idFriendsConfirmation as $idFriend)
		{
			$friendsConfirmations [] = Users::model()->findByPk($idFriend);
		}

		return $friendsConfirmations;
	}

	public function getAllNotifications($id)
	{
		// Set friends requests
		$this->friendsRequest = self::getFriendRequests($id);

		// Set friends confirmations
		$this->friendsConfirmation = self::getFriendsConfirmation($id);

		// Set wallpost notifications
		$this->wallPostNotifications = self::getWallpostNotifications($id);

		// Set feed group notifications
		$this->groupNotifications = self::getFeedGroupNotifications($id);

		// Set new group notifications
		$this->newGroupNotifications = self::getNewGroupNotifications($id);
	}

	public function getProfileImage ($id)
	{
		$user = Users::model()->find(array("condition" => "_id = $id"));

		return $user->profile_image;
	}

	public function existSession ()
	{
		if(!Yii::app()->user->getState('email'))
        {
            $this->redirect(Yii::app()->createUrl('users/index'));
        }
	}
}
