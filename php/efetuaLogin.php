<?php 

require_once 'configuracao.php';
require_once 'classBancoDados.php';
require_once 'funcoesDiversas.php';

session_start();

if($_SESSION["USUARIO_LOGADO"] == 1) {
    echo "<h3>Usuário já logado no sistema...</h3>";    
} else {
    $conexao_bd = new BancoDados($servidorMySQL);

    if (!$conexao_bd->abrirConexao()) {
        echo "<h2>Não foi possível conectar com o banco de dados do site</h2><br>";
        echo $conexao_bd->getCodigoErro() . " -> " . $conexao_bd->getMensagemErro();
    } elseif (($_REQUEST["usuario"] != "") && ($_REQUEST["senha"] != "")) {
        $nomeUsuario = $_REQUEST["usuario"];
        $senhaAcesso = $_REQUEST["senha"];
        $conexao_bd->setSELECT("Nome_Usuario, Senha_Acesso, Codigo_Hospede", "hospedes");
        $conexao_bd->setWHERE("(Nome_Usuario = " .campoTexto($nomeUsuario).") AND (Senha_Acesso = " . campoTexto($senhaAcesso).")");
        
        if($conexao_bd->execSELECT()) {
            $numeroRegistros = $conexao_bd->getTotalRegistros();
            $dataSet = $conexao_bd->getDataSet();
            $registros = $dataSet->fetch_assoc();

            if ($numeroRegistros == 1) {
                $_SESSION["USUARIO_LOGADO"] = 1;
                $_SESSION["NOME_USUARIO"] = $nomeUsuario;
                $_SESSION["CODIGO_HOSPEDE"] = $registros["Codigo_Hospede"];
                echo "<h3>Usuário logado com sucesso...</h3>";
            } else {
                $_SESSION["USUARIO_LOGADO"] = 0;
                $_SESSION["NOME_USUARIO"] = "";
                $_SESSION["CODIGO_HOSPEDE"] = 0;
                echo "<h3>Usuário/Senha inválidos...</h3>";
            }
        } else {
            echo "<h2>Erro na execução do comando SELECT...</h2>";
        }
    }
    $conexao_bd->fecharConexao();
}
