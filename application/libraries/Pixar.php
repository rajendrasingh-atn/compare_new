<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pixar {
    protected $id;
    protected $pid;
    protected $pnm; 
    protected $psrc;
    protected $x;
    protected $y;
    
    function __construct($photoSrc=null, $width=null, $height=null){
        register_shutdown_function(array(&$this, '__destruct'));
        $this->psrc = $photoSrc;
        $this->x = $width;
        $this->y = $height;
        // Height of image org
        list($ox, $oy) = @getimagesize($this->psrc);    // Orignal Size of imae
        $this->width = $ox;
        $this->height = $oy;
    }
    function resize(){
        
        // *** Get optimal width and height - based on $option
        $optionArray = $this->getDimensions($this->x, $this->y, "crop");
        
        $this->x  = $optionArray['optimalWidth'];
        $this->y = $optionArray['optimalHeight'];
        $newPix = imagecreatetruecolor($this->x, $this->y) or die('Cannot Initialize new GD image stream');
        switch(strtolower(substr(strrchr($this->psrc, '.'), 1))):
            case 'jpg':
            case 'jpeg':
                $srcImg = imagecreatefromjpeg($this->psrc);
                $imageWrt = 'imagejpeg';
                $image_quality = 100;
            break;
            case 'gif':
                $srcImg = @imagecreatefromgif($this->psrc);
                $imageWrt = 'imagegif';
                $image_quality = null;
            break;
            case 'png':
                @imagecolortransparent($newPix, @imagecolorallocate($newPix, 0, 0, 0));
                @imagealphablending($newPix, false);
                @imagesavealpha($newPix, true);
                $srcImg = @imagecreatefrompng($this->psrc);
                $imageWrt = 'imagepng';
                $image_quality = 9;
            break;
            default:
                $srcImg = null;
            break;  
        endswitch;
        // Make image
        $make = imagecopyresampled($newPix, $srcImg, 0, 0, 0, 0, $this->x, $this->y, $this->width, $this->height);
        switch(substr($imageWrt, 5)):
            case 'jpeg':
                $mime = 'image/jpeg';
            break;
            case 'png':
                $mime = 'image/png';
            break;
        endswitch;
        // Free up memory (imagedestroy does not delete files):
        header('Content-Type: '.$mime);// defining the image type to be shown in browser window
    /*  header('Cache-Control: no-cache');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); */        
        
        $imageWrt($newPix, null, $image_quality);
        imagedestroy($newPix);
    }
    private function getDimensions($newWidth, $newHeight, $option)
        {
           switch($option)
            {
                case 'exact':
                    $optimalWidth = $newWidth;
                    $optimalHeight= $newHeight;
                break;
                case 'portrait':
                    $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                    $optimalHeight= $newHeight;
                break;
                case 'landscape':
                    $optimalWidth = $newWidth;
                    $optimalHeight= $this->getSizeByFixedWidth($newWidth);
                break;
                case 'auto':
                    $optionArray = $this->getSizeByAuto($newWidth, $newHeight);
                    $optimalWidth = $optionArray['optimalWidth'];
                    $optimalHeight = $optionArray['optimalHeight'];
                break;
                case 'crop':
                    $optionArray = $this->getOptimalCrop($newWidth, $newHeight);
                    $optimalWidth = $optionArray['optimalWidth'];
                    $optimalHeight = $optionArray['optimalHeight'];
                break;
            }
            return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
        }
    private function getSizeByFixedHeight($newHeight)
        {
            $ratio = $this->width / $this->height;
            $newWidth = $newHeight * $ratio;
            return $newWidth;
        }
    private function getSizeByFixedWidth($newWidth)
        {
            $ratio = $this->height / $this->width;
            $newHeight = $newWidth * $ratio;
            return $newHeight;
        }
    private function getSizeByAuto($newWidth, $newHeight)
        {
            if ($this->height < $this->width)
            // *** Image to be resized is wider (landscape)
            {
                $optimalWidth = $newWidth;
                $optimalHeight= $this->getSizeByFixedWidth($newWidth);
            }
            elseif ($this->height > $this->width)
            // *** Image to be resized is taller (portrait)
            {
                $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                $optimalHeight= $newHeight;
            }
            else
            // *** Image to be resizerd is a square
            {
                if ($newHeight < $newWidth) {
                    $optimalWidth = $newWidth;
                    $optimalHeight= $this->getSizeByFixedWidth($newWidth);
                } else if ($newHeight > $newWidth) {
                    $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                    $optimalHeight= $newHeight;
                } else {
                    // *** Sqaure being resized to a square
                    $optimalWidth = $newWidth;
                    $optimalHeight= $newHeight;
                }
            }
            return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
        }
    private function getOptimalCrop($newWidth, $newHeight)
        {
            $heightRatio = $this->height / $newHeight;
            $widthRatio  = $this->width /  $newWidth;
            if ($heightRatio < $widthRatio) {
                $optimalRatio = $heightRatio;
            } else {
                $optimalRatio = $widthRatio;
            }
            $optimalHeight = $this->height / $optimalRatio;
            $optimalWidth  = $this->width  / $optimalRatio;
            return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
        }
    function __destruct(){
        return true;
    }
}
