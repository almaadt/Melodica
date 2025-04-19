-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 19, 2025 alle 12:07
-- Versione del server: 10.4.27-MariaDB
-- Versione PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `melodica`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `artisti`
--

CREATE TABLE `artisti` (
  `id_artista` int(11) NOT NULL,
  `nome_artista` varchar(255) NOT NULL,
  `img_artista` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `artisti`
--

INSERT INTO `artisti` (`id_artista`, `nome_artista`, `img_artista`) VALUES
(1, 'Franco Battiato', 'img/battiato.png'),
(4, 'Francesco De Gregori', 'img/degregori.png'),
(5, 'Bring Me The Horizon', 'img/bmth.png'),
(6, 'Bad Omens', 'img/badomens.png'),
(7, 'Ghost', 'img/ghost.png'),
(8, 'Avicii', 'img/avicii.png'),
(9, 'Sleep Token', 'img/sleeptoken.png'),
(10, 'HIM', 'img/him.png'),
(11, 'Red Hot Chili Peppers', 'img/rhcp.png');

-- --------------------------------------------------------

--
-- Struttura della tabella `ascolti`
--

CREATE TABLE `ascolti` (
  `id_ascolto` int(11) NOT NULL,
  `id_brano_asc` int(11) NOT NULL,
  `id_utente_asc` int(11) NOT NULL,
  `contatore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ascolti`
--

INSERT INTO `ascolti` (`id_ascolto`, `id_brano_asc`, `id_utente_asc`, `contatore`) VALUES
(1, 5, 11, 6),
(2, 27, 11, 34),
(3, 28, 11, 30),
(4, 29, 11, 35),
(5, 30, 11, 14),
(6, 31, 11, 37),
(7, 32, 11, 45),
(8, 33, 11, 51),
(9, 34, 11, 23),
(10, 9, 11, 140),
(13, 12, 11, 7),
(14, 25, 11, 2),
(15, 10, 11, 2),
(16, 6, 11, 3),
(17, 1, 11, 6),
(18, 8, 11, 3),
(19, 32, 47, 22),
(20, 4, 47, 3),
(21, 30, 47, 11),
(22, 1, 47, 13),
(23, 32, 48, 1),
(24, 27, 48, 1),
(25, 28, 48, 1),
(26, 22, 48, 1),
(27, 5, 48, 2),
(28, 25, 48, 1),
(29, 31, 48, 1),
(30, 4, 48, 1),
(31, 33, 49, 16),
(32, 9, 49, 3),
(33, 8, 49, 2),
(34, 5, 49, 5),
(35, 28, 49, 1),
(36, 25, 49, 1),
(37, 7, 49, 1),
(38, 34, 49, 3),
(39, 4, 49, 1),
(40, 28, 47, 14),
(41, 9, 47, 19),
(42, 31, 47, 10),
(43, 6, 47, 15),
(44, 23, 47, 9),
(45, 12, 47, 8),
(46, 22, 47, 6),
(47, 29, 47, 4),
(48, 25, 47, 4),
(49, 5, 47, 7),
(50, 35, 11, 1),
(51, 36, 11, 1),
(52, 37, 11, 2),
(53, 38, 11, 1),
(54, 39, 11, 1),
(55, 38, 47, 1),
(56, 10, 47, 3),
(57, 8, 47, 3),
(58, 39, 47, 9),
(59, 6, 49, 1),
(60, 10, 49, 1),
(61, 1, 49, 2),
(62, 35, 49, 1),
(63, 36, 49, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `brani`
--

CREATE TABLE `brani` (
  `id_brano` int(11) NOT NULL,
  `nome_brano` varchar(255) NOT NULL,
  `durata` time NOT NULL,
  `id_artista` int(255) NOT NULL,
  `id_genere_brano` int(11) NOT NULL,
  `nome_file` varchar(255) NOT NULL,
  `img_brano` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `brani`
--

INSERT INTO `brani` (`id_brano`, `nome_brano`, `durata`, `id_artista`, `id_genere_brano`, `nome_file`, `img_brano`) VALUES
(1, 'Bandiera Bianca', '00:04:55', 1, 2, 'brani/Franco Battiato - Bandiera Bianca.mp3', 'img/brani/bbianca.png'),
(4, 'Generale', '00:04:21', 4, 2, 'brani/Francesco De Gregori - Generale.mp3', 'img/brani/generale.png'),
(5, 'WONDERWaLL', '00:04:00', 5, 1, 'brani/Bring Me The Horizon - WONDERWaLL.mp3', 'img/brani/wonderwall.png'),
(6, 'Follow You', '00:03:39', 5, 1, 'brani/Bring Me The Horizon - Follow You.mp3', 'img/brani/tts.png'),
(7, 'Take Me First', '00:03:19', 6, 1, 'brani/Bad Omens - Take Me First.mp3', 'img/brani/bdomens.png'),
(8, 'Broken Arrows', '00:03:54', 8, 3, 'brani/Avicii - Broken Arrows.mp3', 'img/brani/stories.png'),
(9, 'Rain', '00:04:12', 9, 1, 'brani/Sleep Token - Rain.mp3', 'img/brani/rain.png'),
(10, 'Join Me', '00:03:34', 10, 4, 'brani/HIM - Join Me.mp3', 'img/brani/joinme.png'),
(12, 'Wicked Game', '00:03:53', 10, 4, 'brani/HIM - Wicked Game.mp3', 'img/brani/wickedgame.png'),
(22, 'Just Pretend', '00:03:24', 6, 1, 'brani/Bad Omens - Just Pretend.mp3', 'img/brani/justpretend.png'),
(23, 'Like A Villain', '00:03:31', 6, 1, 'brani/Bad Omens - Like A Villain.mp3', 'img/brani/bdomens.png'),
(25, 'Alkaline', '00:03:31', 9, 1, 'brani/Sleep Token - Alkaline.mp3', 'img/brani/alkaline.png'),
(27, 'Aqua Regia', '00:03:56', 9, 1, 'brani/Sleep Token - Aqua Regia.mp3', 'img/brani/aquaregia.png'),
(28, 'sTraNgeRs', '00:03:15', 5, 1, 'brani/Bring Me The Horizon - sTraNgeRs.mp3', 'img/brani/strangers.png'),
(29, 'The Nights', '00:02:55', 8, 3, 'brani/Avicii - The Nights.mp3', 'img/brani/thenights.png'),
(30, 'Tracks Of My Tears', '00:02:15', 8, 3, 'brani/Avicii - Tracks Of My Tears.mp3', 'img/brani/tomt.png'),
(31, 'Lachryma', '00:05:09', 7, 1, 'brani/Ghost - Lachryma.mp3', 'img/brani/lachryma.png'),
(32, 'Square Hammer', '00:03:59', 7, 1, 'brani/Ghost - Square Hammer.mp3', 'img/brani/squarehammer.png'),
(33, 'Wings of A Butterfly', '00:03:28', 10, 4, 'brani/HIM - Wings of A Butterfly.mp3', 'img/brani/woab.png'),
(34, 'Ritual', '00:04:28', 7, 1, 'brani/Ghost - Ritual.mp3', 'img/brani/ritual.png'),
(35, 'No Time No Space', '00:03:31', 1, 2, 'brani/Franco Battiato - No Time No Space.mp3', 'img/brani/ntns.png'),
(36, 'Voglio Vederti Danzare', '00:03:44', 1, 2, 'brani/Franco Battiato - Voglio Vederti Danzare.mp3', 'img/brani/vvd.png'),
(37, 'La donna cannone', '00:04:41', 4, 2, 'brani/Francesco De Gregori - La donna cannone.mp3', 'img/brani/donnacan.png'),
(38, 'Il Bandito e il Campione', '00:04:18', 4, 2, 'brani/Francesco De Gregori - Il Bandito e il Campione.mp3', 'img/brani/bec.png'),
(39, 'Dani California', '00:04:46', 11, 4, 'brani/Red Hot Chili Peppers - Dani California.mp3', 'img/brani/danicali.png');

-- --------------------------------------------------------

--
-- Struttura della tabella `brani_playlist`
--

CREATE TABLE `brani_playlist` (
  `id_brano_playlist` int(11) NOT NULL,
  `id_utente_bp` int(255) NOT NULL,
  `id_playlist_p` int(11) NOT NULL,
  `id_brano_b` int(11) NOT NULL,
  `data_brano_playlist` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `brani_playlist`
--

INSERT INTO `brani_playlist` (`id_brano_playlist`, `id_utente_bp`, `id_playlist_p`, `id_brano_b`, `data_brano_playlist`) VALUES
(1, 11, 3, 5, '2025-02-19 16:07:48'),
(2, 11, 3, 6, '2025-02-19 16:07:51'),
(3, 11, 3, 10, '2025-02-19 16:07:55'),
(4, 11, 3, 28, '2025-02-22 14:56:29'),
(16, 49, 84, 1, '2025-04-15 11:02:08'),
(17, 49, 84, 4, '2025-04-15 11:02:12'),
(20, 49, 83, 8, '2025-04-15 11:02:21'),
(22, 49, 83, 12, '2025-04-15 11:02:29'),
(24, 49, 83, 28, '2025-04-15 11:02:39'),
(25, 49, 83, 31, '2025-04-15 11:02:42'),
(26, 49, 83, 33, '2025-04-15 11:02:44'),
(27, 47, 85, 5, '2025-04-15 16:42:35'),
(29, 47, 85, 8, '2025-04-15 16:42:40'),
(30, 47, 85, 9, '2025-04-15 16:42:43'),
(31, 47, 85, 12, '2025-04-15 16:42:48'),
(32, 47, 85, 23, '2025-04-15 16:42:51'),
(33, 47, 85, 25, '2025-04-15 16:42:53'),
(34, 47, 85, 27, '2025-04-15 16:42:56'),
(35, 47, 85, 28, '2025-04-15 16:42:59'),
(36, 47, 85, 30, '2025-04-15 16:43:02'),
(37, 47, 85, 31, '2025-04-15 16:43:04'),
(38, 47, 85, 32, '2025-04-15 16:43:07'),
(39, 47, 85, 33, '2025-04-15 16:43:13'),
(40, 47, 85, 34, '2025-04-15 16:43:16'),
(41, 47, 85, 1, '2025-04-16 16:54:03'),
(42, 47, 85, 4, '2025-04-16 16:54:06'),
(43, 49, 82, 1, '2025-04-18 09:34:57'),
(44, 49, 82, 4, '2025-04-18 09:35:00'),
(45, 49, 82, 38, '2025-04-18 09:35:07'),
(46, 49, 82, 37, '2025-04-18 09:35:12'),
(47, 49, 82, 36, '2025-04-18 09:35:15'),
(48, 49, 82, 35, '2025-04-18 09:35:17'),
(49, 11, 1, 1, '2025-04-19 09:10:44'),
(50, 11, 1, 28, '2025-04-19 09:10:46'),
(51, 11, 1, 36, '2025-04-19 09:10:48'),
(52, 11, 1, 37, '2025-04-19 09:10:50'),
(53, 11, 1, 38, '2025-04-19 09:10:52'),
(54, 11, 1, 39, '2025-04-19 09:10:56');

-- --------------------------------------------------------

--
-- Struttura della tabella `generi`
--

CREATE TABLE `generi` (
  `id_genere` int(11) NOT NULL,
  `nome_genere` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `generi`
--

INSERT INTO `generi` (`id_genere`, `nome_genere`) VALUES
(1, 'metalcore'),
(2, 'ita'),
(3, 'edm'),
(4, 'rock'),
(5, 'disco'),
(6, 'pop');

-- --------------------------------------------------------

--
-- Struttura della tabella `logs`
--

CREATE TABLE `logs` (
  `id_log` int(11) NOT NULL,
  `id_utente_log` int(11) DEFAULT NULL,
  `ip` varchar(255) NOT NULL,
  `tipo_log` varchar(255) NOT NULL,
  `esito_log` varchar(255) NOT NULL,
  `data_log` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `logs`
--

INSERT INTO `logs` (`id_log`, `id_utente_log`, `ip`, `tipo_log`, `esito_log`, `data_log`) VALUES
(8, 50, '127.0.0.1', 'LOGIN', 'OK', '2025-04-18 08:35:21'),
(9, NULL, '127.0.0.1', 'LOGIN', 'FAILED', '2025-04-18 08:35:22'),
(10, NULL, '127.0.0.1', 'LOGIN', 'FAILED', '2025-04-18 08:35:24'),
(11, 11, '127.0.0.1', 'LOGIN', 'OK', '2025-04-18 08:35:26'),
(12, 11, '127.0.0.1', 'LOGOUT', 'OK', '2025-04-18 08:35:28'),
(13, NULL, '127.0.0.1', 'LOGIN', 'FAILED', '2025-04-18 08:35:35'),
(14, 47, '127.0.0.1', 'LOGIN', 'OK', '2025-04-18 08:35:38'),
(15, 47, '127.0.0.1', 'LOGOUT', 'OK', '2025-04-18 08:35:41'),
(16, NULL, '127.0.0.1', 'LOGIN', 'FAILED', '2025-04-18 08:35:43'),
(17, 11, '127.0.0.1', 'LOGIN', 'OK', '2025-04-18 08:35:44'),
(18, 11, '127.0.0.1', 'LOGOUT', 'OK', '2025-04-18 08:34:19'),
(19, 47, '192.168.0.15', 'LOGIN', 'OK', '2025-04-18 08:24:57'),
(22, 47, '192.168.0.15', 'LOGOUT', 'OK', '2025-04-18 08:21:57'),
(23, 11, '192.168.0.15', 'LOGIN', 'OK', '2025-04-18 08:23:37'),
(24, 11, '192.168.0.15', 'LOGOUT', 'OK', '2025-04-18 08:23:42'),
(25, NULL, '127.0.0.1', 'LOGIN', 'FAILED', '2025-04-18 08:34:07'),
(26, 50, '127.0.0.1', 'LOGIN', 'OK', '2025-04-18 08:34:11'),
(27, 50, '127.0.0.1', 'LOGOUT', 'OK', '2025-04-18 08:34:13'),
(28, NULL, '192.168.0.21', 'LOGIN', 'FAILED', '2025-04-18 08:26:47'),
(31, 47, '127.0.0.1', 'LOGIN', 'OK', '2025-04-18 08:33:31'),
(33, 11, '127.0.0.1', 'LOGIN', 'OK', '2025-04-18 08:34:52'),
(34, 11, '127.0.0.1', 'LOGOUT', 'OK', '2025-04-18 08:34:56'),
(35, NULL, '127.0.0.1', 'LOGIN', 'FAILED', '2025-04-18 08:36:30'),
(36, 47, '127.0.0.1', 'LOGIN', 'OK', '2025-04-18 08:40:18'),
(37, 47, '127.0.0.1', 'LOGIN', 'OK', '2025-04-18 08:53:11'),
(38, 47, '127.0.0.1', 'LOGOUT', 'OK', '2025-04-18 09:32:29'),
(39, 49, '127.0.0.1', 'LOGIN', 'OK', '2025-04-18 09:32:34'),
(40, 47, '127.0.0.1', 'LOGIN', 'OK', '2025-04-19 08:19:51'),
(41, 11, '127.0.0.1', 'LOGIN', 'OK', '2025-04-19 09:08:04'),
(42, 11, '127.0.0.1', 'LOGIN', 'OK', '2025-04-19 09:08:26'),
(43, NULL, '127.0.0.1', 'LOGIN', 'FAILED', '2025-04-19 10:03:36');

-- --------------------------------------------------------

--
-- Struttura della tabella `playlist`
--

CREATE TABLE `playlist` (
  `id_playlist` int(255) NOT NULL,
  `id_utente_owner` varchar(255) NOT NULL,
  `nome_playlist` varchar(255) NOT NULL,
  `visibilita` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `playlist`
--

INSERT INTO `playlist` (`id_playlist`, `id_utente_owner`, `nome_playlist`, `visibilita`) VALUES
(1, '11', 'playlist an', 1),
(2, '46', 'playlist2', 0),
(3, '11', 'playlist 001', 0),
(82, '49', 'Playlist ita', 1),
(83, '49', 'Playlist Prova', 0),
(84, '49', 'Playlist 3', 0),
(85, '47', 'mia playlist 01', 0),
(87, '49', 'playlist vuota', 1),
(88, '47', 'playlist 02', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `preferiti`
--

CREATE TABLE `preferiti` (
  `id_preferito` int(11) NOT NULL,
  `id_brano_pref` int(11) NOT NULL,
  `id_utente_pref` int(11) NOT NULL,
  `data_pref` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `preferiti`
--

INSERT INTO `preferiti` (`id_preferito`, `id_brano_pref`, `id_utente_pref`, `data_pref`) VALUES
(73, 7, 47, '2025-04-15 16:46:49.095963'),
(75, 32, 47, '2025-04-15 16:47:42.908828'),
(76, 34, 47, '2025-04-15 16:47:46.604424'),
(77, 12, 47, '2025-04-15 16:50:38.776274'),
(89, 7, 11, '2025-04-16 16:19:48.272194'),
(90, 9, 47, '2025-04-16 17:04:34.439882'),
(91, 25, 47, '2025-04-16 17:04:38.744181'),
(92, 33, 47, '2025-04-16 17:04:40.152008'),
(98, 31, 47, '2025-04-16 17:11:03.674968'),
(99, 5, 11, '2025-04-17 10:26:52.994828'),
(100, 9, 11, '2025-04-17 10:26:54.699961'),
(101, 12, 11, '2025-04-17 10:26:55.381809'),
(102, 1, 11, '2025-04-17 10:26:56.081465'),
(104, 36, 11, '2025-04-17 10:27:00.893246'),
(105, 32, 11, '2025-04-17 10:27:04.039395'),
(106, 39, 11, '2025-04-17 10:45:16.624199'),
(107, 28, 47, '2025-04-19 08:30:21.885784'),
(108, 39, 47, '2025-04-19 08:30:27.479198');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id_utente` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pfp` varchar(255) NOT NULL,
  `registrazione` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id_utente`, `username`, `password`, `email`, `pfp`, `registrazione`) VALUES
(7, 'aaaaaa', '$2y$10$aLNbmPQmyMLtXcz1S8l1Je/co9hCnJYXliPBf8KRwe6Muryqmgo5y', 'aaba.dgdg@gmgm.it', 'img/default-user.png', '2025-02-07 17:01:41'),
(11, 'user01', '$2y$10$ZBU9klG2mv149TkFWlyX5ujFIcsq1FogwV1cwB4VQNLRI97ZJ.T4i', 'aa.aa@aa.it', 'img/icon-8.png', '2025-02-12 12:03:17'),
(45, 'dddddddd', '$2y$10$i2Gk42Yq4sQb5PUnI4irEO2PLzASX3k2eT.eYAQISARll9Tj6ZXzy', 'd.d@d.it', 'img/default-user.png', '2025-02-07 17:01:51'),
(46, 'prova', '$2y$10$98oyFLzSY.SXZLbLCTTN6uiyjdMED6ErLjfAQ2oQGqCKKwT4jdZ7a', 'prova.prova@prova.it', 'img/default-user.png', '2025-02-07 17:01:53'),
(47, 'almaa01', '$2y$10$.DcoTtWAN33etk8mwx3DmeITu3CyoRbah.M/FiSkKCGBpib7VFtv2', 'alma.dt@ciao.it', '', '2025-04-15 08:27:34'),
(48, 'almaaa', '$2y$10$0jyNiQRbpZqhC8vdntdkCuw1vmmtsQseg8kbTKQA4Pri0nC9hohwi', 'alma2.dt@ciao.it', 'img/icon-4.png', '2025-04-15 09:45:53'),
(49, 'ciaociao', '$2y$10$iRBrFBLP3PvR/19kYMg6UOKih3e4tAj79S6awcG5/po6TVmhWbnJ6', 'ciao.ciao@ciao.it', 'img/icon-2.png', '2025-04-15 09:49:13'),
(50, 'bobrossi', '$2y$10$713SsZN6NdqQGpYiw5LQ..cChwgJOWimeci6GR3MIThqaHi4sFt7u', 'bob.rossi@ciao.com', '', '2025-04-17 16:01:23');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `artisti`
--
ALTER TABLE `artisti`
  ADD PRIMARY KEY (`id_artista`),
  ADD UNIQUE KEY `nome_artista` (`nome_artista`);

--
-- Indici per le tabelle `ascolti`
--
ALTER TABLE `ascolti`
  ADD PRIMARY KEY (`id_ascolto`);

--
-- Indici per le tabelle `brani`
--
ALTER TABLE `brani`
  ADD PRIMARY KEY (`id_brano`);

--
-- Indici per le tabelle `brani_playlist`
--
ALTER TABLE `brani_playlist`
  ADD PRIMARY KEY (`id_brano_playlist`);

--
-- Indici per le tabelle `generi`
--
ALTER TABLE `generi`
  ADD PRIMARY KEY (`id_genere`);

--
-- Indici per le tabelle `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id_log`);

--
-- Indici per le tabelle `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`id_playlist`),
  ADD UNIQUE KEY `playlist_index` (`id_utente_owner`,`nome_playlist`);

--
-- Indici per le tabelle `preferiti`
--
ALTER TABLE `preferiti`
  ADD PRIMARY KEY (`id_preferito`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id_utente`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `artisti`
--
ALTER TABLE `artisti`
  MODIFY `id_artista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `ascolti`
--
ALTER TABLE `ascolti`
  MODIFY `id_ascolto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT per la tabella `brani`
--
ALTER TABLE `brani`
  MODIFY `id_brano` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT per la tabella `brani_playlist`
--
ALTER TABLE `brani_playlist`
  MODIFY `id_brano_playlist` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT per la tabella `generi`
--
ALTER TABLE `generi`
  MODIFY `id_genere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `logs`
--
ALTER TABLE `logs`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT per la tabella `playlist`
--
ALTER TABLE `playlist`
  MODIFY `id_playlist` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT per la tabella `preferiti`
--
ALTER TABLE `preferiti`
  MODIFY `id_preferito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id_utente` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
