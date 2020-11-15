-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Gép: localhost:3306
-- Létrehozás ideje: 2020. Nov 12. 15:35
-- Kiszolgáló verziója: 10.3.16-MariaDB
-- PHP verzió: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `id15331351_project`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `inroom`
--

CREATE TABLE `inroom` (
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `all_photos` int(11) NOT NULL,
  `num_of_persons` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `room`
--

CREATE TABLE `room` (
  `created_by` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(500) CHARACTER SET utf8 NOT NULL,
  `user_email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `user_profil` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `user_pw` varchar(128) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_profil`, `user_pw`) VALUES
(1, 'Norbi', 'a@example.ru', NULL, '83b05d98186648cd5576ed158c9cf2174413b86d48720c3ffbe6452bc38a6527256ff3435eb1698f24efbc880c8ea870afe314f3004c71cfdd5f0e3c00e3979f'),
(2, 'Norbi', 'a@example.ru', NULL, '83b05d98186648cd5576ed158c9cf2174413b86d48720c3ffbe6452bc38a6527256ff3435eb1698f24efbc880c8ea870afe314f3004c71cfdd5f0e3c00e3979f');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `inroom`
--
ALTER TABLE `inroom`
  ADD PRIMARY KEY (`user_id`,`room_id`);

--
-- A tábla indexei `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`created_by`,`room_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
