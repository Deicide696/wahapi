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
        Mis Arboles / Terrenos
    </span>
    <img style="vertical-align:text-top; margin-top: -2px;margin-left: -4px;"src="<?php echo Yii::app()->request->baseUrl; ?>/images/hojas.png">
    <div class="container-fluid">
        <br>
        <img class="img-responsive thumbnail" src="http://maps.googleapis.com/maps/api/staticmap?center=Pueblo+rico,+Risaralda&zoom=9&scale=false&size=510x270&maptype=hybrid&sensor=false&format=png&visual_refresh=true&markers=size:mid%7Ccolor:red%7Clabel:%7CPueblo+rico,+Risaralda" alt="Google Map of Pueblo rico, Risaralda">
        <div class="row">
            <div class="col-lg-12">
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="<?php echo Yii::app()->request->baseUrl; ?>/images/tree.png" alt="...">
                    </a>
                    <div class="media-body">
                        <div class="col-lg-6">
                            <h4 class="media-heading">Nombre común:</h4>
                            Cecropia palmata
                        </div>
                        <div class="col-lg-6">
                            <h4 class="media-heading">Número de arboles:</h4>
                            100
                        </div>
                        <div class="col-lg-12" style="margin-top:10px;">
                            <h4 class="media-heading">Descripción:</h4>
                            <p id="desc">Cecropia palmata, creciendo en el Valle de Intag, Reserva Ecológica Alto Choco, Provincia de Imbabura.  La Cecropia es parte de un género que incluye unas 25 otras especies.  Todos estan árboles altas, pero con vida corta (desde 25 hasta 30 años.)  El característica más notable de la Cecropia, que es nativo en los bosques nublados y selvas tropicales, es sus hojas gigantes, que medida hasta 50 centimetros de ancha, y que cambian al color plata por parte arriba cuando el árbol es maduro.  Las Cecropias tiene vida corta por sus troncos vacíos y raizes poco profundo, que hacen el árbol menos resistante á tormentos y dañados durante el invierno.  Para combatir eso, las Cecropias crecen muy rápido, y estan entre 10 y 20 metros alta en solo trés ó cuatro años.  En el bosque nublado, las frutas de las Cecropias proveen comida para muchas diferentes pajaros y mamiferas pequeñas, y además el Oso Anteojos, Tremarctos ornatus, que es un especie en peligro.</p>                            
                        </div>
                    </div>
                </div>
                <h4>Nombre de árbol/grupo de arboles</h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="badge">14</span>
                        Cras justo odio
                    </li>
                    <li class="list-group-item">
                        <span class="badge">14</span>
                        Cras justo odio
                    </li>
                    <li class="list-group-item">
                        <span class="badge">14</span>
                        Cras justo odio
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-3">
    <br><br>
    <a href="<?php echo Yii::app()->createUrl('users/gateway'); ?>">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/compra_arboles.png"/>
    </a>
    <br><br>
    <a href="<?php echo Yii::app()->createUrl('users/gateway'); ?>">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/protege_metro.png"/>
    </a>
</div>