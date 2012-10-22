<?php
/**
 * Handles files.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Model_Directory
{
    /**
     * The name of the input we are trying to upload
     *
     * @var string
     */
    private $_inputName;

    /**
     * The max filesize allowed
     *
     * @var string
     */
    private $_maxFilesize;

    /**
     * The ectensions that are allowed
     *
     * @var string
     */
    private $_extensions = array();

    /**
     * The extension that the file is using
     *
     * @var string
     */
    private $_extention;

    /**
     * The MIME types that are allowed
     *
     * @var string
     */
    private $_mimeTypes = array();

    /**
     * Check to see if file exists
     *
     * @var string
     */
    private $_checkForFileExistence;

    /**
     * The real upload location
     *
     * @var string
     */
    private $_uploadLocation;

    /**
     * What to call the file
     *
     * @var string
     */
    private $_fileName;

    /**
     * The error that has occured, if any
     *
     * @var int
     */
    private $_error;

    /**
     * Sets the input name
     *
     * @param string $inputName
     * @return Model_Directory
     */
    public function setInputName($inputName) {
        $this->_inputName = $inputName;
        return $this;
    }

    /**
     * Set the max filesize that the file can be
     *
     * @param int $maxFileSize
     * @return Model_Directory
     */
    public function setMaxFilesize($maxFileSize) {
        $this->_maxFilesize = (int)$maxFileSize;
        return $this;
    }

    /**
     * Set the extentions that the file can have
     *
     * @param array $extensions
     * @return Model_Directory
     */
    public function setExtensions($extensions) {
        $this->_extensions = (array)$extensions;
        return $this;
    }

    /**
     * Sets the MIME types that the file can have
     *
     * @param array $mimeTypes
     * @return Model_Directory
     */
    public function setMimeTypes($mimeTypes) {
        $this->_mimeTypes = (array)$mimeTypes;
        return $this;
    }

    /**
     * Sets whether to not to see if the file exists
     *
     * @param boolean $checkFileForExistence
     * @return Model_Directory
     */
    public function setCheckFileForExistence($checkFileForExistence) {
        $this->_checkForFileExistence = (bool)$checkFileForExistence;
        return $this;
    }

    /**
     * Set the upload destination of the file
     *
     * @param string $uploadLocation
     * @return Model_Directory
     */
    public function setUploadLocation($uploadLocation) {
        $this->_uploadLocation = $uploadLocation;
        return $this;
    }

    /**
     * Set the file name of the file to be
     *
     * @param string $fileName
     * @return Model_Directory
     */
    public function setFileName($fileName) {
        $this->_fileName = $fileName;
        return $this;
    }

    /**
     * Returns the file extension of the uploaded file
     *
     * @return string
     * @return Model_Directory
     */
    public function getExtension() {
        return $this->_extensions;
    }

    /**
     * Returns the complete new base file name
     *
     * @return string
     * @return Model_Directory
     */
    public function getNewFileName() {
        return $this->_fileName . (strlen($this->_extention) >= 1 ? '.' . $this->_extention : '');
    }

    /**
     * Returns the reason for the failed upload
     *
     * @return string
     */
    public function getError() {
        switch ($this->_error) {
            case 1 :
                return 'The file size exceeded the maximum file size of ' . ($this->_maxFilesize / 1024) . 'Kb.';
                break;
            case 2 :
                return 'The file extension used, ' . $this->_extention . ', is not permitted.';
                break;
            case 3 :
                return 'The file type used is not permitted.';
                break;
            case 4 :
                return 'An error occured whilst uploading the file to the Web server.';
                break;
            default :
                return 'An unknown error occured.';
                break;
        }
    }

    /**
     * Uploads a resource to the directory structure
     *
     * @return boolean
     */
    public function uploadResource() {
        // Set some variables
        // Split the filename on .'s
        $extensions = explode('.', basename($_FILES[$this->_inputName]['name']));
        $this->_extention = strtolower($extensions[(count($extensions)-1)]);
        unset($extensions);

        // Perform the checks
        // File size ok?
         if ($this->checkFileSize()) {
            // File extension ok?
            if ($this->checkExtension()) {
                // MIME type ok?
                if ($this->checkMimeType()) {
                    // File more successfully?
                    if ($this->checkMoveFile()) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Checks to see if the file size is ok
     *
     * @return bool
     */
    private function checkFileSize() {
        if (! $_FILES[$this->_inputName]['size'] >= $this->_maxFilesize) {
            $this->_error = 1;
            return false;
        }
        return true;
    }

    /**
     * Checks to see if the extension is ok
     *
     * @return boolean
     */
    private function checkExtension() {
        if (! in_array($this->_extention, $this->_extensions)) {
            $this->_error = 2;
            return false;
        }
        return true;
    }

    /**
     * Checks to see if the MIME type is ok
     *
     * @return boolean
     */
    private function checkMimeType() {
        if (! in_array(strtolower($_FILES[$this->_inputName]['type']), $this->_mimeTypes)) {
            $this->_error = 3;
            return false;
        }
        return true;
    }

    /**
     * Checks to see if the file was moved successfully
     *
     * @return boolean
     */
    private function checkMoveFile() {
        if (! move_uploaded_file($_FILES[$this->_inputName]['tmp_name'],
    		                         $this->_uploadLocation
    		                             . $this->_fileName
    		                                 . '.' . $this->_extention)) {
            $this->_error = 4;
            return false;
        }
        return true;
    }

    /**
     * Removes a resources from the directory structure
     *
     * Notice: This is a recursive function.
     *
     * @param string $resource
     * @return boolean
     */
    public function removeResource($resource) {
		if (!file_exists($resource)) {
			// Doesn't exist, can't delete it!
			return false;
		}
		else if (is_file($resource)) {
			// It's a file, so just delete it
			return unlink($resource);
		}
		else if (is_dir($resource)) {
			// It is a directory! Loop over the contents of it and delete them
			$dir = dir($resource);
			while (false !== $entry = $dir->read()) {
				// We don't want to delete pointers
				if ($entry != '.' && $entry != '..') {
					// Recursion! Delete the resource of the resource
					$this->removeResource("$resource/$entry");
				}
			}

			// We are done deleting resources in the resource
			// Close the dir resource
			$dir->close();
			// Remove the directory we wanted to all along
			return rmdir($resource);
		}
    }
}