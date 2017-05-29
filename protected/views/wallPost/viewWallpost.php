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
            <div id="allPost">
                <ul class="media-list">
                    <?php
                        // foreach ($posts as $post) 
                        // {
                            echo $post;
                        // }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">a
</div>