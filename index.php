<?php

Class Dbh {
 private $servern;
 private $usern;
 private $passn;
 private $dbn;

 protected function connect() {


   $this->host         = "localhost";
   $this->user         = "root";
   $this->password     = "" ;
   $this->database     = "DBValley" ;

    $conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
    return $conn ;
 }


}
Class Auto_query_show extends Dbh {

   protected function getAllUsers() {
     $sql = "SELECT * FROM user_skill" ;
     $result = $this->connect()->query($sql);
     $numRows = $result->num_rows;
     if($numRows > 0) {
       while($row = $result->fetch_assoc()) {
         $data[]= $row;
       }
       return $data ;
     }
   }
}

Class Auto_query extends Dbh {

 public function auto_query( $_table = "user_skill", $_vars = array(['skill_name' => 'PHP'])  ) {
    //Grouped array variables
   $_fields = array(); $_query_params = array();
   // Variable $table_name was wrong
   $_result = $this->connect()->query( "EXPLAIN $_table" );
    // I changed the method FetchRow to Fetch_assoc
    while( $_row = $_result->fetch_assoc() ) {
    	  array_push( $_fields, $_row['Field']  );

        }
    // Using method isset to check $_vars
    if(isset( $_vars[$_table . '_id']) ) {
        $_query = "UPDATE $_table SET ";

       }
    else {
       $_query = "INSERT INTO $_table SET " . $_table . '_date_created = NOW(), ';

       }

 foreach( $_fields as $_field ) {
         if( isset( $_vars[$_field] ) ) { //I've removed quoteSmart method (faster)
           $_query_params[] = "$_field = " . "'" .$_vars[$_field]."'" ;
           }
       }
  $_query .= implode( ',', $_query_params );
   // Using method isset to check $_vars
   if(isset( $_vars[$_table . '_id'] )) {//I've removed quoteSmart method (faster)
       $_query .= " WHERE {$_table}_id = " . "'".$_vars[$_table . '_id']."'";
       }
 //Persisting data to the Database.
  $result = $this->connect()->query($_query);

  if ($result === TRUE) {
    echo "Transaction Successfully ";
  }

 return $_query;

 }

}



Class ViewAuto_query extends Auto_query_show {
  public function showAllUsers(){
    $datas = $this->getAllUsers();

    foreach ($datas as $data) {
      echo $data['skill_name'];
    }
  }
}



//$users = new ViewAuto_query();
//$users->showAllUsers();


$arr = array(
             'skill_name' => 'Javascript',
             'skill_level' => 'advanced',
             'user_skill_id' => 3 ,
         );

$auto = new Auto_query();
$auto->auto_query('user_skill' , $arr);








?>
