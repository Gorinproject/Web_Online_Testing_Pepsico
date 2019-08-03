<?php
  // извлечь из HTTP-запроса значения переданных параметров
  // и сохранить их в локальных переменных
  $name = $_POST['name'];
  $score = $_POST['score'];
  // проверить, что в запросе имеются все необходимые параметры:
  // имя пользователя и его результат тестирования.
  if( !$name || !$score )
  {
    //если параметров не хватает, то вывести уведомление об ошибке
    echo '<h1>Ошибка:</h1>Страница вызвана некорректно';
  }
  else
  {
    // установить HTTP-заголовки, которые упростят web-браузеру
    // выбор приложения для обработки полученного документа
    header('Content-Type: text/html; charset = windows-1251');
    header( 'Content-Type: application/msword' );
    header( 'Content-Disposition: inline, filename=cert.rtf');

    $date = date( 'F d, Y' );

    // открыть файл шаблона
    $filename = 'PHPCertification.rtf';
    $output = file_get_contents($filename);

    // заменить заполнители в шаблоне 
    //на значения соответствующих переменных
    $output = str_replace( '<<NAME>>', strtoupper( $name ), $output );
    $output = str_replace( '<<Name>>', $name, $output );
    $output = str_replace( '<<score>>', $score, $output );
    $output = str_replace( '<<mm/dd/yyyy>>', $date, $output );

    // отправить получившийся документ в web-браузер пользователя
    echo $output;
  }
?>