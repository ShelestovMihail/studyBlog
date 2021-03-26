<?php

return [
    '|^hello/(.*)$|' => [\LiamProject\Controllers\MainController::class, 'sayHi'],
    '|^bye/(.*)$|' => [\LiamProject\Controllers\MainController::class, 'sayBye'],
    '|^$|' => [\LiamProject\Controllers\MainController::class, 'main'],
    '|^article/(\d+)$|' => [\LiamProject\Controllers\ArticleController::class, 'view'],
    '|^article/(\d+)/edit$|' => [\LiamProject\Controllers\ArticleController::class, 'edit'],
    '|^article/create$|' => [\LiamProject\Controllers\ArticleController::class, 'create'],
    '|^article/(\d+)/delete$|' => [\LiamProject\Controllers\ArticleController::class, 'delete'],
    '|^register$|' => [\LiamProject\Controllers\UsersController::class, 'signUp'],
    '|^users/(\d+)/activate/(.+)$|' => [\LiamProject\Controllers\UsersController::class, 'activate'],
    '|^login$|' => [\LiamProject\Controllers\UsersController::class, 'login'],
];