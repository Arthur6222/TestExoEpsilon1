<?php
// Configuration
$target_dir = "uploads/";
$allowed_types = [ 'pdf', 'txt'];
$max_file_size = 5 * 1024 * 1024; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    if (!isset($_FILES["fileToUpload"]) || $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_NO_FILE) {
        header("Location: index.php?error=Veuillez sélectionner un fichier");
        exit();
    }

    $file = $_FILES["fileToUpload"];
    $target_file = $target_dir . basename($file["name"]);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


    if ($file["size"] > $max_file_size) {
        header("Location: index.php?error=Fichier trop volumineux (max 5Mo)");
        exit();
    }

    if (!in_array($file_type, $allowed_types)) {
        header("Location: index.php?error=Type de fichier non autorisé");
        exit();
    }

   
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

  
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        header("Location: index.php?success=1");
        exit();
    } else {
        header("Location: index.php?error=Erreur lors de l'upload du fichier");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
