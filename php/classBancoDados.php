<?php

class BancoDados{
    protected $conexaoBanco;
    protected $idServidor;
    protected $numeroUltimoErro;
    protected $descricaoErro;
    protected $comandoSQL;
    protected $dataSet;
    protected $numeroRegistros;

    //construct

    function __construct($servidor = "") {
        $this->conexaoBanco = NULL;
        $this->numeroUltimoErro = -1;
        $this->descricaoErro = "";
        $this->dataSet = NULL;
        $this->numeroRegistros = 0;
        
        if($servidor === "") {
            $this->idServidor = "localhost";
        } else {
            $this->idServidor = $servidor;
        }
    }

    // Métodos públicos
    
    public function abrirConexao() {
        $this->conexaoBanco = new mysqli($this->idServidor, "root", "Rive@1002", "bd_hotel");
        
        if(mysqli_connect_errno() != 0) {
            $this->conexaoBanco = NULL;
            $this->numeroUltimoErro = mysqli_connect_errno();
            $this->descricaoErro = mysqli_connect_error();
            return FALSE;
        } else {
            $this->conexaoBanco->set_charset("utf8");
            return $this->conexaoBanco;
        }
    }

    public function fecharConexao() {
        if($this->conexaoBanco === NULL) {
            return FALSE;
        }
        $this->conexaoBanco->close();
    }

    // Getters

    public function getCodigoErro() {
        return $this->numeroUltimoErro;
    }
    
    public function getMensagemErro() {
        return $this->descricaoErro;
    }

    public function getTotalRegistros() {
        return $this->numeroRegistros;
    }
    
    public function getDataSet() {
        return $this->dataSet;
    }
    
    // Setters SQL

    public function setSELECT($campos = "", $tabela = "") {
        if(($campos != "") && ($tabela != "")) {
            $this->comandoSQL = "SELECT " . $campos . " FROM " . $tabela;
        }
    }

    public function setWHERE($clausula = "") {
        if($clausula != "") {
            $this->comandoSQL .= " WHERE ";
            $this->comandoSQL .= $clausula;
        }
    }

    public function setORDER($campoOrdenacao = "") {
        if($campoOrdenacao != "") {
            $this->comandoSQL .= " ORDER BY ";
            $this->comandoSQL .= $campoOrdenacao;
        }
    }

    // Executes SQL

    public function execINSERT() {
        if($this->comandoSQL != "") {
            $this->resultado = $this->conexaoBanco->query($this->comandoSQL);
            
            if($this->resultado === FALSE) {
                return FALSE;
            } elseif ($this->conexaoBanco->affected_rows != 1) {
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

    public function execSELECT() {
        if($this->comandoSQL != "") {
            $this->dataSet = $this->conexaoBanco->query($this->comandoSQL);
            if($this->dataSet) {
                $this->numeroRegistros = $this->dataSet->num_rows;
            }
            
            return TRUE;
        } else {
            return FALSE;
        }
    }
}