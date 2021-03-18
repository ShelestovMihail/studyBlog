<?php

return [
    '~^hello/(.*)$~' => [\LiamProject\Controllers\MainController::class, 'sayHi'],
    '~^bye/(.*)$~' => [\LiamProject\Controllers\MainController::class, 'sayBye'],
    '~^$~' => [\LiamProject\Controllers\MainController::class, 'main'],
    '~^article/(\d+)$~' => [\LiamProject\Controllers\ArticleController::class, 'view'],
    '~^article/(\d+)/edit$~' => [\LiamProject\Controllers\ArticleController::class, 'edit'],
    '~^article/create$~' => [\LiamProject\Controllers\ArticleController::class, 'create'],
];