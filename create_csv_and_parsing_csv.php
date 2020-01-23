<?php

ini_set('display_errors', 1); //debug 
error_reporting(E_ALL);

$file_name = "/tmp/sql.csv";
require_once('login.php');

$connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

// запрос к базе и вывод файла в формате csv
$query = "SELECT * FROM classics INTO OUTFILE '$file_name' FIELDS TERMINATED BY ','";

$result_select = $connection->query($query); //даст true если файл не созда

if(!$result_select) {
// парсинг файла
$row = 1;
if (($handle = fopen("sql.csv", "r")) !== FALSE) { // открываем файл для чтения
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        echo "<p> $num полей в строке $row: <br /></p>\n";
        $row++;
        //for ($c=0; $c < $num; $c++) {
            echo "Author: " . $data[0] . "<br/>\n";
            echo "Title: " . $data[1] . "<br/>\n";
            echo "Category: " . $data[2] . "<br/>\n";
            echo "Year: " . $data[3] . "<br/>\n";
            echo "ISBN: " . $data[4] . "<br/>\n";

        //}
    }
    fclose($handle);
}

}


?>