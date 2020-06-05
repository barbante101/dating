<?php
// turn on error reporting
ini_set('display_errors',1);
error_reporting(E_ALL);

//Start a session
session_start();

// require the autoload file
require_once('vendor/autoload.php');
require_once("model/data-layer.php");
require_once("model/validation.php");

//require_once('vendor/autoload.php');
//require_once('model/data-layer.php');

// create an instance of the base class
$f3 = Base::instance();

// define a default route
$f3->route('GET /', function() {
    //echo '<h1>Hello world!</h1>';

    $view = new Template();
    echo $view->render('views/home.html');
});

// personal
$f3->route('GET|POST /personal', function($f3) {

    $gender = getGender();
    //$f3->reroute('/profile');
    //If the form has been submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        var_dump($_POST);

        //valid person
        if(!validName($_POST['first'])) {
            $f3->set('errors["first"]', "Invalid first name");
        }
        if(!validName($_POST['last'])) {
            $f3->set('errors["last"]', "Invalid last name");
        }
        if(!validAge($_POST['age'])) {
            $f3->set('errors["age"]', "Invalid age");
        }
        if(!validPhone($_POST['phone'])) {
            $f3->set('errors["phone"]', "Invalid phone number");
        }



        //Data is valid
        if(empty($f3->get('errors'))) {

            //Store the data in the session array
            $_SESSION['first'] = $_POST['first'];
            $_SESSION['last'] = $_POST['last'];
            $_SESSION['age'] = $_POST['age'];
            $_SESSION['gender'] = $_POST['gender'];
            $_SESSION['phone'] = $_POST['phone'];
            $_SESSION['petName'] = $_POST['petName'];
            $_SESSION['petAge'] = $_POST['petAge'];


            //Redirect to profile page
            $f3->reroute('/profile');
        }
    }
    $f3->set('first', $_POST['first']);
    $f3->set('last', $_POST['last']);
    $f3->set('age', $_POST['age']);
    $f3->set('selectedPerson', $_POST['gender']);
    $f3->set('phone', $_POST['phone']);
    $f3->set('petName', $_POST['petName']);
    $f3->set('petAge', $_POST['petAge']);
    $f3->set('selectedPet', $_POST['pGender']);
    $f3->set('gender', $gender);
    $f3->set('pGender', $gender);

    $view = new Template();
    echo $view->render('views/personal.html');
});

// profile
$f3->route('GET|POST /profile', function($f3) {

    $state = getStates();
    $seeks = getGender();
    //If the form has been submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //var_dump($_SESSION);

        if(!validEmail($_POST['email'])) {
            $f3->set('errors["email"]', "Invalid email");
        }

        if (empty($f3->get('errors'))) {
            //Store the data in the session array
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['state'] = $_POST['state'];
            $_SESSION['seek'] = $_POST['seek'];
            $_SESSION['bio'] = $_POST['bio'];

            //Redirect to interests page
            $f3->reroute('/interests');
        }
    }

    $f3->set('selected', $_POST['state']);
    $f3->set('selectedSeek', $_POST['seek']);
    $f3->set('email', $_POST['email']);
    $f3->set('seeks', $seeks);
    $f3->set('state', $state);

    $view = new Template();
    echo $view->render('views/profile.html');
});

// interest
$f3->route('GET|POST /interests', function($f3) {

    $indoor = getInDoor();
    $outdoor = getOutDoor();

    //If the form has been submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //var_dump($_POST);

        if(!validOutdoor($_POST['outdoor'])) {
            $f3->set('errors["outdoor"]', "Select out-door activity(s)");
        }
        if(!validIndoor($_POST['indoor'])) {
            $f3->set('errors["indoor"]', "Select in-door activity(s)");
        }

        if (empty($f3->get('errors'))) {
            //Store the data in the session array
            $_SESSION['indoor'] = $_POST['indoor'];
            $_SESSION['outdoor'] = $_POST['outdoor'];

            //Redirect to summary page
            $f3->reroute('/summary');
        }
    }

    $f3->set('selectedIn', $_POST['indoor']);
    $f3->set('selectedOut', $_POST['outdoor']);
    $f3->set('indoor', $indoor);
    $f3->set('outdoor', $outdoor);

    $view = new Template();
    echo $view->render('views/interests.html');
});

// summary
$f3->route('GET /summary', function() {


    $view = new Template();
    echo $view->render('views/summary.html');
    session_destroy();


});

// run fat free
$f3->run();