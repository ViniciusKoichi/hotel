<?php
    require_once("configuracao.php");
    require_once("classBancoDados.php");
    require_once("funcoesDiversas.php");

    echo "<link rel='stylesheet' href='../styles/retornoConsulta.css' type='text/css'>";
    echo "<script language='JavaScript'>function fecharFormulario() { location.href='index.php';}</script>";

    session_start();

    if(isset($_SESSION["USUARIO_LOGADO"]) && ($_SESSION["USUARIO_LOGADO"] == 1)) {
        $codigoHospede = $_SESSION["CODIGO_HOSPEDE"];
        $conexao_bd = new BancoDados($servidorMySQL);
    
        if(!$conexao_bd->abrirConexao()) {
            echo "<h2>Não foi possível conectar com o banco de dados do site</h2><br/>";
            echo $conexao_bd->getCodigoErro() . " -> " . $conexao_bd->getMensagemErro();
        } else {
            $campos = "hoteis.Endereco, hoteis.Numero, hoteis.Bairro, hoteis.Cidade, hoteis.UF, apartamentos.Numero_Apartamento, ". 
            "apartamentos.Valor_Diaria, DATE_FORMAT(historico_hospedagem.Inicio_Hospedagem, '%d/%m/%Y') AS DataEntrada, ". 
            "DATE_FORMAT(historico_hospedagem.Fim_Hospedagem, '%d/%m/%Y') AS DataSaida";
            $clausula = "(historico_hospedagem.Codigo_Hospede = $codigoHospede) AND (historico_hospedagem.Codigo_Apartamento = apartamentos.ID_Registro) AND (apartamentos.Codigo_Hotel = hoteis.Codigo_Hotel)";

            $conexao_bd->setSELECT($campos, "apartamentos,hoteis,historico_hospedagem");
            $conexao_bd->setWHERE($clausula);
            $conexao_bd->setORDER("historico_hospedagem.Inicio_Hospedagem");
            
            if($conexao_bd->execSELECT()) {
                $numeroRegistros = $conexao_bd->getTotalRegistros();
                $dataSet = $conexao_bd->getDataSet();
                
                if($numeroRegistros > 0) {
                    echo "<p class='tituloFormulario'>Histórico de Hospedagens</p>";
                    echo "<br/><br/>";
                    echo "<div class='retornoConsulta'>";
                    echo "<table>";
                    echo "<thead>";
                    echo "<tr><th>Apto</th><th>Endereço</th><th>Bairro</th><th>Cidade</th><th>UF</th><th>Entrada</th><th>Saída</th><th>Diária</th></tr></thead>";
                    echo "<tbody>";
                    while ($registros = $dataSet->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $registros["Numero_Apartamento"] . "</td>";
                        echo "<td>" . trim($registros["Endereco"]) . " - Número: " . trim($registros["Numero"]) . "</td>";
                        echo "<td>" . $registros["Bairro"] . "</td>";
                        echo "<td>" . $registros["Cidade"] . "</td>";
                        echo "<td>" . $registros["UF"] . "</td>";
                        echo "<td>" . $registros["DataEntrada"] . "</td>";
                        echo "<td>" . $registros["DataSaida"] . "</td>";
                        echo "<td>" .number_format(
                            $registros["Valor_Diaria"], 2, ",", "") . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<br/><br/>";
                    echo "<h3>Não existe histórico para exibição...</h3>";
                }
            } else {
                echo "<h2>Erro na execução comando SELECT...</h2>";
            }
        }

        $conexao_bd->fecharConexao();
    } else {
        echo "<h3>Para visualizar o histórico, efetue o login no sistema...</h3>";
    } 

    echo "<br><br>";
        echo "<button type='button' name='btnFechar' onclick='fecharFormulario()'>Fechar</button>"; 