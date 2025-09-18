<?php
$files = [
    'pdf' => 'vesrgns3.pdf',
    'epub' => 'vesrgns3.epub',
    'fb2' => 'vesrgns3.fb2'
];

// Получаем запрошенный формат
$format = $_GET['format'] ?? 'pdf';
// Проверяем, существует ли такой формат
if (!isset($files[$format])) {
    die('Неверный формат файла');
}

$filename = $files[$format];
$count_file = 'download_count.txt'; // один файл для всех счетчиков

// Читаем текущие счетчики
if (file_exists($count_file)) {
    $counts = json_decode(file_get_contents($count_file), true);
} else {
    $counts = [
        'pdf' => 0,
        'epub' => 0,
        'fb2' => 0,
        'total' => 0
    ];
}

// Увеличиваем счетчики
$counts[$format]++;
$counts['total']++;

// Сохраняем счетчики
file_put_contents($count_file, json_encode($counts, JSON_PRETTY_PRINT), LOCK_EX);


// Перенаправляем на скачивание
header('Location: https://es.ptah57.keenetic.pro/book/' . $filename);
exit();
?>