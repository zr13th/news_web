<?php

/**
 * Hàm trả về đường dẫn ảnh bài viết, nếu không tồn tại trả về ảnh mặc định.
 *
 * @param string|null $fileName  Tên file ảnh lưu trong DB
 * @param string $default        Đường dẫn ảnh mặc định
 * @return string
 */
function getPostImage(string|null $fileName, string $default = 'uploads/default.png'): string
{
    $uploadDir = __DIR__ . '/../uploads/';
    $webPath   = 'uploads/';

    if (!empty($fileName)) {
        $filePath = $uploadDir . $fileName;
        if (file_exists($filePath)) {
            return $webPath . $fileName;
        }
    }

    return $default;
}
