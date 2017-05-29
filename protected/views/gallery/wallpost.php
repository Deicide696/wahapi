        <div id="mainContainer">
            <div id="leftMenuColumn">
                <div id="menuTabs">
                    <div class="tabsContainer">
                        <div class="tab">
                            <span id="home">
                                <a href="<?php echo Yii::app()->request->baseUrl; ?>">Inicio</a>
                            </span>
                        </div>
                        <div class="tab2">
                            <span id="user">
                                <strong><a href="<?php echo Yii::app()->request->baseUrl; ?>">Mi Wahapi</a></strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div id="profileIdentity">
                    <div id="profileNameWrapper">
                        <span style="font-size: 15px; color:#86b703;float: left;">
                            <?php echo $model->name ?>
                        </span>
                        <br>
                        <br>
                        <p style="color: #000;float:left;">
                            <strong>Creador:</strong>
                            <br>
                            <span><?php echo $userAdmin->name . " " . $userAdmin->last_name?></span>
                        </p>
                    </div>
                    
                    <?php
                        if($isMember == 1)
                        {
                            $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                            'name'=>'addPeople',
                            'source'=>$this->createUrl("searchFriendToRequest?groupId=$model->_id"),
                            'options'=>array(
                                'minLength'=>'1',
                                'select'=>"js:function(event, ui) {
                                    $.ajax({
                                        type: 'POST',
                                        url: 'requestGroup',
                                        data: {'userId' : ui.item[\"id\"], 'groupId' : $model->_id},
                                        success: function(data)
                                        {   
                                            console.log(data + ' views/groups/wallpost');
                                        }
                                    });
                                    console.log(ui.item[\"id\"]);
                                    return false;
                                }"
                            ),
                            'htmlOptions'=>array(
                                // 'style'=>'height:20px;',
                            ),
                            ));
                        }
                    ?>
                </div>
            </div>
            <div id="centerMainColumn">
                <div id="mainOptions">
                    <div class="tabsContainer2">
                        <div id='imgProfile' style="margin-left: -125px;margin-top: -10px;">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/imgProfile.png" >
                            <div style="font-size: 19px; color:#FFF;position:absolute;top: 15px;margin-left: 25px;">
                                <?php echo $model->name; ?>
                            </div>
                            <?php
                                if($isMember === 0 || $isMember == 1)
                                {
                                    // echo CHtml::ajaxLink(
                                    //     CHtml::image(Yii::app()->request->baseUrl . '/images/profile/agregar.png'), 
                                    //     array('addFriend'), 
                                    //     array(
                                    //         'type' => 'POST',
                                    //         'data' => array('receiver' => "$isMember->FK_id"),
                                    //         'success' => 'function(data){
                                    //             console.log(data);
                                    //             $("#btnAddFriend").remove();
                                    //         }' 
                                    //     ),
                                    //     array(
                                    //         'style' => 'position:absolute;top: 160px;margin-left: 440px;',
                                    //         'id' => 'btnAddFriend'
                                    //     )
                                    // );

                                    // Provisional NO EN PRODUCCION!!!!
                                    echo CHtml::image(Yii::app()->request->baseUrl . '/images/profile/agregar.png');
                                }
                            ?>
                        </div>
                        <div style="margin-top: -5px;">
                            <a class="tab_principal" href="#">
                                <div class="notificon">
                                    <!-- <span class="newnotification">1</span> -->
                                </div>
                            </a>
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/amigosGrupo.png"/>
                            <a class="tab_principal" href="#">
                                <div class="notificon">
                                    <!-- <span>1</span> -->
                                </div>
                            </a>
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/fotos_tab.png"/>
                            <a class="tab_principal" href="#">
                                <div class="notificon">
                                    <!-- <span>1</span> -->
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div id="containerTabsPost" style='width: 540px; padding-top: 230px;'>
                    <?php 
                        if($isMember == 1)
                        {
                            $groupId = $model->_id;
                            
                            $this->widget('zii.widgets.jui.CJuiTabs', array(
                                'tabs' => array(
                                    'Status' => array('ajax' => $this->createUrl('status') . '?groupId=' . $groupId),
                                    // 'Denuncio' => array('ajax' => $this->createUrl('users/complaint')),
                                    // panel 3 contains the content rendered by a partial view
                                ),
                                // additional javascript options for the tabs plugin
                                'options' => array(
                                    'collapsible' => false,
                                ),
                            ));
                    ?>
                </div>
                <div id="allPost">
                    <?php 
                            foreach ($posts as $post) 
                            {
                                echo $post;
                            }
                        }
                    ?>
                    <div id="posts">
                        <ol>
                            <li class="psbody">
                                <div class="psimg">
                                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/profile/arbolesWahapi.png" width="100px" height="100px"/>
                                </div>
                                <div class="pstext">
                                    <div class="psuser">
                                        <strong>Bienvenido a Wahapi</strong>
                                    </div>
                                    Esto es Wahapi! Acabas de unirte a la primera nueva red social dedicada a la protecci&oacute;n y conservaci&oacute;n del medio ambiente.
                                    <div class="pslike">
                                        <!-- <a href="#">
                                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/like.png">
                                            <span class="textlike2">Like</span>
                                        </a>
                                        <a href="#">
                                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/dislike.png" class="dislikeButton">
                                            <span class="textlike">Dislike</span>
                                        </a> -->
                                    </div> 
                                </div> 
                            </li>
                        </ol>
                    </div>
                </div>
                <script>
                    loadCSS("<?php echo Yii::app()->request->baseUrl; ?>/css/profile.css");
                </script>
                <footer class="footer">
                    <div class="txtfooter">Copyright &COPY; Wahapi, Powered by Colombia P&uacute;blica &REG;</div>
                </footer>
            </div>
        </div>
        <span id="error"></span>