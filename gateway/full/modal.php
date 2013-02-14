<?php
/*@interface.header@*/



try
{

  include './conf/bootstrap.php';

  // Buffer Output
  if(BUFFER_OUTPUT)
    ob_start();

  $errors = '';

  // calling the main main function
  if( isset($_GET['rqt']) )
  {

    View::setType( View::MODAL );
    $webfrap = Webfrap::init();
    View::engine()->setIndex( 'ajax' );

    $request = Request::getInstance();

    // only allow get,put,post and delete
    if (!$request->inMethod( array('GET','POST','PUT','DELETE') ) )
    {
      $webfrap->httpError(405,$request->method());
      $errors = $webfrap->out();
      $webfrap->shutdown( $errors );
    }
    else
    {
      $webfrap->main();
      $errors = $webfrap->out();
      $webfrap->shutdown( $errors );
    }

  }
  else
  {
    View::setType( 'Html' );
    $webfrap = Webfrap::init();
    $request = Request::getInstance();

    // only allow get,post 
    if (!$request->inMethod(array('GET','POST','PUT','DELETE')) )
    {
      $webfrap->httpError(405,$request->method());
      $errors = $webfrap->out();
      $webfrap->shutdown( $errors );
    }
    else
    {
      // works only with desktop
      $webfrap->redirectByKey( 'tripple.desktop' );

      $view = View::getActive();
      $view->openWindow( 'modal.php?'.$request->getResource() );

      $errors = $webfrap->out();
      $webfrap->shutdown( $errors );
    }
  }


} // ENDE TRY
catch( Exception $exception )
{
  $extType = get_class($exception);

  Error::addError
  (
    'Uncatched  Exception: '.$extType.' Message:  '.$exception->getMessage() ,
    null,
    $exception
  );

  if( BUFFER_OUTPUT )
  {
    $errors .= ob_get_contents();
    ob_end_clean();
  }

  if (!DEBUG )
  {
    if( isset($view) and is_object($view) )
    {
      $view->publishError( $exception->getMessage() , $errors );
    }
    else
    {
      View::printErrorPage
      (
        $exception->getMessage(),
        '500',
        $errors
      );
    }
  }
  else
  {
    echo $errors;
  }

}