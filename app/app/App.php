<?php

declare(strict_types=1);

// Function to retrieve and clear a flash message from the session
function flashMessage(string $key): string
{
    $message = '';

    if (isset($_SESSION[$key]) && !empty($_SESSION[$key])) {
        $message = $_SESSION[$key];
        unset($_SESSION[$key]);
    }

    return $message;
}

// Function to establish a connection to the database
function getConnection(): PDO
{
    // Construct DSN (Data Source Name)
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;

    // Options for PDO - setting default fetch mode
    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    // Create a new PDO instance
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

    return $pdo;
}

// Function to get all reviews from the database
function getReviews(): array
{
    $db = getConnection();

    // Execute the query to get all reviews
    $stmt = $db->query('SELECT * FROM tblReviews');

    // Fetch all reviews
    $reviews = $stmt->fetchAll();

    return $reviews;
}

// Function to get all products from the database
function getProducts(): array
{
    $db = getConnection();

    // Execute the query to get all products
    $stmt = $db->query('SELECT * FROM tblProducts');

    // Fetch all products
    $products = $stmt->fetchAll();


    return $products ?: []; // Return an empty array if no products are found
}

// Function to get a specific product by its ID
function getSelectedProduct(int $id): array
{
    $db = getConnection();

    // Prepare the query to get the product by ID
    $stmt = $db->prepare('SELECT * FROM tblProducts WHERE product_id = :id');

    // Bind the parameter to the prepared statement
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the query
    $stmt->execute();

    // Fetch the single product
    $product = $stmt->fetch(PDO::FETCH_ASSOC);


    return $product ?: []; // Return an empty array if no product is found
}

// Function to get reviews associated with a specific product
function getSelectedReviews(int $id): array
{
    $db = getConnection();

    // Prepare the query to get reviews by product ID
    $stmt = $db->prepare('SELECT * FROM tblReviews WHERE product_id = :id ORDER BY date DESC');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch all reviews
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $reviews ?: []; // Return an empty array if no reviews are found
}

// Function to process the form submission for adding a review
function processFormSubmission($product_id, &$formInputs, &$formErrors, &$formSuccess)
{
    // Trim and store form inputs
    $formInputs['lastName'] = trim($_POST['lastName']);
    $formInputs['firstName'] = trim($_POST['firstName']);
    $formInputs['review'] = trim($_POST['review']);
    $formInputs['id'] = $product_id;
    // Check if the rating is 1 or 0 and convert to int or give it a value of null
    $formInputs['rating'] = isset($_POST['rating']) && $_POST['rating'] !== '' ? (int) $_POST['rating'] : null;

    // Save the user's first name and last name in the session
    $_SESSION['userFirstName'] = $formInputs['firstName'];
    $_SESSION['userLastName'] = $formInputs['lastName'];

    // Validate last name
    if (empty($formInputs['lastName'])) {
        $formErrors['lastName'] = 'Last name required';
    } else if (strlen($formInputs['lastName']) > 50) {
        $formErrors['lastName'] = 'Last name must be less than 50 chars';
    } else if (!preg_match("/^[a-zA-Z ]*$/", $formInputs['lastName'])) {
        $formErrors['lastName'] = 'Only letters and white space allowed';
    }

    // Validate first name
    if (empty($formInputs['firstName'])) {
        $formErrors['firstName'] = 'First Name is required';
    } else if (strlen($formInputs['firstName']) > 35) {
        $formErrors['firstName'] = 'First Name must be less than 35 characters';
    } else if (!preg_match("/^[a-zA-Z ]*$/", $formInputs['firstName'])) {
        $formErrors['firstName'] = 'Only letters and white space allowed';
    }

    // Validate review
    if (empty($formInputs['review'])) {
        $formErrors['review'] = 'Review is required';
    } else if (strlen($formInputs['review']) > 300) {
        $formErrors['review'] = 'Review must be less than 300 characters';
    } else if (!preg_match("/^[\p{L}\p{N}\p{P}\p{Z}]+$/u", $formInputs['review'])) {
        $formErrors['review'] = 'Invalid characters detected.';
    }

    // Validate rating
    if (is_null($formInputs['rating'])) {
        $formErrors['rating'] = 'Please select a rating.';
    }

    // If there are no form errors, add the review
    if (implode('', $formErrors) === '') {
        addReview($formInputs);
        $formSuccess = true;
        $_SESSION['message'] = 'Review Added!';
        header("Location: product.php?id=" . $product_id);
        exit();
    } else {
        $_SESSION['message'] = 'There was some issues with your form, please try again';
    }
}

// Function to add a review to the database
function addReview(array $data): bool
{
    $db = getConnection();

    // Prepare the query to insert a new review
    $stmt = $db->prepare(
        'INSERT INTO tblReviews(product_id, thumb_up, first_name, last_name, comment )
        VALUES (?,?,?,?,?)'
    );

    // Execute the query with the provided data
    return $stmt->execute(
        [
            $data['id'],
            $data['rating'],
            $data['firstName'],
            $data['lastName'],
            $data['review'],
        ]
    );
}
