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
    'members' => [
      'driver' => 'jwt',
      'provider' => 'members',
    ],
  ],
  'providers' => [
    'users' => [
      'driver' => 'eloquent',
      'model' => \App\Models\User::class,
    ],
    'members' => [
      'driver' => 'eloquent',
      'model' => \App\Models\Member::class,
    ],
  ],
];
