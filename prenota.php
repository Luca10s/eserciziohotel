<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente_cognome = $_POST['cliente_cognome'];
    $cliente_nome = $_POST['cliente_nome'];
    $tipologia_camera = $_POST['tipologia_camera'];
    $data_checkin = $_POST['data_checkin'];
    $data_checkout = $_POST['data_checkout'];

    prenotaCamera($cliente_cognome, $cliente_nome, $tipologia_camera, $data_checkin, $data_checkout);
}

function prenotaCamera($cliente_cognome, $cliente_nome, $tipologia_camera, $data_checkin, $data_checkout) {
    global $conn;

    $sql = "SELECT costo_per_notte FROM Camere WHERE tipologia = '$tipologia_camera'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $costo_per_notte = $row['costo_per_notte'];

        $datetime1 = new DateTime($data_checkin);
        $datetime2 = new DateTime($data_checkout);
        $interval = $datetime1->diff($datetime2);
        $notti = $interval->days;

        $costo_totale = $costo_per_notte * $notti;

        $sql = "INSERT INTO Prenotazioni (cliente_cognome, cliente_nome, tipologia_camera, data_checkin, data_checkout, costo_totale)
                VALUES ('$cliente_cognome', '$cliente_nome', '$tipologia_camera', '$data_checkin', '$data_checkout', $costo_totale)";

        if ($conn->query($sql) === TRUE) {
            header("Location: conferma.html");
            exit();
        } else {
            echo "Errore: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Errore: Nessuna camera trovata con la tipologia specificata.";
    }
}
?>
