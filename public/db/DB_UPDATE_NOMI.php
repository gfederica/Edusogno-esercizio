<?php
include_once __DIR__ . '/DB_CONFIG.php';
 // Recupero i dati dal form
 $nome =  $_REQUEST['nome'];
 $cognome = $_REQUEST['cognome'];
 $email = $_REQUEST['email'];
   
 //specifico i campi della tabella da popolare
 
 $sql = "INSERT INTO utenti (nome, cognome, email) VALUES ('$nome', 
     '$cognome','$email')";
   
 if(mysqli_query($conn, $sql)){
     echo "<h3>Dati salvati in DB</h3>";
 } else{
     echo "Errore" 
         . mysqli_error($conn);
 }
 
 mysqli_close($conn);

?>


 