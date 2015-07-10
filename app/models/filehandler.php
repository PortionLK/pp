<?php

    class FileHandler
    {

        private $id;
        private $type;
        private $realname;
        private $size;
        private $uploaded_by;
        private $uploaded_on;

        private $MDatabase;
        private $table_name = "user_files";

        function __construct()
        {

            $MConfig = new Config();
            $this->MDatabase = $MDatabase = new Database($MConfig->host, $MConfig->database, $MConfig->dbuser, $MConfig->dbpassword);

            $this->MDatabase->rowsPerPage = 10;

        }

        function newFile()
        {

            $status = $this->MDatabase->insert($this->table_name, array(
                "type"        => $this->type(),
                "realname"    => $this->realname(),
                "size"        => $this->size(),
                "uploaded_by" => $this->uploadedBy(),
                "uploaded_on" => $this->uploadedOn()
            ));

            $id = mysql_insert_id();
            return $id;

        }

        function type()
        {
            return $this->type;
        }

        function realname()
        {
            return $this->realname;
        }

        function size()
        {
            return $this->size;
        }

        function uploadedBy()
        {
            return $this->uploaded_by;
        }

        //------------------------//

        function uploadedOn()
        {
            return $this->uploaded_on;
        }

        function deleteFile()
        {

            $delete_path = DOC_ROOT . 'uploads/';

            $file = $this->getFileFromId();
            $this->extractor($file);

            unlink($delete_path . $this->realname());

            $status = $this->MDatabase->delete($this->table_name, "id='" . $this->id() . "'");
            return $status;

        }

        function getFileFromId()
        {

            $this->MDatabase->select($this->table_name, "*", "id=" . $this->id());
            return $this->MDatabase->result;

        }

        function id()
        {
            return $this->id;
        }

        function extractor($results, $row = 0)
        {

            $this->setId($results[$row]['id']);
            $this->setType($results[$row]['type']);
            $this->setRealname($results[$row]['realname']);
            $this->setSize($results[$row]['size']);
            $this->setUploadedBy($results[$row]['uploaded_by']);
            $this->setUploadedOn($results[$row]['uploaded_on']);

        }

        function setId($id)
        {
            $this->id = $id;
        }

        function setType($type)
        {
            $this->type = $type;
        }

        function setRealname($realname)
        {
            $this->realname = $realname;
        }

        function setSize($size)
        {
            $this->size = $size;
        }

        function setUploadedBy($uploaded_by)
        {
            $this->uploaded_by = $uploaded_by;
        }

        function setUploadedOn($uploaded_on)
        {
            $this->uploaded_on = $uploaded_on;
        }

    }

?>