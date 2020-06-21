<?php

namespace Pythagus\LaravelFileRequest\Exceptions;

/**
 * Class UploadFileException
 * @package Pythagus\LaravelFileRequest\Exceptions
 *
 * @author: Damien MOLINA
 */
class UploadFileException extends FileRequestException {

    /**
     * Set the called method.
     *
     * @param string $fileKey
     */
    public function __construct(string $fileKey) {
        parent::__construct("Impossible to upload the file $fileKey") ;
    }

}
