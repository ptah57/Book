<?php
$count_file = 'download_count.txt';

if (file_exists($count_file)) {
    $counts = json_decode(file_get_contents($count_file), true);
    echo "<h2>Статистика скачиваний</h2>";
    echo "<p>PDF: ".($counts['pdf'] ?? 0)." скачиваний</p>";
    echo "<p>EPUB: ".($counts['epub'] ?? 0)." скачиваний</p>";
    echo "<p>FB2: ".($counts['fb2'] ?? 0)." скачиваний</p>";
    echo "<p>Всего: ".($counts['total'] ?? 0)." скачиваний</p>";
} else {
    echo "Статистика пока недоступна";
}
?> 