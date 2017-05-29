
<h2>Seleccione: La ubicación donde quiere adoptar los arboles</h2>
<div class="col-lg-4 col-lg-offset-2">
    <select multiple class="form-control">
        <?php
            $i = 0;
            foreach ($model as $reserve)
            {
                if($i === 0)
                {
                    echo "<option value='" . $reserve['id'] . "' alt='" . $reserve['description'] . "'selected>" . $reserve['name'] . "</option>";
                    $i++;
                }
                else
                {
                    echo "<option value='" . $reserve['id'] . "' alt='" . $reserve['description'] . "'>" . $reserve['name'] . "</option>";
                }
            }
        ?>
    </select>
</div>
<div class="col-lg-3 col-lg-offset-1">
    <div class="thumbnail">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/reserve.png" alt="...">
        <div class="caption">
            <h3><?php echo $model[0]['name']; ?></h3>
            <p>...</p>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <a href="<?php echo Yii::app()->createUrl('users/gateway') ?>" type="button" class="btn btn-default">Atrás</a>
    <button id="second_step" type="submit" class="btn btn-default">Enviar</button>
</div>
<script>
$("select").change(function () {
    var newName = "";
    var newDescription = "";
    $( "select option:selected" ).each(function() {
        newName += $(this).text() + " ";
        newDescription += $(this).attr('alt') + " ";
    });
    
    $( "div.caption h3" ).text(newName);
    $( "div.caption p" ).text(newDescription);
}).change();

$('#second_step').click(function() {
    $.ajax({
        type: "POST",
        url: "<?php echo Yii::app()->createUrl('users/getTreesQuantity') ?>",
        data: {"reserveSelected" : $('option:selected').val()},
        beforeSend: function()
        {
            $('#second_step').attr('disabled', true);
        },
        success: function(data)
        {
            $("#main-gateway").empty();
            $("#main-gateway").append(data);

            $('#btn-second').removeClass('active');
            $('#btn-second').attr('disabled', true);
            
            $('#btn-third').attr('disabled', false);
            $('#btn-third').addClass('active');
        }
    });
});
</script>