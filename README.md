# Laravel File Request
LaravelFileRequest is a light Laravel package to easily manage files.

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

## Installation
You can quickly add this package in your application using Composer. **Be careful** to use the correct version of the package regarding your Laravel application version:

### Version
For now, this package supports **all Laravel versions from 5.3**.

### Composer
In a Bash terminal:
```bash
    composer require pythagus/laravel-file-request
```

## Usage
In this section, we will see how to use the current package features. 

### Access to the whole features
There is **two different ways** to access to the whole features. 

##### Using FileRequestTrait
The ```FileRequestTrait``` trait contains the whole features. You can easily add it into your request, like:

```php
use Illuminate\Foundation\Http\FormRequest;
use Pythagus\LaravelFileRequest\FileRequestTrait;

class FileRequestWithTrait extends FormRequest {
    use FileRequestTrait ;
}
```
With this method, you can use the package features without change your request manager (here ```FormRequest```). Please, check the **Main differences between the ways**.

##### Using FileRequest
The ```FileRequest``` class extends the Laravel default request ```FormRequest``` to keep the Laravel request behaviour. You just have to extend your request from ```Pythagus\LaravelFileRequest\FileRequest```, like:

```php
use Pythagus\LaravelFileRequest\FileRequest;

class FileRequestExamplePost extends FileRequest {
    public function rules() {
        return [
            //
        ] ;
    }
}
```

##### Main differences between the ways
Both of the previous ways allow you to use the whole package features. 
What ```FileRequest``` does that ```FileRequestTrait``` does not:
- Setting up the file request options overriding the ```validated``` method.

### StorageHelper
This package includes a ```StorageHelper``` class to simplify the storage treatment. Using this package, I suggest you to make a method called ```storage``` in your models containing files like:
```php
use Illuminate\Database\Eloquent\Model;
use Pythagus\LaravelFileRequest\Storage\StorageHelper;

class Course extends Model {
    /**
     * Folder name containing all the course files.
     *
     * @const string
     */
    public const FOLDER = 'course_files' ;

    public function storage() {
        return StorageHelper::make(Course::FOLDER, $this->file) ;
    }
}
```

## Configuration
In this section, we will see how to configure the request to manage the file. 

### Request options
The method ```setUp``` can be overwritten in the request file to indicate the file options.
List of the available options:

#### Randomize
The method ```randomize()``` indicates that the file name should be generate randomly. It takes two nullable arguments:
* A **query option**: sometimes, you want a unique file name in a datatable. You must specify the database query and the targetted field.

* The **name length**: you can specify an integer value as second argument to set the name length. *Default value: 16*

```php
public function setUp () {
    $this->setOption('file')
         ->randomize(
             new FileOptionQuery(User::query(), 'avatar'), // Query
             32 // Name length
         ) ;
}
```
> With the above example, the generated file name will be random, and unique in the User datatable at the 'avatar' yield. The generated name length will be 32. 

You can also use the ```randomize()``` method like ```randomize(null, 32) ```. Both of the arguments can be set as null.

####  setFolder
You can specify the folder where the file will be stored:
```php
$this->setOption('file')->setFolder('course_folder') ;
```

#### shouldnExistInFolder
This option is only useful in the random name mode.
The generated file name will be unique in the specified folder:
```php
$this->setOption('file')->shouldnExistInFolder('course_folder') ;
```

### Store the file
If you are not using the request ```validated()``` method:
* Be careful, you are playing with fire :flushed:
* If you overwrote the ```setUp()``` method, you must call it in your controller:
```php
public function method(FileRequestExamplePost $request) {
    $request->setUp() ;
}
```

After that, you can store a file with something like this:
```php
if($request->isUploaded('file')) {
    try {
        $user->avatar = $request->saveFile('file') ;
    } catch(\Exception $e) {
        // An error occurred
    }
}
```

## Architecture
This is the files architecture of the package:

```
.
├── composer.json
├── LICENSE
├── README.md
└── src
    ├── Exceptions
    │   ├── FileRequestException.php
    │   └── UploadFileException.php
    ├── File
    │   ├── FileMime.php
    │   ├── FileOption.php
    │   ├── FileOptionQuery.php
    │   └── FileRule.php
    ├── FileRequest.php
    ├── FileRequestTrait.php
    └── Storage
        ├── NullStorageAttributeException.php
        └── StorageHelper.php

4 directories, 13 files
```

You can generate the previous tree using:
```bash
sudo apt install tree
tree -I '.git|vendor'
```

## Licence
This package is under the terms of the [MIT license](https://opensource.org/licenses/MIT).
