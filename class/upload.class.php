<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of upload
 *
 * @author xeyi
 */
class upload extends Database{
    //put your code here
    
//     public $database;
   
 public function __construct() {
        $this->getLink();
    }
    
    public function add_data(
            $ticker,$pclose,$open,$high,$low,$percentSpread, $close, $changeA, $trades, $percentChange, $volume, $value, $user, $title
            ) {
        
        $this->query ("INSERT INTO data_tb (Ticker,P_Close,Open,High,Low,Percent_Spread,Close,Change_a,Percent_Change,Trades,Volume,Value,user,title) "
                . "VALUES(:ticker,:pclose,:open,:high,:low,:percentSpread,:close,:changeA,:percentChange,:trades,:volume,:value,:user,:title)");
        
        $this->bind("ticker", $ticker);
        $this->bind("pclose", $pclose);
        $this->bind("open", $open);
        $this->bind("high", $high);
        $this->bind("low", $low);
        $this->bind("percentSpread", $percentSpread);
        $this->bind("close", $close);
        $this->bind("changeA", $changeA);
        $this->bind("percentChange", $percentChange);
        $this->bind("trades", $trades);
        $this->bind("volume", $volume);
        $this->bind("value", $value);
        $this->bind("user", $user);
        $this->bind("title", $title);
        
        
    
        $this->execute();
        return $this->rowCount()>0? true: false;

        }
        
        public function countUploads() {
                $this->query("SELECT count(*) FROM data_tb");
                $this->execute();
                return $this->single();
        }
        
        public function getData($user,$title) {
            $this->query("SELECT * FROM data_tb WHERE user=:user AND title=:title");
            $this->bind("user", $user);
            $this->bind("title", $title);
            $this->execute();
            
            return $this->resultset();                    
        }
        
        public function deleteData($title) {
            $this->query("DELETE FROM data_tb WHERE title=:title");
            $this->bind("title", $title);
            $this->execute();
            
            return $this->rowCount()>0? true: false;
            
        }
        
        public function dataMenu($user) {
            $this->query("SELECT DISTINCT title, date_uploaded FROM data_tb WHERE user=:user GROUP BY title");
            $this->bind("user", $user);
            $this->execute();
            return $this->resultset();            
        }
       

        
    
}
