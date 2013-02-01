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
	// ����� � �������
	$TABLES = array();
	// ������� � �������� - ������
	$TABLES['anketa'] = 'anketa';
	// ������� � �������� - ��������
	$TABLES['anketa_q'] = 'anketa_q';
	// ��������� � ������ �����������
	$TABLES['users'] = 'users';
	// ������� � �����������
	$TABLES['messages'] = 'messages';
	// ������� � ���������
	$TABLES['klasove'] = 'klasove';
	// ������� � ���������
	$TABLES['paralelki'] = 'paralelki';
	// ������� � �������
	$TABLES['uchenici'] = 'uchenici';
	// ������� � ��������
	$TABLES['predmeti'] = 'predmeti';
	// ������� ������� -> ������
	$TABLES['predmet_teacher'] = 'predmet_teacher';
	// ������� ������ -> ����
	$TABLES['teacher_klas'] = 'teacher_klas';
	// ������� ������� - > ����
	$TABLES['predmet_klas'] = 'predmet_klas';
	// ������� ������
	$TABLES['ocenki'] = 'ocenki';
	// ������� ������ �������
	$TABLES['srok'] = 'srok';
	// ������� ���������
	$TABLES['zabelejki'] = 'zabelejki';
	//������� �� ������ �����������
	$TABLES['klasen'] = 'klasen';
	// ������� �� ���������
	$TABLES['otsastviq'] = 'otsastviq';
	// ������� �� ������ ������
	$TABLES['srochni'] = 'srochni';
	// ������� �� ������� ������
	$TABLES['godishni'] = 'godishni';
	// ������� �� ���������� ������� �����
	$TABLES['informaciq'] = 'informaciq';
	// ������� �� �������� ��������
	$TABLES['programa'] = 'programa';
	// ������� �� �������� ��������
	$TABLES['programa_predmeti'] = 'programa_predmeti';
	// ������� ��������� �� �������
	$TABLES['teacher_messages'] = 'teacher_messages';
	
	// ����� ���������
	define('MYSQL_ERROR', 'There has been an error with the database!!!');
	// ���������� ��������� ��������
	define('INDEX', 'index.php');
	// ���������� ���� �������� ��������
	define('MAX_NUM_Q', '10');
	// ������������
	define('RESULTS', 10);
	// ������������ ���������
	define('RESULT_OTSASTVIQ', 15);
	// ����� �� ������� � ��������
	define('ANKETA_COLOR', 'images/graphic_poll.gif');
?>