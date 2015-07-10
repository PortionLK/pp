<?php
	class MemberBankDetails
    {
		public $timestamps = false;

        function __construct()
        {

            $MConfig = new Config();
            $this->MDatabase = $MDatabase = new Database($MConfig->host, $MConfig->database, $MConfig->dbuser, $MConfig->dbpassword);

            $this->MDatabase->rowsPerPage = 10;

        }

        function extractor($results, $row = 0)
        {

            $this->setBankId($results[$row]['bank_id']);
            $this->setBankMemberId($results[$row]['bank_member_id']);
            $this->setBankName($results[$row]['bank_name']);
            $this->setBankBranch($results[$row]['bank_branch']);
            $this->setBankAccountNumber($results[$row]['bank_account_number']);
            $this->setBankAccountName($results[$row]['bank_account_name']);
            $this->setBankAccountAddress($results[$row]['bank_account_address']);

        }

        function setBankId($bank_id)
        {
            $this->bank_id = $bank_id;
        }

        function setBankMemberId($bank_member_id)
        {
            $this->bank_member_id = $bank_member_id;
        }

        function setBankName($bank_name)
        {
            $this->bank_name = $bank_name;
        }

        function setBankBranch($bank_branch)
        {
            $this->bank_branch = $bank_branch;
        }

        function setBankAccountNumber($bank_account_number)
        {
            $this->bank_account_number = $bank_account_number;
        }

        //------------------------//

        function setBankAccountName($bank_account_name)
        {
            $this->bank_account_name = $bank_account_name;
        }

        function setBankAccountAddress($bank_account_address)
        {
            $this->bank_account_address = $bank_account_address;
        }

        function newMemberBankDetails()
        {

            $status = $this->MDatabase->insert($this->table_name, array(
                "bank_member_id"       => $this->bankMemberId(),
                "bank_name"            => $this->bankName(),
                "bank_branch"          => $this->bankBranch(),
                "bank_account_number"  => $this->bankAccountNumber(),
                "bank_account_name"    => $this->bankAccountName(),
                "bank_account_address" => $this->bankAccountAddress()
            ));

            return $status;

        }

        function bankMemberId()
        {
            return $this->bank_member_id;
        }

        function bankName()
        {
            return $this->bank_name;
        }

        function bankBranch()
        {
            return $this->bank_branch;
        }

        function bankAccountNumber()
        {
            return $this->bank_account_number;
        }

        function bankAccountName()
        {
            return $this->bank_account_name;
        }

        function bankAccountAddress()
        {
            return $this->bank_account_address;
        }

        function updateMemberBankDetails()
        {

            $status = $this->MDatabase->update($this->table_name, array(
                "bank_member_id"       => $this->bankMemberId(),
                "bank_name"            => $this->bankName(),
                "bank_branch"          => $this->bankBranch(),
                "bank_account_number"  => $this->bankAccountNumber(),
                "bank_account_name"    => $this->bankAccountName(),
                "bank_account_address" => $this->bankAccountAddress()
            ), array("bank_id" => $this->bankId()));

            return $status;

        }

        function bankId()
        {
            return $this->bank_id;
        }

        function getAllMemberBankDetailsPaginated($page)
        {
            $this->MDatabase->select($this->table_name, "*", "", "", $page);
            return $this->MDatabase->result;
        }

        function getAllMemberBankDetailsCount()
        {
            $this->MDatabase->select($this->table_name, "COUNT(*) as count", "", "", $page);
            return $this->MDatabase->result;
        }

        function getMemberBankDetailsFromId()
        {
            $this->MDatabase->select($this->table_name, "*", "bank_id='" . $this->bankId() . "'");
            return $this->MDatabase->result;
        }

        function deleteMemberBankDetails()
        {
            $status = $this->MDatabase->delete($this->table_name, "bank_id='" . $this->bankId() . "'");
            return $status;
        }

        function setValues($data)
        {

            foreach ($data as $k => $v) {
                $this->$k = $v;
            }

        }

    }

?>