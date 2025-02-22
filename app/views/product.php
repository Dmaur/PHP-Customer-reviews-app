<?php $title = 'REVO-REVIEW'; ?>
<?php include 'includes/header.php'; ?>

<body class="bg-black text-white font-vt323">
    <main class="flex-col justify-items-center text-center">
        <!-- Back button -->
        <a href="/" class="drop-shadow-glow p-1 absolute top-4 left-4 text-sm lg:text-2xl ml-1 lg:ml-4 hover:bg-white hover:text-black"><-Go Back</a>
        <!-- Main title of the page -->
        <h1 class="text-4xl font-bold text-center drop-shadow-glow mt-4 lg:text-8xl">[<?= $title ?>]</h1>

        <!-- Product title -->
        <p class="text-2xl mt-10 h-auto w-[75vw] text-glow_green lg:text-4xl">*** <?= $product['title'] ?> ***

        <!-- Product information -->
        <div class="text-left flex-col justify-items-center p-4 h-auto w-[75vw] bg-black text-white">
            <div class="flex-col justify-items-center md:flex-row ml-3">
                <!-- Product image -->
                <img class="flex max-w-[40vw] max-h-[40vh] self-center opacity-60 rounded-sm mr-3" src="<?= $product['photo']; ?>" alt="<?= $product['title']; ?>">
                <!-- Product description and price -->
                <p class="drop-shadow-glow text-xl lg:text-4xl mt-4">
                    <?= htmlspecialchars($product['description']) . " _$" . htmlspecialchars($product['price']); ?>
                </p>
                <!-- Thumbs up and down counts -->
                <div class="flex justify-around text-2xl w-[25vw] lg:justify-between self-start mt-4">
                    <div>
                        <img src="/imgs/thmUpGrsm.png" alt="thumbs up">
                        <p>X <?= htmlspecialchars($upCnt); ?></p>
                    </div>
                    <div>
                        <img src="/imgs/thmDnRdSm.png" alt="thumbs down">
                        <p>X <?= htmlspecialchars($dwnCnt); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash message for review submission -->
        <?php if (isset($_SESSION['message'])) : ?>
            <?php
            // Retrieve and store the flash message from the session
            $message = flashMessage('message');
            // Initialize an empty string for the CSS class
            $messageClass = '';

            // Determine the CSS class based on the message content
            if ($message === 'Review Added!') {
                $messageClass = 'text-glow_green';
            } elseif($message === 'There was some issues with your form, please try again') {
                $messageClass = 'text-red-500';
            }
            ?>
            <span id="postFeedback" class="<?= $messageClass; ?>"><?= $message; ?></span>
        <?php endif; ?>

        <!-- Reviews section -->
        <section class="w-[75vw] flex-col justify-start text-left mx-auto">
            <h1 class="text-4xl text-glow_green drop-shadow-glow">_Reviews</h1>
            <?php if (empty($reviews)) : ?>
                <h1 class="text-4xl text-red-500 mt-10">-No reviews available currently-</h1>
            <?php else: ?>
                <div class="">
                    <?php foreach ($reviews as $review) : ?>
                        <div class="mb-3 border-y-2 border-dotted text-xl lg:text-4xl border-glow_green">
                            <p>**<?= htmlspecialchars($review['first_name']) . " " . htmlspecialchars($review['last_name']); ?>*
                                <small class="text-xs text-gray-500"><?= htmlspecialchars($review['date']); ?></small>
                            </p>
                            <div class="flex">
                                <p>-<?= htmlspecialchars($review['comment']); ?> </p>
                                <div class="hidden"><?= htmlspecialchars($review['thumb_up']); ?></div>
                                <img class="ratingImg" src="*" alt="user rating img">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- Add review section -->
        <section class="w-[75vw] mb-4 justify-start text-left mx-auto">
            <button id="revButton" class="text-4xl text-white hover:bg-white hover:text-black drop-shadow-glow">-Add a review-</button>
            <div id="revForm" class="<?= $keepFormOpen ? '' : 'hidden' ?> mt-2">
                <button id="thumbUp"><img id="tUp" class="hover:drop-shadow-glow"  src="/imgs/thmUpWtLg.png" alt="thumbs up unclicked"></button>
                <button id="thumbDn"><img id="tDn" class="hover:drop-shadow-glow" src="/imgs/thmDnWtLg.png" alt="thumbs down unclicked"></button>

                <!-- Review form -->
                <form method="POST" action="product.php?id=<?= htmlspecialchars($product_id) ?>">
                    <span class="text-red-500"><?= $formErrors['rating']; ?></span>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($product_id) ?>">
                    <input id="userRating" name="rating" type="hidden" value="" required>

                    <div>
                        <label for="firstName" class="text-white">First Name</label>
                        <input type="text"
                            value="<?= htmlspecialchars($_SESSION['userFirstName'] ?? '') ?>"
                            name="firstName" class="w-full bg-black text-white border-b-2 border-white focus:border-gray-400 outline-none p-2"
                            maxlength="35"
                            required>
                        <span class="text-red-500"><?= $formErrors['firstName']; ?></span>
                    </div>

                    <div class="mt-4">
                        <label for="lastName" class="text-white">Last Name</label>
                        <input type="text"
                            value="<?= htmlspecialchars($_SESSION['userLastName'] ?? '') ?>"
                            name="lastName" class="w-full bg-black text-white border-solid border-b-2 border-white focus:border-gray-400 outline-none p-2"
                            maxlength="50"
                            required>
                        <span class="text-red-500"><?= $formErrors['lastName']; ?></span>
                    </div>

                    <div class="mt-4">
                        <label for="review" class="text-white">Leave Review</label>
                        <textarea id="comment"
                            name="review" rows="4"
                            class="w-full bg-black text-white border-b-2 border-white focus:border-gray-400 outline-none p-2 resize-none"
                            maxlength="150"
                            required></textarea>
                        <span class="text-red-500"><?= $formErrors['review']; ?></span>
                    </div>
                    <div class="hidden" id="formErrors"><?= json_encode($formErrors); ?></div>

                    <button type="submit" name="submit" class="mt-4 bg-black text-white p-1 hover:bg-white hover:text-black">
                        -Submit-
                    </button>
                </form>

                <!-- Forget me button -->
                <?php if (isset($_SESSION['userFirstName']) || isset($_SESSION['userLastName'])): ?>
                    <form method="POST" action="product.php?id=<?= htmlspecialchars($product_id) ?>">
                        <button type="submit" name="forgetMe" class="mt-4 bg-black text-white p-1 hover:bg-white hover:text-black">
                            -Forget Me-
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>

<?php include 'includes/footer.php'; ?>
