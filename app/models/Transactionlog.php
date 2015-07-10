<?php
/**
 * Created by PhpStorm.
 * User: Seevali
 * Date: 2014-08-15
 * Time: 09:29
 */

    class TransactionLog {

        private $LogId;
        private $HotelId;
        private $Section;
        private $ActionType;
        private $ActionBy;
        private $ActionDate;
        private $TableName;

        private $Obj;
        private $NewObj;

        private $table_name = 'transactionlog';
        private $MDatabase;

        function __construct($HotelId,$Section,$ActionType,$ActionBy,$TableName,$Obj,$NewObj)
        {
            $MConfig = new Config();
            $this->MDatabase = $MDatabase = new Database($MConfig->host, $MConfig->database, $MConfig->dbuser, $MConfig->dbpassword);
            $this->MDatabase->rowsPerPage = 10;

            $this->HotelId=$HotelId;
            $this->Section=$Section;
            $this->ActionType=$ActionType;
            $this->ActionBy=$ActionBy;
            $this->ActionDate=date('y-m-d H:m:s');
            $this->TableName=$TableName;
            $this->Obj=$Obj;
            $this->NewObj=$NewObj;
        }

        function log(){
            if($this->ActionType=='Insert'){
                if($this->insert()){
                    $TransactionLogSub = new TransactionLogSub($this->MDatabase->insert_id(),'All','',urlencode(serialize($this->Obj)));
                    return $TransactionLogSub->insert();
                }
            }else if($this->ActionType=='Update'){
                if($this->insert()){
                    $x=0;
                    $insert_id=$this->MDatabase->insert_id();
                    foreach($this->Obj as $key => $value){
                        if($key == 'settings' || $key == 'MDatabase' || $key == 'table_name'){
                            //continue;
                        }else {
                            if(array_key_exists($key, $this->NewObj)) {
                                if ($value <> $this->NewObj[$key]) {
                                    $TransactionLogSub = new TransactionLogSub($insert_id, $key, $value, $this->NewObj[$key]);
                                    $TransactionLogSub->insert();
                                    $TransactionLogSub=null;
                                }
                            }
                        }
                        $x=$x+1;
                    }
                }
            }else if($this->ActionType=='Delete'){
                if($this->insert()){
                    $TransactionLogSub = new TransactionLogSub($this->MDatabase->insert_id(),'All',urlencode(serialize($this->Obj)),'');
                    return $TransactionLogSub->insert();
                }
            }
        }

        function insert()
        {
            $status = $this->MDatabase->insert($this->table_name, array(
                "HotelId" => $this->HotelId,
                "Section" => $this->Section,
                "ActionType" => $this->ActionType,
                "ActionBy" => $this->ActionBy,
                "ActionDate" => $this->ActionDate,
                "TableName" => $this->TableName
            ));
            return $status;
        }


    }
