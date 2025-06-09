-- Create support_tickets table
CREATE TABLE IF NOT EXISTS `support_tickets` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `order_id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `status` ENUM('pending', 'in_process', 'resolved', 'failed') DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Optional: Add a sample orders table if it doesn't exist
-- (for dropdown list purposes in create_ticket.php)

CREATE TABLE IF NOT EXISTS `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `product_name` VARCHAR(255),
  `order_date` DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Optional: Sample data for testing
INSERT INTO `orders` (`user_id`, `product_name`) VALUES
(1, 'Wireless Headphones'),
(1, 'Bluetooth Speaker'),
(2, 'Fitness Band');
