<?php

namespace Pythagus\LaravelFileRequest\Storage;

use Pythagus\LaravelFileRequest\Exceptions\FileRequestException;

/**
 * Class NullStorageAttributeException
 * @package Pythagus\LaravelFileRequest\Storage
 *
 * @author: Damien MOLINA
 */
class NullStorageAttributeException extends FileRequestException {

    /**
     * Set the called method.
     *
     * @param string $attribute
     * @param string|null $method
     */
    public function __construct(string $attribute, string $method = null) {
        $msg = "." ;

        if(! is_null($method)) {
            $msg = " (In StorageHelper::$method)" ;
        }

        parent::__construct(
            "Trying to access to the $attribute attribute, but it is null".$msg
        ) ;
    }

}
