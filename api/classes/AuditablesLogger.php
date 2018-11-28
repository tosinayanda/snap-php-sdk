<?php

namespace myApp;

use Psr\Container\ContainerInterface;

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;

global $applicationname;
global $validationerrors;
global $tablename;

global $t24WorkingDate;

final class AuditablesLogger
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

    public function LogAction($input)
    {   
        global $applicationname;
        global $validationerrors;

        $applicationname=$this->applicationname;
        $this->setT24WorkingDate();
        $this->ValidateInput($input);

        $this->validationerrors=$validationerrors;
      
    }
}