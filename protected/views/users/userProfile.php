<?php
    $this->renderPartial("//users/_panel-left-user", array(
        "model" => $model)
    );

    $this->renderPartial("//users/_main-menu-user", array(
        'model' => $model,
        'isFriendRequest' => $isFriendRequest)
    );
?>
<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
    <br><br>
</div>
<div class="col-lg-6 col-md-6 col-sm-9 text-center">
    <div class="container-fluid">        
        <div class="row">
            <?php 
                if($isFriend == 1)
                {
                    $userProfileId = $model->_id;
                    
                    $this->widget('zii.widgets.jui.CJuiTabs', array(
                        'tabs' => array(
                            'Status' => array('ajax' => $this->createUrl('users/status') . '?userProfileId=' . $userProfileId),
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
        <div class="row">
            <div id="allPost">
                <ul class="media-list">
                    <?php
                        foreach ($posts as $post) 
                        {
                            echo $post;
                        }
                    ?>
                </ul>
                <div id="posts">
                    <ol>
                        <li class="psbody">
                            <div class="psimg">
                                <?php
//                                    if(Yii::app()->user->getState('userId') === '66')
//                                    {
                                        echo '<img src="'. Yii::app()->request->baseUrl. '/images/profile/arbolesWahapi.png" />';
//                                    }
//                                    else if(Yii::app()->user->getState('userId') === '68')
//                                    {
//                                        echo '<img src="'. Yii::app()->request->baseUrl. '/images/profile/arbolesWahapi.png" width="100px" height="100px"/>';
//                                    }
                                ?>
                            </div>
                            <div class="pstext">
                                <div class="psuser">
                                    <strong>Bienvenido a Wahapi</strong>
                                </div>
                                Esto es Wahapi! Acabas de unirte a la primera nueva red social dedicada a la protecci&oacute;n y conservaci&oacute;n del medio ambiente.
                            </div> 
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <?php 
                }
        ?>
        <footer class="footer">
            <div class="txtfooter">Copyright &COPY; Wahapi, Powered by Colombia P&uacute;blica &REG;</div>
        </footer>
    </div>
</div>
<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">a
</div>