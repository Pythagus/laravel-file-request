<?php

namespace Pythagus\LaravelFileRequest\Storage;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Class StorageHelper
 * @package Pythagus\LaravelFileRequest
 *
 * @property string folder
 * @property string file
 *
 * @author: Damien MOLINA
 */
class StorageHelper {

    /**
     * Name of the file folder.
     *
     * @var string
     */
    private $folder ;

    /**
     * Name of the file in the $this->folder folder.
     *
     * @var string
     */
    private $file ;

    /**
     * @var string
     */
    private static $disk = 'public' ;

    /**
     * Set the disk of the StorageHelper.
     *
     * @param string $disk
     */
    public static function setDisk(string $disk) {
        static::$disk = $disk ;
    }

    /**
     * Set the file of the StorageHelper.
     *
     * @param string $file
     * @return StorageHelper
     */
    public function setFile(string $file) {
        $this->file = $file ;

        return $this ;
    }

    /**
     * Set the folder of the StorageHelper.
     *
     * @param string $folder
     * @return StorageHelper
     */
    public function setFolder(string $folder) {
        $this->folder = $folder ;

        return $this ;
    }

    /**
     * Get the file disk to manage the file.
     *
     * @return string
     */
    private function getDisk() {
        return static::$disk ;
    }

    /**
     * Get the asset of the file in the storage folder.
     *
     * @return string
     * @throws NullStorageAttributeException
     */
    public function asset() {
        $this->assertNotNullFile(__METHOD__) ;

        return asset('storage/'.$this->formatPath()) ;
    }

    /**
     * Determine whether a file already exists.
     *
     * @return bool
     * @throws NullStorageAttributeException
     */
    public function exists() {
        $this->assertNotNullFolder(__METHOD__) ;
        $this->assertNotNullFile(__METHOD__) ;

        return Storage::exists($this->getDisk().'/'.$this->formatPath()) ;
    }

    /**
     * Delete the current file.
     *
     * @throws NullStorageAttributeException
     */
    public function delete() {
        $this->assertNotNullFile(__METHOD__) ;

        Storage::disk($this->getDisk())->delete($this->formatPath()) ;
    }

    /**
     * @param UploadedFile $file
     * @param string|null $fileName
     * @return bool
     * @throws NullStorageAttributeException
     */
    public function save(UploadedFile $file, string $fileName = null) {
        $this->assertNotNullFolder(__METHOD__) ;

        $name     = is_null($fileName) ? $file->getFilename() : $fileName ;
        $response = $file->storeAs(
            $this->folder, $name, $this->getDisk()
        ) ;

        return ($response !== false) ;
    }

    /**
     * Return the path from the folder to the file.
     *
     * @return string
     */
    private function formatPath() {
        if($this->folder == '') {
            return $this->file ;
        }

        return $this->folder.'/'.$this->file ;
    }

    /**
     * Check whether the $this->file property was
     * assigned before using it.
     *
     * @param string|null $method
     * @throws NullStorageAttributeException
     */
    private function assertNotNullFile(string $method = null) {
        if(is_null($this->file)) {
            throw new NullStorageAttributeException('file', $method) ;
        }
    }

    /**
     * Check whether the $this->folder property was
     * assigned before using it.
     *
     * @param string|null $method
     * @throws NullStorageAttributeException
     */
    private function assertNotNullFolder(string $method = null) {
        if(is_null($this->folder)) {
            throw new NullStorageAttributeException('folder', $method) ;
        }
    }

    /**
     * Make a new instance of the StorageHelper class.
     *
     * @param string $folder
     * @param string|null $file
     * @return StorageHelper
     */
    public static function make(string $folder = '', string $file = null) {
        return new StorageHelper($folder, $file) ;
    }

    /**
     * @param string $folder
     * @param string|null $file
     */
    public function __construct(string $folder = '', string $file = null) {
        $this->folder = $folder ;
        $this->file   = $file ;
    }

}
