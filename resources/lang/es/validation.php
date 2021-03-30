<?php

return [
    'required' => 'El campo :attribute es requerido.',
    'image' => 'El campo :attribute debe ser una imagen.',
    'date' => 'El campo :attribute no es una fecha válida',
    'max'                   => [
      'numeric' => 'El campo :attribute debe ser menor que :max.',
      'file'    => 'El campo :attribute debe ser menor que :max kilobytes.',
      'string'  => 'El campo :attribute debe ser menor que :max caracteres.',
      'array'   => 'El campo :attribute puede tener hasta :max elementos.',
    ],
    'mimes'      => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'mimetypes'  => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'min'        => [
      'numeric' => 'El campo :attribute debe tener al menos :min.',
      'file'    => 'El campo :attribute debe tener al menos :min kilobytes.',
      'string'  => 'El campo :attribute debe tener al menos :min caracteres.',
      'array'   => 'El campo :attribute debe tener al menos :min elementos.',
    ],
    'dimensions'=> 'El campo :attribute tiene dimensiones de imagen inválidas.',
    'confirmed' => 'La confirmacion del :attribute no son iguales.',
    'unique'    => 'Este :attribute ya ha sido tomado.',
];
