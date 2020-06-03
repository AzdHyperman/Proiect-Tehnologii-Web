-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: iun. 03, 2020 la 10:35 PM
-- Versiune server: 10.4.11-MariaDB
-- Versiune PHP: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `bookreviewer`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELAȚII PENTRU TABELE `authors`:
--

--
-- Eliminarea datelor din tabel `authors`
--

INSERT INTO `authors` (`id`, `name`) VALUES
(4, 'Miaunel si balanel'),
(2, 'Miaunel si balanel 2'),
(3, 'Mihai Eminescu');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `publHouse_id` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `body` tinytext NOT NULL,
  `title` varchar(50) NOT NULL,
  `posting_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELAȚII PENTRU TABELE `books`:
--   `author_id`
--       `authors` -> `id`
--   `publHouse_id`
--       `publishinghouses` -> `id`
--

--
-- Eliminarea datelor din tabel `books`
--

INSERT INTO `books` (`id`, `author_id`, `publHouse_id`, `year`, `body`, `title`, `posting_date`) VALUES
(2, 2, 1, 2006, 'Carte de colorat pentru copii cu flori si fluturi', 'Desene pentru copii', '2020-05-21'),
(3, 3, 3, 2014, 'o descriere la carte,da', 'carte2', '2020-06-01');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `booksgenres`
--

CREATE TABLE `booksgenres` (
  `book_id` int(11) NOT NULL,
  `genre_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELAȚII PENTRU TABELE `booksgenres`:
--   `book_id`
--       `books` -> `id`
--   `genre_name`
--       `genres` -> `name`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `body` varchar(200) NOT NULL,
  `id_article` int(11) NOT NULL,
  `type` enum('book','review') NOT NULL,
  `user_id` int(11) NOT NULL,
  `posted_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELAȚII PENTRU TABELE `comments`:
--   `user_id`
--       `users` -> `id`
--

--
-- Eliminarea datelor din tabel `comments`
--

INSERT INTO `comments` (`id`, `body`, `id_article`, `type`, `user_id`, `posted_at`) VALUES
(1, 'comment updated', 2, 'book', 2, '0000-00-00'),
(3, 'imi place cartea, super faina, recomand', 2, 'book', 2, '2020-05-29'),
(4, 'comentariu review', 0, 'review', 2, '2020-05-29'),
(5, 'comentariu review', 3, 'review', 2, '2020-05-29'),
(7, 'comentez si eu pe aici', 2, 'book', 3, '2020-06-01'),
(8, 'comentez si eu pe aici pramandhsndn', 2, 'book', 3, '2020-06-01');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `parent` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELAȚII PENTRU TABELE `genres`:
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `publishinghouses`
--

CREATE TABLE `publishinghouses` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `country` varchar(30) DEFAULT NULL,
  `founded` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELAȚII PENTRU TABELE `publishinghouses`:
--

--
-- Eliminarea datelor din tabel `publishinghouses`
--

INSERT INTO `publishinghouses` (`id`, `name`, `country`, `founded`) VALUES
(1, 'Paralela 45', 'Romania', 1986),
(3, 'Timpul', 'Romania', 1967);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `body` tinytext NOT NULL,
  `book_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `posting_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELAȚII PENTRU TABELE `reviews`:
--   `user_id`
--       `users` -> `id`
--

--
-- Eliminarea datelor din tabel `reviews`
--

INSERT INTO `reviews` (`id`, `title`, `body`, `book_id`, `user_id`, `posting_date`) VALUES
(2, 'Miau', 'dfgdhdhdhdfh', 0, 3, '2020-05-24'),
(4, 'Review pt Carticica', 'Mi-a placut aceasta Carte de colorat pentru copii cu flori si fluturi', 0, 3, '2020-05-24'),
(9, 'minunat review', 'am scris sho un review,da, iacasa', 2, 7, '2020-06-01'),
(10, 'minunat review', 'am scris sho un review,da, iacasa', 2, 7, '2020-06-01'),
(11, 'minunat review', 'am scris sho un review,da, iacasa', 2, 7, '2020-06-03');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `birthday` date NOT NULL,
  `gender` enum('M','F','-') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELAȚII PENTRU TABELE `users`:
--

--
-- Eliminarea datelor din tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `email`, `birthday`, `gender`) VALUES
(1, 'mariuca20', '*ACC4557F5BE7A85020E3701B63B184E90B24DC7C', 'maria', 'popa', 'jojo20202@gmail.com', '2020-05-12', 'F'),
(2, 'jojo', '', 'Geo', 'Bobitx', 'jojo20202@gmail.com', '0000-00-00', ''),
(3, 'jojo20202', '*3C5913F2D988CE3333403A2221721C2B13E5E0C5', 'Georgi', 'Bobitz', 'miau@yahoo.com', '1998-05-20', 'M'),
(7, 'miau', '*FCBAB14F2742234BDFB4A7B98921125FC0C76FA7', 'balanel', 'balanel', 'maieu@gogu.com', '0000-00-00', 'M'),
(8, 'miau2', '*FCBAB14F2742234BDFB4A7B98921125FC0C76FA7', 'balanel2', 'balanel2', 'maie2u@gogu.com', '2019-02-03', 'M');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `votes`
--

CREATE TABLE `votes` (
  `article_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_type` enum('book','review') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELAȚII PENTRU TABELE `votes`:
--   `article_id`
--       `reviews` -> `id`
--

--
-- Eliminarea datelor din tabel `votes`
--

INSERT INTO `votes` (`article_id`, `value`, `user_id`, `article_type`) VALUES
(2, 5, 3, 'review'),
(2, 5, 3, 'review');

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `author_name_unique` (`name`);

--
-- Indexuri pentru tabele `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_author` (`author_id`),
  ADD KEY `fk_publHouse` (`publHouse_id`);

--
-- Indexuri pentru tabele `booksgenres`
--
ALTER TABLE `booksgenres`
  ADD KEY `fk_book` (`book_id`),
  ADD KEY `fk_genre` (`genre_name`);

--
-- Indexuri pentru tabele `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexuri pentru tabele `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_genre` (`name`);

--
-- Indexuri pentru tabele `publishinghouses`
--
ALTER TABLE `publishinghouses`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexuri pentru tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_username` (`username`);

--
-- Indexuri pentru tabele `votes`
--
ALTER TABLE `votes`
  ADD KEY `fk_review` (`article_id`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pentru tabele `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pentru tabele `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pentru tabele `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pentru tabele `publishinghouses`
--
ALTER TABLE `publishinghouses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pentru tabele `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pentru tabele `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constrângeri pentru tabele eliminate
--

--
-- Constrângeri pentru tabele `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_author` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`),
  ADD CONSTRAINT `fk_publHouse` FOREIGN KEY (`publHouse_id`) REFERENCES `publishinghouses` (`id`);

--
-- Constrângeri pentru tabele `booksgenres`
--
ALTER TABLE `booksgenres`
  ADD CONSTRAINT `fk_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `fk_genre` FOREIGN KEY (`genre_name`) REFERENCES `genres` (`name`);

--
-- Constrângeri pentru tabele `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constrângeri pentru tabele `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constrângeri pentru tabele `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `fk_review` FOREIGN KEY (`article_id`) REFERENCES `reviews` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
