<?php 

    //Requried files
    require_once('../rabbitmqphp_example/path.inc');
    require_once('../rabbitmqphp_example/get_host_info.inc');
    require_once('../rabbitmqphp_example/rabbitMQLib.inc');

    require_once('dbFunctions.php');

    error_reporting(E_ALL);
    ini_set('display_errors', 'on');
    ini_set('log_errors', 'On');
    ini_set('error_log', dirname(__FILE__).'/../logging/log.txt');
    //logAndSendErrors();


    
    //This will route the request from server to function
    function requestProcessor($request){
        echo "received request".PHP_EOL;
        echo $request['type'];
        var_dump($request);
        
        if(!isset($request['type'])){
            return array('message'=>"ERROR: Message type is not supported");
        }
        switch($request['type']){
                
            //Login & Authentication request    
            case "Login":
                echo "<br>in login";
                $response_msg = doLogin($request['username'],$request['password']);
                break;
                
            //Check if username is already taken
            case "CheckUsername":
                echo "<br>in Checkusername";
                $response_msg = checkUsername($request['username']);
                echo "Result: " . $response_msg;
                break;
          
            //Check if email is valid
            case "CheckEmail":
                echo "<br>in CheckEmail";
                $response_msg = checkEmail($request['email']);
                break;
                
                
            //Send email with username and password
            case "SendEmail":
                echo "<br>in CheckEmail";
                $response_msg = sendEmail($request['email']);
                break;
                
            //New User registration
            case "Register":
                echo "<br>in register";
                $response_msg = register($request['username'], $request['email'], $request['password'], $request['firstname'], $request['lastname']);
                break;
               
            
            //Get user profile
            case "UserProfile":
                $response_msg = userProfile($request['username']);
                break;
                
            //Add favorite
            case "AddFavorite":
                $response_msg = addFavorite($request['username'], $request['restaurant_id']);
                break;
                
            //Remove favorite
            case "RemoveFavorite":
                $response_msg = removeFavorite($request['username'], $request['restaurant_id']);
                break;
        
        }
        echo $response_msg;
        return $response_msg;
    }

    //creating a new server
    $server = new rabbitMQServer('../rabbitmqphp_example/rabbitMQ_db.ini', 'testServer');
    
    //processes the request sent by client
    $server->process_requests('requestProcessor');
    
    //exit();

?>
