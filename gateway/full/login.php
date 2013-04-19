<?php
/*@interface.header@*/

try {

  include './conf/bootstrap.php';

  // Buffer Output
  if (BUFFER_OUTPUT)
    ob_start();

  $errors = '';

  View::setType('Html');
  $webfrap = Webfrap::init();

  // calling the main main function
  $webfrap->redirectToLogin();
  $errors = $webfrap->out();
  $webfrap->shutdown($errors);

} // ENDE TRY
catch(Exception $exception) {
  $extType = get_class($exception);

  Error::addError
  (
    'Uncatched  Exception: '.$extType.' Message:  '.$exception->getMessage() ,
    null,
    $exception
  );

  if (BUFFER_OUTPUT) {
    $errors .= ob_get_contents();
    ob_end_clean();
  }

  if (!DEBUG) {
    
    $view = Webfrap::$env->getView();
    
    if (isset($view) and is_object($view)) {
      $view->publishError($exception->getMessage() , $errors);
    } else {
      View::printErrorPage
      (
        $exception->getMessage(),
        '500',
        $errors
      );
    }
  } else {
    echo $errors;
  }

}