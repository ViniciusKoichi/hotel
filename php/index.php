<?php
    require_once("configuracao.php"); 
    require_once("classBancoDados.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

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

        <script>
            function carregar(pagina){$("#conteudo").load(pagina);}
            function showOptions() {
                opcoes.classList.add('show')
            }
            function removeOptions() {
                opcoes.classList.remove('show')
            }
        </script>

        <!-- Calendário -->
        <script>
            $(function () {
                $("#calendario").datepicker({
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

        <title>Hoteis Orvalho</title>
    </head>
    <body>
        <header class="cabecalho">
            <nav class="cabecalho__menu">
                <div class="cabecalho__menu__botao">
                    <a class="cabecalho__menu__link" href="#conteudo" onclick="carregar('formConsultaApartamentos.html')">Consulta</a>
                </div>
                <div class="cabecalho__menu__botao">
                    <a onclick="showOptions()" class="cabecalho__menu__link">Cadastro</a>
                    <div id="opcoes" class="cabecalho__menu__link__opcoes">
                        <a onclick="carregar('formCadastraHospede.php'),removeOptions()" href="#conteudo">Adicionar cliente</a>
                        <a onclick="removeOptions()" href="#">Editar cliente</a>
                    </div>
                </div>
                <div class="cabecalho__menu__botao">
                    <a class="cabecalho__menu__link" href="#">Reserva</a>
                </div>
                <div class="cabecalho__menu__botao">
                    <a class="cabecalho__menu__link" href="#">Hitórico</a>
                </div>
                <div class="cabecalho__menu__botao">
                    <a class="cabecalho__menu__link" href="#">Login</a>
                </div>
            </nav>
        </header>

        <main class="apresentacao">
            <div class="img__hotel">
                <h1>HOTEIS ORVALHO</h1>
                <img class="img__faixada" src="../assets/faixada.jpg" alt="" />
            </div>
            <section class="apresentacao__conteudo">
                <div class="coluna__esquerda">
                    <?php
                        $conexao_bd = new BancoDados($servidorMySQL);
                        if(!$conexao_bd->abrirConexao()) {
                            echo "<p>Erro na conexão com o banco de dados!</br>" . $conexao_bd->getMensagemErro() . "</p>";
                        } else {
                            $conexao_bd->setSELECT("*", "hoteis");
                            $conexao_bd->setORDER("UF, Cidade");
                            if($conexao_bd->execSELECT()) {
                                $numeroRegistros = $conexao_bd->getTotalRegistros();
                                $dataSet = $conexao_bd->getDataSet();
                                if($numeroRegistros > 0) {
                                    while($registros = $dataSet->fetch_assoc()) {
                                        $enderecoHotel = "<div class='coluna__esquerda__hoteis'><p>" . trim($registros    ["Endereco"]) . " - Número: " . trim($registros["Numero"]) . "<br/>";
                                        $enderecoHotel .= trim($registros["Bairro"]) . " - " . $registros["Cidade"] . "<br/>";
                                        $enderecoHotel .= $registros["UF"] . " - Fone: " . $registros["Telefone"] . "<br/></p></div>";
                                        echo $enderecoHotel;
                                    }
                                }
                            } else {
                                echo "<p>Erro de execução do comando SELECT<p/>";
                            }
                        }
                        $conexao_bd->fecharConexao();
                    ?>
                </div>
                <div class="coluna__central" id="conteudo"></div>
                <div class="coluna__direita">
                    <div class="calendario" id="calendario"></div>
                </div>
            </section>
        </main>

        <footer class="rodape">
            <p>Desenvolvido por Vinícius Koichi</p>
        </footer>
    </body>
</html>