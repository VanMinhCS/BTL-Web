<?php
$htmlFile = __DIR__ . '/news.html';
if (file_exists($htmlFile)) {
    readfile($htmlFile);
} else {
    echo "File HTML không tồn tại: " . $htmlFile;
}
?>
