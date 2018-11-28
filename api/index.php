<?php
// use \Psr\Http\Message\ServerRequestInterface as Request;
// use \Psr\Http\Message\ResponseInterface as Response;

// /**Add Required Classes */
// require 'vendor/autoload.php';

// /**Strt Session */
// session_start();

// require 'config/connection.php';
// require 'classes/Validator.php';
// require 'classes/ComplaintRepository.php';

// /**Create Slim App */


// $app = new \Slim\App;

// /**Define Routes */

// //Get All Complaints
// $app->get('/complaints', function (Request $request, Response $response) {

//     $repo=new ComplaintRepository();
//     $complaints=$repo->GetAllComplaints();

//     $response->withStatus(200)
//     ->withHeader('Content-Type', 'application/json')
//     ->getBody()
//     ->write(json_encode($complaints));

//     return $response;
// });

// //Add new Complaint
// $app->post('/complaints', function (Request $request, Response $response) {

//     $data = $request->getParsedBody();
//     $repo=new ComplaintRepository();
//     $complaint=$repo->AddNewComplaint($data);

//     // return $response->withJson($data, 200);
//     if(is_null($complaint))
//     {  
//         $data = array("error"=>"Record Creation Failed");
//         $newResponse = $response->withJson($data, 500);

//         return $newResponse;
//     }

//     $newresponse=$response
//     ->withJson($complaint, 201);

//     return $newresponse;

// });

// //update Complaint
// $app->patch('/complaints/{id}', function (Request $request, Response $response,array $args) {

//     $complaint_id = $args['id'];
//     $data = $request->getParsedBody();
//     $repo=new ComplaintRepository();
//     $complaint=$repo->UpdateComplaint($complaint_id,$data);

//     if(is_null($complaint))
//     {  
//         $data = array("error"=>"Record Update Failed");
//         $newResponse = $response->withJson($data, 500);

//         return $newResponse;
//     }

//     $newresponse=$response
//     ->withJson($complaint, 200);

//     return $newresponse;

// });

// //Get  Complaints by Id
// $app->get('/complaints/{id}', function (Request $request, Response $response, array $args) {

//     $complaint_id = $args['id'];
//     $repo=new ComplaintRepository();
//     $complaint=$repo->GetComplaintById($complaint_id);

//     if(is_null($complaint))
//     {  
//         $data = array("error"=>"Record with Id not found");
//         $newResponse = $response->withJson($data, 404);

//         return $newResponse;
//     }

//     $newresponse=$response
//     ->withJson($complaint, 200);

//     return $newresponse;
// });

// //delete Complaint
// $app->delete('/complaints/{id}', function (Request $request, Response $response,array $args) {

//     $complaint_id = $args['id'];
//     $repo=new ComplaintRepository();
//     $complaint=$repo->RemoveComplaint($complaint_id);

//     if(!$complaint)
//     {  
//         $data = array("error"=>"Record with Id not found");
//         $newResponse = $response->withJson($data, 404);

//         return $newResponse;
//     }

//     $newresponse=$response
//     ->withHeader('Location', './complaints')
//     ->withJson($complaint, 200);
    
//     return $newresponse;
// });

// //Home Page Route
// $app->get('/', function (Request $request, Response $response, array $args) {
    
//     $response->getBody()->write("CRM API Endpoint from the Team");

//     return $response;
// });

/**Start App */
// $app->run(); 