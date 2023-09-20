<?php

use LDAP\Result;

require_once 'configuracao.php';
require_once 'classBancoDados.php';
require_once 'funcoesDiversas.php';


$dataInclusao = date('d/m/Y');
$nome = $_REQUEST['nomeHospede'];
$dia = $_REQUEST['diaNascimento'];
$mes = $_REQUEST['mesNascimento'];
$ano = $_REQUEST['anoNascimento'];
$dataNascimento = "$ano/$mes/$dia";
$cpf = $_REQUEST['numeroCPF'];
$rg = $_REQUEST['numeroRG'];
$endereco = $_REQUEST['endereco'];
$numero = $_REQUEST['numero'];
$complemento = $_REQUEST['complemento'];
$bairro = $_REQUEST['bairro'];
$cidade = $_REQUEST['cidade'];
$estado = $_REQUEST['estado'];
$cep = $_REQUEST['cep'];
$telefone = $_REQUEST['telefone'];
$celular = $_REQUEST['celular'];
$empresa = $_REQUEST['empresa'];
$nomeUsuario = $_REQUEST['nomeUsuario'];
$senhaAcesso = $_REQUEST['senhaAcesso'];
$email = $_REQUEST['email'];
$erroDados = FALSE;
$mensagemErro = "";

if (trim($nome) == "") {
    $erroDados = TRUE;
    $mensagemErro .= "<h3>Nome obrigatório...</h3>";
}

if ((trim($dia) != "") && (trim($mes) != "") && (trim($ano) != "")) {
    if (!checkdate($mes, $dia, $ano)) {
        $erroDados = TRUE;
        $mensagemErro .= "<h3>Data de nascimento inválida...</h3>";
    }
} else {
    $erroDados = TRUE;
    $mensagemErro .= "<h3>Data de nascimento obrigatória...</h3>";
}

//     /***************************
//      * ARRUMAR ASSIM QUE PUDER *
//      ***************************/

// // if(trim($CPF) != "") {
// //     if(!validaCPF($CPF)) {
// //         $erroDados = TRUE;
// //         $mensagemErro .= "<h3>Número do CPF inválido...</h3>";
// //     }
// // } else {
// //     $erroDados = TRUE;
// //     $mensagemErro .= "<h3>Número do CPF obrigatório...</h3>";
// // }

if(trim($rg) == "") {
    $erroDados = TRUE;
    $mensagemErro .= "<h3>Número do RG obrigatório...</h3>";
}

if(trim($endereco) == "") {
    $erroDados = TRUE;
    $mensagemErro .= "<h3>Endereço obrigatório...</h3>";
}

if(trim($bairro) == "") {
    $erroDados = TRUE;
    $mensagemErro .= "<h3>Bairro obrigatório...</h3>";
}

if(trim($cidade) == "") {
    $erroDados = TRUE;
    $mensagemErro .= "<h3>Cidade obrigatória...</h3>";
}

if(trim($cep) != "") {
    if(!validaCEP($cep)) {
        $erroDados = TRUE;
        $mensagemErro .= "<h3>Formato de CEP inválido...</h3>";
    }   
} else {
    $erroDados = TRUE;
    $mensagemErro .= "<h3>CEP obrigatório...</h3>";
}

if(trim($telefone) == "") {
    $erroDados = TRUE;
    $mensagemErro .= "<h3>Telefone obrigatório...</h3>";
}


if(trim($nomeUsuario) == "") {
    $erroDados = TRUE;
    $mensagemErro .= "<h3>Usuário obrigatório...</h3>";
}

if(trim($senhaAcesso) == "") {
    $erroDados = TRUE;
    $mensagemErro .= "<h3>Senha obrigatória...</h3>";
}

if (!$erroDados) {
    $conexao_bd = new BancoDados($servidorMySQL);

    if (!$conexao_bd->abrirConexao()) {
        echo "<h3>Erro na conexão com o banco de dados!<br/>" . $conexao_bd->getMensagemErro() . "</h3>";
    } else {
        $dadosRegistros["Data_Inclusao"] = campoTexto(DataInvertida($dataInclusao));
        $dadosRegistros["Nome_Hospede"] = campoTexto($nome);
        $dadosRegistros["Data_Nascimento"] = campoTexto($dataNascimento);
        $dadosRegistros["CPF"] = campoTexto($cpf);
        $dadosRegistros["RG"] = campoTexto($rg);
        $dadosRegistros["Endereco"] = campoTexto($endereco);
        $dadosRegistros["Numero"] = campoTexto($numero);
        $dadosRegistros["Complemento"] = campoTexto($complemento);
        $dadosRegistros["Bairro"] = campoTexto($bairro);
        $dadosRegistros["Cidade"] = campoTexto($cidade);
        $dadosRegistros["UF"] = campoTexto($estado);
        $dadosRegistros["CEP"] = campoTexto($cep);
        $dadosRegistros["Telefone"] = campoTexto($telefone);
        $dadosRegistros["Celular"] = campoTexto($celular);
        $dadosRegistros["Empresa"] = campoTexto($empresa);
        $dadosRegistros["Nome_Usuario"] = campoTexto($nomeUsuario);
        $dadosRegistros["Senha_Acesso"] = campoTexto($senhaAcesso);
        $dadosRegistros["Email"] = campoTexto($email);

        $conexao_bd->setINSERT($dadosRegistros, "hospedes");

        if (!$conexao_bd->execINSERT()) {
            echo "<h3>Erro na execução do comando INSERT</h3>";
        } else {
            echo "<h3>Cadastro efetuado com sucesso!</h3>";
        }
    }
    $conexao_bd->fecharConexao();
} else {
    echo $mensagemErro;
}