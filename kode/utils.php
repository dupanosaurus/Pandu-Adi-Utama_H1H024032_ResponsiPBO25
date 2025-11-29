<?php
//Helper untuk baca / tulis JSON dan fungsi kecil lainnya.

function load_json(string $path, $default = []) {
    if (!file_exists($path)) {
        return $default;
    }
    $raw = file_get_contents($path);
    if ($raw === false || trim($raw) === '') return $default;
    $data = json_decode($raw, true);
    if ($data === null) return $default;
    return $data;
}

function save_json(string $path, $data): bool {
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    $json = json_encode($data, JSON_PRETTY_PRINT);
    return file_put_contents($path, $json) !== false;
}
