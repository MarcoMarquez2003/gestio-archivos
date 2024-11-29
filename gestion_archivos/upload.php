<?php
$target_dir = "uploads/";
$max_file_size = 2 * 1024 * 1024; // 2 MB
$allowed_file_types = ['image/jpeg', 'image/png', 'application/pdf'];
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_name = basename($_FILES['file']['name']);
        $file_size = $_FILES['file']['size'];
        $file_type = mime_content_type($file_tmp);

        if ($file_size > $max_file_size) {
            $error_message = "El archivo excede el tamaño máximo permitido de 2 MB.";
        } elseif (!in_array($file_type, $allowed_file_types)) {
            $error_message = "Solo se permiten archivos JPEG, PNG y PDF.";
        } else {
            $target_file = $target_dir . $file_name;
            if (move_uploaded_file($file_tmp, $target_file)) {
                echo "<div class='alert alert-success text-center'>Archivo cargado exitosamente: <a href='$target_file'>$file_name</a></div>";
            } else {
                $error_message = "Hubo un error al guardar el archivo.";
            }
        }
    } else {
        $error_message = "No se seleccionó ningún archivo o hubo un error al cargar.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Archivos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Sube tu archivo</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($error_message): ?>
                            <div class="alert alert-danger text-center">
                                <?php echo htmlspecialchars($error_message); ?>
                            </div>
                        <?php endif; ?>

                        <form action="upload.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-4">
                                <label for="file" class="form-label">Selecciona un archivo:</label>
                                <input type="file" name="file" id="file" class="form-control" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-cloud-upload-alt"></i> Cargar Archivo
                                </button>
                            </div>
                        </form>

                        <p class="text-muted mt-4 text-center">
                            Tamaño máximo: <strong>2 MB</strong>. <br>
                            Tipos permitidos: <strong>JPEG, PNG, PDF</strong>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
