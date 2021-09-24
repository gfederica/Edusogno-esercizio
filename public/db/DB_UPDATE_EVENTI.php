<?php
include_once __DIR__ . '/DB_CONFIG.php';

// Recupero i dati dal form
$nome_evento =  $_REQUEST['nome_evento'];
$descrizione_evento = $_REQUEST['descrizione_evento'];
$data = $_REQUEST['data'];
$ora = $_REQUEST['ora'];

//specifico i campi della tabella da popolare
$sql = "INSERT INTO eventi (nome_evento, descrizione_evento, data, ora) VALUES ('$nome_evento', 
    '$descrizione_evento','$data', '$ora')";

if(mysqli_query($conn, $sql)){
echo "Dati Salvati in DB!";
} else{
    echo "Errore" 
        . mysqli_error($conn);
}

mysqli_close($conn);


?>


 