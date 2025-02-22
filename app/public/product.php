<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/../app/Config.php';
require_once __DIR__ . '/../app/App.php';

// Retrieve product ID from GET or POST and convert to int
$product_id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id']) ? (int) $_POST['id'] : null);

// retrieve values to be used in view
$product = null;
$reviews = [];
if ($product_id !== null) {
    $product = getSelectedProduct($product_id);
    $reviews = getSelectedReviews($product_id);
}


// Error handling
$formErrors = [
    'productID' => '',
    'lastName' => '',
    'firstName' => '',
    'review' => '',
    'rating' => ''
];
$formInputs = $formErrors;
$formSuccess = false;
$upCnt = 0;
$dwnCnt = 0;

foreach($reviews as $review){
    if($review['thumb_up'] == 1){
        $upCnt++;
    }else{
        $dwnCnt++;
    }
}

function forgetMe(){
    unset($_SESSION['userFirstName']);
    unset($_SESSION['userLastName']);
}

if(isset($_POST['forgetMe'])){
    forgetMe();
    header("Location: product.php?id=" . $product_id);
    exit();
}



// Process form submission and submit to the db.
if (isset($_POST['submit'])) {
    processFormSubmission($product_id, $formInputs, $formErrors, $formSuccess);
}








// used to keep the form open if there are errors
$keepFormOpen = !empty(array_filter($formErrors));


// load the page
require_once __DIR__ . '/../views/product.php';?>
