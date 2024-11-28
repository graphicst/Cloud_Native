-- --------------------------------------------------------
-- 호스트:                          192.168.217.128
-- 서버 버전:                        8.0.39 - MySQL Community Server - GPL
-- 서버 OS:                        Linux
-- HeidiSQL 버전:                  12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- 테이블 데이터 php-mysql.access_list:~0 rows (대략적) 내보내기

-- 테이블 데이터 php-mysql.access_list_auth:~0 rows (대략적) 내보내기

-- 테이블 데이터 php-mysql.access_list_client:~0 rows (대략적) 내보내기

-- 테이블 데이터 php-mysql.audit_log:~0 rows (대략적) 내보내기

-- 테이블 데이터 php-mysql.auth:~0 rows (대략적) 내보내기
INSERT IGNORE INTO `auth` (`id`, `created_on`, `modified_on`, `user_id`, `type`, `secret`, `meta`, `is_deleted`) VALUES
	(1, '2024-11-24 07:26:23', '2024-11-24 07:26:23', 1, 'password', '$2b$13$xXv/tzqXwTdvJvezV9CMgO8J7wh8JA7drzWNlX5SDWfW0zgTP6Lfq', '{}', 0);

-- 테이블 데이터 php-mysql.certificate:~0 rows (대략적) 내보내기

-- 테이블 데이터 php-mysql.dead_host:~0 rows (대략적) 내보내기

-- 테이블 데이터 php-mysql.migrations:~0 rows (대략적) 내보내기
INSERT IGNORE INTO `migrations` (`id`, `name`, `batch`, `migration_time`) VALUES
	(1, '20180618015850_initial.js', 1, '2024-11-24 07:26:22'),
	(2, '20180929054513_websockets.js', 1, '2024-11-24 07:26:22'),
	(3, '20181019052346_forward_host.js', 1, '2024-11-24 07:26:22'),
	(4, '20181113041458_http2_support.js', 1, '2024-11-24 07:26:22'),
	(5, '20181213013211_forward_scheme.js', 1, '2024-11-24 07:26:22'),
	(6, '20190104035154_disabled.js', 1, '2024-11-24 07:26:22'),
	(7, '20190215115310_customlocations.js', 1, '2024-11-24 07:26:22'),
	(8, '20190218060101_hsts.js', 1, '2024-11-24 07:26:22'),
	(9, '20190227065017_settings.js', 1, '2024-11-24 07:26:22'),
	(10, '20200410143839_access_list_client.js', 1, '2024-11-24 07:26:22'),
	(11, '20200410143840_access_list_client_fix.js', 1, '2024-11-24 07:26:23'),
	(12, '20201014143841_pass_auth.js', 1, '2024-11-24 07:26:23'),
	(13, '20210210154702_redirection_scheme.js', 1, '2024-11-24 07:26:23'),
	(14, '20210210154703_redirection_status_code.js', 1, '2024-11-24 07:26:23'),
	(15, '20210423103500_stream_domain.js', 1, '2024-11-24 07:26:23'),
	(16, '20211108145214_regenerate_default_host.js', 1, '2024-11-24 07:26:23');

-- 테이블 데이터 php-mysql.migrations_lock:~1 rows (대략적) 내보내기
INSERT IGNORE INTO `migrations_lock` (`index`, `is_locked`) VALUES
	(1, 0);

-- 테이블 데이터 php-mysql.proxy_host:~0 rows (대략적) 내보내기

-- 테이블 데이터 php-mysql.redirection_host:~0 rows (대략적) 내보내기

-- 테이블 데이터 php-mysql.setting:~0 rows (대략적) 내보내기
INSERT IGNORE INTO `setting` (`id`, `name`, `description`, `value`, `meta`) VALUES
	('default-site', 'Default Site', 'What to show when Nginx is hit with an unknown Host', 'congratulations', '{}');

-- 테이블 데이터 php-mysql.stream:~0 rows (대략적) 내보내기

-- 테이블 데이터 php-mysql.transactions:~0 rows (대략적) 내보내기
INSERT IGNORE INTO `transactions` (`id`, `user_id`, `transaction_date`, `description`, `amount`, `category`, `created_at`) VALUES
	(1, 1, '2024-11-05', '월급', 2000000.00, '급여', '2024-11-24 07:42:02'),
	(2, 1, '2024-11-13', '볼링', -20000.00, '취미', '2024-11-24 07:42:26'),
	(3, 1, '2024-11-07', '회식', -200000.00, '식비', '2024-11-24 07:42:41'),
	(4, 1, '2024-12-05', '월급', 2000000.00, '급여', '2024-11-24 07:42:58'),
	(5, 1, '2024-12-05', '야구', -50000.00, '취미', '2024-11-24 07:43:15');

-- 테이블 데이터 php-mysql.user:~0 rows (대략적) 내보내기
INSERT IGNORE INTO `user` (`id`, `created_on`, `modified_on`, `is_deleted`, `is_disabled`, `email`, `name`, `nickname`, `avatar`, `roles`) VALUES
	(1, '2024-11-24 07:26:22', '2024-11-24 07:26:22', 0, 0, 'admin@example.com', 'Administrator', 'Admin', '', '["admin"]');

-- 테이블 데이터 php-mysql.users:~1 rows (대략적) 내보내기
INSERT IGNORE INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
	(1, 'abc', '$2y$10$amN9m/kuAZiKsfI53Zr7V.O3Zjc5qx8oTkLPKt/aCI555VFe6aSGu', '2024-11-24 07:37:12');

-- 테이블 데이터 php-mysql.user_permission:~0 rows (대략적) 내보내기
INSERT IGNORE INTO `user_permission` (`id`, `created_on`, `modified_on`, `user_id`, `visibility`, `proxy_hosts`, `redirection_hosts`, `dead_hosts`, `streams`, `access_lists`, `certificates`) VALUES
	(1, '2024-11-24 07:26:23', '2024-11-24 07:26:23', 1, 'all', 'manage', 'manage', 'manage', 'manage', 'manage', 'manage');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
