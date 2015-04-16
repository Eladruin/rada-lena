<?php

/**
 * @author MPK
 * @copyright 2015
 */

header("Content-Type: text/html; charset=utf-8");

echo("<link rel='stylesheet' href='stylereset.css'>");
echo("<link rel='stylesheet' href='styles.css'>");

echo("<link rel='stylesheet' href='ui/jquery-ui.css'>");
echo("<script type='text/javascript' src='ui/jquery.js'></script>");
echo("<script type='text/javascript' src='ui/jquery-ui.js'></script>");



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
    
    
$j = 0;

echo("<div style='margin:0 auto; width: 620px'>");
    echo("<h1 class='demoHeaders'><a href='loadlogs.php'>Обновить БД </a></h1>");
    echo("</div>");

for ($j=0; $j<10; $j++ )
{  
    
    $sql = "SELECT date FROM $nameserv[$j] ORDER BY id DESC LIMIT 1";
    $result = mysql_query($sql);        
    $line = mysql_fetch_array($result, MYSQL_ASSOC);        
    $date = date_create($line[date]);  
       
    //$sql = "SELECT * FROM $nameserv[$j]";
    $sql = "SELECT DISTINCT nameagent, namecomp FROM $nameserv[$j] ORDER BY nameagent";
    
    $result = mysql_query($sql);
    
    echo("<div style='margin:0 auto; width: 620px'>");
    echo("<h2 class='demoHeaders'>".$nameserv[$j]." (".date_format($date, 'Y-m-d H:i:s').")</h2>");
    echo("</div>");
    
    echo("<div id='".$nameserv[$j]."' style='margin:0 auto; width: 620px'>");    
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
    
        echo "<h3 > $line[nameagent] | $line[namecomp] </h3>";
        
        $sql = "SELECT nameagent, namecomp, date FROM $nameserv[$j] WHERE nameagent='".$line[nameagent]."' and namecomp ='".$line[namecomp]."' ORDER BY id DESC LIMIT 20";
        
        $result_agent = mysql_query($sql);
        echo("<div>");
        echo "<table class='table_hidden'>\n";
        while ($line1 = mysql_fetch_array($result_agent, MYSQL_ASSOC)) {
            echo "\t<tr>\n";
            
            foreach ($line1 as $col_value) 
                echo "\t\t<td>$col_value</td>\n";                
                        
            echo "\t</tr>\n";       
        }   
             
        echo "</table>\n";
        echo("</div>");
    
    }
    echo("</div>");
    
    
    
    echo("<script>$( '#".$nameserv[$j]."' ).accordion({ collapsible: true, active: false, heightStyle: 'content'}); </script>");
}

mysql_close($link);

//echo "<b>Готово!</b>";

?>