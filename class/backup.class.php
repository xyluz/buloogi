<?php require_once('_autoload.php');

class backup {
   public $database;
   
   
   public function __construct() {
       $this->database = new Database();
       $this->database->getLink();
   }
   
//   backup_tables('localhost','username','password','blog');

/* backup the db OR just a table */
    public function run_backup($tables = '*')
    {

            //get all of the tables
            if($tables == '*')
            {

                    $this->database->query("SHOW TABLES");
                    $result = $this->database->execute();
                    $tables =$this->database->resultset();  
                   
            }
            else
            {
                
                    $tables = is_array($tables) ? $tables : explode(',',$tables);
                   
            }

            //cycle through
            foreach($tables as $table)
            { 
       
               $this->database->query("SELECT * FROM " . $table[Tables_in_pivss]);
               $this->database->execute();
               $num_fields = $this->database->columnCount();
               $num_row = $this->database->rowCount();

                    $return.= 'DROP TABLE '.$table[Tables_in_pivss].';';
                    $this->database->query('SHOW CREATE TABLE '.$table[Tables_in_pivss]);
                    $row2 = $this->database->single();
                    $return.= "\n\n".$row2[1].";\n\n";
                    $this->database->query("SELECT * FROM " . $table[Tables_in_pivss]);
                   
                            foreach($this->database->resultset() as $row)
                            {   
                                    $return.= 'INSERT INTO '.$table[Tables_in_pivss].' VALUES(';
                                    for($j=0; $j<$num_fields ; $j++) 
                                    {
                                            $row[$j] = addslashes($row[$j]);
                                            $row[$j] = ereg_replace("\n","\\n",$row[$j]);
                                            if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                                            if ($j<($num_fields-1)) { $return.= ','; }
                                    }
                                    $return.= ");\n";
                            }
                   
                    $return.="\n\n\n";
            }

            //save file
            $filename = 'db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql';
            $file_size = filesize($filename);
            $handle = fopen('backup/'.$filename,'w+');
            $this->save_backup_activity_in_database($filename,$file_size);
            fwrite($handle,$return);
            fclose($handle);
           
    }
    
    public function backup_count(){
        $dir = "../admin/backup";
        $n=0;
            // Open a known directory, and proceed to read its contents
            if (is_dir($dir)) {
                if ($dh = opendir($dir)) {  

                    while (($file = readdir($dh)) !== false) {
                    if($file != "." && $file != ".."){               
                       $n++;
                    }
                    } 
                    closedir($dh);
                    return $n;
                   
                }
            }
            else{
                return 'ERROR::140BcCount';
            }
    }
    
    public function save_backup_activity_in_database($filename,$size){       
        $admin = $_SESSION[admin_id];
        $this->database->query("INSERT INTO backup (filename,admin,date,size) VALUES(:filename,:admin,NOW(),:filesize)");    
        $this->database->bind("filename", $filename);
        $this->database->bind("admin", $admin);
        $this->database->bind("filesize", $size);
        $this->database->execute();
        return $this->database->rowCount();
    }
    public function run_download(){
        //function to download backup
    }
    
    public function delete_restore_point($id){
        $this->database->execute($this->database->query("DELETE FROM backup WHERE backup_id='$id'"));
        return $this->database->rowCount();
    }
    
    public function backup_history(){
        $this->database->query("SELECT * FROM backup");
        $this->database->execute();
        return $this->database->resultset();
    }
   
}
