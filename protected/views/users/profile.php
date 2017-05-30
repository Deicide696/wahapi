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
<div class="col-lg-6 col-md-6 col-sm-9 text-center">
    <div class="container-fluid">
        <div class="row">
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Status' => array('ajax' => $this->createUrl('users/status')),
                ),
                'options' => array(
                    'collapsible' => false,
                ),
            ));?>
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
                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/profile/arbolesWahapi.png"/>
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
    </div>
</div>
<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">a
</div>

<!-- ****************************-->
<!-- Modal Update Profile Picture-->
<!-- ****************************-->

<div class="modal fade" id="updateProfilePicture" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Actualiza tu foto de perfil</h4>
            </div>
            <div class="modal-body">
                <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/fineuploader-5.0.8.min.js"></script>
                <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/fineuploader-5.0.8.min.css" rel="stylesheet">

                <script>
                    $(document).ready(function () {
                        $('#updatePic').fineUploaderS3({
                            debug: true,
                            request: {
                                // REQUIRED: We are using a custom domain
                                // for our S3 bucket, in this case.  You can
                                // use any valid URL that points to your bucket.
                                endpoint: "devwahapi.s3.amazonaws.com",

                                // REQUIRED: The AWS public key for the client-side user
                                // we provisioned.

                                // User IAM
                                accessKey: "AKIAJWMVXAAA3GXWH6MQ",
                                params: {username:'123456789'}
                            },

                            template: "simple-previews-template",

                            // REQUIRED: Path to our local server where requests
                            // can be signed.
                            signature: {
                                endpoint: "<?php echo Yii::app()->request->baseUrl; ?>/fineuploader/s3.php"
                                // endpoint: "http://s372476563.onlinehome.us/fineuploader/html/templates/s3demo.php"
                            },

                            // OPTIONAL: An endpoint for Fine Uploader to POST to
                            // after the file has been successfully uploaded.
                            // Server-side, we can declare this upload a failure
                            // if something is wrong with the file.
                            uploadSuccess: {
                                // endpoint: "<?php echo Yii::app()->request->baseUrl; ?>/fineuploader/success.php"
                                endpoint: "<?php echo $this->createUrl('users/uploadProfilePic'); ?>"
                                // endpoint: "http://s372476563.onlinehome.us/fineuploader/html/templates/success.php"
                            },

                            // optional feature
                            validation: {
                                itemLimit: 1,
                                allowedExtensions: ['jpeg', 'jpg', 'gif', 'png'],
                                sizeLimit: 5242880 // 5 MB = 5 * 1024 * 1024 = 5.242.880 bytes
                            },

                            // thumbnails: {
                            //     placeholders: {
                            //         notAvailablePath: "images/not_available-generic.png",
                            //         waitingPath: "images/waiting-generic.png"
                            //     }
                            // }
                        })
                        .on('complete', function(event, id, name, responseJSON) {                
                            console.log(name);
                        });
                    });
                </script>

                <!-- Fine Uploader DOM Element -->
                <div id="updatePic"></div>

                <!-- Fine Uploader template -->
                <script type="text/template" id="simple-previews-template">
                    <div class="qq-uploader-selector qq-uploader">
                        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                            <span>Drop files here to upload</span>
                        </div>
                        <div class="btn qq-upload-button-selector qq-upload-button">
                            <div>Subir una foto</div>
                        </div>
                        <span class="qq-drop-processing-selector qq-drop-processing">
                            <span>Processing dropped files...</span>
                            <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
                        </span>
                        <ul class="qq-upload-list-selector qq-upload-list">
                            <li>
                                <div class="qq-progress-bar-container-selector">
                                    <div class="qq-progress-bar-selector qq-progress-bar"></div>
                                </div>
                                <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                                <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
                                <span class="qq-edit-filename-icon-selector qq-edit-filename-icon"></span>
                                <span class="qq-upload-file-selector qq-upload-file"></span>
                                <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                                <span class="qq-upload-size-selector qq-upload-size"></span>
                                <a class="qq-upload-cancel-selector btn-small btn-warning" href="#">Cancel</a>
                                <a class="qq-upload-retry-selector btn-small btn-info" href="#">Retry</a>
                                <a class="qq-upload-delete-selector btn-small btn-warning" href="#">Delete</a>
                                <a class="qq-upload-pause-selector btn-small btn-info" href="#">Pause</a>
                                <a class="qq-upload-continue-selector btn-small btn-info" href="#">Continue</a>
                                <span class="qq-upload-status-text-selector qq-upload-status-text"></span>
                                <a class="view-btn btn-small btn-info hide" target="_blank">View</a>
                            </li>
                        </ul>
                    </div>
                </script>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                <a type="button" class="btn btn-default" href="<?php echo Yii::app()->createUrl('users/home'); ?>">Actualizar</a>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>