<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageHelper
{
    /**
     * Convert an UploadedFile to WebP format.
     *
     * @param UploadedFile $file
     * @param string $destinationPath Absolute path to destination directory
     * @param string $filename Base filename (without extension)
     * @param int $quality Compression quality (0-100)
     * @return string The generated webp filename
     */
    public static function convertToWebP(UploadedFile $file, string $destinationPath, string $filename, int $quality = 80): string
    {
        $imagePath = $file->getRealPath();
        
        // Read image binary content
        $imageContent = file_get_contents($imagePath);
        if ($imageContent === false) {
            throw new \RuntimeException('Failed to read uploaded file content.');
        }

        // Create GD image resource from string
        $image = @imagecreatefromstring($imageContent);
        if (!$image) {
            throw new \InvalidArgumentException('Uploaded file is not a valid or supported image format.');
        }

        // Ensure directories exist
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Prepare alpha transparency (PNG/WebP/GIF compatibility)
        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        // Sanitize and append webp extension
        $webpFilename = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
        $fullPath = rtrim($destinationPath, '/') . '/' . $webpFilename;

        // Save WebP image
        if (!imagewebp($image, $fullPath, $quality)) {
            imagedestroy($image);
            throw new \RuntimeException('Failed to compress and save image as WebP.');
        }

        imagedestroy($image);

        return $webpFilename;
    }

    /**
     * Convert a Base64 encoded image string to WebP format.
     *
     * @param string $base64Data Raw base64 data string (e.g. data:image/jpeg;base64,...)
     * @param string $destinationPath Absolute path to destination directory
     * @param string $filename Base filename (without extension)
     * @param int $quality Compression quality (0-100)
     * @return string The generated webp filename
     */
    public static function base64ToWebP(string $base64Data, string $destinationPath, string $filename, int $quality = 80): string
    {
        // Strip out the data URL prefix if present
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Data, $matches)) {
            $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
        }

        $decodedData = base64_decode($base64Data);
        if ($decodedData === false) {
            throw new \InvalidArgumentException('Invalid base64 payload provided.');
        }

        // Create GD image from binary string
        $image = @imagecreatefromstring($decodedData);
        if (!$image) {
            throw new \InvalidArgumentException('Decoded base64 stream is not a valid image format.');
        }

        // Ensure directories exist
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Prepare alpha transparency
        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        $webpFilename = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
        $fullPath = rtrim($destinationPath, '/') . '/' . $webpFilename;

        // Save WebP image
        if (!imagewebp($image, $fullPath, $quality)) {
            imagedestroy($image);
            throw new \RuntimeException('Failed to compress and save base64 image as WebP.');
        }

        imagedestroy($image);

        return $webpFilename;
    }
}
