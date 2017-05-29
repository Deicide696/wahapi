<li class="media-list">
    <a class="pull-left" href="#">
        <img class="media-object" src="<?php echo Yii::app()->params['path_bucket'] . $userWallpost->profile_image ?>" style="max-height: 50px; max-width: 50px;">
    </a>
    <div class="media-body text-left">
        <h4 class="media-heading">
            <?php 
                echo CHtml::link($userWallpost->name . ' ' . $userWallpost->last_name, 
                    array(
                        'users/getProfile',
                        'user' => $userWallpost->_id
                    ),
                    array('class'=>'green')
                );

                if(isset($advertiser))
                {
                    echo " &#9658; ";
                    echo CHtml::link(Yii::app()->user->getState("name") . ' ' . Yii::app()->user->getState("last_name"), 
                        array(
                            'users/getProfile',
                            'user' => Yii::app()->user->getState("userId")
                        ),
                        array('class'=>'green')
                    );
                }

                else if(isset($advertiserToFriend))
                {
                    echo " &#9658; ";
                    echo CHtml::link($advertiserToFriend->name . ' ' . $advertiserToFriend->last_name, 
                        array(
                            'users/getProfile',
                            'user' => $advertiserToFriend->_id
                        ),
                        array('class'=>'green')
                    );
                }

                else if(isset($groupPublished))
                {
                    echo " &#9658; ";
                    echo CHtml::link($groupPublished->name, 
                        array(
                            'users/getProfile',
                            'user' => $groupPublished->_id
                        ),
                        array('class'=>'green')
                    );
                }
            ?>
        </h4>
        <?php echo $model->content ?>
        <div class="container-fluid">
            <?php 
                $baseUrl = Yii::app()->request->baseUrl;
                $feedId = $model->FK_id;

                $statusLike = 'like';
                $statusDislike = 'dislike';

                if(isset($modelLikesDislikes->type))
                {
                    if($modelLikesDislikes->type === '0')
                    {
                        $statusLike = 'like';
                        $statusDislike = 'dislike';
                    }
                    else if ($modelLikesDislikes->type === '1')
                    {
                        $statusLike = 'like';
                        $statusDislike = 'dislike_verde';
                    }
                    else
                    {
                        $statusLike = 'like_verde';
                        $statusDislike = 'dislike';
                    }
                }
            ?>

            <a class="likeButton" id="imgLike<?php echo $feedId ?>" href="">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $statusLike ?>.png" alt="">
            </a>

            <script>   
                $(function(){
                    $("#imgLike<?php echo $feedId ?>").click(function(){
                        $.ajax({
                            type: "POST",
                            url: "like",
                            data: {"idpost" : <?php echo $feedId ?>},
                            success: function(data)
                            {   
                                if(data == 'add' || data == 'new')
                                {
                                    $('#imgLike<?php echo $feedId ?> img').attr('src', '<?php echo Yii::app()->request->baseUrl; ?>/images/like_verde.png');
                                }

                                else if(data == 'change')
                                {   
                                    $('#imgLike<?php echo $feedId ?> img').attr('src', '<?php echo Yii::app()->request->baseUrl; ?>/images/like.png');
                                }
                            }
                        });
                        return false;
                    });
                });
            </script>

            <a class="textlike" id="textLike<?php echo $feedId ?>" href="">
                Like
            </a>
            <?php print_r($numLikes); ?>

            <script>   
                $(function(){
                    $("#textLike<?php echo $feedId ?>").click(function(){
                        $.ajax({
                            type: "POST",
                            url: "like",
                            data: {"idpost" : <?php echo $feedId ?>},
                            success: function(data)
                            {   
                                if(data == 'add' || data == 'new')
                                {
                                    $('#imgLike<?php echo $feedId ?> img').attr('src', '<?php echo Yii::app()->request->baseUrl; ?>/images/like_verde.png');
                                }

                                else if(data == 'change')
                                {   
                                    $('#imgLike<?php echo $feedId ?> img').attr('src', '<?php echo Yii::app()->request->baseUrl; ?>/images/like.png');
                                }
                            }
                        });
                        return false;
                    });
                });
            </script>
            
            <a class="dislikeButton" id="imgDislike<?php echo $feedId ?>" href="">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/<?php echo $statusDislike ?>.png" alt="">
            </a>

            <script>   
                $(function(){
                    $("#imgDislike<?php echo $feedId ?>").click(function(){
                        $.ajax({
                            type: "POST",
                            url: "dislike",
                            data: {"idpost" : <?php echo $feedId ?>},
                            success: function(data)
                            {   
                                if(data == 'add' || data == 'new')
                                {
                                    $('#imgDislike<?php echo $feedId ?> img').attr('src', '<?php echo Yii::app()->request->baseUrl; ?>/images/dislike_verde.png');
                                }

                                else if(data == 'change')
                                {   
                                    $('#imgDislike<?php echo $feedId ?> img').attr('src', '<?php echo Yii::app()->request->baseUrl; ?>/images/dislike.png');
                                }
                            }
                        });
                        return false;
                    });
                });
            </script>

            <a class="textlike" id="textDislike<?php echo $feedId ?>" href="">
                Dislike
            </a>

            <?php print_r($numDislikes);?>

            <script>   
                $(function(){
                    $("#textDislike<?php echo $feedId ?>").click(function(){
                        $.ajax({
                            type: "POST",
                            url: "dislike",
                            data: {"idpost" : <?php echo $feedId ?>},
                            success: function(data)
                            {   
                                if(data == 'add' || data == 'new')
                                {
                                    $('#imgDislike<?php echo $feedId ?> img').attr('src', '<?php echo Yii::app()->request->baseUrl; ?>/images/dislike_verde.png');
                                }

                                else if(data == 'change')
                                {   
                                    $('#imgDislike<?php echo $feedId ?> img').attr('src', '<?php echo Yii::app()->request->baseUrl; ?>/images/dislike.png');
                                }
                            }
                        });
                        return false;
                    });
                });
            </script>
        </div>
        
        <ul id="commentsPost<?php echo $feedId ?>" class="media-list comment-post">
            <?php
                if($comments !== null)
                {
                    foreach ($comments as $comment) 
                    {
                        print_r($comment);
                    }
                }
            ?>
        </ul>

        <div class="media input-comment">
            <a class="pull-left" href="#">
                <img class="media-object" src="<?php  echo Yii::app()->params['path_bucket'] . $userWallpost->profile_image; ?>" style="max-width:35px; max-height:35px;"/>
            </a>
            <div class="media-body">
                <input type="text" id="comment<?php echo $feedId ?>" class="form-control" placeholder="Escribe un comentario">
            </div>
        </div>
    </div>
</li>
<script>   
    $(function(){
        $("#comment<?php echo $feedId ?>").keypress(function(e){
            if(e.which == 13) {
                $.ajax({
                    type: "POST",
                    url: "comment",
                    data: {"idfeed" : <?php echo $feedId ?>, "commentText" : $("#comment<?php echo $feedId ?>").val()},
                    dataType: 'json',
                    beforeSend: function(){
                        $('#comment<?php echo $feedId ?>').attr("disabled", true);
                    },
                    success: function(data)
                    {   
                        console.log(data);
                        //Clear input field
                        $("#comment<?php echo $feedId ?>").val("");
                        //Append comment
                        $("#commentsPost<?php echo $feedId ?>").append("<li class='media'><a class='pull-left' href='#'><img class='media-object' src='<?php echo Yii::app()->params['path_bucket'] . $userWallpost->profile_image; ?>' style='max-width:35px; max-height:35px;'></a><div class='media-body text-left'><h5 class='media-heading'>" + data.userName +"</h5>" + data.comment + "</div></li>");
                        //Enable input comment field
                        $('#comment<?php echo $feedId ?>').attr("disabled", false);
                    }
                });
                return false;
            }
        });
    });
</script>