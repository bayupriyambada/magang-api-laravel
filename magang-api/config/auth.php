<?php

return [
  'defaults' => [
    'guard' => 'users',
    'passwords' => 'users',
  ],

  'guards' => [
    'users' => [
      'driver' => 'jwt',
      'provider' => 'users',
    ],
  ],
  'providers' => [
    'users' => [
      'driver' => 'eloquent',
      'model' => \App\Models\User::class,
    ],
  ],
];
