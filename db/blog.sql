-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 172.17.0.2
-- Generation Time: Sep 05, 2016 at 01:41 PM
-- Server version: 10.1.17-MariaDB-1~jessie
-- PHP Version: 5.6.25

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `writer_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `text` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `writer_id`, `title`, `text`, `created_at`) VALUES
(1, 2, 'test 33333', 'Kaj je Lorem Ipsum?\r\n\r\nLorem Ipsum je slepi tekst, ki se uporablja pri razvoju tipografij in pri pripravi za tisk. Lorem Ipsum je v uporabi že več kot petsto let saj je to kombinacijo znakov neznani tiskar združil v vzorčno knjigo že v začetku 16. stoletja. To besedilo pa ni zgolj preživelo pet stoletij, temveč se je z malenkostnimi spremembami uspešno uveljavilo tudi v elektronskem namiznem založništvu. Na priljubljenosti je Lorem Ipsum pridobil v sedemdesetih letih prejšnjega stoletja, ko so na trg lansirali Letraset folije z Lorem Ipsum odstavki. V zadnjem času se Lorem Ipsum pojavlja tudi v priljubljenih programih za namizno založništvo kot je na primer Aldus PageMaker.\r\nZakaj ga uporabljamo?\r\n\r\nDokazano je, da razumljiva vsebina, med pregledovanjem oblikovne rešitve določene strani, neželeno preusmeri pozornost bralca. Ker ima Lorem Ipsum relativno enakomerno razporeditev znakov uspešno nadomesti začasna vsebinsko pomenska besedila. Veliko namizno založniških programov in spletnih urejevalnikov uporablja Lorem Ipsum kot privzeti slepi tekst. Zato spletno iskanje s ključnimi besedami "lorem ipsum" vrne številne zadetke še nedokončanih spletnih mest. Tekom let so namreč nastale številne različice tega slepega teksta, bodisi nenačrtovano ali namenoma, z različnimi šaljivimi in drugimi vložki.\r\n', '2016-09-05 12:51:15'),
(2, 2, 'test 2', '\r\nKaj je Lorem Ipsum?\r\n\r\nLorem Ipsum je slepi tekst, ki se uporablja pri razvoju tipografij in pri pripravi za tisk. Lorem Ipsum je v uporabi že več kot petsto let saj je to kombinacijo znakov neznani tiskar združil v vzorčno knjigo že v začetku 16. stoletja. To besedilo pa ni zgolj preživelo pet stoletij, temveč se je z malenkostnimi spremembami uspešno uveljavilo tudi v elektronskem namiznem založništvu. Na priljubljenosti je Lorem Ipsum pridobil v sedemdesetih letih prejšnjega stoletja, ko so na trg lansirali Letraset folije z Lorem Ipsum odstavki. V zadnjem času se Lorem Ipsum pojavlja tudi v priljubljenih programih za namizno založništvo kot je na primer Aldus PageMaker.\r\nZakaj ga uporabljamo?\r\n\r\nDokazano je, da razumljiva vsebina, med pregledovanjem oblikovne rešitve določene strani, neželeno preusmeri pozornost bralca. Ker ima Lorem Ipsum relativno enakomerno razporeditev znakov uspešno nadomesti začasna vsebinsko pomenska besedila. Veliko namizno založniških programov in spletnih urejevalnikov uporablja Lorem Ipsum kot privzeti slepi tekst. Zato spletno iskanje s ključnimi besedami "lorem ipsum" vrne številne zadetke še nedokončanih spletnih mest. Tekom let so namreč nastale številne različice tega slepega teksta, bodisi nenačrtovano ali namenoma, z različnimi šaljivimi in drugimi vložki.\r\n', '2016-09-05 12:50:59');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'test', '7505d68c5be9df535c5aca6bf1414d4c'),
(2, 'gc@mac.com', 'a622db8eaae02572c0acc8a4985e570a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `writer_id` (`writer_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`writer_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
