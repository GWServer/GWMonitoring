<?php
/*
 * V 2.0
 */
define( 'MONITORING_URL', 'https://tmonitoring.com/api/check/' );
define( 'CASE_INSENSITIVE', true );

$config = array(

	'db_host' => 'https://cp.sprinthost.ru', //Хост бд

	'db_name' => 'f1115908_bonys', //Название бд

	'db_user' => 'f1115908_bonys', //Пользователь бд

	'db_pass' => '6tSvi4S4', //Пароль от пользователя бд 

	'db_table' => 'iconomy', //Таблицы iconomy

	'col_money' => 'balance', //Название колонки в таблицы баланса

	'col_user' => 'username', //Название колонки в таблицы логина пользователя

	'amount' => 100, //Сумма начисление за голосование

);

$data = @unserialize( @file_get_contents( MONITORING_URL . (string) $_GET['hash'] . '?id=' . (int) $_GET['id'] ) );

if ( @strlen( $data['hash'] ) != 32 or @strlen( $_GET['hash'] ) != 32 or $data['hash'] != $_GET['hash'] ) {
	die( "Invalid hash" );
}

if ( ! $db = @mysqli_connect( $config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name'] ) ) {
	die( "Could not connect to database" );
}

$q = "UPDATE `{$config['db_table']}` SET `{$config['col_money']}`=`{$config['col_money']}`+{$config['amount']} WHERE `{$config['col_user']}`" . ( CASE_INSENSITIVE ? " COLLATE utf8_general_ci " : "" ) . "='{$data['username']}'";
if ( ! @mysqli_query( $db, $q ) ) {
	die( "An error has occurred" );
}
