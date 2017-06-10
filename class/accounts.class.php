<?php require_once('_autoload.php');

class accounts {
    public $database;
   
   
    public function __construct() {
       $this->database = new Database();
       $this->database->getLink();
    }
    
    public function income(){
        $this->database->execute($this->database->query("SELECT SUM(amount) FROM payment WHERE status='0'"));
        return $this->database->resultset();
    }
   
    public function expected(){
       $this->database->execute($this->database->query("SELECT (sum(service1) + sum(service2) + sum(service3) + sum(service4) + sum(service5)) as total FROM subscription WHERE status='0'"));
       return $this->database->single();
    }
    
    public function difference(){
        $this->expected() - $this->income();
    }
    
    public function total_sales(){
        $this->database->query("SELECT count(*) FROM payment WHERE status=1");
        $this->database->execute();
        return $this->database->resultset();
    }
    
    public function sales_for_month($date){
        $this->database->query("SELECT DISTINCT count(date) FROM payment WHERE DATE_FORMAT(date, '%Y %m') = DATE_FORMAT('$date', '%Y %m')");
        $this->database->execute();
        return $this->database->resultset();
    }
    
    public function expected_for_month($date){
        $this->database->query("SELECT DISTINCT count(id) FROM subscription WHERE DATE_FORMAT(date, '%Y %m') = DATE_FORMAT('$date', '%Y %m')");
        $this->database->execute();
        return $this->database->resultset();
    }
    
    public function get_all_month(){
         $date = date('Y-m-d',time());
         $year = date('Y',time());
        $this->database->query("SELECT DISTINCT date FROM payment WHERE date BETWEEN '$year-01-01' AND '$date'");
        $this->database->execute();
        return $this->database->resultset();
    }
    
   
}
