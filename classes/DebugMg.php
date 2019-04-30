<?php
    class DebugMg {

        private $folderName = 'DebugMg';

        /** Error Paths */
        private $fileName = 'index.json';
        private $archiveFileName = 'archive.json';
        private $fullPath;
        private $archiveFullPath;

        /** Success Paths */
        private $successFileName = 'success.json';
        private $successFullPath;


        public function __construct()
        {
            $this->folderName = $_SERVER['DOCUMENT_ROOT'] .'/hopetracker/' . $this->folderName;

            /** Error Paths */
            $this->fullPath  = $this->folderName . '/' .  $this->fileName;
            $this->archiveFullPath  = $this->folderName . '/' .  $this->archiveFileName;

            /** Success Paths */
            $this->successFullPath  = $this->folderName . '/' .  $this->successFileName;


        }
        public function setError($errors){

            /** $error is an array of data.  */

            /** Create the folder if id does not exists */
            if (!file_exists($this->folderName)) {
                mkdir($this->folderName, 0777, true);
            }

            /** Create the file if it does not exists */
            if (!file_exists($this->fullPath)) {
                $file = fopen($this->fullPath,"a+");
                fclose($file);

            }

            $inp = file_get_contents($this->fullPath);
            $tempArray = json_decode($inp,true);

            /** Add date to the array */
            date_default_timezone_set('America/New_York');
            $errors['Time of Error']  = date('l jS \of F Y h:i A');
            $errors['timestamp']  = time();
            $tempArray[] = $errors;
            $jsonData = json_encode($tempArray);

            if(file_put_contents($this->fullPath, $jsonData)){
                return true;
            }

        }
        public function setSuccess($errors){

            /** $error is an array of data.  */

            /** Create the folder if id does not exists */
            if (!file_exists($this->folderName)) {
                mkdir($this->folderName, 0777, true);
            }

            /** Create the file if it does not exists */
            if (!file_exists($this->successFullPath)) {
                $file = fopen($this->successFullPath,"a+");
                fclose($file);

            }

            $inp = file_get_contents($this->successFullPath);
            $tempArray = json_decode($inp,true);

            /** Add date to the array */
            date_default_timezone_set('America/New_York');
            $errors['Time of Error']  = date('l jS \of F Y h:i A');
            $errors['timestamp']  = time();
            $tempArray[] = $errors;
            $jsonData = json_encode($tempArray);

            if(file_put_contents($this->successFullPath, $jsonData)){
                return true;
            }

        }
        public function deleteErrors(){

            /** Delete the file if it exists and archive the errors*/
            if (file_exists($this->fullPath)) {

                /** Create the archive file if it does not exists */
                if (!file_exists($this->archiveFullPath)) {
                    $file = fopen($this->archiveFullPath,"a+");
                    fclose($file);
                }

                /** Get any existing archived errors */
                $inp = file_get_contents($this->archiveFullPath);
                $tempArray = json_decode($inp,true);

                /** Get any existing current errors */
                $inp = file_get_contents($this->fullPath);
                $tempArray[] = json_decode($inp,true);

                /** Combined both arrays and add to archive file */
                $jsonData = json_encode($tempArray);
                file_put_contents($this->archiveFullPath, $jsonData);

                /** Removed the error file */

                if(unlink($this->fullPath)){
                   return true;
                }
            }
        }
    }