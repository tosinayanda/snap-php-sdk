<?php

namespace myApp\Controllers;

// use Psr\Http\Message\ServerRequestInterface as Request;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use myApp\UserRepository;
use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;

final class UserController
{
    private $databaseconnection;
    private $tablename;
    private $repo;

    protected $container;
    
    public function __construct(ContainerInterface $container)
    {
        global $dbc;
        $this->container = $container;
        $this->tablename="users";
        $this->databaseconnection=$dbc;   
        $this->repo=new UserRepository();
    }
    public function CurrentUser (Request $request, Response $response, array $args)
    {
       // print_r($request->getAttribute('decoded_token_data'));
        $token=$request->getAttribute('decoded_token_data');
        $user_id = $token['id'];
        $repo=$this->repo;
        $user=$repo->GetById($user_id);

        if(is_null($user))
        {  
            $data = array("error"=>"Record with Id not found");
            $newResponse = $response->withJson($data, 404);

            return $newResponse;
        }

        $newresponse=$response
        ->withJson($user, 200);

        return $newresponse;
    }
    public function All (Request $request, Response $response, array $args)
    {
        $repo=$this->repo;
        $users=$repo->GetAll();

        $newResponse= $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->getBody()
        ->write(json_encode($users));

        return $newResponse;
    }
    public function Get (Request $request, Response $response, array $args)
    {
        $user_id = $args['id'];
        $repo=$this->repo;
        $user=$repo->GetById($user_id);

        if(is_null($user))
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

    }
    public function Update (Request $request, Response $response, array $args)
    {

    }
    public function Delete (Request $request, Response $response, array $args)
    {
        
    }
}