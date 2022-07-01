-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2021 m. Geg 18 d. 20:18
-- Server version: 5.5.68-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paslaugos`
--

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL,
  `user` varchar(255) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `click` varchar(255) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `action` varchar(255) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `ip` varchar(255) NOT NULL,
  `kada` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=380 DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `logs`
--

INSERT INTO `logs` (`id`, `user`, `click`, `action`, `ip`, `kada`) VALUES
(379, 'admin', '', 'Vartotojas admin prisijunge.', '1.1.1.1', 1621357801),
(378, 'admin', '', 'Vartotojas admin prisijunge.', '1.1.1.1', 1621357750),
(377, 'admin', '', 'Atnaujinti Pavadinimas.lt svetaines nustatymai.', '1.1.1.1', 1616681198),
(376, 'admin', '', 'Vartotojas admin prisijunge.', '1.1.1.1', 1616681125),
(375, 'admin', '', 'Atnaujinti Pavadinimas.lt svetaines nustatymai.', '1.1.1.1', 1613149305);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `paslaugos`
--

CREATE TABLE IF NOT EXISTS `paslaugos` (
  `id` int(11) NOT NULL,
  `nick` varchar(255) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `keyword` varchar(255) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `nr` varchar(255) NOT NULL,
  `expires` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `privgroups`
--

CREATE TABLE IF NOT EXISTS `privgroups` (
  `id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `privgroups`
--

INSERT INTO `privgroups` (`id`, `title`) VALUES
(3, 'Paslaugos '),
(2, 'Privilegijos');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `privileges`
--

CREATE TABLE IF NOT EXISTS `privileges` (
  `id` int(10) NOT NULL,
  `groupid` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` int(1) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `makro_price` int(10) NOT NULL,
  `number` int(10) NOT NULL,
  `cmd` varchar(1000) NOT NULL,
  `content` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `privileges`
--

INSERT INTO `privileges` (`id`, `groupid`, `title`, `type`, `keyword`, `price`, `makro_price`, `number`, `cmd`, `content`) VALUES
(1, 2, 'VIP', 1, 'pavadinimasvip', '150', 100, 1398, 'pex user [nick] group add VIP &quot;&quot; 2592000, bc &amp;bZaidejas&amp;6 [nick] &amp;buzsisake VIP paslauga! uzsisakyk ir tu!&amp;3&amp;l /paslaugos', '<p><strong><span style="color: #ff6600;">VIP</span></strong> Galimybės:</p>\r\n<ul>\r\n<li>Galimybė spalvotai&nbsp; ra&scaron;yti ant lentelės [<strong><span style="color: #ff6600;">LABAS</span></strong>].</li>\r\n<li>Galimybė spalvotai ra&scaron;yti &scaron;aukykloje, pvz: <span style="color: #ffff00;">a</span><span style="color: #00ff00;">sa<span style="color: #ff0000;">s</span></span>.</li>\r\n<li>Galimubė spalvotai ra&scaron;yti per privačias žinutes [/msg nick <strong><span style="color: #ff6600;">TekstasSuSpalvųKodais</span></strong>].</li>\r\n<li>Galimybė prisijungti į pilną serverį.</li>\r\n<li>Galimybė pasiimti visus įrankių komplektus nuo rango <strong><span style="color: #999999;">Valstietis</span></strong> iki <strong><span style="color: #ff0000;">Gerbėjas</span></strong> [<strong><span style="color: #ff6600;">/kits</span></strong>].</li>\r\n<li>Galimybė pasiimti specialų /kit <strong><span style="color: #ff6600;">VIP</span></strong> [<strong><span style="color: #33cccc;">Deimantiniai</span></strong> įrankiai (Efficency 2, Unbreaking 1 ), <strong><span style="color: #33cccc;">Deimantinis</span></strong> kardas (Sharpness 2, Unbreaking 1, Knockback 2 ), x2 OP-Obuoliai, 8 <strong><span style="color: #ff6600;">Auksiniai</span></strong> obuoliai, x32 <strong><span style="color: #33cccc;">Deimantai</span></strong>, x16 <span style="color: #008000;"><strong>Emeralda</strong>i</span>, x128 Exp Buteliukai ].</li>\r\n<li>Galimybė pasidaryti 3 namų ta&scaron;kus [<strong><span style="color: #ff6600;">/sethome Namas1</span></strong>].</li>\r\n<li>Galimybė atstatyti savo alkį [<strong><span style="color: #ff6600;">/feed</span></strong>].</li>\r\n<li>Galimybė i&scaron;kasti monstrų dėžes [<strong><span style="color: #ff6600;">Spawnerius</span></strong>] naudojant kirtiklį su silk touch užbūrimu.</li>\r\n<li>Galimybė pažiūrėti turtingiausius serverio žaidėjus [<strong><span style="color: #ff6600;">/baltop</span></strong>].</li>\r\n<li>Galimybė bet kada atsidaryti darbastalį [<strong><span style="color: #ff6600;">/wb</span></strong>].</li>\r\n<li>Galimybė sukūrti lentelę, kuri parodys jūsų balansą [ [<strong><span style="color: #ff6600;">BALANCE</span></strong>] ].</li>\r\n<li>Galimybė i&scaron;sitrinti &scaron;aukyklą sau [<strong><span style="color: #ff6600;">/ccs</span></strong>].</li>\r\n<li>Praėjus kuriam laikui kai nejudate, jūms automati&scaron;kai užsidės AFK.</li>\r\n<li>Galimybė nustatyti monstrų dėžę(<span style="color: #ff6600;"><strong>/mbox</strong></span>) į &scaron;iuos MOB [Cow, Chicken, Pig, Skeleton, Zombie].</li>\r\n<li>Gausite specialų prie&scaron;delį - [ <strong><span style="color: #ff6600;">VIP</span> </strong>] Vardas.</li>\r\n</ul>'),
(2, 2, 'VIP+', 1, 'pavadinimasvipplus', '290', 200, 1398, 'pex user [nick] group add VIPplus &quot;&quot; 2592000, bc &amp;bZaidejas&amp;6 [nick] &amp;buzsisake VIP+ paslauga! uzsisakyk ir tu!&amp;3&amp;l /paslaugos', '<p><span style="color: #008000;"><strong>Paslaugos apra&scaron;ymas</strong></span></p>'),
(3, 2, 'VIP++', 1, 'pavadinimasvipplusplus', '500', 400, 1398, 'pex user [nick] group add VIPplusplus &quot;&quot; 2592000, bc &amp;bZaidejas&amp;6 [nick] &amp;buzsisake VIP++ paslauga! uzsisakyk ir tu!&amp;3&amp;l /paslaugos', '<p><span style="color: #ff0000;"><strong>Paslaugos apra&scaron;ymas</strong></span></p>'),
(7, 3, 'Unban', 2, 'pavadinimasunban', '300', 200, 1398, 'unban [nick]', '<p>Paslaugos apra&scaron;ymas</p>'),
(5, 2, 'Mod', 1, 'pavadinimasmod', '600', 500, 1398, 'pex user [nick] group add mod &quot;&quot; 2592000, bc &amp;bZaidejas&amp;6 [nick] &amp;buzsisake MOD paslauga! uzsisakyk ir tu!&amp;3&amp;l /paslaugos', '<p>&nbsp;</p>\r\n<p>Paslaugos apra&scaron;ymas</p>'),
(8, 3, 'Unban', 2, 'pavadinimasunban', '300', 200, 1398, 'unban [nick]', '<p>Paslaugos apra&scaron;ymas</p>');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `serveris`
--

CREATE TABLE IF NOT EXISTS `serveris` (
  `id` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `port` varchar(255) NOT NULL,
  `sport` text NOT NULL,
  `rcon` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `serveris`
--

INSERT INTO `serveris` (`id`, `ip`, `port`, `sport`, `rcon`) VALUES
(1, 'mc.pavadinimas.lt', '25575', '25565', 'password');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `project_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `sign_password` varchar(255) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `forumurl` varchar(255) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `forumtype` varchar(2) NOT NULL,
  `telnr` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `settings`
--

INSERT INTO `settings` (`id`, `title`, `project_id`, `sign_password`, `forumurl`, `forumtype`, `telnr`, `email`) VALUES
(0, 'Pavadinimas.lt', '12345', '6d891bva929af78026558901e18346ee', '', '', '3700000000', 'pavadinimas@gmail.com');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `sms`
--

CREATE TABLE IF NOT EXISTS `sms` (
  `id` int(11) NOT NULL,
  `nick` varchar(32) COLLATE utf8_bin NOT NULL,
  `keyword` varchar(32) COLLATE utf8_bin NOT NULL,
  `nr` varchar(255) COLLATE utf8_bin NOT NULL,
  `expires` int(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=196 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL,
  `nick` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Sukurta duomenų kopija lentelei `users`
--

INSERT INTO `users` (`id`, `nick`, `password`) VALUES
(1, 'admin', 'put-your-hashed-password-here);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paslaugos`
--
ALTER TABLE `paslaugos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privgroups`
--
ALTER TABLE `privgroups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `serveris`
--
ALTER TABLE `serveris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=380;
--
-- AUTO_INCREMENT for table `paslaugos`
--
ALTER TABLE `paslaugos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `privgroups`
--
ALTER TABLE `privgroups`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `privileges`
--
ALTER TABLE `privileges`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `serveris`
--
ALTER TABLE `serveris`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sms`
--
ALTER TABLE `sms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=196;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
