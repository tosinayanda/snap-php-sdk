<?php
//global $retrylimit,$retrycount,$uploadstatus;
function custom_curl_fetch($url, $timeout=300, $error_report=FALSE)
{
    $curl = curl_init();

    // HEADERS FROM FIREFOX - APPEARS TO BE A BROWSER REFERRED BY GOOGLE
    $header[] = "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
    $header[] = "Cache-Control: max-age=0";
    $header[] = "Connection: keep-alive";
    $header[] = "Keep-Alive: 300";
    $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $header[] = "Accept-Language: en-us,en;q=0.5";
    $header[] = "Pragma: "; // browsers keep this blank.

    // SET THE CURL OPTIONS - SEE http://php.net/manual/en/function.curl-setopt.php
    curl_setopt($curl, CURLOPT_URL,            $url);
    curl_setopt($curl, CURLOPT_USERAGENT,      'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6');
    curl_setopt($curl, CURLOPT_HTTPHEADER,     $header);
    curl_setopt($curl, CURLOPT_REFERER,        'http://www.google.com');
    curl_setopt($curl, CURLOPT_ENCODING,       'gzip,deflate');
    curl_setopt($curl, CURLOPT_AUTOREFERER,    TRUE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_TIMEOUT,        $timeout);

    // RUN THE CURL REQUEST AND GET THE RESULTS
    $htm = curl_exec($curl);
    $err = curl_errno($curl);
    $inf = curl_getinfo($curl);
    curl_close($curl);

    // ON FAILURE
    if (!$htm)
    {
        // PROCESS ERRORS HERE
        if ($error_report)
        {
            echo "CURL FAIL: $url TIMEOUT=$timeout, CURL_ERRNO=$err";
            var_dump($inf);
        }
        return FALSE;
    }

    // ON SUCCESS
    return $htm;
}

// USAGE EXAMPLE
// $url = "";
// $htm = custom_curl_fetch($url);
// if (!$htm) die("NO $url");

// echo"<pre>";
// var_dump($htm);
// echo"<pre/>";


function return_content_from_url($url)
{
    global $retrycount,$uploadstatus;
    try
    {
        ////Approach 1
        // if(file_exists($url))
        // {
        //     $content = file_get_contents($url);
        // }
        // else{
        //     throw new Exception();
        // }

        ////Approach 2
         //$url=urlencode($url);
         echo $url;
        // $content= @file_get_contents($url);

         ////Approach 3
        $content= custom_curl_fetch($url);

        //Mock Response
	   // $content='FT1824626580//1,TRANSACTION.TYPE=AC:1:1,DEBIT.ACCT.NO=0011009526:1:1,CURRENCY.MKT.DR=1:1:1,DEBIT.CURRENCY=NGN:1:1,DEBIT.AMOUNT=15000.00:1:1,DEBIT.VALUE.DATE=20180303:1:1,DEBIT.THEIR.REF=1000:1:1,CREDIT.THEIR.REF=10000:1:1,CREDIT.ACCT.NO=0011268170:1:1,CURRENCY.MKT.CR=1:1:1,CREDIT.CURRENCY=NGN:1:1,CREDIT.VALUE.DATE=20180303:1:1,PROCESSING.DATE=20180903:1:1,ORDERING.CUST=Me:1:1,PAYMENT.DETAILS=Basic Transfer:1:1,CHARGE.COM.DISPLAY=NO:1:1,COMMISSION.CODE=DEBIT PLUS CHARGES:1:1,CHARGE.CODE=DEBIT PLUS CHARGES:1:1,PROFIT.CENTRE.CUST=100952:1:1,RETURN.TO.DEPT=NO:1:1,FED.FUNDS=NO:1:1,POSITION.TYPE=TR:1:1,AMOUNT.DEBITED=NGN15000.00:1:1,AMOUNT.CREDITED=NGN15000.00:1:1,DELIVERY.OUTREF=D20180906149155598100-900.1.1       DEBIT ADVICE:1:1,DELIVERY.OUTREF=D20180906149155598200-910.2.1       CREDIT ADVICE:2:1,CREDIT.COMP.CODE=NG0010001:1:1,DEBIT.COMP.CODE=NG0010001:1:1,LOC.AMT.DEBITED=15000.00:1:1,LOC.AMT.CREDITED=15000.00:1:1,CUST.GROUP.LEVEL=99:1:1,DEBIT.CUSTOMER=100952:1:1,CREDIT.CUSTOMER=126817:1:1,DR.ADVICE.REQD.Y.N=Y:1:1,CR.ADVICE.REQD.Y.N=Y:1:1,CHARGED.CUSTOMER=126817:1:1,TOT.REC.COMM=0:1:1,TOT.REC.COMM.LCL=0:1:1,TOT.REC.CHG=0:1:1,TOT.REC.CHG.LCL=0:1:1,RATE.FIXING=NO:1:1,TOT.REC.CHG.CRCCY=0:1:1,TOT.SND.CHG.CRCCY=0.00:1:1,AUTH.DATE=20180903:1:1,STMT.NOS=185121491555980.00:1:1,STMT.NOS=1-2:2:1,OVERRIDE=NO.WORKING.DAY}DEBIT VALUE NOT A WORKING DAY:1:1,OVERRIDE=DR.GT.BACKVALUE}DEBIT VALUE EXCEEDS MAX BACKVALUE:2:1,OVERRIDE=CR.BACKDATED}CREDIT VALUE BACKDATED:3:1,OVERRIDE=CR.NO.WORKING.DAY}CREDIT VALUE NOT A WORKING DAY:4:1,OVERRIDE=CR.GT.BACKVALUE}CREDIT VALUE EXCEEDS MAX BACKVALUE:5:1,OVERRIDE=ACCOUNT.INACTIVE}Account & is inactive - Transaction code &{0011009526}213{NGN{{0011009526{100952{213{{5:6:1,OVERRIDE=POSTING.RESTRICT}Account & - &{0011009526}Contact Loan Administrator{NGN{15000{0011009526{100952{213{{5:7:1,OVERRIDE=ACCT.UNAUTH.OD}Unauthorised overdraft of & & on account &.{NGN}304842.03}0011009526{NGN{304842.03{0011009526{100952{213{{5:8:1,CURR.NO=1:1:1,INPUTTER=14915_COB.USER__OFS_TAABS:1:1,DATE.TIME=1809061532:1:1,AUTHORISER=14915_COB.USER_OFS_TAABS:1:1,CO.CODE=NG0010001:1:1,DEPT.CODE=6000:1:1';
       //var_dump($content);
       if($content === false){
         throw new Exception();
       }

        $uploadstatus=true;
        return $content;
    }
    catch(Exception $e)
    {
        echo "Failed Attempt ". $retrycount."<br/>";
        $retrycount++;
    }
}

function retry_function($url){
    global $retrylimit,$retrycount,$uploadstatus,$content;
    $retrycount=1;$retrylimit=1;$uploadstatus=false;
    while($retrycount<=$retrylimit)
    {
        if($uploadstatus===true){
            break;
        }
      $content= return_content_from_url($url);   
    }
    if($uploadstatus==false){
        echo "Could not Connect to T24 Application Server<br/>";
        return null;
    }
    return $content;
}
