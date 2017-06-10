<?php require_once('_autoload.php');
 require_once '../lib/function.php';

class user {
    protected static $table_name="admin";
    protected static $db_fields = array('admin_id', 'userId', 'password', 'fullName');
    
    public $admin_id;
    public $userId;
    public $password;
    public $fullName;
    public $database;
    public $last_insert;
   
    public function __construct() {
        try{
         $this->database = new Database();
         $this->database->getLink();         
         }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }

    public function authenticate($userId="",$password="") { 
        try{
        $this->database->query("SELECT admin_id FROM ". self::$table_name . " WHERE userId= :userid AND password= :password AND status='1' LIMIT 1");
        $this->database->bind("userid", $userId);
        $this->database->bind("password", en_al($password));
        $this->database->execute();
        return $this->database->single();
            }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }  
	}
        
    public function online($admin){
    try{
        $this->database->query("UPDATE admin SET online=1 WHERE admin_id='$admin'");
        $this->database->execute();
        return $this->database->rowCount();
    }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }
    
    public function offline($admin){
    try{
        $this->database->query("UPDATE admin SET online=0 WHERE admin_id='$admin'");
        $this->database->execute();
        return $this->database->rowCount();
        }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }
    
        
    public function create_admin($fullName = "", $userId = "", $password = "",$level=""){ 
        try{
        $this->database->query("INSERT INTO ". self::$table_name . " (fullName,userId,password,level,date) VALUES(:fullName,:userid,:password,:level,NOW())");
        $this->database->bind("fullName", $fullName);
        $this->database->bind("userid", $userId);
        $this->database->bind("level", $level);
        $this->database->bind("password", en_al($password));
        $this->database->execute();
        $this->last_inserted = $this->database->lastInsertId();
        return $this->database->rowCount();
        }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }
    
    public function update_admin($id="",$fullName = "", $userId = "", $password = "",$level="", $email="", $office=""){ 
        try{
        $this->database->query("UPDATE ". self::$table_name . " SET fullName=:fullName,userId=:userid,password=:password,level=:level,email=:email,office=:office WHERE admin_id='$id'");
        
        $this->database->bind("fullName", $fullName);
        $this->database->bind("userid", $userId);
        $this->database->bind("level", $level);
        $this->database->bind("office", $office);
        $this->database->bind("email", $email);
        $this->database->bind("password", en_al($password));
        $this->database->execute();
        return $this->database->rowCount();
        
        }catch(PDOException $myException){
           
            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }
    
    public function generate_random_code(){
   
       $side_one = strtoupper(str_pad(dechex(rand(11111111,99999999)),8,STR_PAD_LEFT));    
       $side_two= strtoupper(str_pad(dechex(rand(11111111,99999999)),8,STR_PAD_LEFT));
       return $side_one . " - " . $side_two;
       
    }
   
    public function search_code($hint){
        try{
        $this->database->query("SELECT * FROM code WHERE code='$hint'");
        $this->database->execute();
        return $this->database->rowCount();
        }catch(PDOException $myException){
         
            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }
    
    public function save_code_into_database($admin="",$code=""){
       try{
        //check if if does not already exist
        if($this->search_code($code) == 1){
            return "code already used";
        }
       else{
        $this->database->query("INSERT INTO code (admin,code,date) VALUES(:admin,:code,NOW())");
        $this->database->bind("admin", $admin);
        $this->database->bind("code", $code);
        $this->database->execute();
        return $this->database->rowCount();
        }
        }catch(PDOException $myException){
           
            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }
   
    public function advance_search_admin(){
       try{
       $this->database->query("SELECT * FROM admin WHERE status=1");
       $this->database->execute();
       return $this->database->resultset();
       }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }
    
    public function advance_search_admin_online(){
       try{
       $this->database->query("SELECT * FROM admin WHERE online=1 AND status = 1");
       $this->database->execute();
       return $this->database->resultset();
       }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }
    
    public function advance_search_admin_offline(){
       try{
       $this->database->query("SELECT * FROM admin WHERE online=0 AND status=1");
       $this->database->execute();
       return $this->database->resultset();
       }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }
    
    public function advance_search_admin_deleted(){
       try{
       $this->database->query("SELECT * FROM admin WHERE status=0");
       $this->database->execute();
       return $this->database->resultset();
       }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }
    
    public function advance_search_code(){
       try{
       $this->database->query("SELECT * FROM code");
       $this->database->execute();
       return $this->database->resultset();
       }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }
   
    public function search_admin($admin_id){
//       try{
       $this->database->query("SELECT * FROM admin WHERE admin_id='$admin_id' LIMIT 1");
       $this->database->execute();
       return $this->database->resultset();
//       }catch(PDOException $myException){
//            //put exception in a text file for deployment
//            //display exception for development
//            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
//        }
    }    
         
    public function count_admin(){
       try{
       $this->database->query("SELECT count(*) FROM admin");
       $this->database->execute();
       return $this->database->resultset();
       }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }  
    
    public function count_offline_admin(){
       try{
       $this->database->query("SELECT count(*) FROM admin WHERE online=0");
       $this->database->execute();
       return $this->database->resultset();
       }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }  
    
    public function count_online_admin(){
       try{
       $this->database->query("SELECT count(*) FROM admin WHERE online=1");
       $this->database->execute();
       return $this->database->resultset();
       }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }  
    
    public function advance_count_code(){
       try{
       $this->database->query("SELECT count(*) FROM code");
       $this->database->execute();
       return $this->database->resultset();
       }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
       
    }  
    
    public function database_action_log($admin,$message){
//        try{
        $this->database->query("INSERT INTO admin_activity (admin_id,message,date) VALUES(:admin,:message,NOW())");
        $this->database->bind("admin", $admin);
        $this->database->bind("message", $message);
        log_action($admin, $message);
        $this->database->execute();
//        return $this->database->rowCount();
//    }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
//            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
//        }
    }
    
    public function fetch_database_log(){
        try{
            $this->database->query("SELECT * FROM admin_activity ORDER BY id DESC LIMIT 20");
            $this->database->execute();
            return $this->database->resultset();
        }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }
    
    public function lockscreen_info($id){
        try{
            $this->database->query("SELECT * FROM admin WHERE admin_id='$id' LIMIT 1");
            $this->database->execute();
            return $this->database->resultset();
        }catch(PDOException $myException){
            //put exception in a text file for deployment
            //display exception for development
            echo $myException->getCode().":".$myException->getMessage() ." filename: ". $myException->getFile() ." line: " . $myException->getLine();
        }
    }
    
    public function count_log(){
        $dir = "../logs";
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
    
    public function delete_admin($id){
        $this->database->query("UPDATE admin set status='0' WHERE admin_id='$id'");
        $this->database->execute();
        return $this->database->rowCount();
    }
    
    public function restore_admin($id){
        $this->database->query("UPDATE admin set status='1' WHERE admin_id='$id'");
        $this->database->execute();
        return $this->database->rowCount();
    }
    
    public function deactivate_code($id){
        $this->database->query("UPDATE code set status='1' WHERE code_id='$id'");
        $this->database->execute();
        return $this->database->rowCount();
    }
    
    public function activate_code($id){
        $this->database->query("UPDATE code set status='1' WHERE code_id='$id'");
        $this->database->execute();
        return $this->database->rowCount();
    }
    
    public function remove_admin($id){
        $this->database->execute($this->database->query("DELETE FROM admin WHERE admin_id='$id'"));
        return $this->database->rowCount();
    }
    
    public function delete_code($id){
        $this->database->execute($this->database->query("DELETE FROM code WHERE code_id='$id'"));
        return $this->database->rowCount();
    }
    
    public function admin_photo($file='',$id=''){
        $this->database->query("UPDATE admin SET photo='$file' WHERE admin_id='$id'");        
        $this->database->execute();
        return $this->database->rowCount();
    }
    
}
