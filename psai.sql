-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 28 Wrz 2020, 22:30
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `psai`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Browsers'),
(15, 'Documents'),
(16, 'Security'),
(17, 'Compression'),
(18, 'Runtimes');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `program`
--

CREATE TABLE `program` (
  `id` int(11) NOT NULL,
  `url` varchar(1000) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `switch` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `program`
--

INSERT INTO `program` (`id`, `url`, `name`, `category_id`, `type_id`, `switch`) VALUES
(23, 'https://dl.google.com/tag/s/appguid%3D%7B8A69D345-D564-463C-AFF1-A69D9E530F96%7D%26iid%3D%7BD4E0B28A-4B5F-CBB4-1E1D-E1DC35D5CE52%7D%26lang%3Den%26browser%3D4%26usagestats%3D0%26appname%3DGoogle%2520Chrome%26needsadmin%3Dtrue%26ap%3Dx64-stable-statsdef_0%26brand%3DGCEA/dl/chrome/install/googlechromestandaloneenterprise64.msi', 'Chrome', 1, 2, NULL),
(24, 'https://download3.operacdn.com/pub/opera/desktop/71.0.3770.171/win/Opera_71.0.3770.171_Setup_x64.exe', 'Opera', 1, 1, NULL),
(26, 'https://sourceforge.net/projects/openofficeorg.mirror/files/4.1.7/binaries/pl/Apache_OpenOffice_4.1.7_Win_x86_install_pl.exe/download', 'OpenOffice', 15, 1, NULL),
(27, 'https://download.mozilla.org/?product=firefox-msi-latest-ssl&os=win64&lang=pl', 'Firefox', 1, 2, NULL),
(28, 'https://www.7-zip.org/a/7z1900-x64.msi', '7zip', 17, 2, NULL),
(29, 'https://sourceforge.net/projects/keepass/files/KeePass%202.x/2.46/KeePass-2.46.msi/download', 'KeePass 2', 16, 2, NULL),
(30, 'https://aka.ms/vs/16/release/vc_redist.x64.exe', 'C++ 2015, 2017, 2019 x64', 18, 1, NULL),
(31, 'https://aka.ms/vs/16/release/vc_redist.x86.exe', 'C++ 2015, 2017, 2019 x32', 18, 1, NULL),
(33, 'https://github.com/peazip/PeaZip/releases/download/7.4.1/peazip-7.4.1.WIN64.msi', 'PeaZip', 17, 2, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `type` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `type`
--

INSERT INTO `type` (`id`, `type`) VALUES
(1, 'exe'),
(2, 'msi');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `email`, `password`) VALUES
(2, 'test@test.com', '$2y$10$3Ytvh1K1nJP8X4Rvv6NOFuTCP3eLh2fKmjxr9AFBaoGfzJgZr2zyS');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indeksy dla tabeli `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `category` (`category_id`),
  ADD KEY `type` (`type_id`);

--
-- Indeksy dla tabeli `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indeksy dla tabeli `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla tabel zrzutów
--

--
-- AUTO_INCREMENT dla tabeli `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT dla tabeli `program`
--
ALTER TABLE `program`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT dla tabeli `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `program`
--
ALTER TABLE `program`
  ADD CONSTRAINT `program_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `program_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
