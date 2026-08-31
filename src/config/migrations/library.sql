SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `books` (
  `book_id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `code` varchar(16) NOT NULL,
  `title` varchar(64) NOT NULL,
  `author` varchar(64) NOT NULL,
  `isbn` varchar(64) NOT NULL,
  `genre` varchar(64) NOT NULL,
  `year` varchar(4) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `available` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `loans` (
  `loan_id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `code` varchar(16) NOT NULL,
  `member_code` varchar(36) NOT NULL,
  `book_code` varchar(36) NOT NULL,
  `loaned_at` datetime NOT NULL,
  `due_at` datetime NOT NULL,
  `returned_at` datetime DEFAULT NULL,
  `is_returned` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `members` (
  `member_id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `code` varchar(16) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `phone` varchar(36) NOT NULL,
  `document` varchar(36) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `users` (
  `user_id` varchar(36) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(255) NOT NULL,
  `library_name` varchar(64) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `unique_user_title` (`user_id`,`title`),
  ADD UNIQUE KEY `unique_user_code` (`user_id`,`code`);

ALTER TABLE `loans`
  ADD PRIMARY KEY (`loan_id`),
  ADD UNIQUE KEY `unique_user_code` (`user_id`,`code`),
  ADD KEY `user_id` (`user_id`,`member_code`),
  ADD KEY `user_id_2` (`user_id`,`book_code`);

ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD UNIQUE KEY `unique_user_code` (`user_id`,`code`),
  ADD UNIQUE KEY `unique_user_name` (`user_id`,`name`),
  ADD UNIQUE KEY `unique_user_email` (`user_id`,`email`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `loans_ibfk_2` FOREIGN KEY (`user_id`,`member_code`) REFERENCES `members` (`user_id`, `code`) ON DELETE CASCADE,
  ADD CONSTRAINT `loans_ibfk_3` FOREIGN KEY (`user_id`,`book_code`) REFERENCES `books` (`user_id`, `code`) ON DELETE CASCADE;

ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;
