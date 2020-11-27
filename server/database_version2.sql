-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Gép: localhost:3306
-- Létrehozás ideje: 2020. Nov 27. 17:13
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

DELIMITER $$
--
-- Eljárások
--
CREATE DEFINER=`id15331351_norbi`@`%` PROCEDURE `insert_registration` (IN `p_fullname` VARCHAR(150) CHARSET utf8, IN `p_email` VARCHAR(150) CHARSET utf8, IN `p_pw` VARCHAR(128) CHARSET utf8, OUT `p_message` VARCHAR(5000) CHARSET utf8)  MODIFIES SQL DATA
BEGIN
	DECLARE v_mindenok INT DEFAULT 1;
	DECLARE v_email VARCHAR(150);
	DECLARE v_id INT DEFAULT 0;
START TRANSACTION;
	SET p_message = 'ok';
	IF(LENGTH(p_email)>150 OR LENGTH(p_fullname)>150 OR LENGTH(p_email)<1 OR LENGTH(p_fullname)<1 OR LENGTH(p_pw)<1 OR LENGTH(p_pw)>128) THEN
		SET v_mindenok = 0;
		SET p_message = CONCAT(p_message, ' Length of email and fullname must be between 1-150! ');
	END IF;
	SELECT COUNT(user_email) INTO v_email FROM users WHERE user_email = p_email;
	IF(v_email > 0) THEN
		SET v_mindenok = 0;
		SET p_message = CONCAT(p_message, ' There have been already a registration with this email! ');
	END IF;
	
	IF(v_mindenok = 1) THEN
		INSERT INTO users (user_name, user_email, user_pw) VALUES(p_fullname, p_email, p_pw);
		SELECT user_id INTO v_id FROM users WHERE user_email = p_email;
		IF(v_id > 0) THEN
			INSERT INTO logs (user_id, log_content, log_date) VALUES(v_id, 'SUCCESSFUL Registration. ', NOW());
		ELSE
			SET v_mindenok = 0;
			SET p_message = CONCAT(p_message, ' An error occured with the user ID! ');
		END IF;
	END IF;
	
	IF(v_mindenok = 1) THEN
		COMMIT;
	ELSE
		ROLLBACK;
	END IF;
END$$

CREATE DEFINER=`id15331351_norbi`@`%` PROCEDURE `user_login` (IN `p_email` VARCHAR(150) CHARSET utf8, IN `p_pw` VARCHAR(128) CHARSET utf8, OUT `p_message` VARCHAR(5000) CHARSET utf8)  MODIFIES SQL DATA
BEGIN
	DECLARE v_mindenok INT;
	DECLARE v_db INT;
	DECLARE v_useremail VARCHAR(150);
	DECLARE v_password VARCHAR(128);
	DECLARE v_id INT;
START TRANSACTION;
	SET v_mindenok = 1;
	SET p_message = '.';
	SELECT COUNT(user_email) INTO v_db FROM users WHERE user_email = p_email;
	IF(v_db = 1) THEN
		
		SELECT user_id, user_email, user_pw INTO v_id, v_useremail, v_password FROM users WHERE user_email = p_email;
		IF((v_password = p_pw) = 0) THEN
			INSERT INTO logs (user_id, log_content, log_date) VALUES(v_id, 'SUCCESSFUL Login. ', NOW());
		ELSE
			SET v_mindenok = 0;
			SET p_message = CONCAT(p_message, 'Incorrect password! ');
		END IF;
	ELSE
		SET v_mindenok = 0;
		SET p_message = CONCAT(p_message, 'Login failed! ');
	END IF;
	
	IF(v_mindenok = 1) THEN
		SET p_message = 'ok';
		COMMIT;
	ELSE
		ROLLBACK;
	END IF;
END$$

DELIMITER ;

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
-- Tábla szerkezet ehhez a táblához `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `log_content` varchar(5000) CHARACTER SET utf8 NOT NULL,
  `log_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- A tábla adatainak kiíratása `logs`
--

INSERT INTO `logs` (`log_id`, `user_id`, `log_content`, `log_date`) VALUES
(1, 4, 'SUCCESSFUL Registration. ', '2020-11-27 06:43:58'),
(2, 5, 'SUCCESSFUL Registration. ', '2020-11-27 09:11:26'),
(3, 6, 'SUCCESSFUL Registration. ', '2020-11-27 10:07:18'),
(4, 9, 'SUCCESSFUL Registration. ', '2020-11-27 12:22:38');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `room`
--

CREATE TABLE `room` (
  `created_by` int(11) NOT NULL,
  `room_name` varchar(150) CHARACTER SET utf8 NOT NULL,
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
  `user_pw` varchar(128) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_pw`) VALUES
(1, 'Norbi', 'a@example.ru', '83b05d98186648cd5576ed158c9cf2174413b86d48720c3ffbe6452bc38a6527256ff3435eb1698f24efbc880c8ea870afe314f3004c71cfdd5f0e3c00e3979f'),
(2, 'Norbi', 'a@example.ru', '83b05d98186648cd5576ed158c9cf2174413b86d48720c3ffbe6452bc38a6527256ff3435eb1698f24efbc880c8ea870afe314f3004c71cfdd5f0e3c00e3979f'),
(3, 'Norbi', 'a@example.ru', '83b05d98186648cd5576ed158c9cf2174413b86d48720c3ffbe6452bc38a6527256ff3435eb1698f24efbc880c8ea870afe314f3004c71cfdd5f0e3c00e3979f'),
(4, 'asd', 'asd', 'efsc'),
(5, 'qwe', 'qwe', 'qwe'),
(6, 'Kedves Norbert', 'kedves.norbert@student.ms.sapientia.ro', '83b05d98186648cd5576ed158c9cf2174413b86d48720c3ffbe6452bc38a6527256ff3435eb1698f24efbc880c8ea870afe314f3004c71cfdd5f0e3c00e3979f'),
(9, 'Kedves Norbert', 'abc@gmail.com', '83b05d98186648cd5576ed158c9cf2174413b86d48720c3ffbe6452bc38a6527256ff3435eb1698f24efbc880c8ea870afe314f3004c71cfdd5f0e3c00e3979f');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `inroom`
--
ALTER TABLE `inroom`
  ADD PRIMARY KEY (`user_id`,`room_id`);

--
-- A tábla indexei `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`);

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
-- AUTO_INCREMENT a táblához `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
