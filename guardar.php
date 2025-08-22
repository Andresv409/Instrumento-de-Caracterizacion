<?php
$servername = "localhost";
$username   = "admin";        
$password   = "1082883166";           
$dbname     = "f_caracterizacion";     

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Conexión fallida: " . $conn->connect_error);
}


// 2. DATOS DE FAMILIA

$departamento = $_POST['departamento'] ?? '';
$municipio    = $_POST['municipio'] ?? '';
$territorio   = $_POST['territorio'] ?? '';
$direccion    = $_POST['direccion'] ?? '';
$estrato      = $_POST['estrato'] ?? '';
$fecha_ficha  = $_POST['fecha_ficha'] ?? '';

$sql_familia = "INSERT INTO familias (departamento, municipio, territorio, direccion, estrato, fecha_ficha) 
                VALUES ('$departamento','$municipio','$territorio','$direccion','$estrato','$fecha_ficha')";

if ($conn->query($sql_familia) === TRUE) {
    $id_familia = $conn->insert_id; 
} else {
    die("❌ Error al guardar familia: " . $conn->error);
}


// 3. DATOS DE INTEGRANTES 

if (isset($_POST['integrantes']) && is_array($_POST['integrantes'])) {
    foreach ($_POST['integrantes'] as $i) {
        $nombre      = $i['nombre'] ?? '';
        $edad        = $i['edad'] ?? '';
        $sexo        = $i['sexo'] ?? '';
        $parentesco  = $i['parentesco'] ?? '';
        $ocupacion   = $i['ocupacion'] ?? '';
        $escolaridad = $i['escolaridad'] ?? '';
        $salud       = $i['estado_salud'] ?? '';

        $sql_integrante = "INSERT INTO integrantes (id_familia, nombre, edad, sexo, parentesco, ocupacion, escolaridad, estado_salud)
                           VALUES ('$id_familia','$nombre','$edad','$sexo','$parentesco','$ocupacion','$escolaridad','$salud')";
        $conn->query($sql_integrante);
    }
}

// 4. DATOS DE VIVIENDA

$tipo_vivienda   = $_POST['tipo_vivienda'] ?? '';
$material_pared  = $_POST['material_pared'] ?? '';
$material_piso   = $_POST['material_piso'] ?? '';
$material_techo  = $_POST['material_techo'] ?? '';
$num_cuartos     = $_POST['num_cuartos'] ?? 0;
$hacinamiento    = isset($_POST['hacinamiento']) ? 1 : 0;
$energia_cocinar = $_POST['energia_cocinar'] ?? '';
$tiene_animales  = isset($_POST['tiene_animales']) ? 1 : 0;
$animales_detalle = $_POST['animales_detalle'] ?? '';

$sql_vivienda = "INSERT INTO vivienda (id_familia, tipo_vivienda, material_pared, material_piso, material_techo, num_cuartos, hacinamiento, energia_cocinar, tiene_animales, animales_detalle)
                 VALUES ('$id_familia','$tipo_vivienda','$material_pared','$material_piso','$material_techo','$num_cuartos','$hacinamiento','$energia_cocinar','$tiene_animales','$animales_detalle')";
$conn->query($sql_vivienda);

// 5. DATOS DE SALUD DE LA FAMILIA

$antecedentes       = $_POST['antecedentes'] ?? '';
$enf_transmisibles  = $_POST['enf_transmisibles'] ?? '';
$practicas_criticas = $_POST['practicas_criticas'] ?? '';
$sucesos_vitales    = $_POST['sucesos_vitales'] ?? '';
$vulnerabilidades   = $_POST['vulnerabilidades'] ?? '';
$observaciones      = $_POST['observaciones'] ?? '';

$sql_salud = "INSERT INTO salud_familia (id_familia, antecedentes, enf_transmisibles, practicas_criticas, sucesos_vitales, vulnerabilidades, observaciones)
              VALUES ('$id_familia','$antecedentes','$enf_transmisibles','$practicas_criticas','$sucesos_vitales','$vulnerabilidades','$observaciones')";
$conn->query($sql_salud);


// 6. CERRAR CONEXIÓN

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Formulario enviado</title>
  <style>
    body {
      font-family: "Segoe UI", Arial, sans-serif;
      background: #f7f7f7;
      text-align: center;
      padding: 50px;
    }
    .card {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      max-width: 500px;
      margin: auto;
      padding: 30px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    h1 {
      color: #28a745;
      font-size: 22px;
      margin-bottom: 20px;
    }
    button {
      background: #444;
      color: white;
      border: none;
      padding: 10px 18px;
      font-size: 14px;
      border-radius: 6px;
      cursor: pointer;
      margin: 8px;
    }
    button:hover {
      background: #222;
    }
  </style>
</head>
<body>
  <div class="card">
    <h1>✅ ¡Información enviada correctamente!</h1>
    <p>Los datos se guardaron en la base de datos.</p>
    <div>
      <button onclick="window.location.href='form.html'">📝 Nuevo formulario</button>
    </div>
  </div>
</body>
</html>
