<?php
require_once 'configuracao.php';
require_once 'classBancoDados.php';

    function DataInvertida($dataNormal)
    {
        $dia = substr($dataNormal, 0, 2);
        $mes = substr($dataNormal, 3, 2);
        $ano = substr($dataNormal, 6, 4);
        $DataInvertida = $ano . "/" . $mes . "/" . $dia;
        return $DataInvertida;
    }
    
    function Estados($ordemTabulacao)
    {
        global $servidorMySQL;
   
        $listaEstados = "<select name='Estado' size='1' tabindex=$ordemTabulacao>";
        
        $conexao_bd = new BancoDados($servidorMySQL);
        
        if ($conexao_bd->abrirConexao()) {
            $conexao_bd->setSELECT("UF, Estado", "estados");
            $conexao_bd->setORDER("Estado");
            
            if($conexao_bd->execSELECT()) {
                $numeroRegistros = $conexao_bd->getTotalRegistros();
                $dataSet = $conexao_bd->getDataSet();
                
                if($numeroRegistros > 0) {
                    while($registros = $dataSet->fetch_assoc()) {
                        $listaEstados .= "<option value='" . $registros["UF"] . "'>"
                                . $registros["Estado"] . "</option>";
                    }
                }
            }
        }
        $conexao_bd->fecharConexao();
        $listaEstados .= "</select>";
        return $listaEstados;
    }
    
    function soDigito($valor)
    {
        $tamanho = strlen($valor);
        $novoValor = "";
        
        for($contador = 0; $contador < $tamanho; $contador++) {
            $digito = $valor[$contador];
            
            if((ord($digito) >= 48) && (ord($digito) <= 57)) {
                $novoValor .= $digito;
            }
        }
        return trim($novoValor);
    }
    
    function validaCPF($numeroCPF)
    {
        $CPF = soCodigo($numeroCPF);
        
        if($CPF === "") {
            $retorno = FALSE;
        } elseif(strlen($CPF) == 11) {
            $soma = 0;
            
            for($contador = 0; $contador <9; $contador++) {
                $calculo = $CPF[8-$contador]*($contador+2);
                $soma += $calculo;
            }
            
            $digito1 = 11 - ($soma % 11);
            
            if($digito1 > 9) {
                $digito1 = 0;
            }
            
            $CPFNovo = substr($CPF,0,9);
            $CPFNovo .= $digito1;
            $soma = 0;
            
            for($contador = 0; $contador < 10; $contador++) {
                $calculo = $CPFNovo[9-$contador]*($contador+2);
                $soma += $calculo;
            }
            
            $digito2 = 11 - ($soma % 11);
            
            if($digito2 > 9) {
                $digito2 = 0;
            }
            
            $retorno = ($digito1 == ((int)$CPF[9])) && ($digito2 == ((int)$CPF[10]));
        } else 
            $retorno = FALSE;
        
        return $retorno;
    }
    
    function validaCEP($CEP)
    {
        $novoCEP = soDigito($CEP);
        
        if(strlen($novoCEP < 8)) {
            $retorno = FALSE;
        } else {
            $retorno = ereg("^([0-9]){5}-?([0-9]){3}", $CEP);
        }
        return $retorno;
    }
    
    function campoTexto($valor) 
    {
        return "'" . $valor . "'";
    }