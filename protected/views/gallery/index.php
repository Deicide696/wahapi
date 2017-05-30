<?php
    $this->renderPartial("//users/_panel-left-home", array(
        "profileImage" => $profileImage)
    );

    $this->renderPartial("//users/_main-menu", array(
        'newMessage' => $newMessage)
    );
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
            <?php
                foreach ($myPics as $pic)
                {
                    echo "<a href=\"" . Yii::app()->params['path_bucket'] . $pic->path . "\" title=\"Lo importante es la voluntad de salir adelante\" data-gallery>";
                    echo "<img src=\"" . Yii::app()->params['path_bucket'] . $pic->path . "\" alt=\"Lo importante es la voluntad de salir adelante\" height=\"15%\" width=\"15%\">";
                    echo "</a>";
                }
            ?>
        </div>
    </div>
</div>
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap-image-gallery.min.js"></script>