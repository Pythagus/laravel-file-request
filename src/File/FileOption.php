<?php

namespace Pythagus\LaravelFileRequest\File;

use Illuminate\Support\Str;
use Pythagus\LaravelFileRequest\Storage\StorageHelper;
use Pythagus\LaravelFileRequest\Storage\NullStorageAttributeException;

/**
 * Class FileOption
 * @package Pythagus\LaravelFileRequest\File
 *
 * @property StorageHelper   storage
 * @property boolean         random
 * @property FileOptionQuery query
 * @property int             randomLength
 * @property string          existFolder
 *
 * @author: Damien MOLINA
 */
class FileOption {

    /**
     * @var StorageHelper
     */
    private $storage ;

    /**
     * Determine whether the file name should be random.
     * If the query property is set, then the name will
     * be random et unique in the specified datatable.
     *
     * @var bool
     */
    private $random = false ;

    /**
     * Size of the random generated name.
     *
     * @var int
     */
    private $randomLength = 16 ;

    /**
     * Query used to find a unique file name.
     *
     * @var FileOptionQuery
     */
    private $query = null ;

    /**
     * Folder that should not contain the
     * file name.
     *
     * @var null
     */
    private $existFolder = null ;

    /**
     * Get the storage helper instance.
     *
     * @return StorageHelper
     */
    public function getStorage() {
        if(is_null($this->storage)) {
            $this->storage = new StorageHelper('') ;
        }

        return $this->storage ;
    }

    /**
     * Set the folder of the option.
     *
     * @param string $folder
     * @return FileOption
     */
    public function setFolder(string $folder) {
        if(is_null($this->storage)) {
            $this->storage = new StorageHelper($folder) ;
        } else {
            $this->storage->setFolder($folder) ;
        }

        return $this ;
    }

    /**
     * Tell that the file name should be randomize.
     * If the
     *
     * @param FileOptionQuery|null $option
     * @param int|null $randomLength
     * @return FileOption
     */
    public function randomize(FileOptionQuery $option = null, int $randomLength = null) {
        $this->random = true ;
        $this->query  = $option ;

        if(! is_null($randomLength)) {
            $this->randomLength = $randomLength ;
        }

        return $this ;
    }

    /**
     * Determine whether the file name should be
     * random.
     *
     * @return bool
     */
    public function isRandom() {
        return boolval($this->random) ;
    }

    /**
     * Find a random name using the potential query.
     *
     * @param string $ext : file extension
     * @return string
     */
    public function findRandomName(string $ext) {
        $name = Str::random($this->randomLength).$ext ;

        if(! is_null($this->query)) {
            if($this->query->nameAlreadyExists($name)) {
                return $this->findRandomName($ext) ;
            }
        }

        if(! is_null($this->existFolder)) {
            try {
                if(StorageHelper::make($this->existFolder, $name)->exists()) {
                    return $this->findRandomName($ext) ;
                }
            } catch(NullStorageAttributeException $exception) {}
        }

        return $name ;
    }

    /**
     * The name shouldn't exist in the given folder.
     * This option is only useful for a random name.
     *
     * @param string $folder
     * @return FileOption
     */
    public function shouldnExistInFolder(string $folder) {
        $this->existFolder = $folder ;

        return $this ;
    }

}
