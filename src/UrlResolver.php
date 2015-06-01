<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 01/06/2015
 * Time: 00:53
 */

namespace Samcrosoft\Placeholder;


/**
 * This class resolves the query string to values that can be used to handle the image creation
 * Class UrlResolver
 * @package Samcrosoft\Placeholder
 */
class UrlResolver
{

    const PARAM_WIDTH = "w";
    const PARAM_HEIGHT = "h";
    const PARAM_TEXT = "t";
    const PARAM_FOREGROUND_COLOR = "f";
    const PARAM_BACKGROUND_COLOR = "b";

    /**
     * This will return the query string values as an array
     * @return array
     */
    private function getQueryValues()
    {
        return $_GET;
    }


    /**
     * This will return the image width
     * @return mixed|null
     */
    public function getWidthValue()
    {
        $iReturn =  $this->arrayValueOrDefault($this->getQueryValues(), self::PARAM_WIDTH,
            Placeholder::DEFAULT_IMAGE_WIDTH);
        return intval($iReturn);
    }

    /**
     * This will return the image height
     * @return mixed|null
     */
    public function getHeightValue()
    {
        $iReturn =  $this->arrayValueOrDefault($this->getQueryValues(), self::PARAM_HEIGHT,
            Placeholder::DEFAULT_IMAGE_HEIGHT);
        return intval($iReturn);
    }

    /**
     * This will return the image text
     * @return string
     */
    public function getText()
    {
        $sDefault = implode("x", [$this->getWidthValue(), $this->getHeightValue()]);
        $sReturn =  $this->arrayValueOrDefault($this->getQueryValues(), self::PARAM_TEXT, $sDefault);
        return urlencode($sReturn);
    }

    /**
     * This will return the text value of the foreground color
     * @return string
     */
    public function getForegroundColor(){
        $sReturn =  $this->arrayValueOrDefault($this->getQueryValues(), self::PARAM_FOREGROUND_COLOR,
            Placeholder::DEFAULT_FOREGROUND_COLOR);
        return strval($sReturn);
    }

    /**
     * This will return the text value of the background color
     * @return string
     */
    public function getBackgroundColor(){
        $sReturn =  $this->arrayValueOrDefault($this->getQueryValues(), self::PARAM_BACKGROUND_COLOR,
            Placeholder::DEFAULT_BACKGROUND_COLOR);

        return strval($sReturn);
    }


    /**
     * Get an item from an array using "dot" notation.
     * @param $aArray
     * @param $sKey
     * @param null $mDefault
     * @return null|mixed
     */
    private function arrayValueOrDefault($aArray, $sKey, $mDefault = null)
    {
        if (is_null($sKey)) return $aArray;

        $mReturn = isset($aArray[$sKey]) ? $aArray[$sKey] : $mDefault;
        return $mReturn;
    }

}