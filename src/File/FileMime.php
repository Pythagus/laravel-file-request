<?php

namespace Pythagus\LaravelFileRequest\File;

/**
 * Class FileMime
 * @package Pythagus\LaravelFileRequest\File
 *
 * @author: Damien MOLINA
 */
class FileMime {

    /**
     * @var array
     * @see: https://en.wikipedia.org/wiki/List_of_Microsoft_Office_filename_extensions
     */
    protected static $word = [
        'doc', 'dot', 'wbk', 'docx', 'docm', 'dotm', 'docb',
    ] ;

    /**
     * @var array
     * @see: https://en.wikipedia.org/wiki/List_of_Microsoft_Office_filename_extensions
     */
    protected static $excel = [
        'xls', 'xlsm', 'xltx', 'xltm', 'xlsb', 'xla', 'xlam', 'xll', 'xlw',
    ] ;

    /**
     * @var array
     * @see: https://en.wikipedia.org/wiki/List_of_Microsoft_Office_filename_extensions
     */
    protected static $powerpoint = [
        'ppt', 'pot', 'pps', 'pptx', 'pptm', 'potx', 'potm', 'ppam', 'ppsx', 'ppsm', 'sldx', 'sldm',
    ] ;


    /**
     * @var array
     * @see: https://en.wikipedia.org/wiki/Image_file_formats
     */
    public static $photo = [
        'tiff', 'jpeg', 'jpg', 'gif', 'png', 'svg', 'bmp'
    ] ;

    /**
     * @var array
     * @see: https://wiki.openoffice.org/wiki/Documentation/OOoAuthors_User_Manual/Getting_Started/File_formats
     */
    public static $openOffice = [
        'odt','ott','odm','ods','ots','odg','otg','odp','otp','odf','odc','odb'
    ] ;

    /**
     * @var array
     */
    public static $pdf = [
        'pdf'
    ] ;

    /**
     * @param string $ext
     * @return bool
     */
    public static function isWord(string $ext) {
        return in_array($ext, static::$word) ;
    }

    /**
     * @param string $ext
     * @return bool
     */
    public static function isExcel(string $ext) {
        return in_array($ext, static::$excel) ;
    }

    /**
     * @param string $ext
     * @return bool
     */
    public static function isPowerpoint(string $ext) {
        return in_array($ext, static::$powerpoint) ;
    }

    /**
     * @param string $ext
     * @return bool
     */
    public static function isOpenOffice(string $ext) {
        return in_array($ext, static::$openOffice) ;
    }

    /**
     * @param string $ext
     * @return bool
     */
    public static function isPdf(string $ext) {
        return in_array($ext, static::$pdf) ;
    }

    /**
     * @param string $ext
     * @return bool
     */
    public static function isPicture(string $ext) {
        return in_array($ext, static::$photo) ;
    }

    /**
     * @param string $name
     * @return string
     */
    public static function getExtensionFromName(string $name) {
        $ext = explode('.', $name) ;

        return $ext[count($ext) - 1];
    }

}
