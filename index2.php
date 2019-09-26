<?php
function auto_query( $_table, $_vars ) {
   $_result = $this->query( "EXPLAIN $_table_name" );
    $_fields = array();
    while( $_row = $_result->fetchRow() ) {
    	  array_push( $_fields, $_row['Field'] );
        }

        if( $_vars[$_table . '_id'] ) {
            $_query = "UPDATE $_table SET ";
           }
        else {
           $_query = "INSERT INTO $_table SET " . $_table . '_date_created = NOW(), ';
           }


   $_query_params = array();
      foreach( $_fields as $_field ) {
       if( isset( $_vars[$_field] ) ) {
           $_query_params[] = "$_field = " . $this->dbh->quoteSmart( $_vars[$_field] );
           }
       }
   $_query .= implode( ',', $_query_params );
   if( $_vars[$_table . '_id'] ) {
       $_query .= " WHERE {$_table}_id = " . $this->dbh->quoteSmart($_vars[$_table . '_id']);
       }
   return $_query;
   }

?>
