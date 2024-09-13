<?php

use Slim\Factory\AppFactory;


require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/ErrorHandler.php';

$app = AppFactory::create();

// Error handling: Use the custom error handler
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Instantiate the CustomErrorHandler class and assign it to the error middleware
$ErrorHandler = new ErrorHandler();
$errorMiddleware->setDefaultErrorHandler($ErrorHandler);

// Load User Routes
(require __DIR__ . '/../routes/userRoute.php')($app);

// Load Event Routes
(require __DIR__ . '/../routes/eventRoute.php')($app);

// Load Category Routes
(require __DIR__ . '/../routes/categoryRoute.php')($app);


// Run the application (no need to create the server request manually)
$app->run();