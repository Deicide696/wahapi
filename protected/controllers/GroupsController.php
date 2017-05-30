<?php

class GroupsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='profile';

	public $friendsRequest;
	public $friendsConfirmation;
	public $posts;
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
				'actions'=>array('index','view', 'searchGroups', 'getGroup', 'status', 'like', 'dislike', 'comment', 'requestGroup', 'searchFriendToRequest', 'responseRequestNewGroup', 'getMembers'),
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
		self::existSession ();

		$model = new Groups;

		$this->performAjaxValidation($model);

		if(isset($_POST['Groups']))
		{
			$model->attributes = $_POST['Groups'];

			if($model->save())
			{
				$modelJuntion = new GroupsJunction;
				
				$modelJuntion->FK_user_id = $model->FK_admin_id;
				$modelJuntion->FK_group_id = $model->_id;

				if($modelJuntion->save())
				{
					$this->redirect('index');
				}
			}
			else
			{
				throw new CHttpException(500,'Internal server error - Groups');
			}
		}

		Yii::app()->end();
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

		if(isset($_POST['Groups']))
		{
			$model->attributes=$_POST['Groups'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->_id));
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
		self::existSession ();

		$myId = Yii::app()->user->getState("userId");

		// $this->friendsRequest = self::getFriendRequests($myId);
		// $this->wallPostNotifications = self::getWallpostNotifications($myId);
		// $this->groupNotifications = self::getFeedGroupNotifications($myId);
		// $this->newGroupNotifications = self::getNewGroupNotifications($myId);

		// Get All Notifications
		self::getAllNotifications($myId);

		// Overview user groups
		if(isset($_GET['user']))
		{
			$id = $_GET['user'];
			$friend = Users::model()->findByPk($id);

			// Get Profile Image (Friend)
			$profileImage = self::getProfileImage($id);

			//Get user groups
			$modelGroupsJunction = GroupsJunction::model()->findAll("FK_user_id = $id");

			$isFriendRequest = self::isFriendRequest($id);

			$groups = array();

			foreach ($modelGroupsJunction as $group) 
			{
				$groupId = $group->FK_group_id;

				$modelMyGroup = Groups::model()->find("_id = $groupId");

				$membersGroup = GroupsJunction::model()->findAll(array("condition" => "FK_group_id = $groupId"));

				$groups [] = $this->renderPartial("_myGroup", array("model" => $modelMyGroup, "members" => $membersGroup), true);
			}

			//Get new message
			// $newMessage = Messages::model()->findAll(array("condition"=>"FK_receiver = $myId and has_read = 0"));

			$modelGroup = new Groups;

			$this->render("index", 
				array(
					"modelGroup" => $modelGroup,
					"groups" => $groups,
					"friend" => $friend,
					'profileImage' => $profileImage,
					'isFriendRequest' => $isFriendRequest
				)
			);
		}

		// Overview my groups
		else
		{
			$id = Yii::app()->user->getState("userId");

			// Get Profile Image (Friend)
			$profileImage = self::getProfileImage($myId);

			//Get new message
			$newMessage = Messages::model()->findAll(array("condition"=>"FK_receiver = $myId and has_read = 0"));

			//Get my groups
			$modelGroupsJunction = GroupsJunction::model()->findAll("FK_user_id = $myId");

			$groups = array();

			foreach ($modelGroupsJunction as $group) 
			{
				$groupId = $group->FK_group_id;

				$modelMyGroup = Groups::model()->find("_id = $groupId");

				$membersGroup = GroupsJunction::model()->findAll(array("condition" => "FK_group_id = $groupId"));

				$groups [] = $this->renderPartial("_myGroup", array("model" => $modelMyGroup, "members" => $membersGroup), true);
			}

			$modelGroup = new Groups;

			$this->render("index", 
				array(
					"newMessage" => $newMessage,
					"modelGroup" => $modelGroup,
					"groups" => $groups,
					'profileImage' => $profileImage
				)
			);
		}

		// Get friend requests
		// $friendRequests = FriendRequests::model()->findAll(array("condition"=>"receiver_id =  $id and has_read = 0"));

		// $idFriendRequests = array();

		// foreach($friendRequests as $requests)
		// {
		// 	$idFriendRequests [] = ($requests->requester_id);
		// }

		// $friendsRequests = array();

		// foreach($idFriendRequests as $idFriend)
		// {
		// 	$friendsRequests [] = Users::model()->findByPk($idFriend);
		// }

		// Get Profile Image
		// $profileImage = self::getProfileImage($id);

		//Get new message
		// $newMessage = Messages::model()->findAll(array("condition"=>"FK_receiver = $id and has_read = 0"));

		//Get my groups
		// $modelGroupsJunction = GroupsJunction::model()->findAll("FK_user_id = $id");

		// $groups = array();

		// foreach ($modelGroupsJunction as $group) 
		// {
		// 	$groupId = $group->FK_group_id;

		// 	$modelMyGroup = Groups::model()->find("_id = $groupId");

		// 	$membersGroup = GroupsJunction::model()->findAll(array("condition" => "FK_group_id = $groupId"));

		// 	$groups [] = $this->renderPartial("_myGroup", array("model" => $modelMyGroup, "members" => $membersGroup), true);
		// }

		// $modelGroup = new Groups;

		// $this->friendsRequest = self::getFriendRequests($id);
		// $this->wallPostNotifications = self::getWallpostNotifications($id);
		// $this->groupNotifications = self::getFeedGroupNotifications($id);
		// $this->newGroupNotifications = self::getNewGroupNotifications($id);

		// if(isset($friend))
		// {
		// 	$this->render("index", 
		// 		array(
		// 			"newMessage" => $newMessage,
		// 			"modelGroup" => $modelGroup,
		// 			"groups" => $groups,
		// 			"friend" => $friend,
		// 			'profileImage' => $profileImage
		// 		)
		// 	);
		// }

		// else
		// {
		// 	$this->render("index", 
		// 		array(
		// 			"newMessage" => $newMessage,
		// 			"modelGroup" => $modelGroup,
		// 			"groups" => $groups,
		// 			'profileImage' => $profileImage
		// 		)
		// 	);
		// }
	}


	public function actionSearchGroups ()
	{
		self::existSession ();

		$name = $_POST['Groups']['name'];
        $country = $_POST['Groups']['country'];
        $category = $_POST['Groups']['category'];
        $city = $_POST['Groups']['city'];

		if($name != "" || $country != "" || $category != "" || $city != "")
		{
            $allGroups = Yii::app()->db->createCommand()
                    ->select()
                    ->from('groups')
                    ->where(array('like', 'name', '%'. $name . '%'))
                    ->orWhere(array('like', 'description', '%'. $name . '%'))
                    ->orWhere("country=:country",array(':country'=>$country))
                    ->orWhere("category=:category",array(':category'=>$category))
                    ->orWhere("city=:city",array(':city'=>$city))
                ->queryAll();

            $groups = array();

            foreach ($allGroups as $group)
            {
                $groupId = $group['_id'];

                $modelMyGroup = Groups::model()->find("_id = $groupId");

                $membersGroup = GroupsJunction::model()->findAll(array("condition" => "FK_group_id = $groupId"));

                $groups [] = $this->renderPartial("_myGroup", array("model" => $modelMyGroup, "members" => $membersGroup), true);
            }

            $id = Yii::app()->user->getState("userId");

            // Get All Notifications
            self::getAllNotifications($id);

            //Get new message
            $newMessage = Messages::model()->findAll(array("condition"=>"FK_receiver = $id and has_read = 0"));

            // Get Profile Image (myself)
            $profileImage = self::getProfileImage($id);

            $modelGroup = new Groups;

            $this->render("searchGroups",
                array(
                    "modelGroup" => $modelGroup,
                    "groups" => $groups,
                    "newMessage" => $newMessage,
                    "profileImage" => $profileImage
                )
            );
		}

		else
		{
//			throw new CHttpException(500,'Internal server error - SearchGroups');
		}
	}

	public function actionGetGroup()
	{
		self::existSession ();

		$groupId = $_GET['groupId'];
		$myId = Yii::app()->user->getState('userId');

		$model = Groups::model()->findByPk($groupId);

		$userAdmin = Users::model()->findByPk($model->FK_admin_id);

		$isMember = false;

		if($myId !== $model->FK_admin_id)
		{
			$searchMember = GroupsJunction::model()->find(array("condition" => "FK_user_id = $myId and FK_group_id = $groupId"));

			if(!empty($searchMember))
			{
				$isMember = true;
			}

			else
			{
				$newMember = UserProfile::model()->find("FK_id = $myId");
			}
		}

		else
		{
			$isMember = true;
		}

		// Get wallpost
		$wallPosts = WallPostGroups::model()->findAll(array('condition' => "which = $groupId", 'order' => 'id DESC'));

		$feeds = array();

		foreach ($wallPosts as $wallpost) 
		{
			$wallpostId = $wallpost->id;
			$userWallpost = Users::model()->findByPk($wallpost->who);

			$feed = FeedsGroup::model()->find("FK_id = $wallpostId");

			// I want like (or dislike) this wallpost?
			$modelLikesDislikes = LikesDislikesGroups::model()->find("who = $myId and what = $wallpostId");

			$numLikes = LikesDislikesGroups::model()->count("who != $myId and what = $wallpostId and type = 2");
			$numDislikes = LikesDislikesGroups::model()->count("who != $myId and what = $wallpostId and type = 1");

			if(empty($modelLikesDislikes))
			{
				$modelLikesDislikes = (object) '';
			}

			//Get comments
			$feedId = $feed->FK_id;

			$modelComments = CommentsFeedsGroup::model()->findAll("FK_feed_group_id = $feedId");

			$comments = array();

			if(!empty($modelComments))
			{
				foreach ($modelComments as $modelComment)
				{
					$userCommentId = $modelComment->FK_user_id;

                    // Get Profile Image (yourself)
                    $profileImage = self::getProfileImage($modelComment->FK_user_id);

					$userComment = Users::model()->find("_id = $userCommentId");
					$comments [] = $this->renderPartial("//wallPost/_comment", array('model' => $modelComment, 'userName' => $userComment->name, 'profileImage' => $profileImage), true);
				}
			}

			$feeds [] = $this->renderPartial("//wallPost/_post", array(
				"model" => $feed,
				"modelLikesDislikes" => $modelLikesDislikes,
				'numLikes' => $numLikes,
				'numDislikes' => $numDislikes,
				"userWallpost" => $userWallpost,
				"comments" => $comments),
				true
			);
		}

		// Get All Notifications
		self::getAllNotifications($myId);

		echo $this->render("wallpost", array(
			"model" => $model, 
			"isMember" => $isMember,
			"posts" => $feeds,
			"userAdmin" => $userAdmin
		));
	}


	public function actionSearchFriendToRequest()
	{
		self::existSession ();

		//Keyword searching
		$request = trim($_GET['term']);

		$groupId = $_GET['groupId'];

		$request = addcslashes($_GET['term'],'%_');
	    
	    if($request!='')
	    {		    		    	
	    	$friendsToRequestGroup = array();

	    	// FriendsJunction by user_id
	    	$myFriends = FriendsJunction::model()->findAll(array(
	    		'condition' => 'user_id = :myId',
	    		'params' => array(':myId' => Yii::app()->user->getState("userId"))
	    	));

			foreach ($myFriends as $myFriend)
			{				
				$junctionGroup = GroupsJunction::model()->find(array(
					'condition' => 'FK_user_id = :friendId AND FK_group_id = :groupId',
					'params' => array(':friendId' => $myFriend->friend_id, ':groupId' => $groupId)
				));
				
				$requestGroup = GroupRequest::model()->find(array(
					'condition' => 'receiver_id = :friendId AND group_id = :groupId',
					'params' => array(':friendId' => $myFriend->friend_id, ':groupId' => $groupId)
				));

				if(empty($junctionGroup) && empty($requestGroup))
				{					
					$friend = UserProfile::model()->find(array(
						'condition' => "FK_id = :friendId AND names LIKE :request",
						'params' => array(':friendId' => $myFriend->friend_id, ':request' => "$request%")
					));

					if(!empty($friend))
					{
						$friendsToRequestGroup[] = $friend;
					}
				}
			}

	        // FriendsJunction by friend_id
	    	$yourFriends = FriendsJunction::model()->findAll(array(
	    		'condition' => 'friend_id = :myId',
	    		'params' => array(':myId' => Yii::app()->user->getState("userId"))
	    	));

	        foreach ($yourFriends as $myFriend)
			{	
				$junctionGroup = GroupsJunction::model()->find(array(
					'condition' => 'FK_user_id = :friendId AND FK_group_id = :groupId',
					'params' => array(':friendId' => $myFriend->user_id, ':groupId' => $groupId)
				));
				
				$requestGroup = GroupRequest::model()->find(array(
					'condition' => 'receiver_id = :friendId AND group_id = :groupId',
					'params' => array(':friendId' => $myFriend->user_id, ':groupId' => $groupId)
				));

				if(empty($junctionGroup) && empty($requestGroup))
				{
					$friend = UserProfile::model()->find(array(
						'condition' => "FK_id = :friendId AND names LIKE :request",
						'params' => array(':friendId' => $myFriend->user_id, ':request' => "$request%")
					));

					if(!empty($friend))
					{
						$friendsToRequestGroup[] = $friend;
					}
				}
			}

			$responde;
	        
	        foreach($friendsToRequestGroup as $friend)
	        {	        	
	            $response[] = array('label' => $friend->names . ' ' .$friend->last_names, 'id' => $friend->FK_id );
	        }
			

	    	//Query to friend_id
			// $sql1 = "SELECT * FROM user_profile AS t 
			// INNER JOIN friends_junction ON t.FK_id = friends_junction.friend_id 
			// LEFT JOIN groups_junction ON t.FK_id = groups_junction.FK_user_id 
			// LEFT JOIN group_request ON t.FK_id = group_request.receiver_id
			// WHERE user_id = " . $myId . " AND (group_id IS NULL OR group_id != 1) AND names LIKE '" . $request. "%'";

			// $modelFriends1 = UserProfile::model()->findAllBySql($sql1);


	        // $response = array();
	        
	        // foreach($modelFriends1 as $friend)
	        // {
	        //     $response[] = array('label' => $friend->names . ' ' .$friend->last_names, 'id' => $friend->FK_id );
	        // }

	        //Query to user_id
			// $sql2 = "SELECT * FROM user_profile AS t 
			// INNER JOIN friends_junction ON t.FK_id = friends_junction.user_id 
			// LEFT JOIN groups_junction ON t.FK_id = groups_junction.FK_user_id 
			// LEFT JOIN group_request ON t.FK_id = group_request.receiver_id
			// WHERE friend_id = " . $myId . " AND (group_id IS NULL OR group_id != 1) AND names LIKE '" . $request. "%'";

			// $modelFriends2 = UserProfile::model()->findAllBySql($sql2);

	  //       foreach($modelFriends2 as $friend)
	  //       {
	  //           $response[] = array('label' => $friend->names . ' ' .$friend->last_names, 'id' => $friend->FK_id );
	  //       }
	        
	        echo json_encode($response);
	    }
	}


	public function actionRequestGroup()
	{
		if($_POST['userId'] && $_POST['groupId'])
		{
			$groupRequest = GroupRequest::model()->findByAttributes(array('group_id' => $_POST['groupId'], 'receiver_id' => $_POST['userId']));

			if(empty($groupRequest))
			{		
				$model = new GroupRequest;
				
				$model->receiver_id = $_POST['userId'];
				$model->group_id = $_POST['groupId'];

				if($model->save())
				{
					// Start || Real-time
					$modelNewGroup = Groups::model()->find(array("condition" => "_id = $model->group_id"));

					$pusher = Yii::app()->pusher;
					$pusher->trigger('user' . $_POST['userId'], 'newGroup', array('idNewGroup' => $_POST['groupId'], 'nameNewGroup' => $modelNewGroup->name), null, true);
					// End || Real-time

					echo $_POST['userId'];
				}
			}
		}
	}


	public function actionResponseRequestNewGroup()
	{
		self::existSession ();

		if(isset($_POST['acceptedGroupId']))
		{
			$myId = Yii::app()->user->getState('userId');

			$groupRequest = GroupRequest::model()->findByAttributes(array('group_id' => $_POST['acceptedGroupId'], 'receiver_id' => $myId));

			$groupRequest->has_read = 1;

			if($groupRequest->save()) 
			{
				$model = new GroupsJunction;

				$model->FK_user_id = Yii::app()->user->getState('userId');
				$model->FK_group_id = $_POST['acceptedGroupId'];

				if($model->save())
				{
					echo $_POST['acceptedGroupId'];
					Yii::app()->end();
				}
			}
		}

		else if(isset($_POST['canceledGroupId']))
		{
			$myId = Yii::app()->user->getState('userId');

			// Get group request
			$groupRequest = GroupRequest::model()->findByAttributes(array('group_id' => $_POST['canceledGroupId'], 'receiver_id' => $myId));

			// Delete group request
			$groupRequest->delete();
			Yii::app()->end();
		}

		$this->redirect('index');
	}


	public function actionGetMembers()
	{
		self::existSession ();

		if(isset($_GET['groupId']))
		{
			$groupId = $_GET['groupId'];
			$myId = Yii::app()->user->getState('userId');

			$model = Groups::model()->findByPk($groupId);

			$userAdmin = Users::model()->findByPk($model->FK_admin_id);

			$isMember = false;

			if($myId !== $model->FK_admin_id)
			{
				$searchMember = GroupsJunction::model()->find(array("condition" => "FK_user_id = $myId and FK_group_id = $groupId"));

				if(!empty($searchMember))
				{
					$isMember = true;
				}

				else
				{
					$newMember = UserProfile::model()->find("FK_id = $myId");
				}
			}

			else
			{
				$isMember = true;
			}

			$membersGroup = GroupsJunction::model()->findAll(array("condition"=>"FK_group_id = $groupId"));

			$members = array();

			foreach ($membersGroup as $memberGroup)
			{
				$member = Users::model()->findByPk($memberGroup->FK_user_id);
				$members [] = $this->renderPartial('//users/_friend', array(
					'model' => $member),
					true
				);
			}

			// $groupJunctions = GroupsJunction::model()->findAll("FK_group_id = $groupId");

			// $users = array();

			// foreach ($groupJunctions as $groupJunction)
			// {
			// 	$userGroup = Users::model()->findByPk($groupJunction->FK_user_id);
			// 	$users [] = $this->renderPartial('//users/_friend', array(
			// 		'model' => $userFriend),
			// 		true
			// 	);
			// }

			// $this->friendsRequest = self::getFriendRequests($myId);
			// $this->wallPostNotifications = self::getWallpostNotifications($myId);
			// $this->groupNotifications = self::getFeedGroupNotifications($myId);
			// $this->newGroupNotifications = self::getNewGroupNotifications($myId);

			// Get All Notifications
			self::getAllNotifications($myId);

			echo $this->render("viewMembers", array(
				"model" => $model, 
				"isMember" => $isMember,
				"members" => $members,
				"userAdmin" => $userAdmin
			));
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Groups('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Groups']))
			$model->attributes=$_GET['Groups'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Groups the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Groups::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Groups $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='newGroupForm')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public static function getYearsOldByBirthday($birthday)
	{
		list($y, $m, $d) = explode("-", $birthday);
    	
    	$y_dif = date("Y") - $y;
    	$m_dif = date("m") - $m;
    	$d_dif = date("d") - $d;
    	
    	if((($d_dif < 0) && ($m_dif == 0)) || ($m_dif < 0))
        {
        	$y_dif--;
        }

    	return $y_dif;
	}

	public function isFriendRequest ($profileId)
	{
		self::existSession ();

		$myId = Yii::app()->user->getState('userId');
		$isFriendRequest = false;

		if($myId !== $profileId)
		{
			$friendRequest = FriendRequests::model()->find(array("condition" => "( receiver_id =  $myId and requester_id = $profileId ) or ( receiver_id =  $profileId and requester_id = $myId )"));

			if(!empty($friendRequest))
			{
				$isFriendRequest = true;
			}
		}

		else
		{
			$isFriendRequest = true;
		}

		return $isFriendRequest;
	}

	/*
	*------------------------------------------------------------------------------
	*------------------------------------------------------------------------------
	*---------------------------WALLPOST CONTROLLER--------------------------------
	*------------------------------------------------------------------------------
	*------------------------------------------------------------------------------
	*/

	public function actionStatus()
	{
		self::existSession ();

		$model = new WallPostGroups;

		if(isset($_POST['status']))
		{
			$myId = Yii::app()->user->getState('userId');
			$groupId = $_GET['groupId'];

		 	$model->who = $myId;
		 	$model->which = $groupId;
		 	$model->type = 1;
			
			// echo CActiveForm::validate($model);

			if($model->save())
			{
		 		$modelFeedsGroup = new FeedsGroup;

		 		$modelFeedsGroup->FK_id = $model->id;
		 		$modelFeedsGroup->content = $_POST['status'];

		 		// echo CActiveForm::validate($modelFeedsGroup);

		 		$modelUsersGroupJunction = GroupsJunction::model()->findAll(array("condition" =>"FK_user_id != $myId and FK_group_id = $groupId"));

		 		foreach ($modelUsersGroupJunction as $user)
		 		{
		 			$modelGroupFeedNotifications = new GroupFeedNotifications;

		 			$modelGroupFeedNotifications->FK_feed_id = $model->id;
		 			$modelGroupFeedNotifications->FK_user_id = $user->FK_user_id;
		 			$modelGroupFeedNotifications->FK_group_id = $groupId;

		 			$modelGroupFeedNotifications->save();

		 			// Start || Real-time
		 			$myName = Yii::app()->user->getState('name') . ' ' . Yii::app()->user->getState('last_name');

		 			$modelUserGroup = Groups::model()->find(array("condition" => "_id = $groupId"));
		 			
		 			$usersGroup = GroupsJunction::model()->findAll(array("condition" => "FK_user_id != $myId and FK_group_id = $groupId"));

		 			foreach ($usersGroup as $userGroup)
		 			{
						$pusher=Yii::app()->pusher;
						$pusher->trigger('user' . $userGroup->FK_user_id, 'newWallpostGroup', 
							array(
								'nameUser' => $myName, 
								'nameGroup' => $modelUserGroup->name, 
								'idWallpostFeedGroup' => $model->id,
								'idWallpostFeed' => $modelGroupFeedNotifications->id
							)
						);
		 			}
					// End || Real-time
		 		}

		 		if($modelFeedsGroup->save())
		 		{
		 			$userWallpost = Users::model()->findByPk($myId);
		 			$this->renderPartial('//wallPost/_post', array(
		 				'model' => $modelFeedsGroup,
		 				'numLikes' => 0,
		 				'numDislikes' => 0,
		 				'userWallpost' => $userWallpost,
		 				'comments' => null)
		 			);
		 		}
		 	}
	 	}
	 	else
	 	{
			$this->renderPartial('//wallPost/_status', array('model' => $model));	 		
	 	}
	}

	// public function actionComplaint()
	// {
	// 	$model = new WallPost;

	// 	if(isset($_POST['status']))
	// 	{
	// 		$model->user_id = Yii::app()->user->getState('userId');
	// 	 	$model->poster_id = 1;
	// 	 	$model->content = $_POST['status'];

	// 		// echo CActiveForm::validate($model);

	// 	 	if($model->save())
	// 	 	{
	// 	 		$this->renderPartial('_post', array('model' => $model));
	// 	 	}
	// 	}
	// 	else
	// 	{
	// 		$this->renderPartial("//wallPost/_complaint", array('model' => $model));
	// 	}
	// }

	public function actionLike()
	{	
		self::existSession ();

		$model = new LikesDislikesGroups;

		if(isset($_POST['idpost']))
		{	
			$who = Yii::app()->user->getState('userId');
			$what = $_POST['idpost'];

			// $likeDislike = LikesDislikes::model()->find(array("condition"=>"who =  $who and 'what' = $what"));

			$likeDislikeWho = LikesDislikesGroups::model()->find("who =  $who");
			
			if(isset($likeDislikeWho))
			{
				$likeDislikeWhat = $likeDislikeWho->find("what = $what");
				if(isset($likeDislikeWhat))
				{
					$typeLike = $likeDislikeWhat->type;
				}
			}

			if(isset($typeLike))
			{
				if($typeLike === '1')
				{
					throw new CHttpException(406,'Not acceptable.');
				}

				elseif ($typeLike === '2') 
				{
					$likeDislikeWhat->type = 0;
					$likeDislikeWhat->save();
					echo 'change';
				}

				elseif ($typeLike === '0')
				{
					$likeDislikeWhat->type = 2;
					$likeDislikeWhat->save();
					echo 'add';
				}

				else
				{
					echo $typeLike;
					throw new CHttpException(404,'Not found.');
				}
			}

			else
			{
				$model->who = $who;
			 	$model->what = $what;
			 	$model->type = 2;

				// echo CActiveForm::validate($model);
			 	$model->save();

			 	echo 'new';
			}
		}
	}

	public function actionDislike()
	{	
		self::existSession ();

		$model = new LikesDislikesGroups;

		if(isset($_POST['idpost']))
		{
			$who = Yii::app()->user->getState('userId');
			$what = $_POST['idpost'];

			$likeDislikeWho = LikesDislikesGroups::model()->find("who =  $who");
			
			if(isset($likeDislikeWho))
			{
				$likeDislikeWhat = $likeDislikeWho->find("what = $what");
				if(isset($likeDislikeWhat))
				{
					$typeLike = $likeDislikeWhat->type;
				}
			}

			if(isset($typeLike))
			{
				if($typeLike === '2')
				{
					throw new CHttpException(406,'Not acceptable.');
				}

				elseif ($typeLike === '1') 
				{
					$likeDislikeWhat->type = 0;
					$likeDislikeWhat->save();
					echo 'change';
				}

				elseif ($typeLike === '0')
				{
					$likeDislikeWhat->type = 1;
					$likeDislikeWhat->save();
					echo 'add';
				}

				else
				{
					echo $typeLike;
					throw new CHttpException(404,'Not found.');
				}
			}

			else
			{
				$model->who = $who;
			 	$model->what = $what;
			 	$model->type = 1;

				// echo CActiveForm::validate($model);
			 	$model->save();

			 	echo 'add';
			}
		}
	}

	public function actionComment()
	{
		self::existSession ();
		
		$model = new CommentsFeedsGroup;

		if(isset($_POST['idfeed']))
		{
			$userId = Yii::app()->user->getState('userId');

			$model->FK_feed_group_id = $_POST['idfeed'];
			$model->FK_user_id = $userId;
			$model->comment = $_POST['commentText'];

			$userComment = Users::model()->find("_id = $userId");

			if($model->save())
			{	
				$responde = array("userName" => $userComment->name . " " . $userComment->last_name , "comment" => $model->comment);
				echo CJSON::encode($responde);
			}
		}

		else
		{
			throw new CHttpException(500,'Internal server error');
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


	public function getWallpost($id)
	{
		$myFriends = FriendsJunction::model()->findAll("user_id = $id");
		$yourFriends = FriendsJunction::model()->findAll("friend_id = $id");

		$friends = array();

		foreach ($myFriends as $myFriend)
		{
			$friends []= Users::model()->findByPk($myFriend->friend_id);
		}

		foreach ($yourFriends as $yourFriend)
		{
			$friends [] = Users::model()->findByPk($yourFriend->user_id);
		}

		// Create query for search all wallpost 
		
		$queryFriends = "whom = $id ";
		
		foreach ($friends as $friend)
		{
			$queryFriends .= "OR whom = " . $friend->_id . " "; 
		}

		// Get wallposts
		$wallPosts = WallPost::model()->findAll(array("condition" => $queryFriends, 'order'=>'id DESC'));

		$feeds = array();

		foreach ($wallPosts as $wallpost) 
		{
			$wallpostId = $wallpost->id;
			$userWallpost = Users::model()->findByPk($wallpost->who);

			$feed = FeedsUser::model()->find("FK_id = $wallpostId");

			// I want like (or dislike) this wallpost?
			$modelLikesDislikes = LikesDislikes::model()->find("who = $id and what = $wallpostId");

			$numLikes = LikesDislikes::model()->count("who != $id and what = $wallpostId and type = 2");
			$numDislikes = LikesDislikes::model()->count("who != $id and what = $wallpostId and type = 1");

			if(empty($modelLikesDislikes))
			{
				$modelLikesDislikes = (object) '';
			}

			//Get comments
			$feedId = $feed->FK_id;

			$modelComments = CommentsFeedsUser::model()->findAll(" FK_feed_user_id = $feedId");

			$comments = array();

			if(!empty($modelComments))
			{
				foreach ($modelComments as $modelComment)
				{
					$userCommentId = $modelComment->FK_user_id;

					$userComment = Users::model()->find("_id = $userCommentId");
					$comments [] = $this->renderPartial("//wallPost/_comment", array('model' => $modelComment, 'userName' => $userComment->name), true);
				}
			}

			// If this post this yourself
			if($wallpost->who === $wallpost->whom)
			{
				$feeds [] = $this->renderPartial("//wallPost/_post", array(
					"model" => $feed,
					"modelLikesDislikes" => $modelLikesDislikes,
					"numLikes" => $numLikes,
					"numDislikes" => $numDislikes,
					"userWallpost" => $userWallpost,
					"comments" => $comments),
					true
				);
			}

			// If this post is write to me
			else if($wallpost->whom === $id)
			{
				$feeds [] = $this->renderPartial("//wallPost/_post", array(
					"model" => $feed,
					"modelLikesDislikes" => $modelLikesDislikes,
					"numLikes" => $numLikes,
					"numDislikes" => $numDislikes,
					"userWallpost" => $userWallpost,
					"comments" => $comments,
					"advertiser" => true),
					true
				);
			}

			//If this post is write to my friend
			else
			{
				$advertiserToFriend = Users::model()->findByPk($wallpost->whom);

				$feeds [] = $this->renderPartial("//wallPost/_post", array(
					"model" => $feed,
					"modelLikesDislikes" => $modelLikesDislikes,
					"numLikes" => $numLikes,
					"numDislikes" => $numDislikes,
					"userWallpost" => $userWallpost,
					"comments" => $comments,
					"advertiserToFriend" => $advertiserToFriend),
					true
				);
			}
		}

		return $feeds;
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
