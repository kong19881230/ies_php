-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- ホスト: localhost
-- 生成日時: 2014 年 10 月 12 日 08:05
-- サーバのバージョン: 5.6.14
-- PHP のバージョン: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- データベース: `aufook`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `url` varchar(100) NOT NULL,
  `avatar` varchar(20) NOT NULL DEFAULT 'gravatar',
  `status` int(1) NOT NULL DEFAULT '0',
  `role` varchar(15) NOT NULL DEFAULT 'user',
  `registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activation_key` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `password`, `url`, `avatar`, `status`, `role`, `registered`, `activation_key`) VALUES
(1, 'admin', 'admin', 'admin@email.com', '21232f297a57a5a743894a0e4a801fc3', '', 'gravatar', 1, 'admin', '2014-02-19 17:52:24', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
