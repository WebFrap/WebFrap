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


/**
 * @package WebFrap
 * @subpackage Request
 *
 */
class LibRequestStack
  extends LibRequestSubrequest
{

  /**
   * post data array
   * @var array
   */
  protected $params   = array();

  /**
   * post data array
   * @var array
   */
  protected $data   = array();

  /**
   * files data array
   * @var array
   */
  protected $files  = array();

  /**
   * @var string
   */
  public $type = 'stack';



  /**
   * @param LibRequestPhp $request
   * @param array $data
   * @param array $files
   */
  public function __construct( $request, $params, $data, $files )
  {

    $this->request = $request;
    $this->params  = $params;
    $this->data    = $data;
    $this->files   = $files;
    
    $this->db  = $request->getDb();

  }//end public function __construct */

////////////////////////////////////////////////////////////////////////////////
// param methodes
////////////////////////////////////////////////////////////////////////////////


  /**
   * Funktion zum testen ob eine bestimmte Urlvariable existiert
   *
   * @param string Key Name der zu erfragende $this->params Variable
   * @return bool
   */
  public function paramExists( $key, $subkey = null )
  {
    
    return isset( $this->params[$key] );
    
  } // end public function paramExists */
  
  /**
  * Daten einer bestimmten Urlvariable erfragen
  *
  * @param string $key Name der zu erfragende $this->params Variable
  * @param string $validator
  * @return TArray
  */
  public function paramList( $key, $validator )
  {

    $response = $this->getResponse();

    $filter = Validator::getActive();
    $filter->clean(); // first clean the filter


    $paramList = new TArray();
    
    if( isset( $this->params[$key] ) )
    {
      $data = $this->params[$key];
      
      if( !is_array( $data ) )
      {
        return $paramList;
      }
    }
    else
    {
      return $paramList;
    }

    $fMethod = 'add'.ucfirst( $validator );

    // clean only one
    foreach( $data as $key => $value )
    {
      $error = $filter->$fMethod( $key, $value );
      if( !$error )
      {
        $paramList->$key = $filter->getData( $key );
      }
      else
      {
        $response->addError( $error ) ;
        continue;
      }
    }
    
    return $paramList;

  } // end public function paramList */

  /**
  * Daten einer bestimmten Urlvariable erfragen
  *
  * @param string $key Name der zu erfragende $this->params Variable
  * @param string $validator
  * @param string $subkey
  * @param string $message
  * @return string
  */
  public function param( $key = null, $validator = null, $subkey = null, $message = null )
  {

    $response = $this->getResponse();

    if( $validator )
    {
      $filter = Validator::getActive();
      $filter->clean(); // first clean the filter

      if( is_string( $key ) )
      {

        if( $subkey )
        {
          
          if( isset( $this->params[$key][$subkey] ) )
          {
            $data = $this->params[$key][$subkey];
          }
          else
          {
            return null;
          }
          
        }//end if $subkey
        else
        {
          
          if( isset( $this->params[$key] ) )
          {
            $data = $this->params[$key];
          }
          else
          {
            return null;
          }
          
        }

        $fMethod = 'add'.ucfirst( $validator );

        if( is_array( $data ) )
        {
          // Clean all the same way
          // Good architecture :-)
          return $this->validateArray( $fMethod , $data );
          
        }
        else
        {
          // clean only one
          if( !$error = $filter->$fMethod( $key, $data ) )
          {
            return $filter->getData( $key );
          }
          else
          {
            
            $response->addError( ($message?$message:$error) ) ;
            return;
            
          }

        }

      }// end is_string($key)
      elseif( is_array( $key ) )
      {
        $data = array();

        if( is_array( $validator ) )
        {
          foreach( $key as $id )
          {
            $fMethod = 'add'.ucfirst( $validator[$id] );

            if( isset( $this->params[$id] ) )
            {
              $filter->$fMethod( $id, $this->params[$id] );
              $data[$id] = $filter->getData( $id );
            }
            else
            {
              //$filter->checkRequired( $id );
              //$data[$id] = null;
            }
            
          }
          
        }
        else
        {
          
          foreach( $key as $id )
          {
            $fMethod = 'add'.ucfirst($validator);

            if( isset($this->params[$id]) )
            {
              $filter->$fMethod( $id, $this->params[$id] );
              $data[$id] = $filter->getData( $id );
            }
            else
            {
              //$filter->checkRequired( $id );
              //$data[$id] = null;
            }
          }
          
        }

        return $data;
      }
      
    }//end if $validator
    else // else $validator
    {
      
      if( is_string( $key ) )
      {
        
        if(  $subkey )
        {
          return isset($this->params[$key][$subkey])
            ?$this->params[$key][$subkey]:null;
        }
        else
        {
          return isset($this->params[$key])
            ?$this->params[$key]:null;
        }
        
      }
      elseif( is_array( $key ) )
      {
        $data = array();

        foreach( $key as $id )
        {
          
          if( array_key_exists( $id, $this->params ) )
            $data[$id] = $this->params[$id];
          
          //$data[$id] = isset( $_POST[$id] )? $_POST[$id] :null;
        }

        return $data;
      }
      elseif( is_null( $key ) )
      {
        return $this->params;
      }
      else
      {
        return null;
      }
      
    }

  } // end public function param */

 /**
  * Hinzufügen oder ersetzten einer Variable in der URL
  *
  * @param string $key Name des Urlkeys
  * @param string $data Die Daten für die Urlvar
  * @return bool
  */
  public function addParam( $key, $data = null  )
  {

    if( is_array($key) )
    {
      $this->params = array_merge($this->params,$key);
    }
    else
    {
      $this->params[$key] = $data;
    }

  } // end public function addParam */

  /**
   * remove some variables from the url
   * @param string $key
   */
  public function removeParam( $key )
  {
    
    if( isset( $this->params[$key]) )
    {
      unset($this->params[$key]);
    }

  }//end public function removeParam */



////////////////////////////////////////////////////////////////////////////////
// Form input
////////////////////////////////////////////////////////////////////////////////


  /** method for validating Formdata
   * if an error is found an message will be send to system, if you want to find
   * out if the test failed ask the system if there are any error messages
   *
   *
   * @param array $values
   * @param array $messages
   * @param string $subkey
   * @return Validator
   *
   */
  public function checkSearchInput( $values , $messages, $subkey = null )
  {
    
    $response = $this->getResponse();

    // get Validator from Factory
    $filter = $this->getValidator();
    $filter->clean();

    $validator = null;

    if( $subkey )
    {// check if we have a subkey

      foreach( $values as $key => $value )
      {
        $method = 'add'.$value[0] ;

        if( isset($this->params[$subkey][$key]) )
          $data = $this->params[$subkey][$key];
        else
          $data = null;

        if( is_array($data) )
        {

          if(!$validator)
            $validator = new LibValidatorBase();

          $checkMethod = 'check'.ucfirst($value[0]);

          $filtered = array();

          foreach( $data as $dataValue )
          {
            if( $validator->$checkMethod( $dataValue, false , $value[2] , $value[3] ) )
            {
              $filtered[] = $validator->sanitized;
              $validator->clean();
            }
          }

          if( $filtered )
            $filter->appendCleanData( $key, $filtered );

        }
        else
        {
          if( $error = $filter->$method( $key , $data, false , $value[2] , $value[3] ) )
          {
            if( isset( $messages[$key][$error] ) )
            {
              $response->addError( $messages[$key][$error] );
            }
            elseif( isset( $messages[$key]['default'] ) )
            {
              $response->addError( $messages[$key]['default'] );
            }
            else
            {
              $response->addError( 'Wrong data for '.$key  );
            }
          }
        }


      }
    }
    else
    {// we have no subkey geht direct

      foreach( $values as $key => $value )
      {

        $method = 'add'.$value[0] ;

        if( isset($this->params[$key]) )
          $data = $this->params[$key];
        else
          continue;

        if( $error = $filter->$method( $key , $data, false , $value[2] , $value[3] ) )
        {
          
          if( isset( $messages[$key][$error] ) )
          {
            $response->addError( $messages[$key][$error] );
          }
          elseif( isset( $messages[$key]['default'] ) )
          {
            $response->addError( $messages[$key]['default'] );
          }
          else
          {
            $response->addError( 'Wrong data for '.$key  );
          }
          
        }

      }

    }

    return $filter;

  }//end public function checkSearchInput */

}// end class LibRequestSubrequest


