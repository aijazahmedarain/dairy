<?php
	require_once('classes/dnevnik_register.php');
	require_once('classes/dnevnik_klas.php');
	require_once('classes/dnevnik_predmet.php');
	require_once('classes/dnevnik_main.php');
	require_once('classes/dnevnik_students.php');
	require_once('classes/dnevnik_srok.php');
	require_once('classes/dnevnik_paralelki.php');
	require_once('classes/dnevnik_otsastviq.php');
	require_once('classes/dnevnik_programa.php');
	// МАСИВ С ТАБЛИЦИ
	$TABLES = array();
	// таблица с анкетата - въпрос
	$TABLES['anketa'] = 'anketa';
	// таблица с анкетата - отговори
	$TABLES['anketa_q'] = 'anketa_q';
	// таблицата с всички потребители
	$TABLES['users'] = 'users';
	// таблица с съобщенията
	$TABLES['messages'] = 'messages';
	// таблица с класовете
	$TABLES['klasove'] = 'klasove';
	// таблица с паралелки
	$TABLES['paralelki'] = 'paralelki';
	// таблица с ученици
	$TABLES['uchenici'] = 'uchenici';
	// таблица с предмети
	$TABLES['predmeti'] = 'predmeti';
	// таблица предмет -> учител
	$TABLES['predmet_teacher'] = 'predmet_teacher';
	// таблица учител -> клас
	$TABLES['teacher_klas'] = 'teacher_klas';
	// таблица предмет - > клас
	$TABLES['predmet_klas'] = 'predmet_klas';
	// таблица оценки
	$TABLES['ocenki'] = 'ocenki';
	// таблица учебни срокове
	$TABLES['srok'] = 'srok';
	// таблица забележки
	$TABLES['zabelejki'] = 'zabelejki';
	//таблица за класен ръководител
	$TABLES['klasen'] = 'klasen';
	// таблица за отсъствия
	$TABLES['otsastviq'] = 'otsastviq';
	// таблица за срочни оценки
	$TABLES['srochni'] = 'srochni';
	// таблица за годишни оценки
	$TABLES['godishni'] = 'godishni';
	// таблица за информация относно сайта
	$TABLES['informaciq'] = 'informaciq';
	// таблица за учебната програма
	$TABLES['programa'] = 'programa';
	// таблица за учебната програма
	$TABLES['programa_predmeti'] = 'programa_predmeti';
	// таблица съобщения за учители
	$TABLES['teacher_messages'] = 'teacher_messages';
	
	// ДРУГИ НАСТРОЙКИ
	define('MYSQL_ERROR', 'There has been an error with the database!!!');
	// дефинираме началната страница
	define('INDEX', 'index.php');
	// максимален брой отговори анкетата
	define('MAX_NUM_Q', '10');
	// странициране
	define('RESULTS', 10);
	// странициране отсъствия
	define('RESULT_OTSASTVIQ', 15);
	// цвета на скалата в анкетата
	define('ANKETA_COLOR', 'images/graphic_poll.gif');
?>