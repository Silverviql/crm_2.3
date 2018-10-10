-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 29 2017 г., 19:36
-- Версия сервера: 5.5.53
-- Версия PHP: 5.6.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `holland-itkzncrm`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, NULL, NULL, NULL, 1490351839, 1490351839),
('disain', 1, NULL, NULL, NULL, 1490351839, 1490351839),
('master', 1, NULL, NULL, NULL, 1490351839, 1490351839),
('program', 1, NULL, NULL, NULL, 1490351839, 1490351839),
('seeAdmin', 2, 'Виднеется меню Админ', NULL, NULL, 1490351839, 1490351839),
('seeAdop', 2, 'Видит магазин и админ', NULL, NULL, 1490351839, 1490351839),
('seeDisain', 2, 'Виднеется меню Дизайнера', NULL, NULL, 1490351839, 1490351839),
('seeIspol', 2, 'Видят исполнители', NULL, NULL, 1490351839, 1490351839),
('seeMaster', 2, 'Виднеется меню Мастер', NULL, NULL, 1490351839, 1490351839),
('seeProg', 2, 'Виднеется меню Программист', NULL, NULL, 1490351839, 1490351839),
('seeShop', 2, 'Виднеется меню Магазину', NULL, NULL, 1490351839, 1490351839),
('shop', 1, NULL, NULL, NULL, 1490351839, 1490351839);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
