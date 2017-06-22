
<div class="container-fluid" style="background-color:#e7e7ec;">
    <div class="row">
        <div class="container text-center" style="background-color:white;">
            <div class="col-md-12" style="padding-left: 200px; padding-right: 200px;">
                <div class="col-md-3">
                    <button id="btn-first" type="button" class="btn btn-default active">
                        1. Selección
                    </button>
                </div>
                <div class="col-md-3">
                    <button id="btn-second" type="button" class="btn btn-default" disabled>
                        2. Ubicación reserva
                    </button>
                </div>
                <div class="col-md-3">
                    <button id="btn-third" type="button" class="btn btn-default" disabled>
                        3. Cantidad
                    </button>
                </div>
                <div class="col-md-3">
                    <button id="btn-fourth" type="button" class="btn btn-default" disabled>
                        4. Realizar pago
                    </button>
                </div>
            </div>
            <style>
                input[type="radio"]{
                    /*display: none;*/
                }

                input[type="radio"] + label span{
                    display: inline-block;
                    width: 178px;
                    height: 186px;
                    background: url(/wahapi.com/images/compra_arboles.png) left top no-repeat;
                }
            </style>
            <div class="col-md-12" style="padding-top:50px;" disabled>
                <div id="main-gateway">
                    <h2>Seleccione: <br> Adoptar arboles o Protejer metro cuadrado</h2>
                    <div class="col-lg-6">
                        <div class="radio select-tree-land">
                            <input type="radio" name="optionsSelectTreeLand" id="select-tree" value="tree">
                            <label for="select-tree">
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="radio select-tree-land">
                            <input type="radio" name="optionsSelectTreeLand" id="select-land" value="land">
                            <label for="select-land">                            
                                <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/protege_metro.png" alt="">
                            </label>
                        </div>            
                    </div>
                    <div class="col-lg-12">
                        <button id="firts_step" type="submit" class="btn btn-default" disabled>Enviar</button>
                    </div>
                </div>
            </div>
            <script>
            $('#select-tree, #select-land').click(function() {
                $('#firts_step').removeAttr('disabled');
                console.log($('input[name=optionsSelectTreeLand]:checked').val());
            });

            $('#firts_step').click(function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->createUrl('users/getReservesOrLands') ?>",
                    data: {"optionsSelected" : $('input[name=optionsSelectTreeLand]:checked').val()},
                    beforeSend: function()
                    {
                        $('#firts_step').attr('disabled', true);
                    },
                    success: function(data)
                    {
                        $("#main-gateway").empty();
                        $("#main-gateway").append(data);

                        $('#btn-first').removeClass('active');
                        $('#btn-first').attr('disabled', true);
                        
                        $('#btn-second').attr('disabled', false);
                        $('#btn-second').addClass('active');
                    }
                });
            });
            </script>
        </div>
    </div>
</div>