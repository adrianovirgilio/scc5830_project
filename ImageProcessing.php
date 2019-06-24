<?php

/**
 * 
 * Class ImageProcessing
 *
 * 
 */
class ImageProcessing
{
    /**
     * Black color value
     */
    const COLOR_BLACK = 0;

    /**
     * White color value
     */
    const COLOR_WHITE = 16777215;

    /**
     * Auto threshold correction value
     */
    const AUTO_THRESHOLD_CORRECTION = 0.85;

    /**
     * @param string $file
     * @return resource
     * @throws Exception
     */
    public static function createImageFromFile(string $file)
    {
        $image = imagecreatefromjpeg($file);
        if (! $image) {
            throw new Exception('Não é possível carregar o arquivo de imagem.');
        }
        
        return $image;
    }

    /**
     * @param resource $sourceImage
     * @param int $threshold
     * @return resource
     */
    public static function threshold($sourceImage, $threshold = 127)
    {
        list($sourceWidth, $sourceHeight) = self::getWidthAndHeight($sourceImage);
		
        $outputImage = imagecreatetruecolor($sourceWidth, $sourceHeight);
		//echo "Retorna a quantidade de memória alocada para PHP:" .  memory_get_usage() ."\n";

        for ($y = 0; $y < $sourceHeight; $y++) {
            for ($x = 0; $x < $sourceWidth; $x++) {
                list($red, $green, $blue) = self::getPixelRGB($sourceImage, $x, $y);
                if ($red >= $threshold and $green >= $threshold and $blue >= $threshold) {
                    imagesetpixel($outputImage, $x, $y, self::COLOR_WHITE);
                } else {
                    imagesetpixel($outputImage, $x, $y, self::COLOR_BLACK);
                }
            }
        }

        return $outputImage;
    }

    /**
     * @param $sourceImage
     * @return resource
     */
    public static function autoThreshold($sourceImage)
    {
        list($sourceWidth, $sourceHeight) = self::getWidthAndHeight($sourceImage);

        $outputImage = imagecreatetruecolor($sourceWidth, $sourceHeight);

        $threshold = 127;
        $intermediateThreshold = null;

        $sumLess = $countLess = $sumGreater = $countGreater = 0;

        for ($y = 0; $y < $sourceHeight; $y++) {
            for ($x = 0; $x < $sourceWidth; $x++) {
                list($red, $green, $blue) = self::getPixelRGB($sourceImage, $x, $y);
                $averageRGB = ($red + $green + $blue) / 3;
                if ($averageRGB < $threshold) {
                    $sumLess += $averageRGB;
                    $countLess++;
                } else {
                    $sumGreater += $averageRGB;
                    $countGreater++;
                }
            }
        }

        $meanLess = $countLess > 0 ? (int) $sumLess / $countLess : 0;
        $meanGreater = $countGreater > 0 ? (int) $sumGreater / $countGreater : 0;

        $intermediateThreshold = ($meanLess + $meanGreater) / 2;

        $threshold = $intermediateThreshold * self::AUTO_THRESHOLD_CORRECTION;

        $outputImage = self::threshold($sourceImage, $threshold);

        return $outputImage;
    }

    /**
     * @param resource $sourceImage
     * @param resource $binaryImage
     * @return array
     */
    public static function getAverageRGBFromImageWithBinary($sourceImage, $binaryImage = null): array
    {
        if ($binaryImage === null) {
            $binaryImage = self::autoThreshold($sourceImage);
        }

        list($sourceWidth, $sourceHeight) = self::getWidthAndHeight($sourceImage);
        list($binaryWidth, $binaryHeight) = self::getWidthAndHeight($binaryImage);

        $countPixels = $countRed = $countGreen = $countBlue = 0;
        for ($y = 0; $y < $binaryHeight; $y++) {
            for ($x = 0; $x < $binaryWidth; $x++) {
                if (self::isPixelBlack($binaryImage, $x, $y)) {
                    list($red, $green, $blue) = self::getPixelRGB($sourceImage, $x, $y);
                    $countRed += $red;
                    $countGreen += $green;
                    $countBlue += $blue;
                    $countPixels++;
                }
            }
        }
        // Mudança de posição numérica para um rótulo em cada index
        $averageRGB = [
            'r' => $countRed / $countPixels,
            'g' => $countGreen / $countPixels,
            'b' => $countBlue / $countPixels,
        ];

        return $averageRGB;
    }

    /**
     * @param resource $image
     * @return array
     */
    protected static function getWidthAndHeight($image): array
    {
        $widthAndHeight = [
            imagesx($image),
            imagesy($image),
        ];

        return $widthAndHeight;
    }

    /**
     * @param resource $image
     * @param int $x
     * @param int $y
     * @return array
     */
    protected static function getPixelRGB($image, int $x, int $y): array
    {
        $pixel = imagecolorat($image, $x, $y);

        $rgb = [
            ($pixel >> 16) & 0xFF,
            ($pixel >> 8) & 0xFF,
            $pixel & 0xFF,
        ];

        return $rgb;
    }

    /**
     * @param resource $image
     * @param int $x
     * @param int $y
     * @return bool
     */
    protected static function isPixelBlack($image, int $x, int $y): bool
    {
        $isPixelBlack = imagecolorat($image, $x, $y) == self::COLOR_BLACK;
        
        return $isPixelBlack;
    }

    /**
     * @param float $red
     * @param float $green
     * @param float $blue
     * @return array
     */
     public function convertRGBtoHSL(float $red, float $green, float $blue): array
     {
         $red /= 255;
         $green /= 255;
         $blue /= 255;
 
         $max = max($red, $green, $blue);
         $min = min($red, $green, $blue);
 
         $luminosity = $max;
         $difference = $max - $min;
 
         if ($difference == 0) {
             $hue = $saturation = 0;
         } else {
             $saturation = $difference / $max;
             switch ($max) {
                 case ($red): 
                     $hue = 60 * fmod((($green - $blue) / $difference), 6);
                     if ($blue > $green) $hue += 360;
                     break;
                 case ($green): 
                     $hue = 60 * (($blue - $red) / $difference + 2);
                     break;
                 case ($blue):
                     $hue = 60 * (($red - $green) / $difference + 4);
                     break;
             }
         }
 
         $hsl = [
             'h' => round($hue, 2),
             's' => round($saturation, 2),
             'v' => round($luminosity, 2),
         ];
 
         return $hsl;
     }

     // Fundo branco
     /*
     * @param $sourceImage
     * @param $thresholdImage
     * @return resource
     */
     public static function getBackgroundWhiteImage($sourceImage, $thresholdImage)
     {
         list($sourceWidth, $sourceHeight) = self::getWidthAndHeight($sourceImage);
 
         $outputImage = imagecreatetruecolor($sourceWidth, $sourceHeight);
         imagealphablending($outputImage, false);
         
         for ($y = 0; $y < $sourceHeight; $y++) {
             for ($x = 0; $x < $sourceWidth; $x++) {
                 $thresholdPixel = imagecolorat($thresholdImage, $x, $y);
                 if ($thresholdPixel == self::COLOR_WHITE) {
                     $color = imagecolorallocate($outputImage,255,255,255);
                     //$color = imagecolorallocatealpha($outputImage, 255, 255, 255, 127);                
                 } else {
                     $color = imagecolorat($sourceImage, $x, $y);
                 }
                 imagesetpixel($outputImage, $x, $y, $color);
             }
         }
         return $outputImage;
     }

}
