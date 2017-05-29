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
    <span class="white" style="padding: 2px 15px 5px 15px;background-color: #86b703;">
        Mensajes
    </span>
    <img style="vertical-align:text-top; margin-top: -2px;margin-left: -4px;"src="<?php echo Yii::app()->request->baseUrl; ?>/images/hojas.png">
    <div class="container-fluid">
        <br>
        <div class="row">
            <div class="btn-group pull-right">
                <button class="btn btn-default btn-custom white" style="background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/images/patterns/add2.png')" data-toggle="modal" data-target=".bs-example-modal-sm">
                    Nuevo mensaje
                </button>
                <button type="button" class="btn btn-default btn-custom white" style="background-color: #855b3b" ;="" data-toggle="modal" data-target=".bs-example-modal-sm">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </div>
            <!-- Modal New Message-->
            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel">Nuevo mensaje</h4>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="form-group">
                                        <?php
                                            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                                                'name'=>'value',
                                                'value'=>'',
                                                'source'=>$this->createUrl('users/searchFriendAutocomplete'),
                                                'options'=>array(
                                                    'showAnim'=>'fold',
                                                    'minLength'=>'1',
                                                    'select'=>"js:function(event, ui)
                                                    {
                                                        console.log(ui.item[\"id\"]);
                                                        $('#receiver').val(ui.item[\"id\"]);
                                                    }"
                                                ),
                                                'htmlOptions'=>array(
                                                    'id'=>'searchFriendsInput',
                                                    'class' => 'form-control',
                                                    'placeholder' => 'Para:'
                                                )
                                            ));
                                        ?>
                                    </div>
                                    <?php echo CHtml::beginForm(); ?>
                                    <div class="form-group">
                                        <?php echo CHtml::textArea("contentMessage", '' , array("class" => "form-control", "placeholder" => "Escribe un mensaje...")); ?>
                                    </div>
                                    <?php echo CHtml::hiddenField('createMessage'); ?>
                                    <?php echo CHtml::hiddenField('receiver','', array("id" => "receiver")); ?>                            
                                    <?php
                                        echo CHtml::ajaxSubmitButton(
                                            'Enviar',
                                            array('users/newMessage'),
                                            array(
                                                "beforeSend" => "function(){
                                                    $('#createMessageBtn').attr('disabled', true);
                                                }",
                                                "success"=>"function(data){
                                                    alert('El mensaje se ha enviado');
                                                    window.location = 'messagesByUser?user=' + data;
                                                }"
                                            ),
                                            array(
                                                'class' => 'btn btn-success pull-right'
                                            )
                                        );
                                    ?>
                                    <?php echo CHtml::endForm(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                if(isset($friend) || (isset($lastConversation) && !empty($lastConversation)))
                {
            ?>
            <h3 id="friendConversation" class="green">
                <?php 
                    if(isset($friend))
                    {
                        echo $friend->name . " " . $friend->last_name;
                    }
                    else
                    {
                        print_r($lastConversation['friendConversation']);
                    }
                ?>
            </h3>
            <div id="conversation">
                <?php 
                    if(isset($friend))
                    {
                        foreach ($messages as $message) 
                        {
                            echo $message;
                        }
                    }
                    else
                    {
                        foreach ($lastConversation['messages'] as $message) 
                        {
                            echo($message['message']);
                        }
                    }
                ?>
            </div>
            <form role="form" id="newMessage" style="margin-top:20px;">
                <input type="hidden" id="userProfile" name="userProfile" value="<?php if(isset($friend)){echo $_GET['user'];}else{echo $lastConversation['idFriendConversation'];}?>">
                <textarea autofocus style="margin-bottom:5px; resize: none;" name="message" id="message" placeholder="Escribe un mensaje" class="form-control" rows="2"></textarea>
                <button type="submit" id="messageBtn" class="btn btn-success pull-right">Enviar</button>
            </form>
            <script type="text/javascript">
                $("#messageBtn").click(function () {
                    $.ajax({
                        type: "POST",
                        url: 'newMessage',
                        data: $('#newMessage').serialize(),
                        dataType: 'json',
                        beforeSend: function(data)
                        {
                            $('#messageBtn').attr("disabled", true);
                        },
                        success: function(data)
                        {
                            $("#message").val('');
                            $("#conversation").append("<div class='media'><a class='pull-left' href='#'><img class='media-object' src='/wahapi/images/ml_thumb.png' alt='...'></a><div class='media-body'><h4 class='media-heading green'>" + data.creator + "</h4>" + data.message + "</div></div>");
                            $('#messageBtn').attr("disabled", false);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                });

                $("#message").keypress(function(e){
                    if(e.which == 13) {
                        $.ajax({
                            type: "POST",
                            url: 'newMessage',
                            data: $('#newMessage').serialize(),
                            dataType: 'json',
                            beforeSend: function(data)
                            {
                                $('#message').attr("disabled", true);
                            },
                            success: function(data)
                            {
                                $("#message").val('');
                                $("#conversation").append("<div class='media'><a class='pull-left' href='#'><img class='media-object' src='/wahapi/images/ml_thumb.png' alt='...'></a><div class='media-body'><h4 class='media-heading green'>" + data.creator + "</h4>" + data.message + "</div></div>");
                                $('#message').attr("disabled", false);
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                            }
                        });
                        return false;
                    }     
                });
            </script>
            <?php
                }
                else
                {
                    echo "<br><br>";
                    echo "<h2>Usted no tienes mensajes</h3>";
                }
            ?>
        </div>
    </div>
</div>
<div class="col-lg-3">
    <?php
        if(isset($listConversations))
        {
            foreach ($listConversations as $conversation)
            {
                echo "<div class='media'>";
                echo "<a class='pull-left' href='#'>";
                echo "<img class='media-object' src='". Yii::app()->request->baseUrl . "/images/ml_thumb.png' alt='...'>";
                echo "</a>";
                echo "<div class='media-body'>";
                echo "<a href='javascript: void(0)' id='getconversation". $conversation['idConversation'] . "'><h4 class='media-heading green'>" . $conversation['friendConversation'] . "</h4></a>";
                echo "</div>";
                echo "</div>";
                echo "<script type='text/javascript'>";
                echo "$('#getconversation" . $conversation['idConversation'] . "').click(function () {";
                echo "$.ajax({";
                echo "type: 'POST',";
                echo "url: 'messagesByConversation?idConversation=" . $conversation['idConversation'] . "&idFriendConversation=" . $conversation['idFriendConversation'] . "&friendConversation=" . $conversation['friendConversation'] . "',";
                echo "dataType: 'json',";
                echo "success: function(data)";
                echo "{";
                echo "$('#friendConversation').html(data.friendConversation);";
                echo "$('#conversation').empty();";
                echo "$('#userProfile').val(data.idFriendConversation);";
                echo "$.each(data.messages, function(i, val) {";
                echo "$('#conversation').append(data.messages[i]['message']);console.log(data.messages[i]['message']);";
                echo "});";
                echo "}";
                echo "});";
                echo "});";
                echo "</script>";
            }
        }
    ?>
</div>