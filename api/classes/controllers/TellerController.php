<?php

namespace myApp\Controllers;

// use Psr\Http\Message\ServerRequestInterface as Request;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;

final class TellerController
{
    private $databaseconnection;
    private $tablename;
    protected $container;
    
    public function __construct(ContainerInterface $container)
    {
        global $dbc;
        $this->container = $container;
        $this->tablename="users";
        $this->databaseconnection=$dbc;   
       // var_dump($dbc);
    }
    public function TwoFactorLogin (Request $request, Response $response, array $args)
    {

    }
    public function TwoFactorConfirmOTP (Request $request, Response $response, array $args)
    {

    }
    public function Login (Request $request, Response $response, array $args)
    {
            $input = $request->getParsedBody();
            if(!isset($input['username']) || !$input['password'])
            {
                return $this->response->withJson(['error' => true, 'message' => 'These credentials do not match our records.']);  
            }
        
        
            $username=$input['username'];
            $password=$input['password'];
            $user = mysqli_query($this->databaseconnection,"SELECT * FROM users WHERE username = '$username'");
            $userdata=mysqli_fetch_array($user);
            $h_password=$userdata['h_password'];
            
            // verify email address.
            if(!$user) {
                return $response->withJson(['error' => true, 'message' => 'These credentials do not match any user in our records.']);  
            }
        
            // verify password.
            if ( $h_password != crypt($password, $h_password) ) {
                return $response->withJson(['error' => true, 'message' => 'These credentials do not match saved password in our records.']);  
            }
        
            $settings = $this->container->get('settings'); // get settings array.

            $tokenId    = base64_encode(random_bytes(32));
            $issuedAt   = time();
            $notBefore  = $issuedAt + 10;             //Adding 10 seconds
            $expire     = $notBefore + 60;   
            
            $token = JWT::encode(['id' => $userdata['user_id'], 'type' =>$userdata['user_type'],
            'name'=>$userdata['user_type'],'jti'  => $tokenId,'iat'  => $issuedAt,'nbf'  => $notBefore,'exp'  => $expire], $settings['jwt']['secret'], "HS256");
        
            return $response->withJson(['token' => $token]);
    }
    public function Logout (Request $request, Response $response, array $args)
    {

    }
}