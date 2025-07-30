<?php
namespace ITATS\PraktikumTeknikSipil\App;

class ImageOptimizer
{
    /**
     * Kompres dan konversi gambar menjadi WebP.
     *
     * @param string $sourcePath  Path file asli (JPG/PNG)
     * @param string $destinationPath Path file tujuan (.webp)
     * @param int $maxWidth Lebar maksimal gambar (optional)
     * @param int $quality Kualitas WebP (0-100)
     * @return bool True jika sukses
     */
    public static function optimizeToWebp($sourcePath, $destinationPath, $maxWidth = 1024, $quality = 80)
    {
        $info = getimagesize($sourcePath);
        if (!$info) return false;

        list($width, $height, $type) = $info;

        switch ($type) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($sourcePath);
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            default:
                return false;
        }

        if ($width > $maxWidth) {
            $ratio = $height / $width;
            $newWidth = $maxWidth;
            $newHeight = intval($maxWidth * $ratio);

            $resized = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $resized;
        }

        $success = imagewebp($image, $destinationPath, $quality);
        imagedestroy($image);

        return $success;
    }
}
