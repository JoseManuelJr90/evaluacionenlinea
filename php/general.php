<?php
/**
 * Configuración general
 */

// Constantes
define('SITE_TITLE', 'ProyectoEvaluacion');
define('SITE_PATH', 'http://localhost/proyectoevaluacion/');


/**
 * Funcion que nos permite quitar espacios al inicio o final de las cadenas ingresadas en los input
 * Y coloca null en caso de ser una cadena vacia
 * @param string || array
 * @return string || array
 */
function limpiarDato($datos) {
    if (is_array($datos)) {
        $datos = array_map(function($dato) {
            return ($dato === '') ? null : trim($dato);
        }, $datos);
    } else {
        $datos = ($datos === '' ? null : trim($datos));
    }
    return $datos;
}
