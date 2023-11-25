-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 25. Nov 2023 um 13:19
-- Server-Version: 10.4.28-MariaDB
-- PHP-Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `be20_cr5_animal_adoption_brunokreppel`
--
CREATE DATABASE IF NOT EXISTS `be20_cr5_animal_adoption_brunokreppel` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `be20_cr5_animal_adoption_brunokreppel`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `animal`
--

CREATE TABLE `animal` (
  `animal_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo_url` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `vaccinated` tinyint(1) DEFAULT NULL,
  `breed` varchar(100) NOT NULL,
  `status` enum('Adopted','Available') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `animal`
--

INSERT INTO `animal` (`animal_id`, `name`, `photo_url`, `location`, `description`, `size`, `age`, `vaccinated`, `breed`, `status`) VALUES
(1, 'Buddyy', 'https://www.animalcare-austria.at/media/85863/dodo_1.jpg?anchor=center&mode=crop&width=270&height=338&rnd=133450233440000000&quality=70', '123 Main St', 'Friendly dog', 'Medium', 3, 0, 'Golden Retriever', 'Available'),
(2, 'Whiskers', 'https://www.animalcare-austria.at/media/86013/katze-17_08200179.jpg?anchor=center&mode=crop&quality=70&width=445&height=317&bgcolor=ffffff&rnd=133404076110000000', '456 Oak St', 'Playful cat', 'Small', 2, 1, 'Siamese', 'Available'),
(3, 'Rocky', 'https://www.tierschutz-austria.at/wp-content/uploads/2022/10/DSC_0322.jpg', '789 Pine St', 'Energetic hamster', 'Tiny', 3, 1, 'Syrian', 'Available'),
(4, 'Mittens', 'https://www.olddominionveterinaryclinic.com/wp-content/uploads/2022/03/WP-Blog-Image-2022-15.png', '101 Elm St', 'Cuddly kitten', 'Small', 1, 1, 'Domestic Shorthair', 'Adopted'),
(5, 'Rexd', 'https://images.saymedia-content.com/.image/t_share/MTc0MDcyMTQyMDQ2OTYzMjY2/german-shepherd-rescue-and-adoption.jpg', '202 Cedar St', 'Loyal German Shepherd', 'Large', 4, 1, 'German Shepherd', 'Available'),
(6, 'Coco', 'https://media.istockphoto.com/id/91401175/photo/green-parrot-perched-on-the-open-door-of-its-cage.jpg?s=612x612&w=0&k=20&c=bKc4NDVIzUDsWxzIdtBXd1x2K3c_z_uDFpczneWvosY=', '303 Birch St', 'Adventurous parrot', 'Small', 9, 0, 'Cockatiel', 'Adopted'),
(7, 'Luna', 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1f/Oryctolagus_cuniculus_Rcdo.jpg/1200px-Oryctolagus_cuniculus_Rcdo.jpg', '404 Maple St', 'Playful rabbit', 'Medium', 2, 1, 'Holland Lop', 'Available'),
(8, 'Charlie', 'https://www.thesprucepets.com/thmb/mSDbzoZb7vkGehMuqz-4MVYAI4U=/3500x0/filters:no_upscale():strip_icc()/importance-of-turnout-for-your-horse-1886932-04-ad68adffccad46c6b00ffe41e0acdbd0.jpg', '505 Pine St', 'Gentle horse', 'Large', 8, 1, 'Thoroughbred', 'Adopted'),
(9, 'Oreo', 'https://image.petmd.com/files/styles/863x625/public/CANS-long-hair-guinea247942651.jpg', '606 Oak St', 'Sweet guinea pig', 'Tiny', 1, 1, 'American', 'Available'),
(10, 'Simba', 'https://as2.ftcdn.net/v2/jpg/02/16/09/45/1000_F_216094514_AUsBJQY6LDqIKKoz3jWe681CT4W8yNky.jpg', '707 Elm St', 'Majestic lion', 'Huge', 14, 0, 'African Lion', 'Available'),
(11, 'Molly', 'https://qph.cf2.quoracdn.net/main-qimg-232e1cd46260642b4b4492006d1d10bc-lq', '808 Cedar St', 'Affectionate fish', 'Tiny', 1, 0, 'Betta', 'Available'),
(12, 'Sasha', 'https://i.imgur.com/kyoGBof.jpeg', '909 Birch St', 'Curious snake', 'Small', 10, 0, 'Ball Python', 'Adopted');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pet_adoption`
--

CREATE TABLE `pet_adoption` (
  `id` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `fk_animal` int(11) NOT NULL,
  `adoption_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `picture_url` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `email`, `phone_number`, `address`, `picture_url`, `password`, `status`) VALUES
(1, 'Bruno', 'Kreppel', 'bruno.kreppel@gmail.com', '069911046695', '', 'avatar.png', '956cd9e97c44cbb5c9f18ccf258bb3ea0fbac91d027d2ac9489185f531478242', 'adm'),
(6, 'Code Factory', '', 'office@codefactory.wien', '0699124897127', 'Kettenbrückengasse', '6561e30c922f9.jpg', 'b7fe96979b3015d34bf391cc61fa554507e1d7b5f1b274c7b360a87e621097e6', 'adm'),
(8, 'test', 'user', 'test@gmail.com', '12312414', 'Wien', 'avatar.png', 'ecd71870d1963316a97e3ac3408c9835ad8cf0f3c1bc703527c30265534f75ae', 'user'),
(9, 'Code Factory User', '', 'codefactory@user.com', '12412412412', 'Wien', 'avatar.png', 'e606e38b0d8c19b24cf0ee3808183162ea7cd63ff7912dbb22b5e803286b4446', 'user');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`animal_id`);

--
-- Indizes für die Tabelle `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`fk_user`),
  ADD KEY `fk_animal` (`fk_animal`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `animal`
--
ALTER TABLE `animal`
  MODIFY `animal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT für Tabelle `pet_adoption`
--
ALTER TABLE `pet_adoption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD CONSTRAINT `fk_animal` FOREIGN KEY (`fk_animal`) REFERENCES `animal` (`animal_id`),
  ADD CONSTRAINT `pet_adoption_ibfk_1` FOREIGN KEY (`fk_user`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
