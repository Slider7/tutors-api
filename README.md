"# tutors-api" 
-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Янв 06 2021 г., 08:57
-- Версия сервера: 10.4.13-MariaDB
-- Версия PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `id15816577_tutors`
--

-- --------------------------------------------------------

--
-- Структура таблицы `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `city`
--

INSERT INTO `city` (`id`, `name`, `region`) VALUES
(1, 'Талдыкорган', 'Алматинская обл.'),
(2, 'Алматы', 'Алматинская обл.'),
(3, 'Текели', 'Алматинская обл.'),
(4, 'Балпык Би', 'Алматинская обл.'),
(5, 'Жаркент', 'Алматинская обл.');

-- --------------------------------------------------------

--
-- Структура таблицы `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `info` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `info`, `type`) VALUES
(1, 'Математика', 'для начальных классов', ''),
(2, 'Английский язык', 'все уровни', ''),
(3, 'Информатика', 'для начальных классов', ''),
(4, 'Казахский язык', 'для начальных классов', '');

-- --------------------------------------------------------

--
-- Структура таблицы `tutors`
--

CREATE TABLE `tutors` (
  `id` int(11) NOT NULL,
  `name` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `rating` float DEFAULT NULL,
  `age` int(11) NOT NULL,
  `type` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stage` int(11) DEFAULT NULL,
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tutors`
--

INSERT INTO `tutors` (`id`, `name`, `phone`, `rating`, `age`, `type`, `lang`, `stage`, `description`, `city_id`, `created`) VALUES
(1, 'Петрова Анна', '87771234567', NULL, 35, 'Оффлайн', 'Русский', NULL, NULL, 1, '2021-01-03 11:30:44'),
(2, 'Аскаров Талгат', '87025566441', 4, 41, 'Онлайн+Оффлайн', 'Казахский и русский', NULL, NULL, 1, '2021-01-03 11:30:44'),
(5, 'Искаков Марат', '87471132144', 3, 32, 'Онлайн', 'Казахский', 4, 'Все что связано с информатикой', 2, '2021-01-03 11:30:44'),
(7, 'Иванов Петр', '1234567890', 0, 36, '', 'Казахский и русский', 8, '', 1, '2021-01-03 11:30:44');

-- --------------------------------------------------------

--
-- Структура таблицы `tutorsubject`
--

CREATE TABLE `tutorsubject` (
  `id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `info` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tutorsubject`
--

INSERT INTO `tutorsubject` (`id`, `tutor_id`, `subject_id`, `info`) VALUES
(1, 1, 2, 'Для начинающих'),
(2, 2, 1, ''),
(3, 2, 3, ''),
(7, 5, 2, ''),
(8, 5, 4, ''),
(9, 2, 4, '');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `tutors_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `tutors_view` (
`id` int(11)
,`name` varchar(80)
,`phone` varchar(16)
,`rating` float
,`age` int(11)
,`type` varchar(40)
,`lang` varchar(40)
,`stage` int(11)
,`description` varchar(200)
,`city_id` int(11)
,`subjects` mediumtext
,`city_name` varchar(20)
,`created` timestamp
);

-- --------------------------------------------------------

--
-- Структура для представления `tutors_view`
--
DROP TABLE IF EXISTS `tutors_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tutors_view`  AS  select `t`.`id` AS `id`,`t`.`name` AS `name`,`t`.`phone` AS `phone`,`t`.`rating` AS `rating`,`t`.`age` AS `age`,`t`.`type` AS `type`,`t`.`lang` AS `lang`,`t`.`stage` AS `stage`,`t`.`description` AS `description`,`t`.`city_id` AS `city_id`,group_concat(`s`.`name` order by `s`.`name` ASC separator ', ') AS `subjects`,`c`.`name` AS `city_name`,`t`.`created` AS `created` from (((`tutors` `t` join `city` `c`) join `subjects` `s`) join `tutorsubject` `ts`) where `t`.`city_id` = `c`.`id` and `t`.`id` = `ts`.`tutor_id` and `s`.`id` = `ts`.`subject_id` group by `t`.`id` ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tutors`
--
ALTER TABLE `tutors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`);

--
-- Индексы таблицы `tutorsubject`
--
ALTER TABLE `tutorsubject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tutor_id` (`tutor_id`),
  ADD KEY `fk_subject_id` (`subject_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `tutors`
--
ALTER TABLE `tutors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `tutorsubject`
--
ALTER TABLE `tutorsubject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `tutors`
--
ALTER TABLE `tutors`
  ADD CONSTRAINT `tutors_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`);

--
-- Ограничения внешнего ключа таблицы `tutorsubject`
--
ALTER TABLE `tutorsubject`
  ADD CONSTRAINT `tutorsubject_ibfk_1` FOREIGN KEY (`tutor_id`) REFERENCES `tutors` (`id`),
  ADD CONSTRAINT `tutorsubject_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
