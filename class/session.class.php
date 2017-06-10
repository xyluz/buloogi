<?php require_once('_autoload.php');

class Session {
    
    private $logged_in=false;
    public $user_id;
    public $message;
    public $error;
    public $warning;
    public $database;
    
    function __construct(){
        session_start();
	$this->check_message();
	$this->check_login();
	$this->check_error();
	$this->check_warning();
//        $this->database = new Database();
//        $this->database->getLink();
      
        
        if($this->logged_in) {
//            if($_SESSION[locked]=true){
//                redirect_to('lockscreen.php');
//            }
        } else {
        // actions to take right away if user is not logged in
        // set message, send user to index page.
        }
    }
    public function is_logged_in() {
        return $this->logged_in;
    }

    public function login($user) {
           
        if($user){
          $_SESSION['userid'] = $this->user_id = $user;
          $this->logged_in = true;
           } 
           else{
               //if user is not found, do something and set logged in to false
               return $this->logged_in;
           }
    }
    
//    public function permission($user){
//        //collect permission level of the specific admin 
//        $this->database->query("SELECT level FROM admin WHERE admin_id=:admin_id LIMIT 1");
//        $this->database->bind("admin_id", $user);
//        $this->database->execute();
//        return $this->database->single();
//    }
    
    public function message($msg=""){       
        if(!empty($msg)){
            $_SESSION['message'] = $msg;            
        }			
        else{
            return $this->message;
        }
    }
    
    public function warning($warn_msg=""){
        if(!empty($warn_msg)){
            $_SESSION['warning'] = $warn_msg;
        }
        else{
            return $this->warning;
        }
    }
    public function error($error_msg=""){
        if(!empty($error_msg)){
            $_SESSION['error'] = $error_msg;
        }
        else{
            return $this->error;
        }
    }
    
    private function check_login() {
        if(isset($_SESSION['admin_id'])) {
//            $this->user_id = $_SESSION['userid'];
            $this->logged_in = true;
        } else {
            unset($this->user_id);
            $this->logged_in = false;
        }
    }
  
    private function check_message(){
	if(isset($_SESSION['message'])){
            $this->message = $_SESSION['message'];			
	}
	else{
            $this->message="";
	}
    }
    private function check_error(){
        if(isset($_SESSION['error']) && (!empty($_SESSION['error']))){
            $this->error = $_SESSION['error'];
//            unset($_SESSION['error']);
        }
        else{
            $this->error="";
            }
//        return 'check error';
    }		
    private function check_warning(){
	if(isset($_SESSION['warning'])){
            $this->warning = $_SESSION['warning'];
            unset($_SESSION['warning']);
	}
	else{
            $this->warning="";
	}
}		
    public function logout() {
        session_destroy();
        unset($this->user_id);
        $this->logged_in = false;
    }
    
}
