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

        <script>
            $(document).ready(function () {
                $("#btnConfirmar").click(function () {
                    var nomeHospede = $("input[name = nomeHospede]").val();
                    var diaNascimento = $("input[name = diaNascimento]").val();
                    var mesNascimento = $("input[name = mesNascimento]").val();
                    var anoNascimento = $("input[name = anoNascimento]").val();
                    var numeroCPF = $("input[name = numeroCPF]").val();
                    var numeroRG = $("input[name = numeroRG]").val();
                    var endereco = $("input[name = endereco]").val();
                    var numero = $("input[name = numero]").val();
                    var complemento = $("input[name = complemento]").val();
                    var bairro = $("input[name = bairro]").val();
                    var cidade = $("input[name = cidade]").val();
                    var estado = $("select[name = estado]").val();
                    var cep = $("input[name = cep]").val();
                    var telefone = $("input[name = telefone]").val();
                    var celular = $("input[name = celular]").val();
                    var empresa = $("input[name = empresa]").val();
                    var nomeUsuario = $("input[name = nomeUsuario]").val();
                    var senhaAcesso = $("input[name = senhaAcesso]").val();
                    var email = $("input[name = email]").val();
                    
                    $.ajax({
                        url: "incluirHospede.php",
                        dataType: "html",
                        data: {
                            nomeHospede: nomeHospede,
                            diaNascimento: diaNascimento,
                            mesNascimento: mesNascimento,
                            anoNascimento: anoNascimento,
                            numeroCPF: numeroCPF,
                            numeroRG: numeroRG,
                            endereco: endereco,
                            numero: numero,
                            complemento: complemento,
                            bairro: bairro,
                            cidade: cidade,
                            estado: estado,
                            cep: cep,
                            telefone: telefone,
                            celular: celular,
                            empresa: empresa,
                            nomeUsuario: nomeUsuario,
                            senhaAcesso: senhaAcesso,
                            email: email,
                        },
                        success: function (response) { 
                            $("div#retorno").html(response);
                        },
                    });
                });
            });
        </script>

        <script language="JavaScript">
            function fecharFormulario() {
                location.href="index.php";
            }
        </script>

    <title>Cadastro de Hospedes</title>
</head>
<body>
    <div class="formulario" id="formulario">
        <p class="tituloFormulario">
            Cadastro de Hospede
        </p>
        <form name="formCadastraHospede">
            <p>Nome: <input type="text" name="nomeHospede" tabindex="1" size="50" maxlength="50"></p>
            <p>Data de Nascimento: <input type="text" name="diaNascimento" tabindex="2" size="2" maxlength="2">/<input type="text" name="mesNascimento" tabindex="3" size="2" maxlength="2">/<input type="text" name="anoNascimento" tabindex="3" size="4" maxlength="4"></p>
            <p>RG: <input type="text" name="numeroRG" tabindex="5" size="12" maxlength="12"/> CPF: <input type="text" name="numeroCPF" tabindex="6" size="14" maxlength="14"></p>
            <p>Endereço: <input type="text" name="endereco" tabindex="7" size="50" maxlength="50"> Número: <input type="text" name="numero" tabindex="8" size="10" maxlength="10"></p>
            <p>Compl.: <input type="text" name="complemento" tabindex="9" size="20" maxlength="20"> Bairro: <input type="text" name="bairro" tabindex="10" size="40" maxlength="40"></p>
            <p>Cidade: <input type="text" name="cidade" tabindex="11" size="40" maxlength="40"> Estado: 
            <?php
                require_once 'funcoesDiversas.php';
                echo estados(12);
            ?>
            </p> 
            <p>CEP: <input type="text" name="cep" tabindex="13" size="9" maxlength="9"> Telefone: <input type="text" name="telefone" tabindex="14" size="18" maxlength="18"> Celular: <input type="text" name="celular" tabindex="15" size="18" maxlength="18"></p>
            <p>Empresa onde Trabalha: <input type="text" name="empresa" tabindex="16" size="50" maxlength="50"></p>
            <p>Nome usuário: <input type="text" name="nomeUsuario" tabindex="17" size="20" maxlength="20"> Senha: <input type="password" name="senhaAcesso" tabindex="18" size="12" maxlength="12"></p>
            <p>Email: <input type="text" name="email" tabindex="19" size="80" maxlength="80"></p>
            <button type="button" name="btnConfirmar" id="btnConfirmar">Confirmar</button>
            <button 
                type="button" 
                name="btnCancelar" 
                onclick="fecharFormulario()"
                >Cancelar</button>
        </form>
    </div>
    <div id="retorno"></div>
</body>
</html>
