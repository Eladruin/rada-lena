<?php

/**
 * @author MPK
 * @copyright 2015
 */
 
header("Content-Type: text/html; charset=utf-8");

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

$file_i = "name_for_exclusion.txt";

// исключения

$nn = array();

class agent_c{
    public $nameagent;
    public $namecomp;
    public $date;
    public $time;
}

class serv
{    
    public $names;
    public $word;    
    public $visible;
    public $visible_danger;
    public $count = 0;
    public $count_work = 0;    
    public $agents;
    public $filetime;
    public $size = 200;             
    
    public function loadc($content, $name){
        $this->names = $name;
        $mas = explode( "\n", $content );
        $this->count = count($mas)-1;
        for($i=0; $i < count($mas); $i++) { 
            $this->visible[$i] = true;
            $this->visible_danger[$i] = false;
            $this->word[$i] = explode( " ", $mas[$i] );
            
            
            $this->agents[$i] = new agent_c();
            
            $this->agents[$i]->nameagent = $this->word[$i][0];
            $this->agents[$i]->namecomp  = $this->word[$i][1];             
            $this->agents[$i]->date  = $this->word[$i][2];
            $this->agents[$i]->time  = $this->word[$i][3];
            
        }
        
    }
    
    public function sort_mas(){
        $n = $this->count;        
        $tmp = array();
        $t;
        // сортировка            
        for($j=0; $j<$this->count; $j++){            
            for($i=0; $i < $this->count; $i++) {                 
                if(strcmp($this->word[$j][0],$this->word[$i][0]) < 0){                
                    $tmp = array_replace($tmp, $this->word[$j]);               
                    $this->word[$j] = array_replace($this->word[$j],$this->word[$i]);
                    $this->word[$i] = array_replace($this->word[$i], $tmp);                                                
                }                      
            }                                    
        }
        

        // выбор дублекатов
        for($j=0; $j < $this->count; $j++){            
                for($i=$j+1; $i < $this->count; $i++){                    
                    if($this->word[$j][0] == $this->word[$i][0])
                        if($this->word[$j][1] == $this->word[$i][1]) {       
                            $this->visible[$i] = false;   
                        }  
                }            
        }                


        // Выбор всех подозрительных        
        for($j=0; $j < $this->count; $j++)         
                if($this->visible[$j])
                    for($i=$j+1; $i < $this->count; $i++)
                      if($this->visible[$i])
                        if(strcmp($this->word[$j][0], $this->word[$i][0])==0)
                            if(strcmp($this->word[$j][1],$this->word[$i][1]) != 0){                    
                                $this->visible_danger[$i] = true;
                                $this->visible[$i] = true; 
                                $this->visible_danger[$j] = true;
                                $this->visible[$j] = true;                                                                     
                            }       
                   
                                      
        // подсчёт уникальных агентов
        
        for($j=0; $j < $this->count; $j++) if($this->visible[$j]) $this->count_work++;
        
    }
    
    // выбор исключений
    public function exclusion($param){
        
        for($j=0; $j < $this->count; $j++){
            if ($this->visible_danger[$j])                
                if( $this->word[$j][0]== $param[0] ){
                    
                    if( $this->word[$j][1] == $param[1]){
                        $this->visible[$j] = false;
                        $this->visible_danger[$j] = false;                        
                    }
            } 
                                                                                      
        }        
    }
    
    public function show_serv(){
        echo("<div  style='margin:0 auto; width: 720px'>");
        echo("<br>");
        echo("<table width='720' class='main_table'>");
        echo("<caption><b>");echo($this->names); echo(" ("); echo($this->count_work); echo(")</b></caption>");
        
        //for($i=0; $i < $this->count; $i++) $this->visible[$i] = true;
        
        for($i=0; $i < $this->count; $i++) {
            if ($this->visible[$i]) echo("<tr>");
            for($j=0; $j< count($this->word[$i]); $j++){                
                    if ($this->visible_danger[$i]) echo("<td class = 'danger td1'> ");
                    else if ($this->visible[$i]) echo("<td class ='td1'>");
                    if ($this->visible[$i]) 
                    {                    
                        echo($this->word[$i][$j]); echo("</td>");
                    }                                    
            } 
            if ($this->visible[$i]) {
               echo("</tr>");               
            }                       
        }
        echo("</table>"); echo("</div>");
    }
    
    public function show_all() {                    
        for($j=0; $j< count($this->agents); $j++){
           if($this->agents[$j]->nameagent == "iagent-buyan")            
           echo($this->agents[$j]->nameagent." ".$this->agents[$j]->namecomp." ".$this->agents[$j]->date." ".$this->agents[$j]->time."<br>");
        }
        
    }
    
    public function show_new($param){        
        echo("<div style='margin:0 auto; width: 620px'>");
        echo("<h1 class='demoHeaders'>".$param." (".date("F d Y H:i:s.", $this->filetime- 3600).")</h1>");
        echo("</div>");
        echo("<div id='".$param."' style='margin:0 auto; width: 620px'>");        
        for($i=0; $i < $this->count; $i++) {
            $n = 0;
            if ($this->visible[$i]){                
                if($this->visible_danger[$i]) echo("<h3>".$this->word[$i][0]." | ".$this->word[$i][1]." - - </h3>");
                else echo("<h3>".$this->word[$i][0]." | ".$this->word[$i][1]."</h3>");             
                echo("<div>");               
                echo("<table class='table_hidden'>");
                for($j=count($this->agents); $j>0; $j--){                    
                    if($this->agents[$j]->namecomp == $this->word[$i][1] && $this->agents[$j]->nameagent == $this->word[$i][0]){
                        echo("<tr>");
                        echo("<td>".$this->agents[$j]->nameagent."</td>");
                        echo("<td>".$this->agents[$j]->namecomp."</td>");
                        echo("<td>".$this->agents[$j]->date."</td>");
                        echo("<td>".$this->agents[$j]->time."</td>");                        
                        echo("</tr>");
                        $n++;
                        if($n>9) break;     
                    }                       
                }             
                echo("</table>");echo("</div>");
            }
        }
                
        echo("</div>");
        
	
    }
    
    
}


echo("<link rel='stylesheet' href='stylereset.css'>");
echo("<link rel='stylesheet' href='styles.css'>");

echo("<link rel='stylesheet' href='ui/jquery-ui.css'>");
echo("<script type='text/javascript' src='ui/jquery.js'></script>");
echo("<script type='text/javascript' src='ui/jquery-ui.js'></script>");

    $handle = fopen($file_i, "r");
    $contents = fread($handle, filesize($file_i));
    fclose($handle);

    $mas = explode( "\n", $contents );
    for($i=0; $i < count($mas); $i++) {        
        $mas_ex[$i] = explode( " ", $mas[$i] );            
    }              

$j = 8;
for ($j=0; $j<10; $j++ )
{     
    
    
    $handle = fopen($filename[$j], "r");
    $contents = fread($handle, filesize($filename[$j]));
    fclose($handle);
    $fil[$j] = new serv();
    $fil[$j]->filetime = filemtime($filename[$j]);
    $fil[$j]->loadc($contents, $nameserv[$j]);     
    $fil[$j]->sort_mas();
    
    for ($i=0; $i<count($mas); $i++ )
        if(strcmp($nameserv[$j],$mas_ex[$i][0]) == 0){
            $nn[0] = $mas_ex[$i][1];   
            $nn[1] = $mas_ex[$i][2];             
            $fil[$j]->exclusion($nn);                   
        }
    
     
    //$fil[$j]->show_serv();
    //$fil[$j]->show_all();
    $fil[$j]->show_new($nameserv[$j]);
    echo("<script>$( '#".$nameserv[$j]."' ).accordion({ collapsible: true, active: false, heightStyle: 'content'}); </script>");
    
}

    

?>