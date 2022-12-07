<?php

/**
 * gestión de assets públicos y privados de la app
 *
 * - imagenes de vehículos
 */

return [

  /**
   * imagenes de vehículos
   */
  'vehicle' => [

    // original
    'original_sp' => 'img/original/vehicles/',
    'original_pp' => public_path('img/original/vehicles/'),

    // resize
    'resize_sp' => 'img/resize/vehicles/',
    'resize_pp' => public_path('img/resize/vehicles/'),

    // extra config
    'max_size' => 1024 * 1024 * 2, // 2MB
    'max_width' => 1920,
    'max_height' => 1080,
    'allowed_extensions' => ['jpg', 'jpeg', 'png', 'webp'],
  ],
];