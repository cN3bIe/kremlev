<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'cn3bie_caviar');

/** MySQL database username */
define('DB_USER', 'cn3bie_caviar');

/** MySQL database password */
define('DB_PASSWORD', 'Xf*2JY?*');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'S!CEb%-haj]9)b0JTxDhakn(&.Fl]Q[Y3:SGwWI^+@pf7+YPU>+54]hGryak2Gwp');
define('SECURE_AUTH_KEY',  'GdW%i:l`b5YX$xGymQIW^w*Im#_YwF]8Gy=Ra/i_Q}b$d9gZv;/6ZEf7H7GMq>*0');
define('LOGGED_IN_KEY',    'ND|vRsQ),>fG+~ZK=%<5JeF<]cUVBJccSC@D X:cw}K=xZF(B{SYF%lM@cq<-/L8');
define('NONCE_KEY',        't;}ajaH=_{71C!{sRdc][#9Ma;QFESK{x6AbwQYuAz&Js-XkcR2==`t}=+M.fVj[');
define('AUTH_SALT',        ',B+~t/:|HO:K!J@(cv+MNN~BI~VJJMyO)E//)tF0u9?43_K7.V22J!T&l=?MCLO=');
define('SECURE_AUTH_SALT', 'z})di5(spB_qxFey_uwko8S7H_iWv-6ldf25dCZPSlPZK3t@uq/KJ!T22? {=kdf');
define('LOGGED_IN_SALT',   '3{yg~AmML8ip&!s_9$JygaSiUfpKgjZ=bQtac+Euhb53%~DV^Zxbj zk}0Ho5728');
define('NONCE_SALT',       '*Jh_k3!F?o)[d.#y8FTHn-CFw_4])d]vu;N/A(*QGlM$yo5(HJXJ&KRi*n`=wv[!');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') ) define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
