<?php
    require_once("configuracao.php");
    require_once("classBancoDados.php");
    require_once("funcoesDiversas.php");

    $conexao_bd = new BancoDados($servidorMySQL);

    if(!$conexao_bd->abrirConexao()) {
        echo "<h2>Não foi possível conectar com o banco de dados do site</h2><br/>";
        echo $conexao_bd->getCodigoErro() . " -> " . $conexao_bd->getMensagemErro();
    } elseif($_REQUEST["DataEntrada"] != "") {
       $data = DataInvertida($_REQUEST["DataEntrada"]);
       $campos = "apartamentos.ID_Registro,apartamentos.Codigo_Hotel,apartamentos.Numero_Apartamento,apartamentos.Valor_Diaria," . "hoteis.Endereco,hoteis.Numero,hoteis.Bairro,hoteis.Cidade,hoteis.UF,hoteis.Telefone";
       $clausula = "((apartamentos.Ocupado = 'N')"
               . " OR (apartamentos.Fim_Hospedagem < '$data'))"
               . " AND (apartamentos.Tipo_Apartamento = " . $_REQUEST["TipoApartamento"] . ")"
               . " AND (apartamentos.Tipo_Acomodacao = " . $_REQUEST["TipoAcomodacao"] . ")"
               . " AND (apartamentos.Quantidade_Cama = " . $_REQUEST["Camas"] . ")";
       if($_REQUEST["TV"] == "S") {
           $clausula .= " AND (apartamentos.Tem_TV = 'S')";
       }
       if($_REQUEST["Frigobar"] == "S") {
           $clausula .= " AND (apartamentos.Tem_Frigobar = 'S')";
       }
       if($_REQUEST["Banheira"] == "S") {
           $clausula .= " AND (apartamentos.Tem_Banheira = 'S')";
       }
       if($_REQUEST["Escrivaninha"] == "S") {
           $clausula .= " AND (apartamentos.Tem_Escrivaninha = 'S')";
       }
       $clausula .= " AND (apartamentos.Codigo_Hotel = hoteis.Codigo_Hotel)";
       
       $conexao_bd->setSELECT($campos, "apartamentos,hoteis");
       $conexao_bd->setWHERE($clausula);
       $conexao_bd->setORDER("apartamentos.Codigo_Hotel,apartamentos.Numero_Apartamento");
       
       if($conexao_bd->execSELECT()) {
           $numeroRegistros = $conexao_bd->getTotalRegistros();
           $dataSet = $conexao_bd->getDataSet();
           
           if($numeroRegistros > 0) {
               echo "<br/><br/>";
               echo "<div class='retornoConsulta'>";
               echo "<table>";
               echo "<thead>";
               echo "<tr><th>Apto</th><th>Endereço</th><th>Bairro</th><th>Cidade</th><th>UF</th><th>Telefone</th></tr></thead>";
               echo "<tbody>";
               while ($registros = $dataSet->fetch_assoc()) {
                   echo "<tr>";
                   echo "<td>" . $registros["Numero_Apartamento"] . "</td>";
                   echo "<td>" . trim($registros["Endereco"]) . " - Número: " . trim($registros["Numero"]) . "</td>";
                   echo "<td>" . $registros["Bairro"] . "</td>";
                   echo "<td>" . $registros["Cidade"] . "</td>";
                   echo "<td>" . $registros["UF"] . "</td>";
                   echo "<td>" . $registros["Telefone"] . "</td>";
                   echo "</tr>";
               }
               echo "</tbody>";
               echo "</table>";
               echo "</div>";
           } else {
               echo "<br/><br/>";
               echo "<h3>Não existem vagas disponíveis...</h3>";
           }
       } else {
           echo "<h2>Erro na execução comando SELECT...</h2>";
       }
    }

    $conexao_bd->fecharConexao();