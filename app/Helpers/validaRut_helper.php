<?php

function validarRut($rut) {
    $rut = preg_replace('/[^k0-9]/i', '', $rut);
    $dv  = substr($rut, -1);
    $numero = substr($rut, 0, strlen($rut)-1);
    $i = 2;
    $suma = 0;
    for ($j = strlen($numero) - 1; $j >= 0; $j--) {
        $suma += $numero[$j] * $i;
        $i = $i == 7 ? 2 : $i + 1;
    }
    $resto = $suma % 11;
    $dv_calculado = 11 - $resto;
    if ($dv_calculado == 11) {
        $dv_calculado = 0;
    } elseif ($dv_calculado == 10) {
        $dv_calculado = 'k';
    }
    if (strtolower($dv) == strtolower($dv_calculado)) {
        return true;
    } else {
        return false;
    }
}