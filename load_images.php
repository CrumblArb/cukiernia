<?php
header('Content-Type: application/json; charset=utf-8');

$baseDir = __DIR__ . '/images';
$categories = ['ciasta', 'slodkie-stoly', 'torty'];
$allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];

$result = [];

foreach ($categories as $cat) {
    $dir = "$baseDir/$cat";
    $images = [];

    if (is_dir($dir)) {
        foreach (scandir($dir) as $file) {
            $path = "$dir/$file";
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            if (in_array($ext, $allowed)) {
                $images[] = [
                    'src' => "images/$cat/$file",
                    'title' => ucfirst(str_replace(['-', '_'], ' ', pathinfo($file, PATHINFO_FILENAME))),
                ];
            }
        }
    }

    // сортуємо за назвою
    usort($images, fn($a, $b) => strcmp($a['src'], $b['src']));

    $result[$cat] = $images;
}

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
