<?php

namespace myApp\Controllers;

// use Psr\Http\Message\ServerRequestInterface as Request;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;

use myApp\AccountRepository;

final class AccountController
{
    private $databaseconnection;
    private $applicationname;
    private $repo;

    protected $container;
    
    public function __construct(ContainerInterface $container)
    {
        global $dbc;
        $this->container = $container;
        $this->applicationname="ACCOUNT";
        $this->databaseconnection=$dbc;   
        $this->repo=new AccountRepository();
       // var_dump($dbc);
    }
    public function All (Request $request, Response $response, array $args)
    {
        $repo=$this->repo;
        $accounts=$repo->GetAll();

        $newResponse= $response->withStatus(200)->withJson($accounts);

        return $newResponse;
    }
    public function AllFromT24 (Request $request, Response $response, array $args)
    {
        $repo=$this->repo;
        $accounts=$repo->GetAllFromT24();

        $newResponse= $response->withStatus(200)->withJson($accounts);

        return $newResponse;
    }
    public function Get (Request $request, Response $response, array $args)
    {
        $user_id = $args['id'];
        $repo=$this->repo;
        $user=$repo->GetById($user_id);

        if(is_null($complaint))
        {  
            $data = array("error"=>"Record with Id not found");
            $newResponse = $response->withJson($data, 404);

            return $newResponse;
        }

        $newresponse=$response
        ->withJson($user, 200);

        return $newresponse;
    }
    public function Create (Request $request, Response $response, array $args)
    {
        $data = $request->getParsedBody();

        //Validation

        $validator=new Validator($this->applicationname);
        $validator->Validate($data);
       
        if(isset($validator->validationerrors))
        {
            return $response->withJson(array("error"=>$validator->validationerrors), 200);
        }

        $repo=$this->repo;
        $user=$repo->AddNew($data);

        // return $response->withJson($data, 200);
        if(is_null($usert))
        {  
            $data = array("error"=>"Record Creation Failed");
            $newResponse = $response->withJson($data, 500);

            return $newResponse;
        }

        $newresponse=$response
        ->withJson($usert, 201);

        return $newresponse;
    }
    public function Validate (Request $request, Response $response, array $args)
    {

        $data = $request->getParsedBody();

        //Validation

        $validator=new Validator($this->applicationname);
        $validator->Validate($data);
       
        return $response->withJson(array("error"=>$validator->validationerrors), 200);

    }
    public function Update (Request $request, Response $response, array $args)
    {
        $user_id = $args['id'];
        $data = $request->getParsedBody();
        $repo=$this->repo;
        $complaint=$repo->Update($user_id,$data);

        if(is_null($complaint))
        {  
            $data = array("error"=>"Record Update Failed");
            $newResponse = $response->withJson($data, 500);

            return $newResponse;
        }

        $newresponse=$response
        ->withJson($user, 200);

        return $newresponse;
    }
    public function Delete (Request $request, Response $response, array $args)
    {
        $user_id = $args['id'];
        $repo=$this->repo;
        $user=$repo->Remove($user_id);

        if(!$user)
        {  
            $data = array("error"=>"Record with Id not found");
            $newResponse = $response->withJson($data, 404);

            return $newResponse;
        }

        $newresponse=$response
        ->withHeader('Location', './customers')
        ->withJson($user, 200);
        
        return $newresponse;
    }
}