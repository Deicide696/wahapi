<?php
    $this->renderPartial("//users/_panel-left-home", array(
        "profileImage" => $profileImage)
    );

    $this->renderPartial("//users/_main-menu");
?>
<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
    a
</div>
<div class="col-lg-9 col-md-9 col-sm-9">
    <br><br>
    <hr>
    <span class="white" style="padding: 2px 15px 5px 15px;background-color: #86b703;">Galeria de Imágenes</span><img style="vertical-align:text-top; margin-top: -2px;margin-left: -4px;"src="<?php echo Yii::app()->request->baseUrl; ?>/images/hojas.png">
    <div class="container-fluid">
        <br>
        <script>
            loadCSS("//blueimp.github.io/Gallery/css/blueimp-gallery.min.css");
            loadCSS("<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-image-gallery.min.css");
        </script>
        <!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
        <div id="blueimp-gallery" class="blueimp-gallery">
            <!-- The container for the modal slides -->
            <div class="slides"></div>
            <!-- Controls for the borderless lightbox -->
            <h3 class="title"></h3>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="close">×</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
            <!-- The modal dialog, which will be used to wrap the lightbox content -->
            <div class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body next"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left prev">
                                <i class="glyphicon glyphicon-chevron-left"></i>
                                Anterior
                            </button>
                            <button type="button" class="btn btn-success next">
                                Siguiente
                                <i class="glyphicon glyphicon-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="links">
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_01.jpg" title="Lo importante es la voluntad de salir adelante" data-gallery>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_thumb_01.jpg" alt="Lo importante es la voluntad de salir adelante">
            </a>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_02.jpg" title="Puk" data-gallery>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_thumb_02.jpg" alt="Puk">
            </a>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_03.jpg" title="Breakfast" data-gallery>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_thumb_03.jpg" alt="Breakfast">
            </a>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_04.jpg" title="Angry face" data-gallery>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_thumb_04.jpg" alt="Angry face">
            </a>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_05.jpg" title=":)" data-gallery>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_thumb_05.jpg" alt=":)">
            </a>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_06.jpg" title="Salento" data-gallery>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_thumb_06.jpg" alt="Salento">
            </a>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_07.jpg" title="Neusa" data-gallery>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_thumb_07.jpg" alt="Neusa">
            </a>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_08.jpg" title="Amazon Webservices" data-gallery>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_thumb_08.jpg" alt="Amazon Webservices">
            </a>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_09.jpg" title="Con empanadirris" data-gallery>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_thumb_09.jpg" alt="Con empanadirris">
            </a>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_10.jpg" title="Night" data-gallery>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_thumb_10.jpg" alt="Night">
            </a>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_11.jpg" title="Dante" data-gallery>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_thumb_11.jpg" alt="Dante">
            </a>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_12.jpg" title="Colombia 2 - 0 Uruguay" data-gallery>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_thumb_12.jpg" alt="Colombia 2 - 0 Uruguay">
            </a>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_13.jpg" title="Pereira" data-gallery>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_thumb_13.jpg" alt="Pereira">
            </a>
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_14.jpg" title="Warrior" data-gallery>
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/imgcp_thumb_14.jpg" alt="Warrior">
            </a>
        </div>
    </div>
</div>
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-image-gallery.min.js"></script>