<?php
echo "Current directory: " . __DIR__ . "<br>";

if (is_dir('tcpdf')) {
    echo "✅ TCPDF folder exists!<br>";
} else {
    echo "❌ TCPDF folder NOT found!<br>";
}

if (file_exists('tcpdf/tcpdf.php')) {
    echo "✅ tcpdf.php exists!<br>";
} else {
    echo "❌ tcpdf.php NOT found!<br>";
}
?>