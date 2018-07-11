# ajax-users

Используется две таблицы:

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `city` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `age` int(2) NOT NULL,
  `city_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

В файле core/MysqlClass.php проставить:

$db_user =""; //имя пользователя бд
$db_password = ""; //пароль к бд
$db_host = "localhost"; //адрес сервера
$db_name = "users-sity"; //имя бд
