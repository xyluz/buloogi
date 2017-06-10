<?php session_start();

require_once('_autoload.php');
require_once '../lib/function.php';
require_once '../lib/excel_reader.php';

echo en_al("45iurw60&");
exit();

// function add_data(
//            $ticker,$pclose,$high,$low,$percentSpread, $close, $changeA, $trades, $volume, $value, $user
//            ) {
//        
//        $data []= array(
//        

//        89iu[poiupoiuppnmn //        'Ticker' => $ticker,
//        'P_Close' => $pclose,
//        'High' => $high,
//        'Low' => $low, 
//        'Percent_Spread' => $percentSpread, 
//        'Close' => $close, 
//        'Change_a' => $changeA,
//        'Trades' => $trades, 
//        'Volume' => $volume, 
//        'Value' => $value, 
//        'user' => $user         
//        );
//        
//        return $data;
//            }
//
//if(isset($_FILES['file'])){
//    
//    print_r($_FILE);
//    exit;
//    
//     if ( $_FILES['file']['tmp_name'] )
//        {
//        $dom = DOMDocument::load( $_FILES['file']['tmp_name'] );
//        $rows = $dom->getElementsByTagName( 'Row' );
//        $first_row = true;
//        foreach ($rows as $row)
//        {
//        if ( !$first_row )
//        {
//            
//            $ticker= "";
//            $pclose= "";
//            $high= "";
//            $low= "";
//            $percentSpread= "";
//            $close= "";
//            $changeA= "";
//            $trades= "";
//            $volume= ""; 
//            $value= "";
//            $user= "";       
//        
//
//            $index = 1;
//            $cells = $row->getElementsByTagName( 'Cell' );
//            
//            foreach( $cells as $cell )
//            { 
//                $ind = $cell->getAttribute( 'Index' );
//                if ( $ind != null ) $index = $ind;
//
//                if ( $index == 1 ) $ticker = $cell->nodeValue;
//                if ( $index == 2 ) $pclose = $cell->nodeValue;
//                if ( $index == 3 ) $high = $cell->nodeValue;
//                if ( $index == 4 ) $low = $cell->nodeValue;
//                if ( $index == 5 ) $percentSpread = $cell->nodeValue;
//                if ( $index == 6 ) $changeA = $cell->nodeValue;
//                if ( $index == 7 ) $trades = $cell->nodeValue;
//                if ( $index == 8 ) $volume = $cell->nodeValue;
//                if ( $index == 9 ) $value = $cell->nodeValue;
//                if ( $index == 10 ) $user = $cell->nodeValue;
//
//                $index += 1;
//            }
//            print_r(add_data($ticker, $pclose, $high, $low, $percentSpread, $close, $changeA, $trades, $volume, $value, $user));
//        }
//         $first_row = false;
//        }
//        }
//    
//    
//
//
//    
//}else{
//    
//    echo "not set";
//}
//




//if($_SESSION[locked]){
//echo 'set' . $_SESSION[locked];
//
//}else{
//    echo 'not'. $_SESSION[locked];
//}
//exit();
//instantiate instances
//$session = new Session();

// $customer = new customer();
// echo "<pre>";
// print_r($customer->check_registeration('411402088'));

//$user = new User();
//echo "<pre>";
//foreach($user->search_admin(6) as $a){
//    echo $a[fullName];
//}
//foreach($customer->get_customer_code_details(11) as $client){
//
//                               print_r($customer->get_vehincle($client[id]));
//                            }

//$setting = new global_settings();
//
//$database;
//
//$database = new Database();
//$database->getLink();
//echo "<pre>";
//
//var_dump($this->database->getLink());
//
//echo "<hr>";
//
//var_dump($d);
//
//$d = "SELECT * FROM admin";
//
//echo "<pre>";
//print_r($db->query($d));

//echo count($setting->get_all_trackers());


//$account = new accounts();

//{x: '2015 Q1', y: 3000, z: 3000},
//{x: '2015 Q2', y: 2000, z: 1000},
//{x: '2015 Q3', y: 2000, z: 4000},
//{x: '2015 Q4', y: 3000, z: 3000},
//{x: '2015 Q5', y: 3000, z: 10000}
//echo '<pre>';
//print_r($account->difference());
//$counter=1;
// foreach($account->get_all_month() as $date){
////     $year = date('Y',time());
//
//     foreach($account->sales_for_month($date[0]) as $a){
//         foreach($account->expected_for_month($date[0]) as $b){
//
//         echo "{x:'" .$year . " Q".$counter ."', y: " .$a[0] .', z: ' .$b[0] .'},<br>' ;
////         echo $a[0];
//         }
//     }
//
//    }

//print_r($customer->count_new_customers());
//print_r($customer->update_customer_nok('968056083', 'firsnamt', 'sur', '$relationship', 'p1', 'p2', 'add'));
//$customer->vehincle_details('77793307a', 'make', 'bmy', 'color', 'plate');
//$customer->customer_progress('920157191');
//echo $customer->customer_progress('77793307a');
//$customer->subscription_details_status('99652008e');
//$customer->payment_details_status('96566307f');
//$customer->nok_details_status('330836079');
//$customer->delete_customer('77793307a');
//echo $customer->customer_progress('99652008e');
//$customer->check_registeration('96566307f');
//$backup = new backup();
//
//$customer->advance_search_nok('968056083');
//$backup->run_backup();
//$filename = 'db-backup-1433082733-641da16394460d22eca2bcd3bb10b6bb.sql';
//$file_size = filesize('backup/'.$filename);
//echo $file_size;

//$b = new breadcrumb();
//
//print_r($b->breadcrumbs(">","Home"));
//<p>breadcrumbs()</p>
//<p>breadcrumbs(' > ')</p>
//<p>breadcrumbs(' ^^ ', 'Index')</p>

//select *
//from table
//where date >= [start date] and date <= [end date]

//DATABASE RESTORE
//
//ini_set('memory_limit','128M'); // set memory limit here
//$db = mysql_connect ( 'Your Host', 'Your Username', 'Your password' ) or die('not connected');
//mysql_select_db( 'Your database', $db) or die('Not found');
//$fp = fopen ( 'sql_dump.sql', 'r' );
//$fetchData = fread ( $FP, filesize ( 'sql_dump.sql') );
//$sqlInfo = explode ( ";\n", $fetchData); // explode dump sql as a array data
//
//foreach ($sqlInfo AS $sqlData )
//{
//mysql_query ( $sqlData ) or die('Query not executed');
//}

?>

<html>
<body>
<form enctype="multipart/form-data"
   action="testrun.php" method="post">
 
  <table width="600">
  <tr>
  <td>Names file:</td>
  <td><input type="file" name="file" /></td>
  <td><input type="submit" value="Upload" /></td>
  </tr>
  </table>
  </form>
  </body>
  </html>

