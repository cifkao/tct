-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 14, 2014 at 09:33 PM
-- Server version: 5.5.33-MariaDB
-- PHP Version: 5.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tct`
--

--
-- Dumping data for table `langs`
--

INSERT INTO `langs` (`id`, `code`, `name`) VALUES
(2, 'en', 'English'),
(3, 'cs', 'Czech'),
(4, 'fr', 'French'),
(5, 'de', 'German'),
(6, 'aa', 'Afar'),
(7, 'ab', 'Abkhazian'),
(8, 'af', 'Afrikaans'),
(9, 'am', 'Amharic'),
(10, 'ar', 'Arabic'),
(11, 'as', 'Assamese'),
(12, 'ay', 'Aymara'),
(13, 'az', 'Azerbaijani'),
(14, 'ba', 'Bashkir'),
(15, 'be', 'Byelorussian'),
(16, 'bg', 'Bulgarian'),
(17, 'bh', 'Bihari'),
(18, 'bi', 'Bislama'),
(19, 'bn', 'Bengali, Bangla'),
(20, 'bo', 'Tibetan'),
(21, 'br', 'Breton'),
(22, 'ca', 'Catalan'),
(23, 'co', 'Corsican'),
(24, 'cy', 'Welsh'),
(25, 'da', 'Danish'),
(26, 'dz', 'Bhutani'),
(27, 'el', 'Greek'),
(28, 'eo', 'Esperanto'),
(29, 'es', 'Spanish'),
(30, 'et', 'Estonian'),
(31, 'eu', 'Basque'),
(32, 'fa', 'Persian'),
(33, 'fi', 'Finnish'),
(34, 'fj', 'Fiji'),
(35, 'fo', 'Faeroese'),
(36, 'fy', 'Frisian'),
(37, 'ga', 'Irish'),
(38, 'gd', 'Gaelic, Scots Gaelic'),
(39, 'gl', 'Galician'),
(40, 'gn', 'Guarani'),
(41, 'gu', 'Gujarati'),
(42, 'ha', 'Hausa'),
(43, 'hi', 'Hindi'),
(44, 'hr', 'Croatian'),
(45, 'hu', 'Hungarian'),
(46, 'hy', 'Armenian'),
(47, 'ia', 'Interlingua'),
(48, 'ie', 'Interlingue'),
(49, 'ik', 'Inupiak'),
(50, 'in', 'Indonesian'),
(51, 'is', 'Icelandic'),
(52, 'it', 'Italian'),
(53, 'iw', 'Hebrew'),
(54, 'ja', 'Japanese'),
(55, 'ji', 'Yiddish'),
(56, 'jw', 'Javanese'),
(57, 'ka', 'Georgian'),
(58, 'kk', 'Kazakh'),
(59, 'kl', 'Greenlandic'),
(60, 'km', 'Cambodian'),
(61, 'kn', 'Kannada'),
(62, 'ko', 'Korean'),
(63, 'ks', 'Kashmiri'),
(64, 'ku', 'Kurdish'),
(65, 'ky', 'Kirghiz'),
(66, 'la', 'Latin'),
(67, 'ln', 'Lingala'),
(68, 'lo', 'Laothian'),
(69, 'lt', 'Lithuanian'),
(70, 'lv', 'Latvian, Lettish'),
(71, 'mg', 'Malagasy'),
(72, 'mi', 'Maori'),
(73, 'mk', 'Macedonian'),
(74, 'ml', 'Malayalam'),
(75, 'mn', 'Mongolian'),
(76, 'mo', 'Moldavian'),
(77, 'mr', 'Marathi'),
(78, 'ms', 'Malay'),
(79, 'mt', 'Maltese'),
(80, 'my', 'Burmese'),
(81, 'na', 'Nauru'),
(82, 'ne', 'Nepali'),
(83, 'nl', 'Dutch'),
(84, 'no', 'Norwegian'),
(85, 'oc', 'Occitan'),
(86, 'om', 'Oromo, Afan'),
(87, 'or', 'Oriya'),
(88, 'pa', 'Punjabi'),
(89, 'pl', 'Polish'),
(90, 'ps', 'Pashto, Pushto'),
(91, 'pt', 'Portuguese'),
(92, 'qu', 'Quechua'),
(93, 'rm', 'Rhaeto-Romance'),
(94, 'rn', 'Kirundi'),
(95, 'ro', 'Romanian'),
(96, 'ru', 'Russian'),
(97, 'rw', 'Kinyarwanda'),
(98, 'sa', 'Sanskrit'),
(99, 'sd', 'Sindhi'),
(100, 'sg', 'Sangro'),
(101, 'sh', 'Serbo-Croatian'),
(102, 'si', 'Singhalese'),
(103, 'sk', 'Slovak'),
(104, 'sl', 'Slovenian'),
(105, 'sm', 'Samoan'),
(106, 'sn', 'Shona'),
(107, 'so', 'Somali'),
(108, 'sq', 'Albanian'),
(109, 'sr', 'Serbian'),
(110, 'ss', 'Siswati'),
(111, 'st', 'Sesotho'),
(112, 'su', 'Sudanese'),
(113, 'sv', 'Swedish'),
(114, 'sw', 'Swahili'),
(115, 'ta', 'Tamil'),
(116, 'te', 'Tegulu'),
(117, 'tg', 'Tajik'),
(118, 'th', 'Thai'),
(119, 'ti', 'Tigrinya'),
(120, 'tk', 'Turkmen'),
(121, 'tl', 'Tagalog'),
(122, 'tn', 'Setswana'),
(123, 'to', 'Tonga'),
(124, 'tr', 'Turkish'),
(125, 'ts', 'Tsonga'),
(126, 'tt', 'Tatar'),
(127, 'tw', 'Twi'),
(128, 'uk', 'Ukrainian'),
(129, 'ur', 'Urdu'),
(130, 'uz', 'Uzbek'),
(131, 'vi', 'Vietnamese'),
(132, 'vo', 'Volapuk'),
(133, 'wo', 'Wolof'),
(134, 'xh', 'Xhosa'),
(135, 'yo', 'Yoruba'),
(136, 'zh', 'Chinese'),
(137, 'zu', 'Zulu');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
