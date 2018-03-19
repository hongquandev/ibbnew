<?php
class Ftp{
    private $_connId = null;
    private $_option = array();
    public function __construct($option) {
        $this->connect($option);
    }

    /**
    @ method : connect
     **/

    public function connect($option) {
        if(empty($this->_option['ftp_server'])) return false;
        $this->_option = $option;
        $this->_connId = @ftp_connect($this->_option['ftp_server']);
        $login = @ftp_login($this->_connId, $this->_option['ftp_user'], $this->_option['ftp_pass']);

        if (!$this->_connId || !$login) {
            //die('FTP : connection has failed!');
        }

        if (!isset($this->_option['ftp_mode'])) {
            $this->_option['ftp_mode'] = FTP_IMAGE;
        }
    }

    public function is_connect() {
        if(empty($this->_option['ftp_server'])) return false;
        $this->_connId = @ftp_connect($this->_option['ftp_server']);
        $login = @ftp_login($this->_connId, $this->_option['ftp_user'], $this->_option['ftp_pass']);

        if (!$this->_connId || !$login) {
            return false;
        }

        if (!isset($this->_option['ftp_mode'])) {
            $this->_option['ftp_mode'] = FTP_IMAGE;
        }
        return true;
    }

    /**
    @ method : copyFile
     **/

    public function copyFile($file, $path) {
        $fileName = $this->validName(basename($file), $path);
        $fp = fopen($file, 'rb');
        if (@ftp_fput($this->_connId, $path.'/'.$fileName, $fp, $this->_option['ftp_mode'])) {
            //echo "Successfully uploaded $file\n";
        } else {
            //echo "FTP : There was a problem while uploading $path/$fileName\n";
        }
    }

    /**
    @ method : copyFolder
     **/

    public function copyFolder($from, $to) {
        if (is_dir($from)) {

            if ($dh = opendir($from)) {
                while (($file = readdir($dh)) !== false) {
                    if (in_array($file, array('.', '..'))) continue;

                    if (is_file($from . '/' . $file)) {
                        $this->copyFile($from . '/' . $file, $to);
                    } else {
                        $this->createFolder($to . '/' . $file);
                        $this->copyFolder($from . '/' . $file, $to . '/' . $file);
                    }
                }
                closedir($dh);
            }
        } else {
            $this->copyFile($from, $to);
        }
    }

    /**
    @ method : deleteFile
     **/

    public function deleteFile($file) {
        if (@ftp_delete($this->_connId, $file)) {
            //echo "$file deleted successful\n";
        } else {
            //echo "could not delete $file\n";
        }
    }

    /**
    @ method : deleteFolder
     **/

    public function deleteFolder($path) {
        $fileAr = @ftp_nlist($this->_connId, $path);
        if (is_array($fileAr) && count($fileAr) > 0) {
            foreach ($fileAr as $file) {
                $fileName = basename($file);

                if (in_array($fileName, array('.', '..'))) continue;

                if (@ftp_size($this->_connId, $path.'/'.$fileName) == -1) {
                    $this->deleteFolder($path.'/'.$fileName);
                } else {
                    $this->deleteFile($path.'/'.$fileName);
                }
            }
        }

        return ftp_rmdir($this->_connId, $path);
    }

    /**
    @ method : listFile
     **/

    public function listFile($path) {
        $rs = array();
        $fileAr = @ftp_nlist($this->_connId, $path);
        if (is_array($fileAr) && count($fileAr) > 0) {
            foreach ($fileAr as $file) {
                $fileName = basename($file);
                if (in_array($fileName, array('.', '..'))) continue;

                if ($this->isExist($path.'/'.$fileName)) {
                    $rs[] = $fileName;
                }
            }
        }
        return $rs;
    }

    /**
    @ method : validName
     **/

    public function validName($fileName, $path) {
        $fileAr = @ftp_nlist($this->_connId, $path);
        if (is_array($fileAr) && count($fileAr) > 0) {
            // push basename to array
            $fileTmpAr = array();
            foreach ($fileAr as $file) {
                array_push($fileTmpAr, basename($file));
            }

            if (!in_array($fileName, $fileTmpAr)) {
                return $fileName;
            }

            $fileNameAr = explode('.', $fileName);
            $ext = $fileNameAr[count($fileNameAr) - 1];
            unset($fileNameAr[count($fileNameAr) - 1]);
            $fileNamePre = implode('.', $fileNameAr);

            $i = 1;
            while($i > 0) {
                $fileName = $fileNamePre.$i.'.'.$ext;
                if (!in_array($fileName, $fileTmpAr)) {
                    return $fileName;
                }
                $i++;
            }
        }

        return $fileName;
    }

    /**
    @ method : createFolder
     **/

    public function createFolder($path) {
        //$path = $this->_option['path'].$path;
        if (@ftp_chdir($this->_connId, $path)) {
            return true;
        } else {
            if (@ftp_mkdir($this->_connId, $path)) {
                if (ftp_chmod($this->_connId, 0777, $path) !== false) {

                };
                return true;
            } else {
                echo 'FTP : Can not create folder '.$path;
            }
        };
        return false;
    }

    /**
    @ method : createFolders
     **/

    public function createFolders($path, $level) {
        $ar = explode('/', $path);
        $total = count($ar);
        if ($total < $level) return ;

        $path1 = '';
        for ($i = 0; $i < $total - $level; $i++) {
            $path1 .= $ar[$i].'/';
        }

        $path1 = rtrim($path1, '/');

        for ($i = $total - $level; $i < $total; $i++) {
            $path1 .= '/'. $ar[$i];
            if (!$this->createFolder($path1)) {
                return false;
            }
        }
    }

    /**
    @ method : getFilenamePre
     **/

    public function getFilenamePre($file) {
        $fileNameAr = explode('.', $file);
        $ext = $fileNameAr[count($fileNameAr) - 1];
        unset($fileNameAr[count($fileNameAr) - 1]);
        $fileNamePre = implode('.', $fileNameAr);
        return $fileNamePre;
    }

    /**
    @ method : isExist
    ---
    is file
     **/

    public function isExist($path) {
        //$path = $this->_option['path'].$path;
        if (@ftp_size($this->_connId, $path) == -1) {
            return false;
        }
        return true;
    }

    /**
    @ method : readFile
     **/

    public function readFile($from, $to) {
        if (@ftp_get($this->_connId, $to, $from, $this->_option['ftp_mode'], 0)) {
            return true;
        }
        echo 'FTP:read fail '.$to.'->'.$from;
        return false;
    }

    /**
    @ method : renameFile
     **/

    public function renameFile($path, $oldFile, $newFile) {
        if (@ftp_rename($this->_connId, rtrim($path, '/') .'/'. $oldFile, rtrim($path, '/'). '/' . $newFile)) {

        } else {
            echo "FTP : There was a problem while renaming $oldFile to $newFile\n";
        }
    }

    /**
    @ method : reConnect
     **/

    public function reConnect() {
        $this->closeConnect();
        $this->connect($this->_option);
    }

    /**
    @ method : closeConnect
     **/

    public function closeConnect() {
        @ftp_close($this->_connId);
    }
}
