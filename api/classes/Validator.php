<?php

namespace myApp;

global $applicationname;
global $validationerrors;
global $tablename;

global $t24WorkingDate;

final class Validator
{
    use DatabaseHelper;
    use ValidatorHelper;

    private $applicationname;
    public $validationerrors;

    public  function __construct($applicationname)
    {
        
        $this->applicationname=$applicationname;
        $this->validationerrors=array();
       // $applicationname="CUSTOMER";
    }

    public function Validate($input)
    {   
        global $applicationname;
        global $validationerrors;

        $applicationname=$this->applicationname;
        $this->setT24WorkingDate();
        $this->ValidateInput($input);

        $this->validationerrors=$validationerrors;

        try
        {
            if(is_array($input))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        catch(Exception $ex)
        {

        }
      
    }
}