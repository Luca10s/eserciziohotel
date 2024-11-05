<?php
include 'db.php';

$sql = "SELECT Prenotazioni.id, Prenotazioni.cliente_cognome, Prenotazioni.cliente_nome, Camere.numero, Prenotazioni.data_checkin, Prenotazioni.data_checkout, Prenotazioni.costo_totale
        FROM Prenotazioni
        JOIN Camere ON Prenotazioni.numero_camera = Camere.numero
        WHERE Prenotazioni.data_checkout >= CURDATE()";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo " - Cliente: " . $row["cliente_cognome"]. " " . $row["cliente_nome"]. " - Camera: " . $row["numero"]. " - Check-in: " . $row["data_checkin"]. " - Check-out: " . $row["data_checkout"]. " - Costo Totale: " . $row["costo_totale"]. "<br>";
    }
} else {
    echo "Nessuna prenotazione attiva.";
}
?>
