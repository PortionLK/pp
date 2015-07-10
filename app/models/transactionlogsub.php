<?php
/**
 * Created by PhpStorm.
 * User: Seevali
 * Date: 2014-08-15
 * Time: 14:22
 */

    class TransactionLogSub {

        private $LogId;
        private $ColumnName;
        private $PreviousValue;
        private $NewValue;

        private $table_name = 'transactionlogsub';
        private $MDatabase;

        function __construct($LogId,$ColumnName,$PreviousValue,$NewValue)
        {
            $MConfig = new Config();
            $this->MDatabase = $MDatabase = new Database($MConfig->host, $MConfig->database, $MConfig->dbuser, $MConfig->dbpassword);
            $this->MDatabase->rowsPerPage = 10;

            $this->LogId=$LogId;
            $this->ColumnName=$ColumnName;
            $this->PreviousValue=$PreviousValue;
            $this->NewValue=$NewValue;
        }

        function insert()
        {
            $status = $this->MDatabase->insert($this->table_name, array(
                "LogId" => $this->LogId,
                "ColumnName" => $this->ColumnName,
                "PreviousValue" => $this->PreviousValue,
                "NewValue" => $this->NewValue
            ));
            return $status;
        }
    }