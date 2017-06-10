<?php

class Database {
    private $link = null ;
    private $stmt;

    public function getLink ( ) {
        if ( $this->link ) {
            return $this->link ;
        }

        $ini = "config.ini" ;
        $parse = parse_ini_file ( $ini , true ) ;

        $driver = $parse [ "db_driver" ] ;
        $dsn = "${driver}:" ;
        $user = $parse [ "db_user" ] ;
        $password = $parse [ "db_password" ] ;
        $options = $parse [ "db_options" ] ;
        $attributes = $parse [ "db_attributes" ] ;

        foreach ( $parse [ "dsn" ] as $k => $v ) {
            $dsn .= "${k}=${v};" ;
        }

        $this->link = new PDO ( $dsn, $user, $password, $options ) ;

        foreach ( $attributes as $k => $v ) {
            $this->link -> setAttribute ( constant ( "PDO::{$k}" )
                , constant ( "PDO::{$v}" ) ) ;
        }

        return $this->link ;
    }

//    public static function __callStatic ( $name, $args ) {
//        $callback = array ( self :: getLink ( ), $name ) ;
//        return call_user_func_array ( $callback , $args ) ;
//    }
//    public function __call( $name, $arguments )
//    {
//        if ( $name === 'send' ) {
//            call_user_func( array( $this, 'sendNonStatic' ) );
//        }
//    }

    public function query($query){
        $this->stmt = $this->link->prepare($query);
    }

    public function bind($param, $value, $type = null){
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }
    public function execute(){
        return $this->stmt->execute();
    }
    public function resultset(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_BOTH);
    }
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function rowCount(){
        return $this->stmt->rowCount();
    }
    public function columnCount(){
        return $this->stmt->columnCount();
    }
    public function lastInsertId(){
        return $this->link->lastInsertId ();
    }
    public function beginTransaction(){
        return $this->link->beginTransaction();
    }
    public function endTransaction(){
        return $this->link->commit();
    }
    public function cancelTransaction(){
        return $this->link->rollBack();
    }
    public function debugDumpParams(){
        return $this->stmt->debugDumpParams();
    }
    public function connected(){
        echo "database connection established";
    }
    public function count_all(){

    }

}
