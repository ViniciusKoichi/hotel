<?php
require_once 'classBancoDados.php';

    function DataInvertida($dataNormal)
    {
        $dia = substr($dataNormal, 0, 2);
        $mes = substr($dataNormal, 3, 2);
        $ano = substr($dataNormal, 6, 4);
        $DataInvertida = $ano . "/" . $mes . "/" . $dia;
        return $DataInvertida;
    }
    