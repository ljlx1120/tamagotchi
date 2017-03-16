<?php
  date_default_timezone_set('America/Los_Angeles');
  require_once __DIR__."/../vendor/autoload.php";
  require_once __DIR__."/../src/Pet.php";

  session_start();
  if(empty($_SESSION['time'])){
    $_SESSION['time'] = array();
    $_SESSION['food'] = '';
    $_SESSION['rest'] = '';
    $_SESSION['attention'] = '';
    $_SESSION['name'] = '';
  }

  $app = new Silex\Application();

  $app->register(new Silex\Provider\TwigServiceProvider(), array ('twig.path' => __DIR__."/../views"));

  $app->get("/", function() use ($app) {
    return $app['twig']->render('index.html.twig');
  });

  $app->post("/create", function() use ($app) {
    $pet = new Pet ($_POST['name']);

    $hour = Pet::getHour();
    $min = Pet::getMin();
    $sec = Pet::getSec();
    array_push($_SESSION['time'], $hour, $min, $sec);

    $_SESSION['name'] = $pet->name;
    $_SESSION['food'] = $pet->food;
    $_SESSION['rest'] = $pet->rest;
    $_SESSION['attention'] = $pet->attention;

    print_r($_SESSION['time']);
    echo $_SESSION['food'] . $_SESSION['rest'];

    return $app['twig']->render('index.html.twig', array('name'=>$pet->name, 'food'=>$pet->food, 'rest'=>$pet->rest, 'attention'=>$pet->attention, 'hour'=>Pet::getHour(), 'min'=>Pet::getMin(), 'sec'=>Pet::getSec()));
  });

  $app->post("/food", function() use ($app) {
    $hour = date("h");
    $min = date("i");
    $sec = date("s");

    $_SESSION['time'] = array($hour,$min,$sec);

    print_r($_SESSION['time']);
    if($_SESSION['food']<100){
      $_SESSION['food'] += 1;
    } else if ($_SESSION['food']>100){
      $_SESSION['food'] = 100;
    };

    return $app['twig']->render('index.html.twig', array('food'=>$_SESSION['food']));
  });

  $app->post("/rest", function() use ($app) {
    $hour = date("h");
    $min = date("i");
    $sec = date("s");

    $_SESSION['time'] = array($hour,$min,$sec);

    print_r($_SESSION['time']);
    if($_SESSION['rest']<100){
      $_SESSION['rest'] += 1;
    } else if ($_SESSION['rest']>100){
      $_SESSION['rest']=100;
    };

    return $app['twig']->render('index.html.twig', array('rest'=>$_SESSION['rest']));
  });

  $app->post("/attention", function() use ($app) {
    $hour = date("h");
    $min = date("i");
    $sec = date("s");

    $_SESSION['time'] = array($hour,$min,$sec);

    print_r($_SESSION['time']);
    if($_SESSION['attention']<100){
      $_SESSION['attention'] += 1;
    } else if ($_SESSION['attention']>100){
      $_SESSION['attention']=100;
    };

    return $app['twig']->render('index.html.twig', array('attention'=>$_SESSION['attention']));
  });

  $app->post("/status", function() use ($app) {
    $hour = date("h");
    $min = date("i");
    $sec = date("s");

    print_r($_SESSION['time']);
    $dif = ($hour*3600 + $min*60 + $sec) - ($_SESSION['time'][0]*3600 + $_SESSION['time'][1]*60 + $_SESSION['time'][2]);

    $_SESSION['food'] -= number_format($dif*2,2);
    $_SESSION['rest'] -= number_format($dif*2,2);
    $_SESSION['attention'] -= number_format($dif*2,2);

    return $app['twig']->render('status.html.twig', array('food'=>$_SESSION['food'], 'rest'=>$_SESSION['rest'], 'attention'=>$_SESSION['attention'], 'name'=> $_SESSION['name']));
  });

  $app->post("/goback", function() use ($app) {
    return $app['twig']->render('index.html.twig');
  });

  $app->post("/reset", function() use ($app) {
    Pet::reset();
    return $app['twig']->render('index.html.twig');
  });

  return $app;
?>
