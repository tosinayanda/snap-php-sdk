<?php

    global $validationerrors;
    global $t24WorkingDate;

    function ValidateFundsInput($postbody){
        global $validationerrors;
        global $formcontent;
        global $t24WorkingDate;

        // echo "FUNCTION LOGIC ACTIVE";
            //echo $t24WorkingDate;
            $workingdate=new DateTime($t24WorkingDate);
            $workingdate= $workingdate->format('Ymd');
            
        //	 var_dump($postbody);
            
            // exit();
	  if($postbody['DEBIT_ACCT_NO'] === $postbody['CREDIT_ACCT_NO']){
        
           $validationerrors.="<br/>Credit Account cannot be equal to Debit Account";
       }

       if($postbody['DEBIT_VALUE_DATE'] > $postbody['CREDIT_VALUE_DATE']){
        
           $validationerrors.="<br/>Credit Date cannot be Less than Debit Date".$t24WorkingDate;
       }
	    if ($postbody['DEBIT_VALUE_DATE'] > $workingdate)
		{
			 $validationerrors.="<br/>Debit Date cannot be Greater than T24 Working Date".$t24WorkingDate;
		}
		if ($postbody['CREDIT_VALUE_DATE'] > $workingdate)
		{
			 $validationerrors.="<br/>Credit Date cannot be Greater than T24 Working Date";
		}
		
       // if ($postbody['DEBIT_VALUE_DATE'] >= $postbody['CREDIT_VALUE_DATE'])
       // {
           // $date1=new DateTime($postbody['DEBIT_VALUE_DATE']);
           // $date2=new DateTime($t24WorkingDate);
       
           // if(($date1->diff($date2)->d)<50){
              // // $x=date_sub($date, date_interval_create_from_date_string('50 days'));
               // // $x= $date1->sub(new DateInterval('P50D'));
               // // $validationerrors.="<br/>Debit Date ".$date1->format('d-m-Y')." has to be earlier than ".$x->format('d-m-Y');
              // // echo $x->format('Y-m-d');
           // }
       // }
    };
    function ValidateCustomerInput($postbody){
        global $validationerrors;
        global $formcontent;
        global $t24WorkingDate;

       // echo "FUNCTION LOGIC ACTIVE";
        $todaydate=new DateTime($t24WorkingDate);

        if($postbody['SECTOR']=='' || $postbody['SECTOR']==null){
            $validationerrors.="Sector Field is Missing" .'/n';
        }

        if(isset($postbody['DATE_OF_BIRTH']) && $postbody['DATE_OF_BIRTH']!="")
        {
            //echo $todaydate->format('Y-m-d');
            //echo $postbody['DATE_OF_BIRTH'];
            $datebirth=new DateTime($postbody['DATE_OF_BIRTH']);
            //echo $datebirth->format('Y-m-d');
           // exit();
            if($datebirth < $todaydate)
            {
              $validationerrors.="<br/>  Customer Pay Date cannot be Less than Today's Date";
            }
        }
        if($postbody['INDUSTRY']=='' || $postbody['INDUSTRY']==null){
            $validationerrors.="Industry Field is Missing" .'/n';
        }
        if($postbody['OPENING_DATE'] < $postbody['BIRTH_INCORP_DATE']){
         //   echo $postbody['OPENING_DATE'] .' '.  $postbody['BIRTH_INCORP_DATE'];
            $validationerrors.="<br/>Customer Birth Date cannot be Less than Customer Oppening Date";
        }
        else
        {
            $date1=new DateTime($postbody['OPENING_DATE']);
            $date2=new DateTime($postbody['BIRTH_INCORP_DATE']);

            if(($date2->diff($date1)->y)<1){
                //var_dump($date2->diff($date1)->y);
                $validationerrors.="<br/>Customer Birth Date cannot be Less than Customer Opening Date (Customer cannot have zero(0) age)";
            }
        }
 
     };
    function ValidateLoanInput($postbody){
        // echo "FUNCTION LOGIC ACTIVE";
        global $validationerrors;
        global $t24WorkingDate;

        $todaydate=new DateTime($t24WorkingDate);
        $todaydate=$todaydate->format('Ymd');
        echo $todaydate;
        
        echo $postbody['VALUE_DATE'];
        echo $postbody['AGREEMENT_DATE'];
        
        echo $postbody['FIN_MAT_DATE'];

       

        if($postbody['VALUE_DATE'] != $postbody['AGREEMENT_DATE']){
            //echo "Yay";
            $validationerrors.="<br/>Value Date is not equal Loan Approval Date";
        }
		if($postbody['CHRG_CLAIM_DATE'] > $postbody['VALUE_DATE']){
            //echo "Yay";
            $validationerrors.="<br/>Charge Claim Date cannot be greater than Value Date";
        }
           if($postbody['VALUE_DATE'] > $todaydate){
               //echo "Yay";
               $validationerrors.="<br/>Value Date cannot be greater than Today's Date";
           }
           if($postbody['FIN_MAT_DATE'] <= $todaydate){
               $validationerrors.="<br/>Fin Mat Date must be greater than Today's Date";
           }
            if($postbody['AGREEMENT_DATE'] > $todaydate){
               $validationerrors.="<br/>Loan Approved Date cannot be greater than Today's Date";
           }
 
     }; 
    function ValidateAccountInput($postbody){
        // echo "FUNCTION LOGIC ACTIVE";
          global $t24WorkingDate;
          global $validationerrors;

          setT24WorkingDate();
         // $validationerrors.="Current T24 Date is ".t24WorkingDate.' <br/>';
        
     };
     function ValidateMoneyMarketInput($postbody){
        //echo "FUNCTION LOGIC ACTIVE";
        //var_dump($postbody);
        global $validationerrors;
        $todaydate=new DateTime($t24WorkingDate);
        $todaydate=$todaydate->format('Ymd');
        //echo $todaydate;

           if($postbody['VALUE_DATE'] > $todaydate){
               //echo "Yay";
               //echo $postbody['OPENING_DATE'] .' '.  $postbody['BIRTH_INCORP_DATE'];
               $validationerrors.="<br/>Value Date cannot be Less than Today's Date";
           }
           if($postbody['DEAL_DATE'] > $todaydate){
            //   echo $postbody['OPENING_DATE'] .' '.  $postbody['BIRTH_INCORP_DATE'];
               $validationerrors.="<br/>Deal Date cannot be greater than Today's Date";
           }
            if($postbody['VALUE_DATE'] < $postbody['DEAL_DATE']){
            //   echo $postbody['OPENING_DATE'] .' '.  $postbody['BIRTH_INCORP_DATE'];
               $validationerrors.="<br/>Value Date cannot be Less than Deal Date";
           }

           if($postbody['MATURITY_DATE'] < $postbody['DEAL_DATE']){
            //   echo $postbody['OPENING_DATE'] .' '.  $postbody['BIRTH_INCORP_DATE'];
               $validationerrors.="<br/>Maturity Date cannot be Less than Deal Date";
           }

           $date1=new DateTime($postbody['VALUE_DATE']);
           $date2=new DateTime($t24WorkingDate);

           if(($date1->diff($date2)->d)<7){
               //var_dump($date2->diff($date1)->y);
               $x= $date2->sub(new DateInterval('P7D'));
            //   $validationerrors.="<br/>Deal Date cannot be less than Process Date ".$x->format('d-m-Y');
           }
     };
    function ValidateInput($postbody){
       
        global $applicationname;
        setT24WorkingDate();
         // echo "FUNCTION LOGIC ACTIVE";
         
        if($applicationname =='FUNDS.TRANSFER'){
            ValidateFundsInput($postbody);
        }
        elseif($applicationname =='CUSTOMER'){
            ValidateCustomerInput($postbody);
        }
        elseif($applicationname =='LD.LOANS.AND.DEPOSITS'){
            ValidateLoanInput($postbody);
        }
        elseif($applicationname =='ACCOUNT'){
            ValidateAccountInput($postbody);
        }
        elseif($applicationname =='MM.MONEY.MARKET'){
            ValidateMoneyMarketInput($postbody);
        }
        else{

            return null;
        }
     };

    function GenerateSnapId($tablename){
        global $tablename;
        global $dbc;
        global $applicationname;
        global $branch;
        $id='';
		
		if(isset($_POST['snapid']))
        {
            return $_POST['snapid'];
            //var_dump($_POST);
            //exit();
        }

       // $auto1 = mysqli_query($dbc,"SHOW TABLE status LIKE '$tablename'");
        $auto1 = mysqli_query($dbc,"SELECT count FROM snapidtracker WHERE `tablename`='$tablename'");
        //var_dump($auto1);
        $auto1data=mysqli_fetch_assoc($auto1);
       // var_dump($auto1data); 
       // $autoidnumber = $auto1data['Auto_increment'] =='' ? 1: $auto1data['Auto_increment'];
       $autoidnumber = $auto1data['count'] =='' ? 1: $auto1data['count'];
       $auto1 = mysqli_query($dbc,"UPDATE snapidtracker SET `count`= ($autoidnumber+1) WHERE `tablename`='$tablename'");
        //echo $autoidnumber;

        if($applicationname =='FUNDS.TRANSFER'){
            $num="SNAP/FT/HO/";
            $id =$num.$autoidnumber;
            return $id;
        }
        elseif($applicationname =='CUSTOMER'){
            $num="SNAP/CUST/HO/";
            $id =$num.$autoidnumber;
            return $id;
        }
        elseif($applicationname =='LD.LOANS.AND.DEPOSITS'){
            $num="SNAP/LD/HO/";
            $id =$num.$autoidnumber;
            return $id;
        }
        elseif($applicationname =='ACCOUNT'){
            $num="SNAP/ACCT/HO/";
            $id =$num.$autoidnumber;
        
            return $id;
        }
        elseif($applicationname =='MM.MONEY.MARKET'){
            $num="SNAP/MM/HO/";
            $id =$num.$autoidnumber;
            return $id;
        }
        else{
            return null;
        }
        //$MNEMONIC=$id;
       // echo $id;
       
    };
    function GenerateCustomerMnemonic($postbody){
        global $tablename;
        global $dbc;
        global $applicationname;
        $id='';
        $id= strtoupper(substr($postbody["SHORT_NAME"],0,3).substr($postbody["NAME_1"],0,2).mt_rand(100,999));
        //$MNEMONIC=$id;
       // echo $id;
       return $id;
    };
    function GenerateAccountMnemonic($postbody){
        $letter='';
            for($i=1;$i<=7;$i++)
            {
            //	$letter .= chr(rand(97,122));
                $letter .= chr(rand(65,90));
            }
           // echo $letter;
           return $letter;
    };
    function GenerateLoanMnemonic($postbody){
        $letter='';
            for($i=1;$i<=7;$i++)
            {
            //	$letter .= chr(rand(97,122));
                $letter .= chr(rand(65,90));
            }
           // echo $letter;
           return $letter;
    };
    function generate_next_id($lastid,$lengthid,$prefixlength,$seed=1){

        $newidprefix=substr($lastid,0,$prefixlength);
        $lastid=substr($lastid,$prefixlength,$lengthid-$prefixlength);
        $newid=rand(1,$seed) + $lastid;
        $zeropadding=$lengthid-2-strlen($newid);
     
        for($j=1;$j<=$zeropadding;$j++)
        {
          $newidprefix.='0';
        }
    
        $id="$newidprefix$newid";
        return $id;
    }
?>