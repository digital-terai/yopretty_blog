<?php namespace App\maguttiCms\Tools;

use Input;
Use Form;
Use App;

class UploadManager
{

    protected $model;

    protected $newMedia;            // file object
    protected $fileFullName;        // full filename
    protected $fileBaseName;        // filename  without extension
    protected $fileExtension;       // file extension
    protected $mediaType;           // media type  doc or image
    protected $destinationStorage;  // media destination storage
    protected $destinationPath;     // media destination path

    /**
     * @param $media
     * @param $model
     * @return $this
     */
    public function init($media, $request, $disk = '', $folder = '')
    {
        $this->media = $media;
        $this->request = $request;

        if ($disk) {
            $this->destinationStorage = $disk;
            $this->destinationPath = $folder;
        } else {
            $this->destinationStorage = 'media';
            $this->destinationPath = '';
        }

        return $this;
    }

    protected function prepareMediaToUpload()
    {
        if (Input::hasFile($this->media) && Input::file($this->media)->isValid()) {
            $this->newMedia = Input::file($this->media);
            $this->setFileFullName($this->newMedia->getClientOriginalName());
            if ($this->destinationStorage == 'media' && !$this->destinationPath) {
                $this->destinationPath = $this->getMediaType();
            }
            $this->fileNameHandler();
            return true;
        }
        return false;
    }

    /**
     * Store function uploading
     * file to given path;
     * @return $this
     */
    public function store()
    {
        if ($this->prepareMediaToUpload()) {
            $this->request->file($this->media)->storeAs(
                $this->destinationPath,
                $this->getFileFullName(),
                $this->destinationStorage
            );
        }
        return $this;
    }

    /**
     * Rename the file name if
     * if already exist
     * @return $this
     */
    public function fileNameHandler()
    {
        if ($this->verifyIfFileExist()) {
            $newFileName = Str::slug(rand(10000, 99999) . '_' . $this->getFileBaseName()) . "." . $this->getFileExtension();
            $this->setFileFullName($newFileName);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getDestinationPath()
    {
        return $this->destinationPath;
    }

    /**
     *
     * @return bool
     */
    protected function verifyIfFileExist()
    {
        return \Storage::disk($this->destinationStorage)->exists($this->destinationPath . '/' . $this->getFileFullName());
    }

    /**
     * @return mixed
     */
    protected function getFileExtension()
    {
        return $this->fileExtension = $this->newMedia->getClientOriginalExtension(); // getting image extension
    }


    /**
     * @return mixed
     */
    public function getFileBaseName()
    {
        return $this->fileBaseName = basename($this->newMedia->getClientOriginalName(), '.' . $this->newMedia->getClientOriginalExtension());
    }

    /**
     * @return string
     */
    public function getMediaType()
    {
        return $this->mediaType = (is_image($this->newMedia->getMimeType()) == 'image') ? 'images' : 'docs';
    }

    /**
     * @return mixed
     */
    public function getFileFullName()
    {
        return $this->fileFullName;
    }

    /**
     * @param mixed $fileName
     */
    public function setFileFullName($fileName)
    {
        $this->fileFullName = $fileName;
    }

    /**
     * Store file attributes
     * @return array
     */
    public function getFileDetails()
    {
        return [
            'basename' => $this->getFileBaseName(),
            'fullName' => $this->getFileFullName(),
            'extension' => $this->getFileExtension(),
            'fullPath' => $this->getDestinationPath(),
            'mimeType' => $this->newMedia->getMimeType(),
            'mediaType' => $this->getMediaType(),
            'size' => $this->newMedia->getClientSize(),
        ];
    }
}
