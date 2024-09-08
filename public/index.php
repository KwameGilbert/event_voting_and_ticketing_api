<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';

$app = AppFactory::create();

// Load User Routes
(require __DIR__ . '/../routes/userRoute.php')($app);

// // Load Event Routes
// (require __DIR__ . '/../routes/eventRoute.php')($app);

// Error handling
$app->addErrorMiddleware(true, true, true);

// Run the application (no need to create the server request manually)
$app->run();
