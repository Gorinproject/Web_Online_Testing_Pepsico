<!DOCTYPE HTML>
<head><meta charset="utf-8"/></head>
<?
mysql_connect("", "", "");
mysql_select_db("question");
mysql_query("SET NAMES 'utf8';");
mysql_query("SET CHARACTER SET 'utf8';");
mysql_query("SET SESSION collation_connection = 'utf8_general_ci';"); 

if($_GET['login']=='admin1' ){
$query = mysql_query("SELECT `name`, `score`, `date_question`, `question_parent`, `answer` FROM `result` order by 1, 3;");
if (!$query)
	{
		$message  = 'Неверный запрос: ' . mysql_error() . "\n";
		$message .= 'Запрос целиком: ' . $query;
		die($message);
	}
	echo '<table>';
	while ($data_answer = mysql_fetch_assoc($query))
	{
	echo '<tr>';
		echo '<td>'.$data_answer['name'].'</td><td>'.$data_answer['score'].'</td><td>'.$data_answer['date_question'].'</td><td>'.$data_answer['question_parent'].'</td><td>'.$data_answer['answer'].'</td>';
		echo '</tr>';
	}
	echo '</table>';
	}
	