<?php

namespace Pythagus\LaravelFileRequest;

use Illuminate\Http\UploadedFile;
use Pythagus\LaravelFileRequest\File\FileOption;
use Pythagus\LaravelFileRequest\Storage\StorageHelper;
use Pythagus\LaravelFileRequest\Exceptions\UploadFileException;

/**
 * Trait FileRequestTrait
 * @package Pythagus\LaravelFileRequest
 *
 * @author: Damien MOLINA
 */
trait FileRequestTrait {

    /**
     * Array of the files' options.
     * Each key is the file key in the request's data.
     *
     * @var array
     */
    private $options = [] ;

    /**
     * This method is used to set up the files
     * options.
     *
     * @return void
     */
    public function setUp() {
        //
    }

    /**
     * Get the option identified by the given key.
     *
     * @param string $fileKey
     * @return FileOption
     */
    private function getOption(string $fileKey) {
        $this->manageOption($fileKey) ;

        return $this->options[$fileKey] ;
    }

    /**
     * Get a StorageHelper instance.
     *
     * @param string $fileKey
     * @return StorageHelper
     */
    private function getStorage(string $fileKey) {
        return $this->getOption($fileKey)->getStorage() ;
    }

    /**
     * Set the option for the given file key.
     *
     * @param string $fileKey
     * @return FileOption
     */
    public function setOption(string $fileKey) {
        $this->manageOption($fileKey) ;

        return $this->options[$fileKey] ;
    }

    /**
     * Manage the option if not already exists.
     *
     * @param string $fileKey
     */
    private function manageOption(string $fileKey) {
        if(! array_key_exists($fileKey, $this->options)) {
            $this->options[$fileKey] = new FileOption() ;
        }
    }

    /**
     * Determine whether the file with the
     * given key was successfully uploaded.
     *
     * @param string $fileKey
     * @return bool
     */
    public function isUploaded(string $fileKey) {
        if(! $this->hasFile($fileKey)) {
            return false ;
        }

        return $this->file($fileKey)->isValid() ;
    }

    /**
     * Get the file name.
     * The given $name should not contain the extension of the
     * file.
     *
     * @param UploadedFile $file
     * @param string $fileKey
     * @param string|null $name
     * @return string
     */
    private function findFileName(UploadedFile $file, string $fileKey, string $name = null) {
        $ext = '.'.$file->getClientOriginalExtension() ;

        if(! is_null($name)) {
            return $name.$ext ;
        }

        $option = $this->getOption($fileKey) ;

        if($option->isRandom()) {
            return $option->findRandomName($ext) ;
        }

        return $file->getClientOriginalName() ;
    }

    /**
     * Save the file by its key.
     *
     * @param string $fileKey
     * @param string|null $name
     * @return string
     * @throws UploadFileException|Storage\NullStorageAttributeException
     */
    public function saveFile(string $fileKey, string $name = null) {
        $file     = $this->file($fileKey) ;
        $fileName = $this->findFileName($file, $fileKey, $name) ;
        $response = $this->getStorage($fileKey)->save($file, $fileName) ;

        if(! $response) {
            throw new UploadFileException($fileKey) ;
        }

        return $fileName ;
    }

}
