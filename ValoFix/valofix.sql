-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2025-07-20 19:47:06
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `valofix`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `agents`
--

CREATE TABLE `agents` (
  `agent_id` int(255) NOT NULL,
  `agent_name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `agents`
--

INSERT INTO `agents` (`agent_id`, `agent_name`) VALUES
(1, 'BRIMSTONE'),
(2, 'PHOENIX'),
(3, 'SAGE'),
(4, 'SOVA'),
(5, 'VIPER'),
(6, 'CYPHER'),
(7, 'REYNA'),
(8, 'KILLJOY'),
(9, 'BREACH'),
(10, 'OMEN'),
(11, 'JETT'),
(12, 'RAZE'),
(13, 'SKYE'),
(14, 'YORU'),
(15, 'ASTRA'),
(16, 'KAY/O'),
(17, 'CHAMBER'),
(18, 'NEON'),
(19, 'FADE'),
(20, 'HARBOR'),
(21, 'GEKKO'),
(22, 'DEADLOCK'),
(23, 'ISO'),
(24, 'CLOVE'),
(26, 'VYSE'),
(27, 'TEJO'),
(28, 'WAYLAY');

-- --------------------------------------------------------

--
-- テーブルの構造 `agent_fixes`
--

CREATE TABLE `agent_fixes` (
  `fix_id` int(255) UNSIGNED NOT NULL,
  `user_id` int(255) UNSIGNED NOT NULL,
  `map_id` int(255) NOT NULL,
  `agent_id` int(255) NOT NULL,
  `point_x` double NOT NULL,
  `point_y` double NOT NULL,
  `comment` varchar(255) NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `agent_fixes`
--

INSERT INTO `agent_fixes` (`fix_id`, `user_id`, `map_id`, `agent_id`, `point_x`, `point_y`, `comment`, `url`) VALUES
(17, 10, 1, 1, 34.93, 36, '入力したキャラクター「BRIMSTONE」の定点の情報が表示されます', 'https://youtu.be/vr9dLvJs7VE?si=UaIQEnakPoe3KQRt'),
(18, 10, 1, 1, 34.6, 43.5, 'URLなしの定点登録情報です。URLが登録されていない場合、「watch video」のリンクが表示されません。', ''),
(19, 10, 9, 26, 25.6, 43.67, '滝からC入口レーザーヴァイン', 'https://youtu.be/Tx5KV9my6yc?si=jLGHPntOFpxzfcVR'),
(20, 10, 9, 26, 42.93, 36.33, 'CリンクからB入口レーザーヴァイン', 'https://youtu.be/dFA-O9yM1_g?si=pcXYcTacC2K0zHNC'),
(21, 10, 9, 26, 73.6, 67, 'Aメインからロビーレーザーヴァイン', 'https://youtu.be/jUSwJA7JIIk?si=SXeMnGoMj8a8ft--');

-- --------------------------------------------------------

--
-- テーブルの構造 `common_macros`
--

CREATE TABLE `common_macros` (
  `macro_id` int(255) UNSIGNED NOT NULL,
  `user_id` int(255) UNSIGNED NOT NULL,
  `point_x` double NOT NULL,
  `point_y` double NOT NULL,
  `comment` text NOT NULL,
  `url` text NOT NULL,
  `map_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `common_macros`
--

INSERT INTO `common_macros` (`macro_id`, `user_id`, `point_x`, `point_y`, `comment`, `url`, `map_id`) VALUES
(9, 10, 46.93, 36, '入力した「共通マクロ」の情報が表示されます。これは選択したエージェントに関わらず表示されます。', 'https://youtu.be/vr9dLvJs7VE?si=UaIQEnakPoe3KQRt', 1),
(10, 10, 47.1, 43.67, 'URL無しの共通マクロの情報です。', '', 1),
(11, 10, 8.77, 29.5, 'オフアングル（共通マクロとして登録）', '', 9);

-- --------------------------------------------------------

--
-- テーブルの構造 `maps`
--

CREATE TABLE `maps` (
  `map_id` int(255) NOT NULL,
  `map_name` varchar(256) NOT NULL,
  `image_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `maps`
--

INSERT INTO `maps` (`map_id`, `map_name`, `image_path`) VALUES
(1, 'ABYSS', 'maps/abyss.png'),
(2, 'ASCENT', 'maps/ascent.png'),
(3, 'BIND', 'maps/bind.png'),
(4, 'BREEZE', 'maps/breeze.png'),
(5, 'CORRODE', 'maps/corrode.png'),
(6, 'FRACTURE', 'maps/fracture.png'),
(7, 'HAVEN', 'maps/haven.png'),
(8, 'ICEBOX', 'maps/icebox.png'),
(9, 'LOTUS', 'maps/lotus.png'),
(10, 'PEARL', 'maps/pearl.png'),
(11, 'SPLIT', 'maps/split.png'),
(12, 'SUNSET', 'maps/sunset.png');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `user_id` int(255) UNSIGNED NOT NULL,
  `mailAddress` varchar(256) DEFAULT NULL,
  `pwd` varchar(256) DEFAULT NULL,
  `userName` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`user_id`, `mailAddress`, `pwd`, `userName`) VALUES
(10, 'test@mail', '$2y$10$ooZtrvJRBOJhtBNpdLkP/Oqn4LBDnaWNoDe7lSe4TueAb5t5yHv8C', 'test');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`agent_id`);

--
-- テーブルのインデックス `agent_fixes`
--
ALTER TABLE `agent_fixes`
  ADD PRIMARY KEY (`fix_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `map_id` (`map_id`),
  ADD KEY `agent_id` (`agent_id`);

--
-- テーブルのインデックス `common_macros`
--
ALTER TABLE `common_macros`
  ADD PRIMARY KEY (`macro_id`),
  ADD KEY `map_id` (`map_id`),
  ADD KEY `user_id` (`user_id`);

--
-- テーブルのインデックス `maps`
--
ALTER TABLE `maps`
  ADD PRIMARY KEY (`map_id`),
  ADD UNIQUE KEY `map_name` (`map_name`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `mailAddress` (`mailAddress`),
  ADD KEY `pwd` (`pwd`) USING BTREE;

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `agent_fixes`
--
ALTER TABLE `agent_fixes`
  MODIFY `fix_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- テーブルの AUTO_INCREMENT `common_macros`
--
ALTER TABLE `common_macros`
  MODIFY `macro_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `agent_fixes`
--
ALTER TABLE `agent_fixes`
  ADD CONSTRAINT `agent_fixes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `agent_fixes_ibfk_2` FOREIGN KEY (`map_id`) REFERENCES `maps` (`map_id`),
  ADD CONSTRAINT `agent_fixes_ibfk_3` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`agent_id`);

--
-- テーブルの制約 `common_macros`
--
ALTER TABLE `common_macros`
  ADD CONSTRAINT `common_macros_ibfk_1` FOREIGN KEY (`map_id`) REFERENCES `maps` (`map_id`),
  ADD CONSTRAINT `common_macros_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
