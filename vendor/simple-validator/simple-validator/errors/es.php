<?php
/**
 * :attribute => input name
 * :params => rule parameters ( eg: :params(0) = 10 of max_length(10) )
 */
return array(
    'required' => ':attribute es requerido',
    'integer' => ':attribute debe ser del tipo entero',
    'float' => ':attribute debe ser del tipo float',
    'numeric' => ':attribute debe ser del tipo numérico',
    'email' => ':attribute no es un correo válido',
    'alpha' => ':attribute debe ser del tipo alfa',
    'alpha_numeric' => ':attribute debe ser del tipo alfanumérico',
    'ip' => ':attribute debe ser una IP válida',
    'url' => ':attribute debe ser una URL válida',
    'max_length' => ':attribute como maxímo solo puede contener :params(0) caracteres',
    'min_length' => ':attribute como mínimo solo puede contener :params(0) caracteres',
    'exact_length' => ':attribute debe contener exactamente :params(0) caracteres',
    'equals' => ':attribute debe ser igual a :params(0)'
);
