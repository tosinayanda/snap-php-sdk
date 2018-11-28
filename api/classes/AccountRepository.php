<?php

namespace myApp;

global $dbc;

class AccountRepository
{
    private $databaseconnection;
    private $tablename;

    
    function __construct()
    {
        global $dbc;
        $this->tablename="t24_account_tablenew";
        $this->databaseconnection=$dbc;
    }

    function GetAll()
    {
        $tablename=$this->tablename;
        $q = mysqli_query($this->databaseconnection,"SELECT * FROM $tablename LIMIT 100");
       // $q = mysqli_query($dbc,"SELECT * FROM $tablename where status='Active' AND snapid != ''");
        while ($data = mysqli_fetch_assoc($q))
        {
          $records[]=$data;
        }	
        return $records;
       
    }
    function GetAllFromT24()
    {
        $tablename=$this->tablename;
        $q = mysqli_query($this->databaseconnection,"SELECT * FROM t24snapaccounts LIMIT 100");
       // $q = mysqli_query($dbc,"SELECT * FROM $tablename where status='Active' AND snapid != ''");
        while ($data = mysqli_fetch_assoc($q))
        {
          $records[]=$data;
        }	
        return $records;
       
    }
    function GetById($recordid)
    {
        
        $record=null;
       
        $tablename=$this->tablename;
        $recordquery=mysqli_query($this->databaseconnection,"SELECT * FROM $tablename
         where `ids`='$recordid' || `t24customerid`='$recordid'");

        if($recordquery)
        {
            $record=mysqli_fetch_array($recordquery);
            //return null;
        }

        return $record;
    }
    function AddNewComplaint($body)
    {
        $tablename=$this->tablename;
        $keys="";
        $values="";
        $record=null;

        // $auto1 = mysqli_query($dbc,"SHOW TABLE status LIKE '$tablename'");
        //$autoidnumber = $auto1data['Auto_increment'] =='' ? 1: $auto1data['Auto_increment']
        $id=$this->GenerateId();

        $body["t24id"]=$id;
        $body["t24customerid"]=$id;

        foreach ($body as $key => $value) {

            $keys.="`$key`,";
            $values.="'".trim($value)."',";
        }

        $keys= mb_substr($keys, 0, -1); 
        $values= mb_substr($values, 0, -1); 
        
        $recordquery=mysqli_query($this->databaseconnection,
        "INSERT INTO $tablename ($keys) VALUES($values)");

        if($recordquery=1)
        {
            //return createdresource
           //$record=$body;
           $record=$this->GetComplaintById($id);
        }

        return $record;

    }
    function UpdateComplaint($recordid,$body)
    {
        $tablename=$this->tablename;
        $key_values="";
        $record=null;

        foreach ($body as $key => $value)
        {
            if($key==="ids")
            {
                continue;
            }
            if($value==null || $value==''){
                continue;
            }
            $key_values.="`$key`='".trim($value)."',";
        }
        
        $key_values= mb_substr($key_values, 0, -1);
        //return  $key_values;
        //return "UPDATE $tablename SET $key_values where `ids`='$recordid' || `t24customerid`='$recordid'";

        $recordquery=mysqli_query($this->databaseconnection,"UPDATE `$tablename` SET $key_values
        where `ids`='$recordid' || `t24customerid`='$recordid'");

        if($recordquery=1)
        {
            //return updated resource
            $record=$this->GetComplaintById($recordid);
        }
        return $record;
    }
    function RemoveComplaint($recordid)
    {
        $record=false;
        $tablename=$this->tablename;
        $recordquery=mysqli_query($this->databaseconnection,"DELETE FROM $tablename
         where `ids`='$recordid' || `t24customerid`='$recordid'");
        if($recordquery)
        {
            $record=true;
        }
        return $record;
    }
    function GenerateId(){
        $letter='';
            for($i=1;$i<=7;$i++)
            {
            //	$letter .= chr(rand(97,122));
                $letter .= chr(rand(65,90));
            }
           // echo $letter;
           return $letter;
    }
}