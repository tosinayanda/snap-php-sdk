<?php

namespace myApp\Controllers;

// use Psr\Http\Message\ServerRequestInterface as Request;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;

final class MoneyMarketController
{
    private $databaseconnection;
    private $tablename;
    private $repo;

    protected $container;
    
    public function __construct(ContainerInterface $container)
    {
        global $dbc;
        $this->container = $container;
        $this->tablename="";
        $this->databaseconnection=$dbc;   
       // var_dump($dbc);
    }
    public function All (Request $request, Response $response, array $args)
    {

    }
    public function Get (Request $request, Response $response, array $args)
    {
          
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