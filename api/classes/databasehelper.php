<?php

namespace myApp;

trait DatabaseHelper
{
    function InsertDataIntoDatabase($postbody){
        global $applicationname;
        global $formfields;
        global $dbc;
        global $tablename;
        global $result;

        $formfields=$postbody;
        //Audit trail for form Access
        InsertAuditables();
        //CREATE TABLE FUNCTIONS
	    createtable($tablename,$formfields,$dbc);
        //INSERT INTO DATABASE        
        insertdata($tablename,$formfields,$dbc);
    }
    function UpdateDataInDatabase($postbody,$recordid){
        global $applicationname;
        global $formfields;
        global $dbc;
        global $tablename;
        global $result;

        $formfields=$postbody;
        //Audit trail for form Access
        InsertAuditables();
        //CREATE TABLE FUNCTIONS
	     createtable($tablename,$formfields,$dbc);
        //INSERT INTO DATABASE        
         updatedata($tablename,$formfields,$dbc,$recordid);
         UnLockRecord($formfields['snapid']);
    }
    function DeleteDataInDatabase($recordid){
        global $applicationname;
        global $dbc;
        global $tablename;
        global $result;

        //DELETE FROM DATABASE        
        deletedata($tablename,$dbc,$recordid);
    }
    function ReverseDataInDatabase($recordid){
        global $applicationname;
        global $dbc;
        global $tablename;
        global $result;

        //DELETE FROM DATABASE        
        reversedata($tablename,$dbc,$recordid);
    }
   
    function ApproveRecord($postbody,$recordid){
        global $applicationname;
        global $formfields;
        global $dbc;
        global $tablename;
        global $result;

        $formfields=$postbody;
        //var_dump($formfields);
        //Audit trail for form Access
        InsertAuditables();    
        $SNAP_AUT=$formfields['SNAP_AUT'];   
        if($applicationname=="ACCOUNT"){
            $query = "UPDATE `$tablename` SET `status`='Active',`POSTING_RESTRICT`='',`rejection_note`='', `SNAP_AUT`='$SNAP_AUT' WHERE ids=$recordid";
        }
        else{
            $query = "UPDATE `$tablename` SET `status`='Active',`rejection_note`='',`SNAP_AUT`='$SNAP_AUT' WHERE ids=$recordid";
        }

        //echo $query;
        //exit();
        $result = mysqli_query($dbc,$query);
        
        if($result=1){
            //echo "it is successfully done inserts";
            InsertDataIntoT24Ref($formcontent);
        }else
        {
                //echo "sorry insert not successful";
                echo mysqli_error(0);      
        }
        UnLockRecord($formfields['snapid']);
    }
    function RejectRecord($postbody,$recordid){
        global $applicationname;
        global $formfields;
        global $dbc;
        global $tablename;
        global $result;

        $formfields=$postbody;
        //Audit trail for form Access
        InsertAuditables();       
        $rejectionnote=trim($formfields['rejection_note']);

        $querycheck="SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE
          (table_name = $tablename)
          AND (table_schema = 'inlakssnapnewdb2')
          AND (column_name = 'rejection_note')";

         $checkresult = mysqli_query($dbc,$query);

         if($checkresult=1)
         {
            $query = "UPDATE `$tablename` SET `rejection_note`='$rejectionnote' WHERE ids=$recordid";
         }
         else
         {
            $query = "ALTER TABLE `$tablename` ADD `rejection_note` varchar(255);
            UPDATE `$tablename` SET `rejection_note`='$rejectionnote' WHERE ids=$recordid";
         }

        // var_dump($checkresult);
        // echo $query;
        // exit();

       $result = mysqli_query($dbc,$query);
        
        if($result=1){
            echo "it is successfully done inserts";
        }else
        {
                //echo "sorry insert not successful";
                echo mysqli_error(0);      
        }
        UnLockRecord($formfields['snapid']);
        
    }
    function InsertAuditables(){
        global $dbc;
        global $applicationname;
        global $ipaddress1;
        global $clientcomputername;
        global $date1;
        global $username1;
        global $functions;
       
        $audittrail = "INSERT INTO audittables(`id`,`application_name`,`functions`, `username`,`date`,`description`,`status`,`ip_address`,`host_name`)
         VALUES ('$id','$applicationname Creation Form','$functions','$username1','$date1','$username1 Accessed Customer Creation Form at $time on $clientcomputername ','Form Opened','$ipaddress','$clientcomputername')";
       // echo "Auditing ".$audittrail;    
        $auditquiry = mysqli_query($dbc,$audittrail) or mysqli_connect_error("Error");      
    }
    function updatedata($tablename,$formfields,$dbc,$recordid){
        global $dbc;
        global $tablename;
        global $formfields;
        global $result;
        global $recordid;
        global $type;
        
        $key_values="";
        //$MNEMONIC='MNEMONIC';
        foreach ($formfields as $key => $value) {
            if($value==null || $value==''){
                continue;
            }
            $key_values.="`$key`='".trim($value)."',";
         //   echo "$key=$value";
        }
        //echo $key_values;
        //var_dump($formcontent);
        //exit();
        $key_values= mb_substr($key_values, 0, -1); 
        
        if($tablename="snapuserroles")
        {
            $query = "UPDATE `$tablename` SET $key_values WHERE `name`='$type'";
        }
        else
        {
            $query = "UPDATE `$tablename` SET $key_values WHERE ids=$recordid";
        }
       
        $result = mysqli_query($dbc,$query);
      //  echo $query;

        if($result=1){
                //echo "it is successfully done inserts";
        }else
        {
                //echo "sorry insert not successful";
                echo mysqli_error(0);      
        }

    }
    function deletedata($tablename,$dbc,$recordid){
        global $dbc;
        global $tablename;
        global $result;
        global $recordid;
        //$formfields=$_POST;
        $query = "DELETE  FROM `$tablename` WHERE ids=$recordid";
        $result = mysqli_query($dbc,$query);

        //echo $query;

        if($result=1){
              //  echo "it is successfully done delete";
        }else
        {
                //echo "sorry delete not successful";
                echo mysqli_error(0);      
        }

    }
    function reversedata($tablename,$dbc,$recordid){
        global $dbc;
        global $tablename;
        global $result;
        global $recordid;
        //$formfields=$_POST;
        //var_dump($_SESSION);
      //  exit;
        $query = "UPDATE `$tablename` SET `status`='INAU',`REVERSE_RECORD`='true' WHERE ids=$recordid";
        $result = mysqli_query($dbc,$query);

        echo $query;

        if($result=1){
            //  echo "it is successfully done delete";
        }else
        {
              //  echo "sorry delete not successful";
                echo mysqli_error(0);      
        }

    }
    function InsertDataIntoT24Ref($postbody)
    {
        global $applicationname;
        global $formfields;
        global $dbc;
        global $tablename;
        global $result;
        global $snapid;

        if($applicationname=="ACCOUNT" ||  $applicationname=="CUSTOMER")
        {
            //var_dump($postbody);
            if($applicationname=="ACCOUNT"){
                global $ACCOUNT_TITLE_1;
                $query = "INSERT INTO t24snapaccounts(`@ID`,`SHORT_TITLE`) VALUES('$snapid','$ACCOUNT_TITLE_1')";
            }
            elseif($applicationname=="CUSTOMER"){
                $SHORT_NAME=$postbody['SHORT_NAME'];
                $NAME_1=$postbody['NAME_1'];
                $NAME_2=$postbody['NAME_2'];
                $query = "INSERT INTO t24snapcustomers(`@ID`,`SHORT_NAME`) VALUES('$snapid','$SHORT_NAME $NAME_1 $NAME_2')";
            }
    
          // echo $query;
           $result = mysqli_query($dbc,$query);
            
            if($result=1){
                //echo "it is successfully done inserts";
            }else
            {
                    //echo "sorry insert not successful";
                    echo mysqli_error(0);      
            }
        }
       
        

    }
    function get_t24_customers()
    {
        global $dbc;
        $customerrecords= mysqli_query($dbc,"SELECT `@ID`, `SHORT_NAME` as SHORT_TITLE FROM t24snapcustomers");;
        return $customerrecords;
    }
    function get_t24_accounts()
    {
        global $dbc;

        $accountrecords= mysqli_query($dbc,"SELECT `@ID`, SHORT_TITLE FROM t24snapaccounts");
        return $accountrecords;
    }
    function setT24WorkingDate(){
        global $dbc;
        global $t24WorkingDate;
        $query="SELECT LAST_WORKING_DAY FROM `t24systemdates` ORDER BY LAST_WORKING_DAY DESC LIMIT 1";
        $response= mysqli_query($dbc,$query);
        $t24WorkingDate= mysqli_fetch_row($response)[0];
        //echo $t24WorkingDate;
        //exit();
        // return $t24WorkingDate;
    }
	function IsRecordLocked($recordid)
	{
		global $applicationname;
        global $formfields;
        global $dbc;
        global $tablename;
        global $result;
        global $action;
		
		//echo "$recordid In there";
		$recordstatus= mysqli_query($dbc,"SELECT LOCKED_STATUS,LOCKED_BY,LOCKED_DATE FROM snaprecordlocker WHERE `id`='$recordid'");
		
		$output="";
        $recordstatus=mysqli_fetch_assoc($recordstatus);
        
       // var_dump($recordstatus);
		if($recordstatus["LOCKED_STATUS"]=="true")
		{
            $username=$_SESSION['username'];
            if($recordstatus["LOCKED_BY"]!=$username)
            {
                $lockdate=$recordstatus["LOCKED_DATE"];
                $lockedby=$recordstatus["LOCKED_BY"];
                $output="<div class='alert alert-danger container'>This Record was locked by $lockedby on $lockdate</div>";
                echo $output;
                exit();
            }
            
        }
        else
        {
            if($action=="edit" || $action=="approve")
            {
                $mode=$recordstatus==NULL?"create":"update";
                //echo $mode;
                //exit;
                LockRecordDuringEdit($recordid,$mode);
            }
            
            
        }
		
		
	} 	
	function LockRecordDuringEdit($recordid,$mode)
	{
		global $applicationname;
        global $formfields;
        global $dbc;
        global $tablename;
        global $result;
		
		$username=$_SESSION['username'];
		$lockdate=date('Y/m/d H:m:s');
        if($mode=="create")
        {
            $recordstatus= mysqli_query($dbc,"INSERT INTO snaprecordlocker (`id`,`LOCKED_STATUS`,`LOCKED_BY`,`LOCKED_DATE`) 
            VALUES('$recordid','true','$username','$lockdate')");
        }
        else
        {
            $recordstatus= mysqli_query($dbc,"UPDATE snaprecordlocker SET LOCKED_STATUS='true',
            LOCKED_BY='$username',LOCKED_DATE='$lockdate' WHERE `id`='$recordid'");
        }
	}
	function UnLockRecord($recordid)
	{
		global $applicationname;
        global $formfields;
        global $dbc;
        global $tablename;
        global $result;
        $recordstatus= mysqli_query($dbc,"UPDATE snaprecordlocker SET LOCKED_STATUS='',LOCKED_BY='',LOCKED_DATE='' WHERE `id`='$recordid'");
       // echo $recordid ."Done";
	}
}