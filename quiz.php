<html>
<head>
	<title>Quiz System</title>
</head>
<body>
<h1>Quiz system prototype</h1>
<?php
	session_start();

	$intro_text =
		'<p>One day, this will evolve into SMACKDOWN, a competitive social quiz tool for students of
		pretty much any topic to have fun and help each other study.
		<p>To start with, though, here is this rather sad little PHP script. Gotta start somewhere.
		<p><i>You must accept cookies to use this site.</i>';
	
	$form_markup = '<form action="quiz.php" method="post">
		<p>Your answer: <input type="text" name="user_answer" /></p>
		<p><input type="submit" /></p>
		</form>';

	if (isset($_SESSION['attempted_count']) and isset($_POST['user_answer']))
	{
		$_SESSION['attempted_count']++; 
		// check answer against expected answer
		if ($_POST['user_answer'] == $_SESSION['correct_answer'])
		{
			echo '<p>Correct!';
			$_SESSION['correct_count']++;
			echo '<p>Try another one...';
		}
		else
		{
			echo '<p>Sorry, the correct answer is: ' . $_SESSION['correct_answer'];
			echo '<p>Try another one!';
		}
		echo '<p>So far your score is ' . $_SESSION['correct_count'] . 
			' out of ' . $_SESSION['attempted_count'];
	}
	else if (!isset($_SESSION['attempted_count']) and isset($_POST['user_answer']))
	{
		// form request has been submitted but no cookie for me
		echo '<p><i>You must accept cookies. It is only waffer thin, monsieur.</i>';
	}
	else
	{
		// new session!
		$_SESSION['attempted_count'] = 0;
		$_SESSION['correct_count'] = 0;
		echo $intro_text;
	}

	// pull a new question and answer pair from the database
	$connect_string = "host=localhost port=5432 dbname=Smackdown user=readonly password=readonly";
	$db_conn = pg_connect($connect_string);
	if (!$db_conn) {
		echo '<p>Trouble connecting to the database.';
	} else {
		$query_result = pg_query($db_conn, 'select * from multi_out_test();');
		$question = pg_fetch_result($query_result, 0, 0);
		$answer = pg_fetch_result($query_result, 0, 1);
		$_SESSION['correct_answer'] = $answer;
		echo '<p>Question: ' . $question;
	}

	// get the user's response to the question
	echo $form_markup;
?>

</body>
</html>
