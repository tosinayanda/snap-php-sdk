<?php

use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;
use myApp\ComplaintRepository;
use myApp\Controllers\AuthorizationController as AuthorizationController;


/**Define Routes */
//Login
$app->post('/login','AuthorizationController:Login');
//$app->post('/login',AuthorizationController::class.':Login');
//Get Token
$app->post('/auth/token','AuthorizationController:Login');

//Secured Routes
$app->group('/api/v1/', function(\Slim\App $app) {
    
    //Get Current User
    $app->get('/user','UserController:CurrentUser');
    //Get All SNAP Users
    $app->get('/user/all','UserController:All')->setName("users-list");

    //Get All Snap Customers
    $app->get('/customers','CustomerController:All')->setName("customers-list");;
    //Get All T24 Customers
    $app->get('/customers/t24','CustomerController:AllFromT24');

    //Add new Customer
    $app->post('/customers','CustomerController:Create');

     //Validate Customer
     $app->post('/customers/validate','CustomerController:Validate');

    //update Customers
    $app->patch('/customers/{id}','CustomerController:Update');

    //Get  Customers by Id
    $app->get('/customers/{id}','CustomerController:Get');

    //delete Customer
    $app->delete('/customers/{id}','CustomerController:Delete');

    //Get All Snap Accounts
    $app->get('/accounts','AccountController:All')->setName("accounts-list");;
    //Get All T24 Account
    $app->get('/accounts/t24','AccountController:AllFromT24');
    
    //Add new Account
    $app->post('/accounts','AccountController:Create');

    //Add new Account
    $app->post('/accounts/validate','AccountController:Validate');

    //update Accounts
    $app->patch('/accounts/{id}','AccountController:Update');

    //Get  Accounts by Id
    $app->get('/accounts/{id}','AccountController:Get');

    //delete Account
    $app->delete('/accounts/{id}','AccountController:Delete');

    //Get All Snap Funds Transfers
    $app->get('/fundstransfers','FundsTransferController:All')->setName("fundstransfers-list");

    //Add new Funds Transfer
    $app->post('/fundstransfers','FundsTransferController:Create');

    //Add new Funds Transfer
    $app->post('/fundstransfers/validate','FundsTransferController:Validate');

    //update Funds Transfers
    $app->patch('/fundstransfers/{id}','FundsTransferController:Update');

    //Get  Funds Transfers by Id
    $app->get('/fundstransfers/{id}','FundsTransferController:Get');

    //delete Funds Transfer
    $app->delete('/fundstransfers/{id}','FundsTransferController:Delete');
   
});

    //Home Page Route
$app->get('/', function (Request $request, Response $response, array $args) {
        
        $secret=base64_encode(openssl_random_pseudo_bytes(64));
        $response->getBody()->write("SNAP API Endpoint from the Team ".$secret);

        return $response;
});
// Routes

// $app->get('/[{name}]', function (Request $request, Response $response, array $args) {
//     // Sample log message
//     $this->logger->info("Slim-Skeleton '/' route");

//     // Render index view
//     return $this->renderer->render($response, 'index.phtml', $args);
// });
// $app->post('/auth/token', function (Request $request, Response $response, array $args) {
//     global $dbc;

//     $input = $request->getParsedBody();

//     if(!isset($input['username']) || !$input['password'])
//     {
//         return $this->response->withJson(['error' => true, 'message' => 'These credentials do not match our records.']);  
//     }


//     $username=$input['username'];
//     $password=$input['password'];
//     $user = mysqli_query($dbc,"SELECT * FROM users WHERE username = '$username'");
//     $userdata=mysqli_fetch_array($user);
//     $h_password=$userdata['h_password'];
    
//     // verify email address.
//     if(!$user) {
//         return $this->response->withJson(['error' => true, 'message' => 'These credentials do not match our records.']);  
//     }

//     // verify password.
//     if ( $h_password != crypt($password, $h_password) ) {
//         return $this->response->withJson(['error' => true, 'message' => 'These credentials do not match our records.']);  
//     }

//     $settings = $this->get('settings'); // get settings array.
    
//     $token = JWT::encode(['id' => $userdata['user_id'], 'type' =>$userdata['user_type'],'name'=>$userdata['user_type']], $settings['jwt']['secret'], "HS256");

//     return $this->response->withJson(['token' => $token]);

// });