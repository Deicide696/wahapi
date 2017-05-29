<form method="post" id="complaintForm">
	<input type="text" placeholder='Escribe tu denuncio aquí' id="denuncio" name="status">
	<input type="button" class="greenButton" id='complaintButton' value="Denunciar">
</form>

<script>   
$(function(){
 $("#complaintButton").click(function(){
 	var url = "../wallpost/complaint"; // El script a dónde se realizará la petición.
    $.ajax({
		type: "POST",
        url: url,
        data: $("#complaintForm").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(data)
        {
            $('#status').val('');
            $("#allPost").html(data); // Mostrar la respuestas del script PHP.
        }
    });

    return false; // Evitar ejecutar el submit del formulario.
 });
});
</script>