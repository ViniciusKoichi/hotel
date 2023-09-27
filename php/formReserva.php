<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <!-- Css -->
        <link rel="stylesheet" href="../styles/style.css" /> 

         <!-- Scripts -->
        <!-- <script src="../scripts/jquery-3.7.1.js"></script> -->
        <script
            src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
            crossorigin="anonymous"
        ></script>
        <script
            src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"
            integrity="sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY="
            crossorigin="anonymous"
        ></script>
        <link rel="stylesheet" href="../scripts/jquery-ui.css" />

        <!-- Calendário -->
        <script>
            $(function () {
                $(".calendario").datepicker({
                    showOn: "button",
                    buttonImage: "../assets/calendario-icon.png",
                    buttonImageOnly: true,
                    changeMonth: true,
                    changeYear: true,
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    dateFormat: "dd/mm/yy",
                    dayNames: [
                        "Domingo",
                        "Segunda",
                        "Terça",
                        "Quarta",
                        "Quinta",
                        "Sexta",
                        "Sábado",
                        "Domingo",
                    ],
                    dayNamesMin: ["D", "S", "T", "Q", "Q", "S", "S", "D"],
                    dayNamesShort: [
                        "Dom",
                        "Seg",
                        "Ter",
                        "Qua",
                        "Qui",
                        "Sex",
                        "Sab",
                        "Dom",
                    ],
                    monthNames: [
                        "Janeiro",
                        "Fevereiro",
                        "Março",
                        "Abril",
                        "Maio",
                        "Junho",
                        "Julho",
                        "Agosto",
                        "Setembro",
                        "Outubro",
                        "Novembro",
                        "Dezembro",
                    ],
                    monthNamesShort: [
                        "Jan",
                        "Fev",
                        "Mar",
                        "Abr",
                        "Mai",
                        "Jun",
                        "Jul",
                        "Ago",
                        "Set",
                        "Out",
                        "Nov",
                        "Dez",
                    ],
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $("#btnConfirmar").click(function() {
                    var codigoHotel = $("select[name = hotel]").val();
                    var numeroApartamento = $("input[name = apartamento]").val();
                    var dataEntrada = $("input[name = dataEntrada]").val();
                    var dataSaida = $("input[name = dataSaida]").val();

                    $.ajax({
                        url: "efetivarReserva.php",
                        dataType: "html",
                        data: {
                            "codigoHotel":codigoHotel,
                            "numeroApartamento":numeroApartamento,
                            "dataEntrada":dataEntrada,
                            "dataSaida":dataSaida
                        },
                        success: function(response) {
                            $("div#retorno").html(response);
                            //setTimeout("location.href = 'index.php'", 5000);
                        }
                    });
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $("#btnCancelar").click(function() {
                    $(location).attr("href", "index.php");
                });
            });
        </script>
    <title>Reserva Apartamento</title>
</head>
<body>
    <?php
        if(isset($_SESSION["USUARIO_LOGADO"]) && ($_SESSION["USUARIO_LOGADO"] == 1)) {
            $codigoHospede = $_SESSION["CODIGO_HOSPEDE"];
        } else {
            $codigoHospede = "";
        }
    ?>

    <div class="formulario" id="formulario">
        <p class="tituloFormulario">
            Reserva de apartamento
        </p>
        <form method="post" name="formReserva" action="efetivarReserva.php" class="formReserva">
            <?php
                if($codigoHospede != "") {
            ?>
            Hotel:
            <?php
                require_once 'funcoesDiversas.php';
                echo listaHoteis();
            ?>
            <p>Apartamento: <input type="text" name="apartamento" tabindex="2" size="2" maxlength="2"></p>
            <p>Data de entrada: <input type="text" name="dataEntrada" tabindex="3" size="10" maxlength="10"> Data de saída: <input type="text" name="dataSaida" tabindex="4" size="10" maxlength="10"></p>
            <button type="button" name="btnConfirmar" id="btnConfirmar">Continuar</button>
            <input type="reset" name="btnCancelar" id="btnCancelar" value="Cancelar"><br><br>
            <?php
                } else { 
            ?>
            <p>Para efetuar uma reserva, você precisa estar logado no sistema!</p>
            <input type="reset" name="btnFechar" value="Fechar" id="btnCancelar"><br><br>
            <?php
                }
            ?>
        </form>
        <div id="retorno"></div>
    </div>
</body>
</html>