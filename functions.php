<?php
function getDownloadCount()
{
    $count_file = 'download_count.txt';
    if (file_exists($count_file)) {
        $counts = json_decode(file_get_contents($count_file), true);
        return $counts['total'] ?? 0;
    }
    return 0;
}
?>