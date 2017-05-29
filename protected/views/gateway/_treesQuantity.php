
<h2>Cuantos arboles desea adoptar?</h2>
<div class="col-lg-4 col-lg-offset-2">
    <h3>Cantidad</h3>
    <input id="quantity" value="3" type="text">
</div>
<div class="col-lg-3 col-lg-offset-1">
    <h4>Valor árbol</h4>
    <p>$7.000</p>
    <br><br>
    <h4>Valor Total</h4>
    <p id="totalPrice">$ 21.000</p>
</div>
<div class="col-lg-12">
    <a href="<?php echo Yii::app()->createUrl('users/gateway') ?>" type="button" class="btn btn-default">Atrás</a>
    <button id="third_step" type="submit" class="btn btn-default">Enviar</button>
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

$("#quantity").blur(function() {

    var myQuantity = parseInt($(this).val());
    var priceUnit = parseInt('7000');
    if(myQuantity <= parseInt('<?php echo $treesQuantity ?>'))
    {
        if($(this).val() < 3)
        {
            alert('La cantidad minima para adoptar es de 3 arboles.');
            $(this).val('3');
            $('#totalPrice').text('$ 21.000');
        }
        else
        {
            console.log(myQuantity * priceUnit);
            $('#totalPrice').text('$ ' + conPuntos(myQuantity * priceUnit));
        }
    }
    else if($(this).val() === '')
    {
        $(this).val('3');
        $('#totalPrice').text('$ 21.000');
    }
    else
    {
        alert('No se puede adquirir esta cantidad. Para esta reserva solo quedan disponibles <?php echo $treesQuantity ?> arboles.');
        $(this).val('3');
        $('#totalPrice').text('$ 21.000');
    }
});

$('#third_step').click(function() {
    $.ajax({
        type: "POST",
        url: "<?php echo Yii::app()->createUrl('users/generateOrder') ?>",
        data: {'reserveId' : "<?php echo $reserveId ?>", 'quantity' : $('#quantity').val()},
        beforeSend: function()
        {
            $('#third_step').attr('disabled', true);
        },
        success: function(data)
        {
            $("#main-gateway").empty();
            $("#main-gateway").append(data);

            $('#btn-third').removeClass('active');
            $('#btn-third').attr('disabled', true);
            
            $('#btn-fourth').attr('disabled', false);
            $('#btn-fourth').addClass('active');
        }
    });
});
</script>