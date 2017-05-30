<?php
ob_start();
class UsersController extends Controller
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
				'actions'=>array('index','view', 'home', 'logout', 'autocomplete', 'getProfile', 'addFriend', 'status', 'complaint', 'like', 'dislike', 'responseRequestNewFriend', 'comment', 'sendMessage', 'viewNotification', 'messagesByUser', 'newMessage', 'allConversations', 'messagesByConversation', 'getFriends', 'searchFriendAutocomplete', 'gateway', 'getReservesOrLands', 'getTreesQuantity', 'generateOrder', 'validAccount', 'gallery', 'landAndTrees', 'uploadProfilePic', 'recoveryPassword', 'readFriendConfirmation'),
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
		// $this->render('view',array(
		// 	'model'=>$this->loadModel($id),
		// ));

		// $this->layout = 'profile';

		$this->render("profile");
	}

	/**
	* Display home page
	*/
	public function actionHome()
	{
		self::existSession ();

		// Get user id from valid start session
		$id = Yii::app()->user->getState("userId");

		// Get Profile Image
		$profileImage = self::getProfileImage($id);

		// Get All Notifications
		self::getAllNotifications($id);

		// Get Wallpost
		$feeds = self::getWallpost($id);

		//Get new message
		$newMessage = Messages::model()->findAll(array("condition"=>"FK_receiver = $id and has_read = 0"));

		// Set variable to layout
		$this->posts = $feeds;

		$this->render('profile', 
			array(
				'profileImage' => $profileImage,
				'posts' => $feeds,
				'newMessage' => $newMessage
			)
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Users;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->_id));
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

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
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
        // Show layout 'register'
        $this->layout = 'register';

        $model = new Users;
        $loginModel=new LoginForm;

        // AJAX Register form
        if(isset($_POST['ajax']) and $_POST['ajax'] === 'registerForm')
        {
            echo CActiveForm::validate($model);

            $model->attributes = $_POST['Users'];
            $model['pwd'] = sha1($model['pwd']);
            $model['profile_image'] = "162673-2-big.jpg";

            if($model->save())
            {
                // Create user profile
                $userProfile = new UserProfile;

                $userProfile->FK_id = $model->_id;
                $userProfile->names = $model->name;
                $userProfile->last_names = $model->last_name;
                $userProfile->email = $model->email;
                $userProfile->country = $model->country;
                $userProfile->city = $model->city;
                $userProfile->birth_date = $model->birth_date;

                if($userProfile->save())
                {
                    $loginModel->username = $model->email;
                    $loginModel->password = $_POST['Users']['pwd'];

                    if($loginModel->validate())
                    {
                    	$code = rand(0000000000,9999999999);

                    	//Create pending validation
                    	$validation = new PendingValidations;

                    	$validation->FK_id_user = $model->_id;
                    	$validation->email = $model->email;
                    	$validation->code = $code;

                    	if($validation->save())
                    	{
             				// Yii::import("ext.mailer.*");

							// $mail = new PHPMailer();

							// $mail->setFrom("no-responder@wahapi.com","Wahapi");
							// $mail->Subject = "Confirmación de registro en Wahapi";
							// $mail->CharSet = 'UTF-8';
							// $mail->msgHTML("<h1>Ya estas registrado en Wahapi</h1><p>Para confirmar tu inscripción a Wahapi, ingresa al siguiente a este <a href='http://localhost/wahapi/users/validAccount?user=" . $model->_id . "&code=" . $code . "'>link</a></p>");
							// $mail->addAddress($model->email, $model->name);

							// $mail->send();

                        	$loginModel->login();
                        }
                    }
                }
            }

            Yii::app()->end();
        }

        // AJAX Login form
        if(isset($_POST['ajax']) && $_POST['ajax']==='loginForm')
        {
            echo CActiveForm::validate($loginModel);

            $loginModel->attributes=$_POST['LoginForm'];

            if($loginModel->validate())
            {
                $loginModel->login();
            }

            Yii::app()->end();
        }

        if(Yii::app()->user->getState('email'))
        {
            // echo Yii::app()->user->getState('email');
            $this->redirect(Yii::app()->createUrl('users/home'));
            // $this->render('profile');
            // Yii::app()->user->logout();
        }
        else
        {
            $this->render('index',array(
                'model'=>$model,
                'loginModel' => $loginModel
            ));
        }
    }

	public function actionLogout()
	{
		Yii::app()->user->logout();

		$this->redirect('index');
	}

	public function actionAutocomplete()
	{
		self::existSession ();

		$response =array();

		if (isset($_GET['term'])) 
		{
			$trimmed = trim($_GET['term'], " ");

			$sqlSentence ="SELECT _id,name,last_name FROM users WHERE name LIKE :username OR last_name LIKE :username";
			$command =Yii::app()->db->createCommand($sqlSentence);
			$command->bindValue(":username", '%'.$trimmed.'%', PDO::PARAM_STR);
			$response =$command->queryAll();
			$resp = $response[0]['name'] . $response[0]['last_name'];
			$response[] = array('label' => $response[0]['name'] . ' ' . $response[0]['last_name'], '_id' => $response[0]['_id']);
		}

		echo CJSON::encode($response);
		// echo($response);
		Yii::app()->end();
	}

	public function actionSearchFriendAutocomplete()
	{
		self::existSession ();

		// Remueve espacios en blanco
		$request = trim($_GET['term']);

		// Escapa la cadena de '%'
		$request = addcslashes($request,'%_');
	    
	    if($request!='')
	    {	
	    	$response = array();

	    	// FriendsJunction by user_id
	    	$myFriends = FriendsJunction::model()->findAll(array(
	    		'condition' => 'user_id = :myId',
	    		'params' => array(':myId' => Yii::app()->user->getState("userId"))
	    	));

			foreach ($myFriends as $myFriend)
			{
				$friend = UserProfile::model()->find(
					array(
						'condition' => "FK_id = :friendId AND names LIKE :request",
						'params' => array(':friendId' => $myFriend->friend_id, ':request' => "$request%")
					)
				);
		        if(!empty($friend))
		        {
					$response[] = array('label' => $friend->names . ' ' .$friend->last_names, 'id' => $friend->FK_id );
				}
			}

	        // FriendsJunction by friend_id
	    	$yourFriends = FriendsJunction::model()->findAll(array(
	    		'condition' => 'friend_id = :myId',
	    		'params' => array(':myId' => Yii::app()->user->getState("userId"))
	    	));

	        foreach ($yourFriends as $yourFriend)
			{
				$friend = UserProfile::model()->find(
					array(
						'condition' => "FK_id = :friendId AND names LIKE :request",
						'params' => array(':friendId' => $yourFriend->user_id, ':request' => "$request%")
					)
				);
		        if(!empty($friend))
		        {
					$response[] = array('label' => $friend->names . ' ' .$friend->last_names, 'id' => $friend->FK_id );
				}
			}
	        
			echo json_encode($response);
	    }
	}

	public function actionGetProfile()
	{
		self::existSession ();

		$myId = Yii::app()->user->getState('userId');
		$profileId = $_GET['user'];

		$model = Users::model()->findByPk($profileId);

		$isFriend = self::isFriend($profileId);
		$isFriendRequest = self::isFriendRequest($profileId);

		// Get wallpost

		$wallPosts = WallPost::model()->findAll(array("condition" =>"whom = $profileId", 'order'=>'id DESC'));	

		$feeds = array();

		foreach ($wallPosts as $wallpost) 
		{
			$wallpostId = $wallpost->id;
			$userWallpost = Users::model()->findByPk($wallpost->who);

			$feed = FeedsUser::model()->find("FK_id = $wallpostId");

			// I want like (or dislike) this wallpost?
			$modelLikesDislikes = LikesDislikes::model()->find("who = $myId and what = $wallpostId");

			$numLikes = LikesDislikes::model()->count("who != $myId and what = $wallpostId and type = 2");
			$numDislikes = LikesDislikes::model()->count("who != $myId and what = $wallpostId and type = 1");

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
					$comments [] = $this->renderPartial("//wallPost/_comment", array('model' => $modelComment, 'userName' => $userComment->name, 'profileImage' => $userComment->profile_image), true);
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

		$modelMessage = new Messages;

		// Get All Notifications
		self::getAllNotifications($myId);

		echo $this->render("userProfile", array(
			"model" => $model,
			"isFriend" => $isFriend,
			"isFriendRequest" => $isFriendRequest,
			"posts" => $feeds,
			"modelMessage" => $modelMessage
		));
	}

	public function actionAddFriend()
	{
		self::existSession ();

		$model = new FriendRequests;
		$requesterId = Yii::app()->user->getState('userId');

		if(isset($_POST['receiver']))
		{
			$model->requester_id = $requesterId;
			$model->receiver_id = $_POST['receiver'];

			// echo CActiveForm::validate($model);

			// Start || Real-time
			$modelRequesterFriend = UserProfile::model()->find(array("condition" => "FK_id = $requesterId"));

			$pusher = Yii::app()->pusher;
			$pusher->trigger("user" . $_POST["receiver"], "newFriend", 
				array(
					"idRequestFriend" => $requesterId, 
					"nameRequesterFriend" => $modelRequesterFriend->names . " " . $modelRequesterFriend->last_names
				), 
				null, 
				true
			);
			// End || Real-time

			// print_r($model->save());
			$model->save();
		}
	}

	public function actionResponseRequestNewFriend ()
	{
		self::existSession ();

		$model = new FriendsJunction;

		if(isset($_POST['accepted']))
		{
			$myId = Yii::app()->user->getState('userId');
			$requesterId = $_POST['accepted'];
			
			// Get friend request
			$friendRequest = FriendRequests::model()->find(array("condition"=>"receiver_id =  $myId and requester_id = $requesterId and has_read = 0"));
			
			$friendRequest->has_read = 1;

			// echo CActiveForm::validate($friendRequest[0]);

			if($friendRequest->save())
			{
				$model->user_id = Yii::app()->user->getState('userId');
				$model->friend_id = $requesterId;

				// Start || Real-time
				$myName = Yii::app()->user->getState('name') . ' ' . Yii::app()->user->getState('last_name');

				$pusher = Yii::app()->pusher;
				$pusher->trigger("user" . $requesterId, "notificationNewFriend", array("idNotificationNewFriend" => $myId, "nameNotificationNewFriend" => $myName));
				// End || Real-time

				$model->save();
			}
		}

		else if(isset($_POST['canceled']))
		{
			$myId = Yii::app()->user->getState('userId');
			$requesterId = $_POST['canceled'];
			
			// Get friend request
			$friendRequest = FriendRequests::model()->find(array("condition"=>"receiver_id =  $myId and requester_id = $requesterId and has_read = 0"));
			
			// Delete friend request
			$friendRequest->delete();
		}
	}

	public function actionReadFriendConfirmation ()
	{
		self::existSession ();

		if(isset($_POST['checked']))
		{
			$myId = Yii::app()->user->getState('userId');
			$userId = $_POST['checked'];
			
			// Get friend junction
			$friendJunction = FriendsJunction::model()->find(array("condition"=>"user_id =  $userId and friend_id = $myId and has_read = 0"));
			
			$friendJunction->has_read = 1;

			// echo CActiveForm::validate($friendRequest[0]);

			if(!$friendJunction->save())
			{
				throw new CHttpException(500,'Internal server error - FriendsJunction');
			}
		}
	}

	public function actionViewNotification ()
	{
		self::existSession ();

		// Get user id from valid start session
		$myId = Yii::app()->user->getState("userId");

		// Get Profile Image
		$profileImage = self::getProfileImage($myId);

		//Get new message
		$newMessage = Messages::model()->findAll(array("condition"=>"FK_receiver = $myId and has_read = 0"));

		// Get All Notifications
		self::getAllNotifications($myId);

		// View notification users
		if(isset($_GET['feed']))
		{
			// Get wallpost
			$wallpost = WallPost::model()->findByPk($_GET['feed']);
			
			$wallpostId = $wallpost->id;

			//Has read wallpost
			$wallpost->has_read = '1';

			$wallpost->save();

			// Advertiser
			$userWallpost = Users::model()->findByPk($wallpost->who);

			$feedUser = FeedsUser::model()->find("FK_id = $wallpostId");

			// I like (or dislike) this wallpost?
			$modelLikesDislikes = LikesDislikes::model()->find("who = $myId and what = $wallpostId");

			$numLikes = LikesDislikes::model()->count("who != $myId and what = $wallpostId and type = 2");
			$numDislikes = LikesDislikes::model()->count("who != $myId and what = $wallpostId and type = 1");

			if(empty($modelLikesDislikes))
			{
				$modelLikesDislikes = (object) '';
			}

			//Get comments

			$feedId = $feedUser->FK_id;

			$modelComments = CommentsFeedsUser::model()->findAll(" FK_feed_user_id = $feedId");

			$comments = array();

			if(!empty($modelComments))
			{
				foreach ($modelComments as $modelComment)
				{
					$userCommentId = $modelComment->FK_user_id;

					$userComment = Users::model()->find("_id = $userCommentId");
					$comments [] = $this->renderPartial("//wallPost/_comment", array('model' => $modelComment, 'userName' => $userComment->name, 'profileImage' => $userComment->profile_image), true);
				}
			}

			$feed = $this->renderPartial("//wallPost/_post", array(
				"model" => $feedUser,
				"modelLikesDislikes" => $modelLikesDislikes,
				"numLikes" => $numLikes,
				"numDislikes" => $numDislikes,
				"userWallpost" => $userWallpost,
				"comments" => $comments,
				'advertiser' => true),
				true
			);

			$this->render('//wallPost/viewWallpost',
				array(
					'profileImage' => $profileImage,
					'post' => $feed,
					'newMessage' => $newMessage
				)
			);
		}

		// View notification groups
		else if(isset($_GET['feedGroup'], $_GET['notificationGroupId']))
		{
			// Get wallpost
			$wallpostGroup = WallPostGroups::model()->findByPk($_GET['feedGroup']);

			//Has read wallpost group
			$groupFeedNotification = GroupFeedNotifications::model()->findByPk($_GET['notificationGroupId']);
			$groupFeedNotification->has_read = 1;
			$groupFeedNotification->save();
			
			// Advertiser
			$userWallpost = Users::model()->findByPk($wallpostGroup->who);

			// Group which published
			$groupPublished = Groups::model()->findByPk($wallpostGroup->which);

			$feedGroup = FeedsGroup::model()->find("FK_id = $wallpostGroup->id");

			// I like (or dislike) this wallpost?
			$modelLikesDislikes = LikesDislikesGroups::model()->find("who = $myId and what = $wallpostGroup->id");

			$numLikes = LikesDislikesGroups::model()->count("who != $myId and what = $wallpostGroup->id and type = 2");
			$numDislikes = LikesDislikesGroups::model()->count("who != $myId and what = $wallpostGroup->id and type = 1");

			if(empty($modelLikesDislikes))
			{
				$modelLikesDislikes = (object) '';
			}

			//Get comments
			$modelComments = CommentsFeedsGroup::model()->findAll(" FK_feed_group_id = $feedGroup->FK_id");

			$comments = array();

			if(!empty($modelComments))
			{
				foreach ($modelComments as $modelComment)
				{
					$userComment = Users::model()->find("_id = $modelComment->FK_user_id");
					$comments [] = $this->renderPartial("//wallPost/_comment", array('model' => $modelComment, 'userName' => $userComment->name, 'profileImage' => $userComment->profile_image), true);
				}
			}

			$feed = $this->renderPartial("//wallPost/_post", array(
				"model" => $feedGroup,
				"modelLikesDislikes" => $modelLikesDislikes,
				"numLikes" => $numLikes,
				"numDislikes" => $numDislikes,
				"userWallpost" => $userWallpost,
				"comments" => $comments,
				'groupPublished' => $groupPublished),
				true
			);
			
			$this->render('//wallPost/viewWallpost',
				array(
					'post' => $feed
				)
			);
		}
	}


	public function actionRecoveryPassword ()
	{
		self::existSession ();

		// Show layout 'register'
        $this->layout = 'register';

        $model = new Users;
        $loginModel=new LoginForm;

		if(isset($_POST['Recovery']))
		{
			$model->attributes=$_POST['Users'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->_id));
		}

		$this->render('recovery',array(
            'model'=>$model,
            'loginModel' => $loginModel
        ));
	}


	public function actionValidAccount ()
	{
		self::existSession ();

		if(isset($_GET['user']) && isset($_GET['code']))
		{
			$userId = $_GET['user'];
			$code = $_GET['code'];

			$pendingValidation = PendingValidations::model()->find("FK_id_user = $userId and code = $code");

			if(!empty($pendingValidation))
			{
				$user = Users::model()->findByPk($userId);
				$user->email_validation = 1;
				$user->save();

				// Delete pending validation
				$pendingValidation->delete();
				
				print_r("Fue validada su cuenta");
			}

			else
			{
				print_r("Este link ya no es valido");
			}
		}
	}


	public function actionGateway ()
	{
		self::existSession ();

		// Show layout 'gateway'
        $this->layout = 'gateway';

		$this->render('//gateway/index');
	}


	public function actionGetReservesOrLands ()
	{
		self::existSession ();

		// Show layout 'gateway'
        $this->layout = 'gateway';

		if(isset($_POST['optionsSelected']))
		{
			if($_POST['optionsSelected'] === 'tree')
			{
				$reservesModel = Reserves::model()->findAll(array("condition"=>"is_full = 0"));

				$reserves = array();

				foreach ($reservesModel as $reserve)
				{
					$reserves[] = array('id' => $reserve->id, 'name' => $reserve->name, 'description' => $reserve->description);
				}

				$this->renderPartial('//gateway/_reserveLocation', 
					array(
						'model' => $reserves
					)
				);
			}
		}
	}


	public function actionGetTreesQuantity ()
	{
		self::existSession ();

		// Show layout 'gateway'
        $this->layout = 'gateway';

		if(isset($_POST['reserveSelected']))
		{
			$reserveId = $_POST['reserveSelected'];

			$reserveModel = Reserves::model()->find(array("condition"=>"id = $reserveId"));

			$treesQuantity = $reserveModel->quantity;

			$this->renderPartial('//gateway/_treesQuantity', 
				array(
					'reserveId' => $reserveModel->id,
					'treesQuantity' => $treesQuantity
				)
			);
		}
	}


	public function actionGenerateOrder ()
	{
		self::existSession ();

		// Show layout 'gateway'
        $this->layout = 'gateway';

		if(isset($_POST['reserveId']))
		{
			$reserveId = $_POST['reserveId'];

			$quantityTrees = $_POST['quantity'];

			$totalPrice = $quantityTrees * 7000;

			$reserveModel = Reserves::model()->find(array("condition"=>"id = $reserveId"));

			$this->renderPartial('//gateway/_generateOrder', 
				array(
					'model' => $reserveModel,
					'totalPrice' => $totalPrice,
					'treesQuantity' => $quantityTrees
				)
			);
		}
	}	

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
			$model->attributes=$_GET['Users'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
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

	public function isFriend ($profileId)
	{
		self::existSession ();

		$myId = Yii::app()->user->getState('userId');
		$isFriend = false;

		if($myId !== $profileId)
		{
			$isFriend = FriendsJunction::model()->find(array("condition" => "( user_id = $myId and friend_id = $profileId ) or ( user_id = $profileId and friend_id = $myId )"));

			if(!empty($isFriend))
			{
				$isFriend = true;
			}
		}

		else
		{
			$isFriend = true;
		}

		return $isFriend;
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

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionGallery ()
	{
		self::existSession ();

		$myId = Yii::app()->user->getState('userId');

        // Get All Notifications
        self::getAllNotifications($myId);

		// Get Profile Image
		$profileImage = self::getProfileImage($myId);

        //Get new message
        $newMessage = Messages::model()->findAll(array("condition"=>"FK_receiver = $myId and has_read = 0"));

		$this->render('//Gallery/index', array(
			    'profileImage' => $profileImage,
                "newMessage" => $newMessage,)
		);
	}

	public function actionLandAndTrees ()
	{
		self::existSession ();

		$myId = Yii::app()->user->getState('userId');

		$this->friendsRequest = self::getFriendRequests($myId);
		$this->wallPostNotifications = self::getWallpostNotifications($myId);
		$this->groupNotifications = self::getFeedGroupNotifications($myId);
		$this->newGroupNotifications = self::getNewGroupNotifications($myId);

		$this->render('//landAndTrees/index');
	}

	public function actionUploadProfilePic ()
	{
		self::existSession ();

		if (isset($_POST['key']))
		{
			$myId = Yii::app()->user->getState('userId');

			$album = "profile";

			$profileAlbum = PictureAlbumsUsers::model()->find(array("condition"=>"FK_user_id =  $myId and album = \"profile\""));

			if(!isset($profileAlbum))
			{
				$model = new PictureAlbumsUsers;

				$model->FK_user_id = $myId;
				$model->album = $album;
				
				if($model->save())
				{
					$newPic = new UserPictures;

					$newPic->FK_album_id = $model->id;
					$newPic->FK_user_id = $myId;
					$newPic->path = $_POST['key'];
					
					if(!$newPic->save())
					{
						throw new CHttpException(500,'Internal server error - UserPictures');
					}
				}

				else
				{
					throw new CHttpException(500,'Internal server error - PictureAlbumsUsers');
				}
			}

			else
			{
				$newPic = new UserPictures;

				$newPic->FK_album_id = $profileAlbum->id;
				$newPic->FK_user_id = $myId;
				$newPic->path = $_POST['key'];
				if(!$newPic->save())
				{
					throw new CHttpException(500,'Internal server error - UserPictures');
				}
			}

			$userModel = Users::model()->find(array("condition" => "_id = $myId"));
			$userModel->profile_image = $_POST['key'];

			if(!$userModel->save())
			{
				throw new CHttpException(500,'Internal server error - Users (Profile Image)');
			}
		}
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

		$model = new WallPost;

		if(isset($_POST['status']))
		{
		 	$model->who = Yii::app()->user->getState('userId');
		 	$model->whom = $_GET['userProfileId'];
		 	$model->type = 1;
			
			// echo CActiveForm::validate($model);

			if(Yii::app()->user->getState('userId') === $_GET['userProfileId'])
		 	{
		 		$model->has_read = 1;
		 	}

		 	if($model->save())
		 	{
		 		$modelFeedsUser = new FeedsUser;

		 		$modelFeedsUser->FK_id = $model->id;
		 		$modelFeedsUser->FK_type = $model->type;
		 		$modelFeedsUser->content = $_POST['status'];

		 		if($modelFeedsUser->save())
		 		{
		 			// Start || Real-time
		 			if(Yii::app()->user->getState('userId') !== $_GET['userProfileId'])
		 			{
		 				$modelFriend = UserProfile::model()->find(array("condition" => "FK_id = $model->who"));

						$pusher=Yii::app()->pusher;
						$pusher->trigger('user' . $_GET['userProfileId'], 'newWallpost', array('nameFriend' => $modelFriend->names . ' ' . $modelFriend->last_names, 'idFeed'=> $model->id, 'type' => $model->type), null, true);
		 			}
					// End || Real-time

		 			$userWallpost = Users::model()->findByPk($model->who);
		 			$this->renderPartial('//wallPost/_post', array(
		 				'model' => $modelFeedsUser,
		 				"numLikes" => 0,
						"numDislikes" => 0,
		 				'userWallpost' => $userWallpost,
		 				"comments" => null)
		 			);
		 		}
		 	}
		}

		else
		{
			$this->renderPartial('//wallPost/_status', array('model' => $model));
		}
	}

	public function actionComplaint()
	{
		self::existSession ();

		$model = new WallPost;

		if(isset($_POST['status']))
		{
			$model->user_id = Yii::app()->user->getState('userId');
		 	$model->poster_id = 1;
		 	$model->content = $_POST['status'];

			// echo CActiveForm::validate($model);

		 	if($model->save())
		 	{
		 		$this->renderPartial('_post', array('model' => $model));
		 	}
		}
		else
		{
			$this->renderPartial("//wallPost/_complaint", array('model' => $model));
		}
	}

	public function actionLike()
	{	
		self::existSession ();

		$model = new LikesDislikes;

		if(isset($_POST['idpost']))
		{	
			$me = Yii::app()->user->getState('userId');
			$what = $_POST['idpost'];

			// $likeDislike = LikesDislikes::model()->find(array("condition"=>"who =  $me and 'what' = $what"));

			$likeDislike = LikesDislikes::model()->find("who = $me and what = $what");
			
			if(isset($likeDislike))
			{
				$typeLike = $likeDislike->type;
			
				if($typeLike === '1')
				{
					throw new CHttpException(406,'Not acceptable.');
				}

				elseif ($typeLike === '2') 
				{
					$likeDislike->type = 0;
					$likeDislike->save();
					echo 'change';
				}

				elseif ($typeLike === '0')
				{
					$likeDislike->type = 2;
					$likeDislike->save();
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
				$model->who = $me;
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

		$model = new LikesDislikes;

		if(isset($_POST['idpost']))
		{
			$who = Yii::app()->user->getState('userId');
			$what = $_POST['idpost'];

			$likeDislikeWho = LikesDislikes::model()->find("who =  $who");
			
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

		$model = new CommentsFeedsUser;

		if(isset($_POST['idfeed']))
		{
			$userId = Yii::app()->user->getState('userId');

			$model->FK_feed_user_id = $_POST['idfeed'];
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


	/*
	*------------------------------------------------------------------------------
	*------------------------------------------------------------------------------
	*---------------------------MESSAGE CONTROLLER--------------------------------
	*------------------------------------------------------------------------------
	*------------------------------------------------------------------------------
	*/

	public function actionMessagesByUser()
	{
		self::existSession ();

		$myId = Yii::app()->user->getState('userId');
		$friendId = $_GET['user'];

		// Get Profile Image
		$profileImage = self::getProfileImage($myId);

		$friend = Users::model()->findByPk($friendId);

		$modelMessages = Messages::model()->findAll(array("condition" => "( FK_creator = $myId and FK_receiver = $friendId ) or ( FK_creator = $friendId and FK_receiver = $myId  )"));

		$messages = array();

		if(!empty($modelMessages))
		{
			foreach ($modelMessages as $modelMessage)
			{
				if($modelMessage->FK_receiver === $myId && $modelMessage->has_read === '0')
				{
					$modelMessage->has_read = '1';
					$modelMessage->save();
				}
				
				if($modelMessage->FK_creator === $myId)
				{
					$messages [] = $this->renderPartial("//messages/_message", array('creator' => Yii::app()->user->getState('name') . ' ' . Yii::app()->user->getState('last_name'), 'profileImage' => $profileImage ,'message' => $modelMessage->content), true);					
				}
				else
				{
					$messages [] = $this->renderPartial("//messages/_message", array('creator' => $friend->name . ' ' . $friend->last_name , 'profileImage' => $friend->profileImage , 'message' => $modelMessage->content), true);
				}
			}
		}

		// $this->friendsRequest = self::getFriendRequests($myId);
		// $this->wallPostNotifications = self::getWallpostNotifications($myId);
		// $this->groupNotifications = self::getFeedGroupNotifications($myId);
		// $this->newGroupNotifications = self::getNewGroupNotifications($myId);

		// Get All Notifications
		self::getAllNotifications($myId);

		//Get new message
		$newMessage = Messages::model()->findAll(array("condition"=>"FK_receiver = $myId and has_read = 0"));

		$this->render('//messages/messages', array(
			'friend' => $friend,
			'messages' => $messages,
			'profileImage' => $profileImage,
			'newMessage' => $newMessage
		));
	}

	public function actionAllConversations()
	{
		self::existSession ();

		$myId = Yii::app()->user->getState('userId');

		$criLastMessageNoRead = new CDbCriteria;

		$criLastMessageNoRead->condition = 'FK_receiver = ' . $myId;
		$criLastMessageNoRead->addCondition('has_read = 0');
		$criLastMessageNoRead->order = 'date_sender DESC';

		$lastConversation = array();

		$modelLastMessageNoRead = Messages::model()->find($criLastMessageNoRead);

		if(!isset($modelLastMessageNoRead))
		{
			$criLastMessageRead = new CDbCriteria;

			$criLastMessageRead->condition = 'FK_receiver = ' . $myId;
			$criLastMessageRead->addCondition('FK_creator = ' . $myId, 'OR');
			$criLastMessageRead->select="t.FK_id_conversation, t.FK_creator, t.FK_receiver";
			$criLastMessageRead->order = 'date_sender DESC';

			$modelLastMessageRead = Messages::model()->find($criLastMessageRead);
			
			if(isset($modelLastMessageRead))
			{
				$modelMessages = Messages::model()->findAll('FK_id_conversation =' . $modelLastMessageRead->FK_id_conversation);

				if($modelLastMessageRead->FK_creator === $myId)
				{
					$modelFriendConversation = UserProfile::model()->findByAttributes(array('FK_id'=>$modelLastMessageRead->FK_receiver));
				}

				else
				{
					$modelFriendConversation = UserProfile::model()->findByAttributes(array('FK_id'=>$modelLastMessageRead->FK_creator));
				}

				foreach ($modelMessages as $modelMessage)
				{
					$creator = UserProfile::model()->findByAttributes(array('FK_id'=>$modelMessage->FK_creator));

					if(!empty($lastConversation))
					{
						array_push($lastConversation['messages'], array('creator' => $creator->names . ' ' . $creator->last_names, 'message' => $this->renderPartial("//messages/_message", array('creator' => $creator->names . ' ' . $creator->last_names, 'message' => $modelMessage->content), true)));
					}

					else
					{
						$lastConversation['idFriendConversation'] = $modelFriendConversation->FK_id;
						$lastConversation['friendConversation'] = $modelFriendConversation->names . ' ' . $modelFriendConversation->last_names;
						$lastConversation['messages'] = array(array('creator' => $creator->names . ' ' . $creator->last_names, 'message' => $this->renderPartial("//messages/_message", array('creator' => $creator->names . ' ' . $creator->last_names, 'message' => $modelMessage->content), true)));
					}
				}
			}
		}
		else
		{
			$modelMessages = Messages::model()->findAll('FK_id_conversation =' . $modelLastMessageNoRead->FK_id_conversation);

			if($modelLastMessageNoRead->FK_creator === $myId)
			{
				$modelFriendConversation = UserProfile::model()->findByAttributes(array('FK_id'=>$modelLastMessageNoRead->FK_receiver));
			}

			else
			{
				$modelFriendConversation = UserProfile::model()->findByAttributes(array('FK_id'=>$modelLastMessageNoRead->FK_creator));
			}

			foreach ($modelMessages as $modelMessage)
			{
				if($modelMessage->FK_receiver === $myId && $modelMessage->has_read === '0')
				{
					$modelMessage->has_read = '1';
					$modelMessage->save();
				}

				$creator = UserProfile::model()->findByAttributes(array('FK_id'=>$modelMessage->FK_creator));

				if(!empty($lastConversation))
				{
					array_push($lastConversation['messages'], array('creator' => $creator->names . ' ' . $creator->last_names, 'message' => $this->renderPartial("//messages/_message", array('creator' => $creator->names . ' ' . $creator->last_names, 'message' => $modelMessage->content), true)));
				}

				else
				{
					$lastConversation['idFriendConversation'] = $modelFriendConversation->FK_id;
					$lastConversation['friendConversation'] = $modelFriendConversation->names . ' ' . $modelFriendConversation->last_names;
					$lastConversation['messages'] = array(array('creator' => $creator->names . ' ' . $creator->last_names, 'message' => $this->renderPartial("//messages/_message", array('creator' => $creator->names . ' ' . $creator->last_names, 'message' => $modelMessage->content), true)));
				}
			}
		}



		$listConversations = array();

		if(!empty($lastConversation))
		{
			$criAllConversations = new CDbCriteria;

			$criAllConversations->condition = 'FK_id_user1 = ' . $myId;
			$criAllConversations->addCondition('FK_id_user2 = ' . $myId, 'OR');
			$criAllConversations->select="t.id, t.FK_id_user1, t.FK_id_user2";
			$criAllConversations->order = 'date_update DESC';

			$modelAllConversations = Conversations::model()->findAll($criAllConversations);

			foreach ($modelAllConversations as $modelConversation)
			{
				if($modelConversation->FK_id_user1 === $myId)
				{
					$modelFriendConversation = UserProfile::model()->findByAttributes(array('FK_id'=>$modelConversation->FK_id_user2));
				}
				else
				{
					$modelFriendConversation = UserProfile::model()->findByAttributes(array('FK_id'=>$modelConversation->FK_id_user1));	
				}

				$listConversations[] = array('idConversation' => $modelConversation->id, 'idFriendConversation' => $modelFriendConversation->FK_id ,'friendConversation' => $modelFriendConversation->names . ' ' . $modelFriendConversation->last_names);
			}
		}

		// $this->friendsRequest = self::getFriendRequests($myId);
		// $this->wallPostNotifications = self::getWallpostNotifications($myId);
		// $this->groupNotifications = self::getFeedGroupNotifications($myId);
		// $this->newGroupNotifications = self::getNewGroupNotifications($myId);

		// Get All Notifications
		self::getAllNotifications($myId);

		// Get Profile Image
		$profileImage = self::getProfileImage($myId);

		//Get new message
		$newMessage = Messages::model()->findAll(array("condition"=>"FK_receiver = $myId and has_read = 0"));

		$this->render('//messages/messages', array(
			'listConversations' => $listConversations,
			'lastConversation' => $lastConversation,
			'profileImage' => $profileImage,
			'newMessage' => $newMessage
		));
	}

	public function actionNewMessage()
	{
		self::existSession ();

		if(isset($_POST['message']))
		{
			$creator = Yii::app()->user->getState('userId');
			$receiver = $_POST['userProfile'];

			// Search if exist a conversation
			$searchConversation = Conversations::model()->find(" (FK_id_user1 = $creator and FK_id_user2 = $receiver) or (FK_id_user2 = $creator and FK_id_user1 = $receiver) ");

			$model = new Messages;

			if(empty($searchConversation))
			{
				$modelConversation = new Conversations;

				$modelConversation->FK_id_user1 = $creator;
				$modelConversation->FK_id_user2 = $receiver;
				$modelConversation->date_update = date("Y:m:d H:i:s");

				if($modelConversation->save())
				{
					$model->FK_id_conversation = $modelConversation->id;
					$model->FK_creator = $creator;
					$model->FK_receiver = $receiver;
					$model->content = $_POST['message'];

					if($model->save())
					{	
						$responde = array("creator" => Yii::app()->user->getState('name') . ' ' . Yii::app()->user->getState('last_name') , "message" => $model->content);
						echo CJSON::encode($responde);
					}
				}
			}

			else
			{
				$searchConversation->date_update = date("Y:m:d H:i:s");
			
				$model->FK_id_conversation = $searchConversation->id;
				$model->FK_creator = $creator;
				$model->FK_receiver = $receiver;
				$model->content = $_POST['message'];

				if($model->save() && $searchConversation->save())
				{	
					$responde = array("creator" => Yii::app()->user->getState('name') . ' ' . Yii::app()->user->getState('last_name') , "message" => $model->content);
					echo CJSON::encode($responde);
				}
			}
		}

		else if(isset($_POST['createMessage']))
		{
			$creator = Yii::app()->user->getState('userId');
			$receiver = $_POST['receiver'];

			// Search if exist a conversation
			$searchConversation = Conversations::model()->find(" (FK_id_user1 = $creator and FK_id_user2 = $receiver) or (FK_id_user2 = $creator and FK_id_user1 = $receiver) ");

			$model = new Messages;

			if(empty($searchConversation))
			{
				$modelConversation = new Conversations;

				$modelConversation->FK_id_user1 = $creator;
				$modelConversation->FK_id_user2 = $receiver;
				$modelConversation->date_update = date("Y:m:d H:i:s");

				if($modelConversation->save())
				{
					$model->FK_id_conversation = $modelConversation->id;
					$model->FK_creator = $creator;
					$model->FK_receiver = $receiver;
					$model->content = $_POST['contentMessage'];

					if($model->save())
					{	
						echo $receiver;
					}
				}
			}

			else
			{
				$searchConversation->date_update = date("Y:m:d H:i:s");
			
				$model->FK_id_conversation = $searchConversation->id;
				$model->FK_creator = $creator;
				$model->FK_receiver = $receiver;
				$model->content = $_POST['contentMessage'];

				if($model->save() && $searchConversation->save())
				{	
					echo $receiver;
				}
			}
		}

		else
		{
			throw new CHttpException(500,'Internal server error');
		}
	}

	public function actionMessagesByConversation()
	{
		self::existSession ();

		$messagesByConversation = array();

		if(isset($_GET['idConversation']))
		{
			$modelMessages = Messages::model()->findAll('FK_id_conversation =' . $_GET['idConversation']);

			foreach ($modelMessages as $modelMessage)
			{
				$creator = UserProfile::model()->findByAttributes(array('FK_id'=>$modelMessage->FK_creator));

				if(!empty($messagesByConversation))
				{
					array_push($messagesByConversation['messages'], array('creator' => $creator->names . ' ' . $creator->last_names, 'message' => $this->renderPartial("//messages/_message", array('creator' => $creator->names . ' ' . $creator->last_names, 'message' => $modelMessage->content), true)));
				}

				else
				{
					$messagesByConversation['idFriendConversation'] = $_GET['idFriendConversation'];
					$messagesByConversation['friendConversation'] = $_GET['friendConversation'];
					$messagesByConversation['messages'] = array(array('creator' => $creator->names . ' ' . $creator->last_names, 'message' => $this->renderPartial("//messages/_message", array('creator' => $creator->names . ' ' . $creator->last_names, 'message' => $modelMessage->content), true)));
				}
			}
		}

		else
		{
			throw new CHttpException(500,'Internal server error');
		}

		echo CJSON::encode($messagesByConversation);
	}

	public function actionGetFriends()
	{
		self::existSession ();
		
		if(isset($_GET['user']))
		{
			$myId = $_GET['user'];
			$friend = UserProfile::model()->find("FK_id = $myId");
		}
		else
		{
			$myId = Yii::app()->user->getState('userId');
		}

		// Get Profile Image
		$profileImage = self::getProfileImage($myId);

		$myFriends = FriendsJunction::model()->findAll("user_id = $myId");
		$yourFriends = FriendsJunction::model()->findAll("friend_id = $myId");

		$friends = array();

		foreach ($myFriends as $myFriend)
		{
			$userFriend = Users::model()->findByPk($myFriend->friend_id);
			$friends [] = $this->renderPartial('_friend', array(
				'model' => $userFriend),
				true
			);
		}

		foreach ($yourFriends as $yourFriend)
		{
			$userFriend = Users::model()->findByPk($yourFriend->user_id);
			$friends [] = $this->renderPartial('_friend', array(
				'model' => $userFriend),
				true
			);
		}

		// $this->friendsRequest = self::getFriendRequests($myId);
		// $this->wallPostNotifications = self::getWallpostNotifications($myId);
		// $this->groupNotifications = self::getFeedGroupNotifications($myId);
		// $this->newGroupNotifications = self::getNewGroupNotifications($myId);

		// Get All Notifications
		self::getAllNotifications($myId);

		//Get new message
		$newMessage = Messages::model()->findAll(array("condition"=>"FK_receiver = $myId and has_read = 0"));

		if(isset($friend))
		{
			$this->render('viewFriends', 
				array(
					'friends' => $friends,
					'friend' => $friend,
					'profileImage' => $profileImage,
					'newMessage' => $newMessage
				)
			);
		}
		else
		{
			$this->render('viewFriends', 
				array(
					'friends' => $friends,
					'profileImage' => $profileImage,
					'newMessage' => $newMessage
				)
			);
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
					$comments [] = $this->renderPartial("//wallPost/_comment", array('model' => $modelComment, 'userName' => $userComment->name, 'profileImage' => $userComment->profile_image), true);
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
