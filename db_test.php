<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LET US TEST SOME PHP DATABASE STUFF SHALL WE</title>
</head>
<body>
<h1>LET US TEST SOME PHP DATABASE STUFF SHALL WE</h1>
<?php
	$connect_string = "host=localhost port=5432 dbname=Smackdown user=readonly password=readonly";
	$db_conn = pg_connect($connect_string);
	if (!$db_conn) {
		echo '<p>Ruh roh';
	} else {
		echo '<p>Mkay, I have a connection.';
		$query_result = pg_query_params($db_conn, 'select question_text from public.card where card_id = $1', array(1));
		$question = pg_fetch_result($query_result, 0, 0);
		echo '<p>The question is: ' . $question;
}
?>
</body>
</html>
