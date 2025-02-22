<?php $title = 'REVO-REVIEW'; // Set the page title ?>
<?php include 'includes/header.php'; // Include the header file ?>

<body class="bg-black text-white font-vt323 ">
    <main class="flex-col justify-items-center text-center">

        <!-- Main title of the page -->
        <h1 class="text-4xl font-bold text-center drop-shadow-glow mt-4 lg:text-8xl">[<?= $title ?>]</h1>
        <!-- Subtitle of the page -->
        <p class="text-2xl mt-4 text-glow_green drop-shadow-glow lg:text-4xl">*** Helping you build and protect a community ***</p>
        <p class="text-2xl mt-4 text-glow_green drop-shadow-glow lg:text-4xl">*** Your feedback is essential! ***</p>

        <div class="self-center mt-10 flex flex-col divide-y-4 divide-y-reverse text-left divide-gray-100">

            <!-- Check if there are any products available -->
            <?php if (empty($products)): ?>
                <h1 class="text-4xl text-red-500 mt-10">Sorry, No products available currently.</h1>
            <?php else: ?>
                <!-- Loop through each product and display its details -->
                <?php foreach ($products as $product) : ?>
                    <div class="flex-col p-4 border-y-4 border-white h-[auto] w-[75vw] bg-black text-white ">
                        <!-- Product image -->
                        <img class="h-[15vh] opacity-60 rounded-sm mr-3" src="<?= $product['photo']; ?>" alt="<?= $product['title']; ?>">
                        <div class="flex-col ml-3">
                            <h1 class="text-2xl drop-shadow-glow text-glow_green lg:text-6xl">
                                <?php
                                $title = $product['title']; // Get the title from the product array
                                $limitedTitle = mb_substr($title, 0, 40); // Limit the title to 40 characters using mb_substr

                                // Add an ellipsis if the original title is longer than 40 characters
                                if (strlen($title) > 40) {
                                    $limitedTitle .= '...';
                                }

                                echo "_".htmlspecialchars($limitedTitle); // Display the limited title
                                ?>
                            </h1>
                            <div>
                                <h1 class="drop-shadow-glow text-xl lg:text-4xl mt-4">
                                    <?php
                                    $description = $product['description']; // Get the description from the product array
                                    $words = explode(' ', $description); // Split the description into words
                                    $limitedWords = array_slice($words, 0, 15); // Take the first 15 words
                                    $limitedDescription = implode(' ', $limitedWords); // Join the words back together

                                    // Add an ellipsis if the original description has more than 15 words
                                    if (count($words) > 15) {
                                        $limitedDescription .= '...';
                                    }

                                    echo htmlspecialchars($limitedDescription). " _$".htmlspecialchars($product['price']); // Display the limited description and price
                                    ?>
                                </h1>

                                <!-- Form to go to the product page -->
                                <form method="GET" action="product.php">
                                    <button type="submit" class="p-1 mt-2 lg:text-4xl hover:bg-white hover:text-black hover:drop-shadow-glow">Go To -></button>
                                    <input type="hidden" name="id" value="<?= $product['product_id']; // Pass the product ID ?>">
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>

    </main>

    <?php include 'includes/footer.php'; // Include the footer file ?>
</body>

</html>
