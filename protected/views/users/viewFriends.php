<?php
    $this->renderPartial("//users/_panel-left-home", array(
        "profileImage" => $profileImage)
    );

    $this->renderPartial("//users/_main-menu", array(
        'newMessage' => $newMessage)
    );
?>
<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
    <br><br>
</div>
<div class="col-lg-9" style="min-height: 0px;">
    <hr>
</div>
<div class="col-lg-6 col-md-6 col-sm-9">
    <hr>
    <span class="white" style="padding: 2px 15px 5px 15px;background-color: #86b703;">
        Amigos
    </span>
    <img style="vertical-align:text-top; margin-top: -2px;margin-left: -4px;"src="<?php echo Yii::app()->request->baseUrl; ?>/images/hojas.png">
    <div class="container-fluid">
        <div class="row">
            <h2>
                <?php 
                    if(isset($friend))
                    {
                        echo "<h1>" . $friend->names . " tiene ";
                        echo count($friends);
                        echo " Amigos </h1>";
                    }
                    else
                    {
                        echo "<h1> Usted tiene ";
                        echo count($friends);
                        echo " Amigos </h1>";
                    }
                ?>
            </h2>
            <?php
                foreach ($friends as $friend) 
                {
                    echo $friend;
                }
            ?>
        </div>
    </div>
</div>