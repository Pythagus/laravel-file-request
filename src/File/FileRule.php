<?php

namespace Pythagus\LaravelFileRequest\File;

/**
 * Class FileRule
 * @package Pythagus\LaravelFileRequest\File
 *
 * @property boolean required
 * @property int     size
 * @property array   mimes
 * @property array   mimeTypes
 *
 * @author: Damien MOLINA
 */
class FileRule {

    /**
     * Factor between 1 kilobyte and 1 megabyte.
     *
     * @const int
     */
    public const MEGABYTE = 1024 ;

    /**
     * Determine whether the key should
     * be present in the request data.
     *
     * @var boolean
     */
    private $required = true ;

    /**
     * Max size of the file, in kilobytes.
     *
     * @var int
     */
    private $size = 0 ;

    /**
     * Allowed file mimes.
     *
     * @var array
     */
    private $mimes = [] ;

    /**
     * Allowed file mimes types.
     *
     * @var array
     */
    private $mimeTypes = [] ;

    /**
     * Make a new instance of FileRule.
     *
     * @return FileRule
     */
    public static function make() {
        return new FileRule() ;
    }

    /**
     * Put the required attribute as false.
     *
     * @return $this
     */
    public function nullable() {
        $this->required = false ;

        return $this ;
    }

    /**
     * Set the max size of the file.
     *
     * @param int $size : size in kilobytes
     * @param int $factor : factor to convert kilobyte or something
     *                      else to kilobytes.
     * @return FileRule
     */
    public function size(int $size, int $factor = 1) {
        $this->size = $size * $factor ;

        return $this ;
    }

    /**
     * Set the allowed mimes.
     *
     * @param string|array $mimes
     * @return FileRule
     */
    public function mimes($mimes) {
        $this->mimes = $this->convertMimes($mimes) ;

        return $this ;
    }

    /**
     * Set the allowed mimes types.
     *
     * @param string|array $types
     * @return FileRule
     */
    public function mimeTypes($types) {
        $this->mimeTypes = $this->convertMimes($types) ;

        return $this ;
    }

    /**
     * Convert the given mimes to an array.
     *
     * @param string|array $mimes
     * @return array
     */
    private function convertMimes($mimes) {
        if(! is_array($mimes)) {
            return [$mimes] ;
        }

        $array = [] ;
        foreach($mimes as $mime) {
            if(is_array($mime)) {
                $array = array_merge($array, $this->convertMimes($mime)) ;
            } else {
                $array[] = $mime ;
            }
        }

        return $array ;
    }

    /**
     * Get the rules for the file.
     *
     * @return string[]
     */
    public function get() {
        $rules = [
            'file',
            ($this->required ? 'required' : 'nullable'),
            'max:'.$this->size,
        ] ;

        if(count($this->mimes) > 0) {
            $rules[] = 'mimes:'.implode(',',$this->mimes) ;
        }

        return $rules ;
    }

}
