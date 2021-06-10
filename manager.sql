-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Июн 10 2021 г., 12:31
-- Версия сервера: 5.6.47
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `manager`
--

-- --------------------------------------------------------

--
-- Структура таблицы `contact_post`
--

CREATE TABLE `contact_post` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `contact_name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_email` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `descriptive_post`
--

CREATE TABLE `descriptive_post` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `position_description` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `starts_at` int(11) NOT NULL,
  `ends_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1623120987),
('m210608_025257_create_user_table', 1623121002);

-- --------------------------------------------------------

--
-- Структура таблицы `post`
--

CREATE TABLE `post` (
  `id` int(10) UNSIGNED NOT NULL,
  `type_form` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `posts_queue`
--

CREATE TABLE `posts_queue` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `post_at` int(11) NOT NULL,
  `notification_sent_at` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `queue`
--

CREATE TABLE `queue` (
  `id` int(11) NOT NULL,
  `channel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job` blob NOT NULL,
  `pushed_at` int(11) NOT NULL,
  `ttr` int(11) NOT NULL,
  `delay` int(11) NOT NULL DEFAULT '0',
  `priority` int(11) UNSIGNED NOT NULL DEFAULT '1024',
  `reserved_at` int(11) DEFAULT NULL,
  `attempt` int(11) DEFAULT NULL,
  `done_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'NOi_Bv1B_hKonyHiZJgpZyExYXr-ujEd', '$2y$13$QuFfojxYmd2TD5gSK2LtM.rqlaj8dC0UPerwhvEPrMpZX4.fZVpem', NULL, 'zt_052@mail.ru', 10, 1623122697, 1623208731);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `contact_post`
--
ALTER TABLE `contact_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Индексы таблицы `descriptive_post`
--
ALTER TABLE `descriptive_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `posts_queue`
--
ALTER TABLE `posts_queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Индексы таблицы `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `channel` (`channel`(191)),
  ADD KEY `reserved_at` (`reserved_at`),
  ADD KEY `priority` (`priority`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `post`
--
ALTER TABLE `post`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT для таблицы `posts_queue`
--
ALTER TABLE `posts_queue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `contact_post`
--
ALTER TABLE `contact_post`
  ADD CONSTRAINT `contact_post_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`);

--
-- Ограничения внешнего ключа таблицы `descriptive_post`
--
ALTER TABLE `descriptive_post`
  ADD CONSTRAINT `descriptive_post_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`);

--
-- Ограничения внешнего ключа таблицы `posts_queue`
--
ALTER TABLE `posts_queue`
  ADD CONSTRAINT `posts_queue_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
