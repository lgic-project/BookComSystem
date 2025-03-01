-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2025 at 03:23 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookcomsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `profile_img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `full_name`, `email`, `phone_number`, `profile_img`) VALUES
(2, 'deepak4156', '$2y$10$UOvM2mB4i4RYxzbUMP8AzOwEHwG391hdRVYSxNQqsVOcoS7psEdsq', 'Deepak Chhantyal', 'deepakchhantyal1761@gmail.com', '9746311761', '474889997_936486748678747_685540894895782057_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `pages` int(11) NOT NULL,
  `category` varchar(30) NOT NULL,
  `book_description` text NOT NULL,
  `pub_year` int(11) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `book_img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `genre`, `pages`, `category`, `book_description`, `pub_year`, `isbn`, `publisher`, `price`, `stock`, `book_img`) VALUES
(34, 'The Book Thief', 'Markus Zusak', 'Literary Fiction', 400, '', '\"The Book Thief\" tells the story of Liesel Meminger, a young girl living in Nazi Germany during World War II.  Stealing books becomes her way of finding solace and understanding in a world filled with chaos and cruelty.', 2005, '978-0375842207', 'Alfred A. Knopf (US) / Picador (UK) ', 700.00, 8, '67644875980f0.jpg'),
(35, 'The Kite Runner', 'Khaled Hosseini', 'Literary Fiction', 371, '', '\"The Kite Runner\" tells the powerful story of Amir, a man haunted by his betrayal of his childhood friend, Hassan, in war-torn Afghanistan.  Spanning decades and continents, the novel explores themes of guilt, redemption, friendship, and the devastating impact of war and political upheaval.', 2003, '978-1594480003', 'Riverhead Books', 650.00, 9, '6780fb13909f6.jpg'),
(36, 'The Great Gatsby', 'F. Scott Fitzgerald', ' Literature', 200, '', '\"The Great Gatsby\" explores the complexities of love, wealth, and class on Long Island, as Gatsby\'s pursuit of Daisy reveals the emptiness beneath the glittering surface of the Jazz Age.', 1232, '978-0743273558', 'Charles Scribner\'s Sons (First published)', 800.00, 7, '67b58d9550f16.jpg'),
(45, 'It', 'Stephen King', 'Horror', 1138, '', 'A group of childhood friends in Derry, Maine, face an ancient evil that takes the form of Pennywise the Clown, returning 27 years later to confront their deepest fears. *IT* is a chilling tale of horror, trauma, and the power of friendship.', 1986, '0670813028', 'Viking Press', 800.00, 10, '67b9a4726d96c.png'),
(46, '12 Rules for life: An Antitode to chaos', 'Jordan peterson', 'Self-Help', 409, '', '12 Rules for Life offers practical life principles based on psychology, philosophy, and mythology, helping readers find meaning, take responsibility, and navigate life\'s chaos. Peterson blends scientific insights with timeless wisdom to encourage discipline and self-improvement', 2018, '0345816021', 'Random House Canada', 750.00, 10, '67b9a52c14dd2.jpg'),
(47, 'Beyond Order:12 more rules for life', 'Jordan peterson', 'Self-help', 432, '', 'Beyond Order expands on Peterson’s previous work, offering 12 more rules to help individuals balance structure with creativity. Emphasizing the need for courage, responsibility, and meaning, it guides readers through uncertainty and personal growth.', 2021, '0593084640', 'Penguin Allen Lane', 750.00, 10, '67b9a5e3d65e4.jpg'),
(48, 'Pride and Prejudice', 'Jane Austen', 'Romance', 432, '', 'A witty and heartwarming love story between the independent Elizabeth Bennet and the proud yet honorable Mr. Darcy, exploring themes of social class, love, and personal growth.', 1813, '1503290565', 'T. Egerton, Whitehall', 800.00, 10, '67b9a77d5153f.jpeg'),
(49, 'The Notebook', 'Nicholas Sparks', 'Romance', 214, '', 'A touching tale of enduring love between Noah and Allie, separated by fate and reunited years later, proving that true love never fades.', 1996, '0446605239', 'Warner Books', 600.00, 10, '67b9a8018aad2.jpeg'),
(50, 'Me Before You', 'Jojo Moyes', 'Romance', 480, '', 'A heartbreaking yet beautiful story about Louisa Clark, who becomes the caregiver of Will Traynor, a quadriplegic man who teaches her about life, love, and loss.', 2012, '0143124544', 'Penguin Books', 800.00, 10, '67b9a88c79a2f.jpeg'),
(51, 'It Ends With Us', 'Colleen Hoover', 'Romance', 384, '', 'A deeply emotional novel about Lily Bloom, caught in a powerful yet painful love story that challenges her past, her heart, and her strength to break toxic cycles.', 2016, '1501110365', 'Atria Books', 700.00, 10, '67b9aa1bee989.jpeg'),
(52, 'The Fault in Our Stars', 'Jhone Green', 'Romance', 313, '', 'A deeply emotional love story between Hazel Grace Lancaster, a cancer patient, and Augustus Waters, a charismatic boy, as they navigate love, loss, and the meaning of life.', 2012, '0525478817', 'Dutton Books', 700.00, 10, '67b9ac303e144.jpeg'),
(53, 'How to Win Friends and Influence People', 'Dale Carnegie', 'Self-help', 288, '', 'A timeless guide on improving social skills, building relationships, and influencing people positively through communication, empathy, and leadership.', 1936, '0671027034', 'Simon & Schuster', 300.00, 10, '67b9aeb9db3e1.jpeg'),
(54, 'Think and Grow Rich', 'Napoleon Hill', 'Self-help', 238, '', 'A foundational book on success and wealth, teaching the 13 principles of achievement, emphasizing the power of mindset, persistence, and goal-setting.', 1937, '1585424331', 'The Ralston Society', 250.00, 10, '67b9af2242920.jpeg'),
(55, '7 Habits of High Effective People', 'Stephen R. Covey', 'Self-help', 381, '', 'A principle-based framework for personal and professional success, focusing on habits like proactivity, prioritization, and synergy for effectiveness and fulfillment.', 1989, '0743269519', 'Free Press', 450.00, 10, '67b9af8a333a6.jpg'),
(56, 'Man’s Search for Meaning', 'Viktor E. Frankl', 'Self-help', 200, '', 'A powerful memoir and psychological exploration of finding purpose in suffering, based on Frankl’s experiences as a Holocaust survivor and his development of logotherapy.', 1946, '080701429X', 'Beacon Press', 250.00, 10, '67b9afe523530.jpeg'),
(57, 'The Hobbit', 'J.R.R Tolkien', 'Fantasy', 310, '', 'A classic adventure following Bilbo Baggins, a reluctant hobbit who embarks on a journey with a group of dwarves to reclaim their homeland from the dragon Smaug.', 1937, '054792822X', 'George Allen & Unwin', 1300.00, 10, '67b9b0ae0b61c.jpeg'),
(58, 'Harry Potter and the Sorcerer’s Stone', 'J.K. Rowling', 'Fantasy', 309, '', 'The first book in the Harry Potter series introduces Harry, an orphan who discovers he is a wizard and attends Hogwarts School of Witchcraft and Wizardry, where he uncovers a magical destiny.', 1997, '059035342X', 'Bloomsbury (UK) / Scholastic (US)', 800.00, 10, '67b9b1043d088.jpeg'),
(59, 'The Girl with the Dragon Tattoo', 'Stieg Larsson', 'Mystery, Thriller', 465, '', 'Investigative journalist Mikael Blomkvist and hacker Lisbeth Salander uncover dark secrets while solving a decades-old missing person case involving a wealthy Swedish family.', 2005, '0307269752', 'Knopf (US)', 800.00, 10, '67b9b191c8f36.jpeg'),
(60, 'Gone Girl', 'Gillian Flynn', 'Mystery, Thriller', 432, '', 'A psychological thriller about Nick Dunne, whose wife Amy disappears, leaving behind twisted clues. As the media frenzy grows, secrets unravel, and nothing is as it seems.', 2012, '030758836X', 'Crown Publishing Group', 750.00, 10, '67b9b1e8a6c8a.jpeg'),
(61, 'The shining', 'Stephen King', 'Horror', 688, '', 'Jack Torrance, a struggling writer and recovering alcoholic, takes a job as the winter caretaker of the haunted Overlook Hotel. As he, his wife, and their psychic son Danny settle in, the hotel\'s dark past begins to consume them, leading to horrifying consequences.', 1977, '978-0307743657', 'Anchor', 800.00, 10, '67ba0f18512f0.jpeg'),
(62, 'The Exorcist', 'William Peter Blatty', 'Horror', 400, '', 'Inspired by a real exorcism, this terrifying novel follows the possession of a young girl, Regan MacNeil, and the desperate battle of her mother and two priests to save her from the demonic entity taking over her body.', 1971, '978-0061007224', 'Harper publications', 880.00, 10, '67ba0f6ec2f2c.jpg'),
(63, 'Pet Sematary', 'Stephen King', 'Horror', 416, '', 'When Dr. Louis Creed moves his family to a new home, they discover a burial ground with the power to bring back the dead. But some things should stay buried, as Louis soon learns when unimaginable horror follows his choices.', 1983, '978-1501156700', 'Gallery Book Publications', 900.00, 10, '67ba0fe73b4f1.jpeg'),
(64, 'The Haunting of Hill House', 'Shirley Jackson', 'Horror', 182, '', 'A classic haunted house novel about four strangers who gather at Hill House to investigate supernatural occurrences. As eerie events unfold, the psychological terror intensifies, blurring the line between reality and madness.', 1959, '978-0143039983', 'Penguin classics', 900.00, 10, '67ba10694c25c.jpeg'),
(65, 'Games of Thrones', 'George R.R. Martin', 'Fantasy', 694, '', 'In the land of Westeros, noble families engage in brutal power struggles, while an ancient evil awakens in the North. This epic tale of betrayal, war, and magic has captivated readers worldwide.', 1996, '978-0553573404', '1996', 900.00, 10, '67ba11341158a.jpeg'),
(66, 'The Wheel of Time', 'Robert Jordan', 'Fantasy', 694, '', 'A farm boy, Rand al’Thor, is swept into a prophecy that could determine the fate of the world, as ancient forces of darkness rise again.', 1990, '978-0553573404', 'Tor books', 900.00, 10, '67ba11b203e11.jpeg'),
(67, 'The Chronicles of Narnia', 'C.S. Lewis', 'Fantasy', 208, '', 'Four siblings enter the magical land of Narnia through a wardrobe and must help defeat the evil White Witch with the guidance of Aslan the Lion.', 1950, '978-0553573404', 'Geoffrey Bles', 900.00, 10, '67ba12044e979.jpg'),
(68, 'The Da Vinci Code', 'Dan Brown', 'Mystery, Thriller', 489, '', 'Symbologist Robert Langdon races against time to solve a murder mystery involving secret societies, religious history, and hidden messages in Leonardo da Vinci’s artworks.', 2003, '9780735278332', 'Doubleday Publications', 900.00, 10, '67ba1280e1605.jpeg'),
(69, 'The Diary of a Young Girl', 'Anne frank', 'Biography', 283, '', 'A moving account of a Jewish girl\'s life while hiding from the Nazis during World War II. Anne Frank’s diary captures her thoughts, fears, and dreams during this dark period.', 1947, '9780735278332', 'Bantam Books', 300.00, 10, '67ba132d37584.jpg'),
(70, 'Long Walk to Freedom', 'Nelson Mandela', 'Biography', 656, '', 'The powerful memoir of Nelson Mandela, chronicling his early life, activism, 27 years in prison, and his role in dismantling apartheid to become South Africa’s first Black president.', 1994, '978-0316548182', 'Little, Brown and Compan', 500.00, 10, '67ba138bb780f.jpeg'),
(71, 'Steve Jobs', 'Walter Isaacson', 'Biography', 656, '', 'A comprehensive biography of Steve Jobs, co-founder of Apple Inc., detailing his visionary leadership, innovation, and personal struggles. Based on exclusive interviews with Jobs and those close to him.', 2011, '978-0316548182', 'Simon & Schuster', 700.00, 10, '67ba13f09e593.jpg'),
(72, 'Dune', 'Frank Herbert', 'sci-fi', 896, '', 'A futuristic epic following Paul Atreides as he navigates political intrigue, war, and prophecy on the desert planet Arrakis, home to the powerful spice melange.', 1965, '978-0316548182', 'Ace Books', 700.00, 9, '67ba144baea7a.jpeg'),
(73, 'The martian', 'Andy Weir', 'Sci-fi', 896, '', 'Astronaut Mark Watney is left stranded on Mars and must use his engineering skills, intelligence, and humor to survive until a possible rescue mission.', 1965, '978-0316548182', 'Crown Publishing Group', 369.00, 10, '67ba14b40f3e8.jpeg'),
(74, 'Foundation', 'Issac Asimov', 'Sci-fi', 244, '', 'the first book in Asimov\'s legendary Foundation series, it follows mathematician Hari Seldon, who predicts the fall of the Galactic Empire and creates a plan to preserve knowledge and civilization.', 1965, '978-0316548182', 'Bantam Books', 1951.00, 10, '67ba151f96934.jpg'),
(75, 'To Kill a Mockingbird', 'Harper Lee', 'Literature', 336, '', 'A classic American novel that explores themes of racism and justice through the eyes of young Scout Finch in the Deep South during the 1930s.', 1960, '978-0061120084', 'Harper Perennial', 800.00, 10, '67ba15bfa09d0.jpeg'),
(76, 'Crime and Punishment', 'Fyodor Dostoevsky', 'Literature', 671, '', 'A dark psychological novel that follows Raskolnikov, a young man who commits a crime and suffers from deep guilt and paranoia, exploring themes of morality and redemption.', 1866, '9780735278332', 'Penguin classics', 750.00, 10, '67ba1623202d7.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `amount` double NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` enum('Pending','Completed','Cancelled') DEFAULT NULL,
  `address` varchar(30) NOT NULL,
  `phone_no` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `total_price`, `status`, `address`, `phone_no`) VALUES
(48, 12, '2025-02-22 14:11:30', 700.00, 'Completed', 'zero k.m chowk', '9746311761'),
(49, 12, '2025-02-22 23:14:22', 800.00, 'Pending', '7th street, house no. 8, srija', '9746311761');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(19, 48, 72, 1, 700.00),
(20, 49, 36, 1, 800.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(50) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `address`, `phone_no`, `created_at`, `profile_image`) VALUES
(12, 'deepak1761', 'deepakchhantyal2078@gmail.com', '$2y$10$6BmbszgSod9CkYynm0zPxee9FajvIzrZaOLF6UROJ8MuBYJ/uovGS', '7th street, house no. 8, srijana chowk, Pokhara', '9746311761', '2025-02-22 12:19:30', 'uploads/userPfp/profile_67b9f3fa573818.32155136.jpeg'),
(17, 'deepak41561', 'deepak123@gmail.com', '$2y$10$ZUd66HkY9cXi077BUqXUmeu.YitbTHmscgiNdDyvpBV8AGwTKc4Zu', 'pokhara', '97463117611', '2025-02-23 04:06:07', NULL),
(18, 'deepak123', 'deepak321@gmail.com', '$2y$10$aIQh3mbjGJ4tRTKDutZDYuowo0YzozrjU6w2aWHp7qbfM.WPND4lS', 'pokhara', '9746311761', '2025-02-24 10:15:26', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `books` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
