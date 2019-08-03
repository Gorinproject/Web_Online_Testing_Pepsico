<!DOCTYPE HTML>
<head><meta charset="utf-8"/></head>
<?php 
mysql_connect("sql107.site.com", "login", "pass");
mysql_select_db("db_question");
mysql_query("SET NAMES 'utf8';");
mysql_query("SET CHARACTER SET 'utf8';");
mysql_query("SET SESSION collation_connection = 'utf8_general_ci';"); 
 $parent_id = 1;
 $max_answer = 10;
 $score_true = 50;
$query = mysql_query("SELECT count(id) page_max FROM `question` WHERE `parent_id` = '".$parent_id."';");
if (!$query)
	{
		$message  = 'Неверный запрос: ' . mysql_error() . "\n";
		$message .= 'Запрос целиком: ' . $query;
		die($message);
	}
$data = mysql_fetch_assoc($query);	
$page_max = $data['page_max'];
/*	
while ($data_question = mysql_fetch_assoc($query))
	{
		$question_id[$i] = $data_question['id'];					
		$question_text[$i] = $data_question['text'];
	}
$page_max=count($question_id);
*/
header('Content-Type: text/html; charset = utf8');
if (isset($_POST['page'])){
$page = $_POST['page'];
} else {$page =0;}
 
?>
<?

?>

<html>
  <body>


    <h1><p align="center" style="margin-top: 139px;">
         Онлайн-тестирование
         </p></h1>
<?php if($_POST['page']< $page_max+1) echo  '<p style="text-align:center; font-size:25px; color:#bf1010;">Необходимо дать ответы на поставленные Вам вопросы:</p>'; ?>

    <form action="score1.php" method="post" style=" font-size: 21px;  margin-left: 85px;">
  <?php if ($page == 0) { ?>  
    <p style="text-align:center; font-size:23px; font-weight:bold; margin-left:-85px;">Ваше ФИО<input type="text" name="name"  style="border: 1px solid #345ea0;  border-radius: 16px;  font-size: 27px;  margin-left: 16px; text-indent:15px; width:500px; " ></p>
    <input type="hidden" name="page" value="1">
    <? } ?>
     <?php if ($page > 0 and $page < $page_max + 1) { 
     $p = 'q1';
     $rezult = '';
     for ($i=1; $i <= 10; $i++)
	{
	$yy='q'.$i;
	if ($_POST["$yy"]=='on') { $rezult = $rezult.'1';} else {$rezult = $rezult.'0';}
	}
	
     //echo $rezult;
     if (isset($_POST['name']))
        {
     echo '<input type="hidden" name="name" value="'.$_POST['name'].'">';
     echo '<input type="hidden" name="page" value="'.($page+1).'">';
     echo '<input type="hidden" name="answer_rezult'.($page-1).'" value="'.$rezult.'">';
     for ($i=1; $i < $page-1; $i++)
	{
	echo '<input type="hidden" name="answer_rezult'.$i.'" value="'.$_POST['answer_rezult'.$i].'">';
	}
     }
     $query1 = mysql_query("SELECT `id`, `text` FROM `question` WHERE `parent_id` = '".$parent_id."' and `id`= '".mysql_real_escape_string($_POST['page'])."' LIMIT 1;");
if (!$query1)
	{
		$message  = 'Неверный запрос: ' . mysql_error() . "\n";
		$message .= 'Запрос целиком: ' . $query;
		die($message);
	}
$data1 = mysql_fetch_assoc($query1);
echo '<p style="font-weight:bold; font-size:26px; text-decoration:underline;">Моделирование №'.$data1['id'].' '.$data1['text'].'</p>';

$query = mysql_query("SELECT `sort` id, `text` FROM `answer` WHERE `id_question_parent` = '".$parent_id."' and `id_question`= '".mysql_real_escape_string($_POST['page'])."' order by 1;");
if (!$query)
	{
		$message  = 'Неверный запрос: ' . mysql_error() . "\n";
		$message .= 'Запрос целиком: ' . $query;
		die($message);
	}
	while ($data_answer = mysql_fetch_assoc($query))
	{
		$answer_id = $data_answer['id'];					
		$answer_text = $data_answer['text'];
	echo '<p><input type="checkbox" name="q'.$answer_id.'">'.$answer_text.'</p>';
	}
	
     ?>  
      
<? } ?>
     
     <?php  if($_POST['page']<$page_max+1) echo 
      '<p align="center"><input type="image" border="0" src="dalee.png" style="margin-left:-85px;"></p>'; ?>
    </form>
  </body>
</html>



<?php
header('Content-Type: text/html; charset = utf8');
  // извлечь из HTTP-запроса значения переданных параметров
  // и проверить результаты ответов
  if($_POST['page']==$page_max+1){
	$count_true = 0;
	$name = $_POST['name'];
	$rezult = '';
	$result_ = '';
     for ($i=1; $i <= $max_answer; $i++)
	{
	$yy='q'.$i;
	if ($_POST["$yy"]=='on') { $rezult = $rezult.'1';} else {$rezult = $rezult.'0';}
	} 
 for ($i=1; $i < $page_max; $i++)
	{
	$answer_rezult[$i]=$_POST['answer_rezult'.$i];
	}
	
     $answer_rezult[$page_max] = $rezult;
     $result_log = '';
     for ($i=1; $i <= $page_max; $i++)
     {
     $result_log =$result_log.'['.$i.']-{'.$answer_rezult[$i].'}, ';
     }


for($i=1; $i <= $page_max; $i++){
$query = mysql_query("SELECT `sort` id, `is_true` FROM `answer` WHERE `id_question_parent` = '".$parent_id."' and `id_question`= ".$i." order by 1;");
if (!$query)
	{
		$message  = 'Неверный запрос: ' . mysql_error() . "\n";
		$message .= 'Запрос целиком: ' . $query;
		die($message);
	}
	$answer_true[$i] = '';
	while ($data_answer = mysql_fetch_assoc($query))
	{
		$answer_true[$i] = $answer_true[$i].$data_answer['is_true'];					
	}
	$answer_true[$i] =  str_pad($answer_true[$i],$max_answer,'0000000000000000000000000000000000000000000000000000000000000000000000000000000000');
	if ($answer_true[$i] == $answer_rezult[$i]) { $count_true = $count_true +1;
	$result_= $result_.$i.'=OK, ';}
}
$score = ($count_true*100)/$page_max;
$key = md5 ($name.$score.time());
$query = mysql_query("INSERT INTO `result`(`name`, `score`, `answer`, `date_question`, `question_parent`, `key`) VALUES ('".mysql_real_escape_string($name)."','".number_format($score,4)."','".$result_.$result_log."',sysdate(),'".$parent_id."', '".$key."');");
if (!$query)
	{
		$message  = 'Неверный запрос: ' . mysql_error() . "\n";
		$message .= 'Запрос целиком: ' . $query;
		die($message);
	}
 
 
 
   if($score < $score_true)
    {
      // пользователь не прошел экзамен, так как набрал меньше 50%
      // показать страницу с сообщением об ошибке
      echo '<h1 align="center"><img src="rosette.gif" alt="" />
                               Очень жаль:
                               <img src="rosette.gif" alt="" /></h1>';
      echo '<p style=\'color:#bf1010; font-weight:bold; font-size:22px; text-align:center;\'>Для того чтобы пройти тестирование, вы должны правильно ответить хотя бы на
          50% вопросов</p>';
    }
    else
    {
      // пользователь прошел экзамен
      // показать страницу для загрузки сертификатов

      // создать строку с результатом с точностью до знака после запятой
      $score = number_format($score, 1);

      echo '<h1 align="center"><img src="rosette.gif" alt="" />
                               Поздравляем!
                               <img src="rosette.gif" alt="" /></h1>';
      echo "<p style=\"text-align:center; font-weight:bold; font-size:26px;\">Вы успешно сдали экзамен, $name, ваш итог
               составляет $score%.</p>";

      // вывести ссылки на сценарии, которые создают сертификаты
 
      echo '<p> </p>';
      echo '<form action="/tcpdf/examples/q1.php" method="post">';
      echo '<center>
              <input type="image" src="certificate.png" border="0">
            </center>';
      echo '<input type="hidden" name="key" value="'.$key.'">';
      echo '<input type="hidden" name="name_certificate" value="'.$name.'">';
      echo '</form>';
     }
 
  }
  
  
?>