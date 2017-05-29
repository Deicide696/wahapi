<?php

// class WallPostController extends Controller
// {
// 	public function actionIndex()
// 	{
// 		$this->render('index');
// 	}

// 	public function actionStatus()
// 	{
// 		$model = new WallPost;

// 		if(isset($_POST['status']))
// 		{
// 		 	$model->user_id = Yii::app()->user->getState('userId');
// 		 	$model->poster_id = 1;
// 		 	$model->content = $_POST['status'];

// 			// echo CActiveForm::validate($model);

// 		 	if($model->save())
// 		 	{
// 		 		$this->renderPartial('_post', array('model' => $model));
// 		 	}
// 		}

// 		else
// 		{
// 			$this->renderPartial('_status', array('model' => $model));
// 		}
// 	}

// 	public function actionComplaint()
// 	{
// 		$model = new WallPost;

// 		if(isset($_POST['status']))
// 		{
// 			$model->user_id = Yii::app()->user->getState('userId');
// 		 	$model->poster_id = 1;
// 		 	$model->content = $_POST['status'];

// 			// echo CActiveForm::validate($model);

// 		 	if($model->save())
// 		 	{
// 		 		$this->renderPartial('_post', array('model' => $model));
// 		 	}
// 		}
// 		else
// 		{
// 			$this->renderPartial('_complaint', array('model' => $model));
// 		}
// 	}

// 	public function actionLike()
// 	{	
// 		$model = new LikesDislikes;

// 		if(isset($_POST['idpost']))
// 		{
// 			$who = Yii::app()->user->getState('userId');
// 			$what = $_POST['idpost'];

// 			// $likeDislike = LikesDislikes::model()->find(array("condition"=>"who =  $who and 'what' = $what"));

// 			$likeDislikeWho = LikesDislikes::model()->find("who =  $who");
			
// 			if(isset($likeDislikeWho))
// 			{
// 				$likeDislikeWhat = $likeDislikeWho->find("what = $what");
// 				if(isset($likeDislikeWhat))
// 				{
// 					$typeLike = $likeDislikeWhat->type;
// 				}
// 			}

// 			if(isset($typeLike))
// 			{
// 				if($typeLike === '1')
// 				{
// 					throw new CHttpException(406,'Not acceptable.');
// 				}

// 				elseif ($typeLike === '2') 
// 				{
// 					$likeDislikeWhat->type = 0;
// 					$likeDislikeWhat->save();
// 					echo 'change';
// 				}

// 				elseif ($typeLike === '0')
// 				{
// 					$likeDislikeWhat->type = 2;
// 					$likeDislikeWhat->save();
// 					echo 'add';
// 				}

// 				else
// 				{
// 					echo $typeLike;
// 					throw new CHttpException(404,'Not found.');
// 				}
// 			}

// 			else
// 			{
// 				$model->who = $who;
// 			 	$model->what = $what;
// 			 	$model->type = 2;

// 				// echo CActiveForm::validate($model);
// 			 	$model->save();

// 			 	echo 'new';
// 			}
// 		}
// 	}

// 	public function actionDislike()
// 	{	
// 		$model = new LikesDislikes;

// 		if(isset($_POST['idpost']))
// 		{
// 			$who = Yii::app()->user->getState('userId');
// 			$what = $_POST['idpost'];

// 			$likeDislikeWho = LikesDislikes::model()->find("who =  $who");
			
// 			if(isset($likeDislikeWho))
// 			{
// 				$likeDislikeWhat = $likeDislikeWho->find("what = $what");
// 				if(isset($likeDislikeWhat))
// 				{
// 					$typeLike = $likeDislikeWhat->type;
// 				}
// 			}

// 			if(isset($typeLike))
// 			{
// 				if($typeLike === '2')
// 				{
// 					throw new CHttpException(406,'Not acceptable.');
// 				}

// 				elseif ($typeLike === '1') 
// 				{
// 					$likeDislikeWhat->type = 0;
// 					$likeDislikeWhat->save();
// 					echo 'change';
// 				}

// 				elseif ($typeLike === '0')
// 				{
// 					$likeDislikeWhat->type = 1;
// 					$likeDislikeWhat->save();
// 					echo 'add';
// 				}

// 				else
// 				{
// 					echo $typeLike;
// 					throw new CHttpException(404,'Not found.');
// 				}
// 			}

// 			else
// 			{
// 				$model->who = $who;
// 			 	$model->what = $what;
// 			 	$model->type = 1;

// 				// echo CActiveForm::validate($model);
// 			 	$model->save();

// 			 	echo 'add';
// 			}
// 		}
// 	}

// 	// Uncomment the following methods and override them if needed
// 	/*
// 	public function filters()
// 	{
// 		// return the filter configuration for this controller, e.g.:
// 		return array(
// 			'inlineFilterName',
// 			array(
// 				'class'=>'path.to.FilterClass',
// 				'propertyName'=>'propertyValue',
// 			),
// 		);
// 	}

// 	public function actions()
// 	{
// 		// return external action classes, e.g.:
// 		return array(
// 			'action1'=>'path.to.ActionClass',
// 			'action2'=>array(
// 				'class'=>'path.to.AnotherActionClass',
// 				'propertyName'=>'propertyValue',
// 			),
// 		);
// 	}
// 	*/
// }

class WallPostController extends Controller
{
	public function actionStatus()
	{
		$model = new WallPost;

		if(isset($_POST['status']))
		{
		 	$model->who = Yii::app()->user->getState('userId');
		 	$model->whom = $_GET['userProfileId'];
		 	$model->type = 1;
			
			// echo CActiveForm::validate($model);

		 	if($model->save())
		 	{
		 		$modelFeedsUser = new FeedsUser;

		 		$modelFeedsUser->FK_id = $model->id;
		 		$modelFeedsUser->FK_type = $model->type;
		 		$modelFeedsUser->content = $_POST['status'];

		 		if($modelFeedsUser->save())
		 		{
		 			$userWallpost = Users::model()->findByPk($model->who);
		 			$this->renderPartial('//wallPost/_post', array(
		 				'model' => $modelFeedsUser,
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
		$model = new LikesDislikes;

		if(isset($_POST['idpost']))
		{	
			$who = Yii::app()->user->getState('userId');
			$what = $_POST['idpost'];

			// $likeDislike = LikesDislikes::model()->find(array("condition"=>"who =  $who and 'what' = $what"));

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
}

?>