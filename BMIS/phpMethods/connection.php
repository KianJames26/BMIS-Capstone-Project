<?php
function OpenCon(){
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db = "bmis_db";
        $conn = new mysqli($host,$user,$pass,$db) or die("Connect failed: %s\n". $conn -> error);
        
        return $conn;
    }
    
function CloseCon($conn){
    $conn -> close();
}
?>