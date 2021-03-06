
<div class="col-lg-5 col-lg-offset-1">
    <h3>Resumen de la adopción</h3>
	<div class="media" style="border:dashed 1px #d3d5d5; background: #f4f7f8; padding-top: 12px; padding-left: 12px;">
		<img class="media-object pull-left" src="<?php echo Yii::app()->request->baseUrl; ?>/images/reserve_thumb.png" />
	  	<div class="media-body" style="text-align: left;">
	    	<h5 class="media-heading">Reserva:</h5>
	    	<p><?php echo $model->name; ?></p>
	    	<h5 class="media-heading">Cantidad:</h5>
	    	<p><?php echo $treesQuantity; ?></p>
	    	<h5 class="media-heading">Valor:</h5>
	    	<p><?php echo $totalPrice; ?></p>
	  	</div>
	</div>
</div>
<div class="col-lg-4 col-lg-offset-1">
    <h3>Términos y condiciones</h3>
    <div class="panel panel-default" style="height:200px;overflow-y:auto;">
        <div class="panel-body text-justify">
            <strong>Condiciones de Pago</strong>
            <p>Antes de la aceptación por parte de Wahapi S.A.S de cualquier oferta de compra, el cliente 
            deberá elegir el medio de pago según los que se encuentran establecidos en este sitio. Aun cuando Wahapi S.A.S 
            ponga a disposición del cliente un sistema de conexión segura para toda la realización de todas las ofertas de 
            compra, en ningún caso Wahapi S.A.S será responsable por los fallos en las comunicaciones de las entidades bancarias
            o de crédito, o de la plataforma de Payu Latam, así como tampoco de los daños causados a los usuarios con ocasión 
            de una acción u omisión de dichas entidades.</p>
            <p>Una vez que Wahapi S.A.S verifique el pago, podrá proceder a la aceptación de la oferta de compra. En todo caso, 
            no obstante haberse verificado el pago, Wahapi S.A.S podrá denegar la aceptación de una oferta de compra o aceptarla 
            parcialmente, en cuyo caso sólo estará obligado a restituirle al usuario, sin ningún tipo de interés o rendimiento, 
            el valor cancelado por la oferta de compra no aceptada o el porcentaje correspondiente a la parte no aprobada de una 
            oferta de compra aceptada parcialmente. Wahapi S.A.S podrá facturar partes de una misma oferta de compra de manera 
            separada.</p>
            <p>El servicio de compras de Wahapi.com es exclusivo para los miembros de la red social Wahapi, cualquier transacción 
            realizada desde su cuenta de usuario se verá reflejada en su inventario personal de árboles y/o metros cuadrados de 
            tierra una vez comprobado el pago, por lo tanto sin importar el medio de pago empleado e el nombre de la persona que 
            realice la transacción, la asignación de los productos y/o servicios serán adjudicados automáticamente al usuario a 
            través del cual se ingresó a la pasarela de compras de wahapi.com</p>

            <strong>Información para pagos</strong>
            <p>Dentro de las alternativas que se contemplan en este sitio para la cancelación de los productos y/o servicios 
            seleccionados por el usuario, Wahapi.com ofrece,  un vínculo (link) que comunica con Payu Latam quien a su vez comunica 
            al usuario con las respectivas entidades financieras, en las cuales se procede a realizar el pago, y por consiguiente, 
            en tales eventos el manejo de la información personal será de responsabilidad exclusiva de Payu Latam y la entidad 
            financiera, según lo establecido en sus acuerdos con los usuarios.</p>

            <strong>Exoneración de Responsabilidad</strong>
            <p>Siempre que no se haya notificado oportunamente por parte del usuario la existencia de la violación de su información 
            personal, o cuando el usuario no haya procedido a notificar a las correspondientes entidades financieras o cooperativas 
            de la pérdida, uso indebido, sustracción o hurto de los instrumentos conferidos por éstas para realizar transacciones, o 
            cuando se realice un uso indebido de sus datos de registro, Wahapi S.A.S no asume ninguna responsabilidad por tales acciones.</p>
        </div>
    </div>
    <div class="checkbox">
        <label>
            <input type="checkbox"> He leido y acepto los términos y condiciones
        </label>
    </div>
</div>
<div class="col-lg-12">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

        <div class="form-group">
            <?php echo $form->labelEx($paymentModel,'primaryAccountNumber'); ?>
            <?php echo $form->textField($paymentModel,'primaryAccountNumber', array('class' => 'form-control', 'placeholder'=>'Número de la Tarjeta de Credito')); ?>
            <?php echo $form->error($paymentModel,'primaryAccountNumber'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($paymentModel,'cardHolderName'); ?>
            <?php echo $form->textField($paymentModel,'cardHolderName', array('class' => 'form-control', 'placeholder'=>'Nombre')); ?>
            <?php echo $form->error($paymentModel,'cardHolderName'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($paymentModel,'expirationMonth'); ?>
            <?php echo $form->dropDownList($paymentModel,'expirationMonth', array('01'=>'01', '02'=>'02', '03' => '03', '04' => '04', '05' => '05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12'), array('class'=>'form-control')); ?>
            <?php echo $form->error($paymentModel,'expirationMonth'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($paymentModel,'expirationYear'); ?>
            <?php echo $form->dropDownList($paymentModel,'expirationMonth', array('2017'=>'2017', '2018'=>'2018', '2019' => '2019', '2020' => '2020', '2021' => '2021', '2022' => '2022', '2023' => '2023', '2024' => '2024', '2025' => '2025', '2026' => '2026', '2027' => '2027', '2028' => '2028'), array('class'=>'form-control')); ?>
            <?php echo $form->error($paymentModel,'expirationYear'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($paymentModel,'cvc'); ?>
            <?php echo $form->textField($paymentModel,'cvc', array('class' => 'form-control', 'placeholder'=>'CVC')); ?>
            <?php echo $form->error($paymentModel,'cvc'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->hiddenField($paymentModel,'amount', array('value' => $totalPrice)); ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton('Procesar pago', array('class' => 'btn btn-warning')); ?>
        </div>

    <?php $this->endWidget(); ?>
</div>
<script>
function conPuntos(valor) {
    var nums = new Array();
    var simb = "."; //Éste es el separador
    valor = valor.toString();
    valor = valor.replace(/\D/g, "");   //Ésta expresión regular solo permitira ingresar números
    nums = valor.split(""); //Se vacia el valor en un arreglo
    var long = nums.length - 1; // Se saca la longitud del arreglo
    var patron = 3; //Indica cada cuanto se ponen las comas
    var prox = 2; // Indica en que lugar se debe insertar la siguiente coma
    var res = "";
 
    while (long > prox) {
        nums.splice((long - prox),0,simb); //Se agrega la coma
        prox += patron; //Se incrementa la posición próxima para colocar la coma
    }
 
    for (var i = 0; i <= nums.length-1; i++) {
        res += nums[i]; //Se crea la nueva cadena para devolver el valor formateado
    }
 
    return res;
}
</script>