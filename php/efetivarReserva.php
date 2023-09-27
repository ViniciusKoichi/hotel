<?php
require_once 'configuracao.php';
require_once 'classBancoDados.php';
require_once 'funcoesDiversas.php';

session_start();

$hotel = $_REQUEST["codigoHotel"];
$apartamento = $_REQUEST["numeroApartamento"];
$dataEntrada = $_REQUEST["dataEntrada"];
$dataSaida = $_REQUEST["dataSaida"];
$erroDados = FALSE; 
$mensagemErro = "";

if(trim($hotel) == "") {
    $erroDados = TRUE;
    $mensagemErro .= "<h3>Nenhum hotel selecionado...</h3>";
}

if(trim($apartamento) == "") {
    $erroDados = TRUE;
    $mensagemErro .= "<h3>Nenhum apartamento informado...</h3>";
}

if(trim($dataEntrada) == "") {
    $erroDados = TRUE;
    $mensagemErro .= "<h3>Data de entrada não fornecida...</h3>";
}

if(trim($dataSaida) == "") {
    $erroDados = TRUE;
    $mensagemErro .= "<h3>Data de saída não fornecida...</h3>";
}

if(!$erroDados) {
    $conexao_bd = new BancoDados($servidorMySQL); 

    if (!$conexao_bd->abrirConexao()) {
        echo "<h3>Erro na conexão com o banco de dados!" . $conexao_bd->getMensagemErro() . "</h3>";
    } else {
        $clausula = "(Codigo_Hotel = $hotel) AND (Numero_Apartamento = $apartamento) AND (Ocupado = 'N')";
        $conexao_bd->setSELECT("ID_Registro", "apartamentos");
        $conexao_bd->setWHERE($clausula);

        if($conexao_bd->execSELECT()) {
            $numeroRegistros = $conexao_bd->getTotalRegistros();

            if($numeroRegistros == 0) {
                echo "<h3>Apartamento não disponível...</h3>";
            } else {
                $dadosRegistros["Ocupado"] = "'S'";
                $dadosRegistros["Inicio_Hospedagem"] = campoTexto(DataInvertida($dataEntrada));
                $dadosRegistros["Fim_Hospedagem"] = campoTexto(DataInvertida($dataSaida));
                $dadosRegistros["Codigo_Hospede"] = $_SESSION["CODIGO_HOSPEDE"];
                

                $clausula = "Codigo_Hotel = $hotel AND Numero_Apartamento = $apartamento";
                $conexao_bd->setUPDATE($dadosRegistros, "apartamentos");
                $conexao_bd->setWHERE($clausula);

                if(!$conexao_bd->execUPDATE()) {
                    echo "<h3>Erro na execução do comando UPDATE</h3>";
                } else {
                    echo "<h3>Reserva efetuada com sucesso!</h3>";
                }
            }
        }
    }
    $conexao_bd->fecharConexao();
} else {
    echo $mensagemErro;
}