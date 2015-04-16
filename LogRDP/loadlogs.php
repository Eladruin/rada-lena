<?php

/**
 * @author MPK
 * @copyright 2015
 */

header("Content-Type: text/html; charset=utf-8");

echo("<link rel='stylesheet' href='stylereset.css'>");
echo("<link rel='stylesheet' href='styles.css'>");


$filename[0] = "logsrdp/alllogs/utf8/abakanrdp.log";
$filename[1] = "logsrdp/alllogs/utf8/achinskrdp.log";
$filename[2] = "logsrdp/alllogs/utf8/barnaulrdp.log";
$filename[3] = "logsrdp/alllogs/utf8/irkutskrdp.log";
$filename[4] = "logsrdp/alllogs/utf8/kanskrdp.log";
$filename[5] = "logsrdp/alllogs/utf8/minusinskrdp.log";
$filename[6] = "logsrdp/alllogs/utf8/nskrdp.log";
$filename[7] = "logsrdp/alllogs/utf8/omskrdp.log";
$filename[8] = "logsrdp/alllogs/utf8/ts.log";
$filename[9] = "logsrdp/alllogs/utf8/ulanuderdp.log";
$nameserv[0] = "ABAKANRDP";
$nameserv[1] = "ACHINSKRDP";
$nameserv[2] = "BARNAULRDP";
$nameserv[3] = "IRKUTSKRDP";
$nameserv[4] = "KANSKRDP";
$nameserv[5] = "MINUSINSKRDP";
$nameserv[6] = "NSKRDP";
$nameserv[7] = "OMSKRDP";
$nameserv[8] = "TS";
$nameserv[9] = "ULANUDERDP";


//$word = array();

    $server = "pavel";
    $user = "pavel";
    $password = "qazwsxedc";
    // Попытка установить соединение с MySQL:
    $link = mysql_connect($server, $user, $password);
    
    // Соединились, теперь выбираем базу данных:
    $db = "base_logs";
    mysql_select_db($db);
    
    
    // удаляем таблицу
    $sql = "DROP TABLE logs";    mysql_query($sql);   
    

$j = 0;

echo("<div style='margin:0 auto; width: 360px'>");
echo "<table class='table_load'>";
    echo "<tr><td> Имя сервера:</td><td> Дата и время:</td>";
for ($j=0; $j<10; $j++ )
{   /*
    // Создаём таблицу
    $sql = "CREATE TABLE $nameserv[$j] (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            nameserv VARCHAR(30) NOT NULL,
            nameagent VARCHAR(30) NOT NULL,
            namecomp VARCHAR(30),
            date TIMESTAMP
            )";    
    mysql_query($sql);
    */
    $handle = fopen($filename[$j], "r");
    $contents = fread($handle, filesize($filename[$j]));    
    fclose($handle);   
    
    //$filetime = filemtime($filename[$j]);  
    //echo(date("F d Y H:i:s.", $filetime - 3600));
    
    $mas = explode( "\n", $contents );    
    for($i=0; $i < count($mas); $i++) {
        $word[$i] = explode( " ", $mas[$i] );
    }
    
    echo "<tr>";
    
    $result=mysql_query("select * from $nameserv[$j]");
    $num=mysql_num_rows($result);
    if ($num>0){ 
    
        $sql = "SELECT date FROM $nameserv[$j] ORDER BY id DESC LIMIT 1";
        $result = mysql_query($sql);
        
        $line = mysql_fetch_array($result, MYSQL_ASSOC);
        
        $date = date_create($line[date]);
        
        echo "<td><b>$nameserv[$j]</b> </td> <td>".date_format($date, 'Y-m-d H:i:s')."</td>";    
    }   
    else{
        $date = date_create("2000-01-01 00:00:00");
    } 
    
    
    
    $i = 0;
    for($i=0; $i < count($mas); $i++){     
        
        
        $str = substr($word[$i][2], 6, 4)."-".substr($word[$i][2], 0, 2)."-".substr($word[$i][2], 3, 2);    
        $str = $str." ".substr($word[$i][3], 0, 8);
        $date_new = date_create($str); 
        
        if($date < $date_new){
            //echo($word[$i][0]." ".$word[$i][1]." ".$word[$i][2]." ".$word[$i][3]."<br>");    
            $sql = "INSERT INTO $nameserv[$j](nameserv, nameagent, namecomp, date) 
                        values('".$nameserv[$j]."', '".$word[$i][0]."', '".$word[$i][1]."', '".$str."')";
            mysql_query($sql);    
        }
    }    
    
    echo "</tr>";    
}
echo "</table>";

echo "<br><b>Овновление таблиц выполнено!</b >";
mysql_close($link);

?>