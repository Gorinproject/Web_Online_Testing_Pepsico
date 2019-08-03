<?php
  // ������� �� HTTP-������� �������� ���������� ����������
  // � ��������� �� � ��������� ����������
  $name = $_POST['name'];
  $score = $_POST['score'];
  // ���������, ��� � ������� ������� ��� ����������� ���������:
  // ��� ������������ � ��� ��������� ������������.
  if( !$name || !$score )
  {
    //���� ���������� �� �������, �� ������� ����������� �� ������
    echo '<h1>������:</h1>�������� ������� �����������';
  }
  else
  {
    // ���������� HTTP-���������, ������� �������� web-��������
    // ����� ���������� ��� ��������� ����������� ���������
    header('Content-Type: text/html; charset = windows-1251');
    header( 'Content-Type: application/msword' );
    header( 'Content-Disposition: inline, filename=cert.rtf');

    $date = date( 'F d, Y' );

    // ������� ���� �������
    $filename = 'PHPCertification.rtf';
    $output = file_get_contents($filename);

    // �������� ����������� � ������� 
    //�� �������� ��������������� ����������
    $output = str_replace( '<<NAME>>', strtoupper( $name ), $output );
    $output = str_replace( '<<Name>>', $name, $output );
    $output = str_replace( '<<score>>', $score, $output );
    $output = str_replace( '<<mm/dd/yyyy>>', $date, $output );

    // ��������� ������������ �������� � web-������� ������������
    echo $output;
  }
?>