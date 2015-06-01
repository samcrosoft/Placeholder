<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 31/05/2015
 * Time: 21:28
 */

namespace Samcrosoft\Placeholder;


/**
 * Class Placeholder
 * @package Samcrosoft\Placeholder
 */
class Placeholder
{
    const DEFAULT_BACKGROUND_COLOR = '#333';
    const DEFAULT_FOREGROUND_COLOR = '#FFF';
    const DEFAULT_FONT_SIZE = 10;

    const DEFAULT_IMAGE_WIDTH = 100;
    const DEFAULT_IMAGE_HEIGHT = 100;

    const IMAGE_PNG_TYPE = 0x1;
    const IMAGE_JPG_TYPE = 0x2;


    /**
     * Generate a placeholder using the query string parameters
     * @return resource
     */
    public function makePlaceholderFromURL(){
        $oURLResolver = new UrlResolver();
        return $this->makePlaceHolder($oURLResolver->getWidthValue(), $oURLResolver->getHeightValue(),
        $oURLResolver->getText(), $oURLResolver->getBackgroundColor(), $oURLResolver->getForegroundColor());
    }


    /**
     * This will create a typed image and echo it out to the browser, the image content cant be trapped using
     * output buffering
     * @param int $iImageType
     */
    public function makeTypedPlaceHolderFromURL($iImageType = self::IMAGE_PNG_TYPE)
    {
        $oImage = $this->makePlaceholderFromURL();
        switch($iImageType){
            case self::IMAGE_JPG_TYPE:
                imagepng($oImage);
                break;
            case self::IMAGE_PNG_TYPE:
            default:
                imagejpeg($oImage);
                break;
        }

        imagedestroy($oImage);
    }

    /**
     * This is just an alias for placeholder from url with IMAGE_JPG_TYPE
     */
    public function makeJpegImageFromURL()
    {
        $this->makeTypedPlaceHolderFromURL(self::IMAGE_JPG_TYPE);
    }

    /**
     * This is just an alias for the default make placeholder from url method
     */
    public function makePngImageFromURL(){
        $this->makeTypedPlaceHolderFromURL();
    }


    /**
     * @param int $iWidth
     * @param int $iHeight
     * @param $sText
     * @param string $sBackColor
     * @param string $sForeColor
     * @return resource
     */
    protected function makePlaceHolder($iWidth = self::DEFAULT_IMAGE_WIDTH, $iHeight = self::DEFAULT_IMAGE_HEIGHT,
                                    $sText, $sBackColor = self::DEFAULT_BACKGROUND_COLOR,
                                    $sForeColor = self::DEFAULT_FOREGROUND_COLOR)
    {
        // make the image
        $oImage = $this->getImage($iWidth, $iHeight);
        // add color to the image
        $aColorifyValues = $this->colorifyImage($oImage, $sBackColor, $sForeColor);
        // add text to the image
        $aForeColorInt = $aColorifyValues[0];
        $this->textifyImage($oImage, $sText, $aForeColorInt);
        return $oImage;
    }

    /**
     * @param int $iWidth
     * @param int $iHeight
     * @return resource
     */
    private function getImage($iWidth = 100, $iHeight = 100)
    {
        $oImage = imagecreate($iWidth, $iHeight);
        return $oImage;
    }


    /**
     * @param resource $oImage
     * @param string $sBkColor
     * @param string $sFgColor
     * @return array
     */
    private function colorifyImage(&$oImage, $sBkColor = self::DEFAULT_BACKGROUND_COLOR,
                                   $sFgColor = self::DEFAULT_FOREGROUND_COLOR)
    {
        /*
         * Implement the background
         */
        $aBackColor = $this->hex2rgb($sBkColor);
        list($iRed, $iGreen, $iBlue) = $aBackColor;
        $aBackColorInt = imagecolorallocate($oImage, $iRed, $iGreen, $iBlue);



        /*
         * Implement the foreground for text
         */
        $aForegroundColor = $this->hex2rgb($sFgColor);
        list($iRed2, $iGreen2, $iBlue2) = $aForegroundColor;
        $aForeColorInt = imagecolorallocate($oImage, $iRed2, $iGreen2, $iBlue2);

        return [$aForeColorInt, $aBackColorInt];
    }

    /**
     * Simple helper class to get the RGB values from a hex string
     * @param $hex
     * @return array
     */
    private function hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, self::DEFAULT_FONT_SIZE, 2));
        }
        $aRGB = [$r, $g, $b];
        return $aRGB;
    }


    /**
     * This method will add text to the image
     * @param resource $oImage
     * @param string $sText
     * @param $aForeColorInt
     */
    protected function textifyImage(&$oImage, $sText, $aForeColorInt)
    {
        /*
         * Calculate the text positioning
         */
        $iFontSize = self::DEFAULT_FONT_SIZE;
        $iFontWidth = imagefontwidth($iFontSize);
        $iFontHeight = imagefontheight($iFontSize);
        $length = strlen($sText);
        $fTextWidth = $length * $iFontWidth;
        $fxPos = (imagesx($oImage) - $fTextWidth) / 2;
        $fyPos = (imagesy($oImage) - $iFontHeight) / 2;

        // Generate text
        imagestring($oImage, $iFontSize, $fxPos, $fyPos, $sText, $aForeColorInt);
    }
}