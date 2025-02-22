<?php

session_start();




require_once __DIR__ . '/../app/Config.php';

require_once __DIR__ . '/../app/App.php';

// $reviews = getReviews();
$products = getProducts();

require_once __DIR__ . '/../views/index.php';

