<?php
/*******************************************************************************
*
* @author      : Dominik Bonsch <dominik.bonsch@webfrap.net>
* @date        :
* @copyright   : Webfrap Developer Network <contact@webfrap.net>
* @project     : Webfrap Web Frame Application
* @projectUrl  : http://webfrap.net
*
* @licence     : BSD License see: LICENCE/BSD Licence.txt
*
* @version: @package_version@  Revision: @package_revision@
*
* Changes:
*
*******************************************************************************/

try {

  include './conf/bootstrap.php';

  // Buffer Output
  if (BUFFER_OUTPUT)
    ob_start();

  $errors = '';

  $webfrap = Webfrap::init();
  $request = Webfrap::$env->getRequest();
  $graphKey = $request->param('graph', Validator::CKEY);

  $graphClass = SParserString::subToCamelCase($graphKey).'_Graph';

  if (Webfrap::loadable($graphClass)) {

    try {

      $graph = new $graphClass(Webfrap::$env);
      $graph->prepare();
      $graph->render();
      $errors = Response::getOutput();

      if ('' != trim($errors)  )
        echo 'ERROR: '.$errors;
      else
        $graph->out();
    } catch (Exception $e) {
      $errors = Response::getOutput();
      echo $e;
    }
  } else {

    $errors = Response::getOutput();

    echo 'Missing Graph '.$graphKey.' '.$errors;
  }

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

