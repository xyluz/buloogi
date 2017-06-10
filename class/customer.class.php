<?php require_once('_autoload.php');

class customer {
    
    public $database;
    protected static $table_name="customer";
    private $last_customer;


    public function __construct() {
        $this->database = new Database();
        $this->database->getLink();       
    }
    
    public function update_customer($table,$variable,$variable_db_name,$customer_db_name,$customer_id){
       
        $this->database->execute(
                $this->database->query("UPDATE $table SET $variable_db_name='$variable' WHERE $customer_db_name='$customer_id'"));
        return $this->database->rowCount();        
        
    }
   
    public function customer_info($title,$firstname,$middlename,$lastname,$phone1,$phone2,$email,$address,$dob,$occupation,$photo){
//        Generate the customer id based on algorithm created in the method generate_id()
        $id = $this->customer_id($this->database->lastInsertId());        
        
        $this->database->query("INSERT INTO ". self::$table_name . " (title,firstname,middlename,lastname,phone1,phone2,email,address,dob,occupation,photo,id,admin,date) "
                . "VALUES(:title,:firstname,:middlename,:lastname,:phone1,:phone2,:email,:address,:dob,:occupation,:photo,:id,:admin,NOW())");
        $this->database->bind("title", $title);
        $this->database->bind("firstname", $firstname);
        $this->database->bind("middlename", $middlename);
        $this->database->bind("lastname", $lastname);
        $this->database->bind("phone1", $phone1);
        $this->database->bind("phone2", $phone2);
        $this->database->bind("email", $email);
        $this->database->bind("address", $address);
        $this->database->bind("dob", $dob);
        $this->database->bind("occupation", $occupation);
        $this->database->bind("photo", $photo);
        $this->database->bind("id", $id);
        $this->database->bind("admin", $_SESSION[admin_id]);             
        $this->database->execute();
        $this->last_customer = $this->database->lastInsertId();
        $_SESSION[id] = $id;
//        return $this->database->rowCount();
        return $id;
    }
    
    public function update_customer_info($title,$firstname,$middlename,$lastname,$phone1,$phone2,$email,$address,$dob,$occupation,$id){
      
        $this->database->query("UPDATE ". self::$table_name . " SET title=:title,firstname=:firstname,middlename=:middlename,lastname=:lastname,phone1=:phone1,phone2=:phone2,email=:email,address=:address,dob=:dob,occupation=:occupation WHERE id='$id'");
        $this->database->bind("title", $title);
        $this->database->bind("firstname", $firstname);
        $this->database->bind("middlename", $middlename);
        $this->database->bind("lastname", $lastname);
        $this->database->bind("phone1", $phone1);
        $this->database->bind("phone2", $phone2);
        $this->database->bind("email", $email);
        $this->database->bind("address", $address);
        $this->database->bind("dob", $dob);
        $this->database->bind("occupation", $occupation);
                    
        $this->database->execute();
        return $this->database->rowCount();

    }
    
    public function customer_id(){
        //count all i have in my database
        $this->database->query("SELECT count(*) FROM customer");
        $count = $this->database->single()['count(*)'];
        //create hex of $count
        $dec = dechex($count);
        //get length of $dec
        $pad_length = strlen($dec);
        //use length of dec to determine the pad required
        $padded = str_pad($dec, ++$pad_length,0, STR_PAD_LEFT);
        //use length of $padded to determine length of timestamp() pad
        $stamp_length = 9 - strlen($padded);
        $timestamp = substr(time(),4,$stamp_length);
        return $id = $timestamp . $padded;
        
    }
    
    public function customer_nok($customer='',$firstname='',$surname='',$relationship='',$phone1='',$phone2='',$address=''){
        //create next of kin 
        $this->database->query("INSERT INTO nok (customer,firstname,surname,relationship,phone1,phone2,address) "
                . "VALUES (:customer,:firstname,:surname,:relationship,:phone1,:phone2,:address)");
        
        $this->database->bind("customer", $customer);
        $this->database->bind("firstname", $firstname);
        $this->database->bind("surname", $surname);
        $this->database->bind("relationship", $relationship);
        $this->database->bind("phone1", $phone1);
        $this->database->bind("phone2", $phone2);
        $this->database->bind("address", $address);        
        $this->database->execute();
        return $this->database->rowCount();
        
    }
    
    public function update_customer_nok($customer='',$firstname='',$surname='',$relationship='',$phone1='',$phone2='',$address=''){ 
         
            $this->database->query("UPDATE nok SET firstname=:firstname,surname=:surname,relationship=:relationship,phone1=:phone1,phone2=:phone2,address=:address WHERE customer='$customer'");
           
      
        $this->database->bind("firstname", $firstname);
        $this->database->bind("surname", $surname);
        $this->database->bind("relationship", $relationship);
        $this->database->bind("phone1", $phone1);
        $this->database->bind("phone2", $phone2);
        $this->database->bind("address", $address);        
        $this->database->execute();
        
        return $this->database->rowCount();
        
    }
    
    public function customer_photo($file='',$id=''){
        $this->database->query("UPDATE customer SET photo =:photo WHERE id='$id'");
        $this->database->bind("photo", $file);
        $this->database->execute();
        return $this->database->rowCount();
    }
    
    public function customer_payment($customer='',$teller='',$amount='',$bank='',$date=''){
       $this->database->query("INSERT INTO payment (customer,teller,date,amount,bank,admin) "
               . "VALUES(:customer,:teller,:date,:amount,:bank,:admin)");
       $this->database->bind("customer",$customer);
       $this->database->bind("teller",$teller);
       $this->database->bind("date",$date);
       $this->database->bind("amount",$amount);
       $this->database->bind("bank",$bank);
       $this->database->bind("admin",$_SESSION[admin_id]);
       $this->database->execute();
       return $customer;
    }
    
    public function update_customer_payment($customer='',$teller='',$amount='',$bank=''){
       $this->database->query("UPDATE payment SET teller=:teller,amount=:amount,bank=:bank WHERE customer='$customer'");
       
       $this->database->bind("teller",$teller);       
       $this->database->bind("amount",$amount);
       $this->database->bind("bank",$bank);       
       $this->database->execute();
       return $this->database->rowCount();
    }
    
    public function vehincle_details($customer='',$make='',$bmy='',$color='',$plate=''){
      $this->database->query("INSERT INTO vehincle (customer,make,bmy,color,plate,admin,date) "
               . "VALUES(:customer,:make,:bmy,:color,:plate,:admin,NOW())");      
      $this->database->bind("customer",$customer);
      $this->database->bind("make",$make);
      $this->database->bind("bmy",$bmy);
      $this->database->bind("color",$color);
      $this->database->bind("plate",$plate);
      $this->database->bind("admin",$_SESSION[admin_id]);      
      $this->database->execute();
      return $customer;      
    }
    
    public function update_vehincle_details($customer='',$make='',$bmy='',$color='',$plate=''){
      $this->database->query("UPDATE vehincle SET make=:make,bmy=:bmy,color=:color,plate=:plate WHERE customer='$customer'");                    
     
      $this->database->bind("make",$make);
      $this->database->bind("bmy",$bmy);
      $this->database->bind("color",$color);
      $this->database->bind("plate",$plate);           
      $this->database->execute();
      return $this->database->rowCount();     
    }
    
    public function customer_subscription(  $customer='',
                                            $tracker='',
                                            $duration='',
                                            $services='',
                                            $service1='',
                                            $service2='',
                                            $service3='',
                                            $service4='',
                                            $service5='',
                                            $discount='',
                                            $remark=''){
        $this->database->query("INSERT into subscription "
                . "(customer,tracker,duration,services,service1,service2,service3,service4,service5,discount,date) "
                . "VALUES(:customer,:tracker,:duration,:services,:service1,:service2,:service3,:service4,:service5,:discount,NOW())");
        $this->database->bind("customer", $customer);
        $this->database->bind("tracker", $tracker);
        $this->database->bind("duration", $duration);
        $this->database->bind("services", $services);
        $this->database->bind("service1", $service1);
        $this->database->bind("service2", $service2);
        $this->database->bind("service3", $service3);
        $this->database->bind("service4", $service4);
        $this->database->bind("service5", $service5);
        $this->database->bind("discount", $discount);                        
        $this->database->execute();
        
        $this->put_remark($customer, $remark);
        
        return $customer;
    }
    
    public function update_customer_subscription( $customer='',
                                            $tracker='',
                                            $duration='',
                                            $services='',
                                            $service1='',
                                            $service2='',
                                            $service3='',
                                            $service4='',
                                            $service5='',
                                            $discount='',
                                            $remark=''){
        $this->database->query("UPDATE subscription SET tracker=:tracker,duration=:duration,services=:services,service1=:service1,service2=:service2,service3=:service3,service4=:service4,service5=:service5,discount=:discount WHERE customer='$customer'");
        
        $this->database->bind("tracker", $tracker);
        $this->database->bind("duration", $duration);
        $this->database->bind("services", $services);
        $this->database->bind("service1", $service1);
        $this->database->bind("service2", $service2);
        $this->database->bind("service3", $service3);
        $this->database->bind("service4", $service4);
        $this->database->bind("service5", $service5);
        $this->database->bind("discount", $discount);                        
        $this->database->execute();
        
        $this->put_remark($customer, $remark);
        
        return $customer;
    }
    
    public function put_remark($customer,$remark){
        $this->database->query("UPDATE subscription set remark ='$remark' WHERE customer ='$customer'");
//        $this->database->bind("remark", $remark);
        $this->database->execute();        
    }   
    
    public function search_record(){
        //search customers inserted by a particular admin
        $this->database->query("SELECT * FROM customer WHERE admin='$_SESSION[admin]'");
        $this->database->execute();
        return $this->database->resultset();
    } 
    
    public function advanced_search_record(){
        //search all customers
        $this->database->query("SELECT * FROM customer");
        $this->database->execute();
        return $this->database->resultset();
    }
    
    public function advanced_single_record($customer){
        //search single customers
        $this->database->query("SELECT * FROM customer WHERE id='$customer' LIMIT 1");
        $this->database->execute();
        return $this->database->resultset();
    }
       
      
    public function generate_invoice($customer){
        //search for particular customer with the $id
        //search all customer info, like subscription details,
        //call get_subscription, get_payment, advanced_single_record
        $this->advanced_single_record($customer);
        $this->get_payment($customer);
        $this->get_subscription($customer);
        
        //marge the produced array and use for the invoice page
        //come back to this later
       
    }
    
    public function get_subscription($customer){
        //get the subscription details of the customer and return        
        $this->database->query("SELECT * FROM subscription WHERE customer='$customer' LIMIT 1");
        $this->database->execute();
        return $this->database->resultset();
    }
    
    public function get_nok($customer){
        //get the subscription details of the customer and return        
        $this->database->query("SELECT * FROM nok WHERE customer='$customer' LIMIT 1");
        $this->database->execute();
        return $this->database->resultset();
    }
    
    public function get_vehincle($customer){
        //get the subscription details of the customer and return        
        $this->database->query("SELECT * FROM vehincle WHERE customer='$customer' LIMIT 1");
        $this->database->execute();
        return $this->database->resultset();
    }
    
    public function get_payment($customer){
        //get the customer payment details with this
        $this->database->query("SELECT * FROM payment WHERE customer='$customer' LIMIT 1");
        $this->database->execute();
        return $this->database->resultset();
    }
    
    public function count_record(){
        $this->database->query("SELECT count(*) FROM customer WHERE admin='$_SESSION[admin]'");
        $this->database->execute();
        return $this->database->resultset();
    }
    
    public function advance_count_record(){
        $this->database->query("SELECT count(*) FROM customer");
        $this->database->execute();
        return $this->database->resultset();
    }
    
    public function count_new_customers(){
        //count new customer based on week, if result for week i 0, then use month, if month is 0 then use 4 months.
        $date = date('Y-m-d',time());
        $this->database->query("SELECT DISTINCT count(*) FROM customer WHERE DATE_FORMAT(date, '%Y %m') = DATE_FORMAT('$date', '%Y %m')");
        $this->database->execute();
        return $this->database->resultset();
    }
    
    public function invoice_id(){
        //generate invoice id and put in database with customer id
        //invoice id should be seria with some random
        $one = rand(111,999);
        
        $this->database->query("SELECT count(*) FROM customer");
        $count = $this->database->single()['count(*)'];        
        $two = $count++;  
        
        $invoice_id = $one . $two;
        return $invoice_id;       

    }
    
    public function recently_added_customers(){
        $this->database->query("SELECT id, firstname,lastname, status, date, admin FROM customer ORDER BY serial DESC LIMIT 10");
        $this->database->execute();
        return $this->database->resultset();
    }
    
    public function admin_add_customer($id){
    //to get the admin that added the customer
        $this->database->query("SELECT fullName FROM admin WHERE admin_id=:admin_id");
        $this->database->bind("admin_id", $id);
        $this->database->execute();
        $admin_add = $this->database->single();
        return $admin_add[fullName];
    }
    
    public function customer_progress($id){
        $information='';
        if($this->personal_details_status($id) != 0){
            $information .= '\npersonal details are incomplete';
        }
        if($this->payment_details_status($id) != 0){
            $information .= '\npayment details are incomplete';
        }
        if($this->subscription_details_status($id) != 0){
            $information .= '\nSubscription details are incomplete';
        }
        if($this->nok_details_status($id) != 0){
            $information .= '\nNexk of Kin Information are incomplete';
        }        
        return $information;        
    }
    
    protected function personal_details_status($id){
        $empty_count =0;
        
        //check if this customer $id profile is complete
        $this->database->query("SELECT * FROM customer WHERE id='$id' LIMIT 1");
        $this->database->execute();        
        $details = $this->database->resultset();
                
           foreach($details as $detail){
             
               if($detail[title] == "" ){
                   $empty_count++;
               }             
               if($detail[firstname] == "" ){
                   $empty_count++;
               }             
               if($detail[middlename] == "" ){
                   $empty_count++;
               }             
               if($detail[lastname] == "" ){
                   $empty_count++;
               }             
               if($detail[email] == "" ){
                   $empty_count++;
               }             
               if($detail[dob] == "" ){
                   $empty_count++;
               }             
               if($detail[occupation] == "" ){
                   $empty_count++;
               }             
               if($detail[phone1] == "" && $detail[phone2] == "" ){
                   $empty_count++;
               } 
           }
           
           return $empty_count;
        }
    
    
    public function subscription_details_status($id){
            $empty_count =0;

            //check if this customer $id profile is complete
            $this->database->query("SELECT * FROM subscription WHERE customer='$id' LIMIT 1");
            $this->database->execute();
            $subscription = $this->database->resultset();
         
               foreach($subscription as $sub){                
                  
               if($sub[services] == ""){
                   $empty_count++;
               }
               if($sub[service1] == 0 && $sub[service2] == 0 && $sub[service3] == 0 && $sub[service4] == 0 && $sub[service5] == 0){
                   $empty_count++;
               }
               if($sub[tracker] == ""){
                   $empty_count++;
               }
               return $empty_count;
        }
    }
    
    public function payment_details_status($id){
            $empty_count =0;
            
            //check if this customer $id profile is complete
            $this->database->query("SELECT * FROM payment WHERE customer='$id' LIMIT 1");
            $this->database->execute();
            $payment = $this->database->resultset();
        
               foreach($payment as $pay){              
                
                   if($pay[teller] == ""){
                       $empty_count++;
                   }
                   if($pay[date] == "0000-00-00"){
                       $empty_count++;
                   }
                   if($pay[amount] == ""){
                       $empty_count++;
                   }
                   if($pay[bank] == ""){
                       $empty_count++;
                   }
                   
               }

               return $empty_count;
        }
    
    
    public function nok_details_status($id){
            $empty_count =0;
            
            //check if this customer $id profile is complete
            $this->database->query("SELECT * FROM nok WHERE customer='$id' LIMIT 1");
            $this->database->execute();
            $nextok = $this->database->resultset();
        
               foreach($nextok as $nok){              
                
                   if($nok[firstname] == ""){
                       $empty_count++;
                   }
                   if($nok[surname] == ""){
                       $empty_count++;
                   }
                   if($nok[relationship] == ""){
                       $empty_count++;
                   }
                   if($nok[phone1] == "" && $nok[phone2] == ""){
                       $empty_count++;
                   } 
               }
               return $empty_count;
        }
    
    
    public function check_registeration($id){
        
        $this->database->query("SELECT amount FROM payment WHERE customer='$id'");
        $this->database->execute();
        $amount_paid = $this->database->resultset();
        foreach ($amount_paid as $amount){            
           $fetch = $amount[amount];
        }
        
        $this->database->query("SELECT service1,service2,service3,service4,service5,discount,tracker,duration FROM subscription WHERE customer='$id'");
        $this->database->execute();
        $expected_amount =  $this->database->resultset();
       
        foreach($expected_amount as $expected){
            $tracker = substr($expected[tracker], 10);
            $discount = $expected[discount];
            $serv = $expected[service1] + $expected[service2] + $expected[service3] + $expected[service4] + $expected[service5];
            $result = (($tracker + $serv)*$expected[duration]) - $discount;
        }
       
        if($result != $fetch){
        return false;            
        }
        else{
            return true;
        }
    }
    
    public function delete_customer($id){
        if($this->database->execute($this->database->query("UPDATE customer set status=0 WHERE id='$id'"))){
        $this->database->execute($this->database->query("UPDATE subscription set status='0' WHERE customer='$id'"));
        $this->database->execute($this->database->query("UPDATE payment set status='0' WHERE customer='$id'"));
        $this->database->execute($this->database->query("UPDATE nok set status='0' WHERE customer='$id'"));
        $this->database->execute($this->database->query("UPDATE vehincle set status='0' WHERE customer='$id'"));
        return $this->database->rowCount();
        }
    }
    
    public function restore_customer($id){
        if($this->database->execute($this->database->query("UPDATE customer set status=1 WHERE id='$id'"))){
        $this->database->execute($this->database->query("UPDATE subscription set status='1' WHERE customer='$id'"));
        $this->database->execute($this->database->query("UPDATE payment set status='1' WHERE customer='$id'"));
        $this->database->execute($this->database->query("UPDATE nok set status='1' WHERE customer='$id'"));
        $this->database->execute($this->database->query("UPDATE vehincle set status='1' WHERE customer='$id'"));
        return $this->database->rowCount();
        }
    }
    
    public function remove_customer_record($id){
        if($this->database->execute($this->database->query("DELETE FROM customer WHERE id='$id'"))){
        $this->database->execute($this->database->query("DELETE FROM subscription WHERE customer='$id'"));
        $this->database->execute($this->database->query("DELETE FROM payment WHERE customer='$id'"));
        $this->database->execute($this->database->query("DELETE FROM nok WHERE customer='$id'"));
        $this->database->execute($this->database->query("DELETE FROM vehincle WHERE customer='$id'"));
        return $this->database->rowCount();
        }
    }
    
    public function link_to_code($code_id,$customer){
        $this->database->query("UPDATE customer SET code_id='$code_id' WHERE id='$customer'");
        $this->database->execute();
        return $this->database->rowCount();
    }
    
    public function get_customer_code_details($code_id){
        
        $this->database->query("SELECT firstname,lastname,id FROM customer WHERE code_id='$code_id'");
        $this->database->execute();
        return $this->database->resultset();
        
    }    
    
    public function linked($code_id){
        $this->database->query("UPDATE code SET linked='1' WHERE code_id='$code_id'");
        $this->database->execute();
        return $this->database->rowCount();
    }
    
    public function get_linked_code($code_id){
        $this->database->query("SELECT code FROM code WHERE code_id='$code_id'");
        $this->database->execute();
        return $this->database->resultset();
    }
    

}
