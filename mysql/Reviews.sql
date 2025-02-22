
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Create the Products table
CREATE TABLE  `tblProducts` (
    `product_id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL,
    `photo` VARCHAR(255) NOT NULL
);

-- Create the Reviews table
CREATE TABLE `tblReviews` (
    `review_id` INT AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT NOT NULL,
    `thumb_up` TINYINT(1) NOT NULL, -- 1 for thumb up, 0 for thumb down
    `first_name` VARCHAR(50) NOT NULL,
    `last_name` VARCHAR(50) NOT NULL,
    `comment` TEXT NOT NULL,
    `date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`product_id`) REFERENCES `tblProducts`(`product_id`) ON DELETE CASCADE
);
-- Insert sample products
INSERT INTO `tblProducts` (`title`, `description`, `price`, `photo`) VALUES
('Mutual Aid: Building Solidarity During This Crisis (and the Next)', 'A handbook for how to organize to meet immediate needs in your community and work toward lasting change. by Dean Spade', 19.99, '/imgs/mutualAid.png'),
('Picnic libation set', 'Great for on the go! Comes with traditional rag stopper and matches (for lighting candles to set the mood).', 9.99, '/imgs/redacted.png'),
('Soup for my family', 'Great for those cold nights. Ergonomically shaped for a superior grip. "better than a brick".', 0.39, '/imgs/soupForMyFamily.png');

-- Insert sample reviews
INSERT INTO `tblReviews` (`product_id`, `thumb_up`, `first_name`, `last_name`, `comment`) VALUES
(2, 1, 'Emma', 'Goldman', 'Great product! I love it.'),
(2, 0, 'Jane', 'Smith', 'Not what I expected.'),
(2, 1, 'Karl', 'Marx', 'workers of the world, you have nothing to lose but this sick deal'),
(2, 0, 'Pearl', 'Clutcher',"I think I know what you're talking about and I am reporting you"),
(3, 1, 'Alice', 'Johnson', 'Excellent quality and fast shipping.'),
(3, 1, 'Peter', 'Kropotkin', 'This would go well with some bread.');
