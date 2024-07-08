<?php
$file= $_GET['file'];

// Vérifiez si le fichier existe
if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    
    readfile($file);
    exit;
} else {
    
    echo "Le fichier n'existe pas.";
}
?>
