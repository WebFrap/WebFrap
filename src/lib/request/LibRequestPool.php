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
 * @deprecated use subrequest or stack request
 */
class LibRequestPool
  extends LibRequestAbstract
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var string
   */
  public $type = 'pool';

  /**
   *
   * @var array
   */
  protected $get    = array();

  /**
   *
   * @var array
   */
  protected $post   = array();

  /**
   *
   * @var array
   */
  protected $cookie = array();

  /**
   *
   * @var array
   */
  protected $files  = array();

  /**
   *
   * @var array
   */
  protected $server = array();

  /**
   *
   * @var array
   */
  protected $env    = array();


  /**
   *
   *
   */
  public function init()
  {


  }//end public function init()

////////////////////////////////////////////////////////////////////////////////
// Magic Methodes
////////////////////////////////////////////////////////////////////////////////

  public function __construct( $get, $post, $cookie = array(), $files= array(), $server= array(), $env= array() )
  {

    $this->get    = $get;
    $this->post   = $post;
    $this->cookie = $cookie;
    $this->files  = $files;
    $this->server = $server;
    $this->env    = $env;

  }//end public function __construct

////////////////////////////////////////////////////////////////////////////////
// getter + setter Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * Funktion zum testen ob eine bestimmte Urlvariable existiert
   *
   * @param string Key Name der zu erfragende $_GET Variable
   * @return bool
   */
  public function getExists( $key )
  {

    if( isset( $this->get[$key] ) )
    {
      return true;
    }
    else
    {
      return false;
    }
  } // end public function getExists */

  /**
  * Daten einer bestimmten Urlvariable erfragen
  *
  * @param string Key Name der zu erfragende $this->get Variable
  * @param string/array $validator
  * @param string/array $message
  * @return string
  */
  public function get( $key = null , $validator = null , $message = null )
  {

    if($validator)
    {
      $filter = Validator::getActive();
      $filter->clean(); //

      if( is_string($key) )
      {

        if(isset( $this->get[$key]) )
        {
          $fMethod = 'add'.ucfirst($validator);

          if( $error = $filter->$fMethod( $key , $this->get[$key] ) )
          {
            if( $message === true)
            {
              throw new Security_Exception($error);
            }
            elseif( is_string($message) )
            {
              Message::addError($message);
              return null;
            }
            else
            {
              return null;
            }
          }

          return $filter->getData($key);
        }
        else
        {
          return null;
        }

      }
      elseif( is_array($key) )
      {
        $data = array();

        if( is_array($validator) )
        {
          foreach( $key as $id )
          {
            $fMethod = 'add'.ucfirst($validator[$id] );

            if( isset($this->get[$id]) )
            {
              $filter->$fMethod( $this->get[$id], $id );
              $data[$id] = $filter->getData($id);
            }
            else
            {
              $data[$id] = null;
            }
          }
        }
        else
        {
          foreach( $key as $id )
          {
            $fMethod = 'add'.ucfirst($validator);

            if( isset($this->get[$id]) )
            {
              $filter->$fMethod( $this->get[$id], $id );
              $data[$id] = $filter->getData($id);
            }
            else
            {
              $data[$id] = null;
            }
          }
        }

        return $data;
      }
      else
      {
        Log::warn( 'Falschen Datentyp zum Variablen anfordern übergeben' );

        return null;
      }
    }// if($validator)
    else
    {
      if( is_string($key) )
      {
        return isset( $this->get[$key] )? $this->get[$key] :null;
      }
      elseif( is_array($key) )
      {
        $data = array();

        foreach( $key as $id )
        {
          $data[$id] = isset( $this->get[$id] )? $this->get[$id] :null;
        }

        return $data;
      }
      elseif( is_null($key) )
      {
        return $this->get;
      }
      else
      {
        Log::warn(  'Falschen Datentyp zum Variablen anfordern übergeben' );

        return null;
      }
    }

  } // end public function getUrlVar

 /**
  * Hinzufügen oder ersetzten einer Variable in der URL
  *
  * @param string $key Name des Urlkeys
  * @param string $data Die Daten für die Urlvar
  * @return bool
  */
  public function addGet( $key, $data = null  )
  {

    if( is_array($key) )
    {
      $this->get = array_merge($this->get,$key);
    }
    else
    {
      $this->get[$key] = $data;
    }

  } // end public function addUrlVar



  /**
   * Abfragen des Status einer POST Variable
   *
   * @param string Key Name der zu prüfenden Variable
   * @return bool
   */
  public function postExists( $key , $subkey = null )
  {

    if( !is_null($subkey) )
    {
      if(isset( $this->post[$key][$subkey] ))
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      if(isset( $this->post[$key] ))
      {
        return true;
      }
      else
      {
        return false;
      }
    }

  } // end public function postExists */

  /**
  * Auslesen einer Postvariable
  *
  * @param array/string[optional] Array mit Namen von Keys / Key Name der Variable
  * @param string $validator
  * @param string $subkey
  * @param string $message
  * @return array
  */
  public function post( $key = null , $validator = null , $subkey = null , $message = null  )
  {

    if( $validator )
    {
      $filter = Validator::getActive();
      $filter->clean(); // first clean the filter

      if( is_string($key) )
      {

        if($subkey)
        {
          if(isset($this->post[$key][$subkey]))
          {
            $data = $this->post[$key][$subkey];
          }
          else
          {
            return null;
          }
        }//end if $subkey
        else
        {
          if(isset($this->post[$key]))
          {
            $data = $this->post[$key];
          }
          else
          {
            return null;
          }
        }

        $fMethod = 'add'.ucfirst($validator);

        if( is_array($data) )
        {
          // Clean all the same way
          // Good architecture :-)
          return $this->validateArray($fMethod , $data );

        }
        else
        {
          // clean only one
          if(!$filter->$fMethod($key,$data))
          {
            return $filter->getData($key);
          }
          else
          {
            Message::addError($message);
            return;
          }

        }

      }// end is_string($key)
      elseif( is_array($key) )
      {
        $data = array();

        if( is_array($validator) )
        {
          foreach( $key as $id )
          {
            $fMethod = 'add'.ucfirst($validator[$id] );

            if( isset($this->post[$id]) )
            {
              $filter->$fMethod( $this->post[$id], $id );
              $data[$id] = $filter->getData($id);
            }
            else
            {
              $data[$id] = null;
            }
          }
        }
        else
        {
          foreach( $key as $id )
          {
            $fMethod = 'add'.ucfirst($validator);

            if( isset($this->post[$id]) )
            {
              $filter->$fMethod( $this->post[$id], $id );
              $data[$id] = $filter->post($id);
            }
            else
            {
              $data[$id] = null;
            }
          }
        }

        return $data;
      }
    }//end if $validator
    else // else $validator
    {
      if( is_string($key) )
      {
        if($subkey)
        {
          return isset($this->post[$key][$subkey])
            ?$this->post[$key][$subkey]:null;
        }
        else
        {
          return isset($this->post[$key])
            ?$this->post[$key]:null;
        }
      }
      elseif( is_array($key) )
      {
        $data = array();

        foreach( $key as $id )
        {
          $data[$id] = isset( $this->post[$id] )
            ? $this->post[$id] :null;
        }

        return $data;
      }
      elseif( is_null($key) )
      {
        return $this->post;
      }
      else
      {
        return null;
      }
    }

  } // end public function post

  /**
   * remove some variables from the url
   *
   */
  public function removePost( $key , $subkey = null )
  {

    if( is_null($subkey) )
    {
      if( isset( $this->post[$key]) )
      {
        unset($this->post[$key]);
      }
    }
    else
    {
      if( isset( $this->post[$key][$subkey]) )
      {
        unset($this->post[$key][$subkey]);
      }
    }

  }//end public function removePost */

  /**
   * Enter description here...
   *
   * @param string $fMethod
   * @param array $data
   * @return array
   */
  protected function validateArray($fMethod , $data )
  {

    $filter = Validator::getActive();
    $filter->clean();

    $back= array();

    // Clean all the same way
    // Good architecture :-)
    foreach( $data as $key => $value )
    {
      if( is_array($value) )
      {
        $back[$key] = $this->validateArray( $fMethod , $value );
      }
      else
      {
        $filter->$fMethod($key,$value);
        $back = array_merge($back,$filter->getData());
      }
    }

    return $back;

  }//end protected function validateArray($fMethod , $data )

  /**
   * request if one or more values are empty
   *
   * @param string Key Name der zu prüfenden Variable
   * @return bool
   */
  public function postEmpty( $keys , $subkey = null )
  {

    if( $subkey )
    {
      if( is_array($keys) )
      {

        foreach( $keys as $key )
        {

          if( !isset( $this->post[$subkey][$key] ) )
          {
            return true;
          }

          if( trim($this->post[$subkey][$key]) == '' )
          {
            return true;
          }

          return false;

        }

      }
      else
      {

        if( !isset( $this->post[$subkey][$keys] ) )
        {
          return true;
        }

        if( trim($this->post[$subkey][$keys]) == '' )
        {
          return true;
        }

        return false;

      }
    }
    else
    {
      if( is_array($keys) )
      {

        foreach( $keys as $key )
        {

          if( !isset( $this->post[$key] ) )
          {
            return true;
          }

          if( trim($this->post[$key]) == '' )
          {
            return true;
          }

          return false;

        }

      }
      else
      {

        if( !isset( $this->post[$keys] ) )
        {
          return true;
        }

        if( trim($this->post[$keys]) == '' )
        {
          return true;
        }

        return false;

      }
    }

  } // end public function postEmpty

  /**
  * request if we have a cookie with this name
  *
  * @param string Key Name des zu testenden Cookies
  * @return bool
  */
  public function issetCookie( $key  )
  {
    return isset( $this->cookie[$key] );
  } // end of member function issetCookie

 /**
  * Abfragen einer bestimmten Postvariable
  *
  * @param string Key Name des angefragten Cookies
  * @return string
  */
  public function cookie( $key = null , $validator = null, $message = null )
  {

    if( is_null($key) )
    {
      return Db::addSlashes($this->cookie);
    }

    if($validator)
    {
      $filter = Validator::getActive();
      $filter->clean(); // first clean the filter

      if(isset( $this->cookie[$key] ))
      {
        $fMethod = 'add'.ucfirst($validator);
        $filter->$fMethod($this->cookie[$key],$key);

        return Db::addSlashes($filter->getData($key));
      }
      else
      {
        return null;
      }
    }
    else
    {
      if(isset( $this->cookie[$key] ))
      {
        return Db::addSlashes($this->cookie[$key]);
      }
      else
      {
        return null;
      }
    }
  } // end of member function cookie */

 /**
  * Request if a File Upload Exists
  *
  * @param string Key Name des zu testenden Cookies
  * @return bool
  */
  public function fileExists( $key )
  {
    if( isset( $this->files[$key] ) )
    {
      return true;
    }
    else
    {
      return false;
    }
  } // end public function fileExists */

 /**
  * Request if a File Upload Exists
  *
  * @param string $key Name des zu testenden Cookies
  * @param string $typ Name des zu testenden Cookies
  * @param string $message
  * @return bool
  */
  public function file( $key = null , $type = null, $message = null )
  {
    if( is_null($key) )
    {
      return $this->files;
    }

    if( $typ )
    {

      if( isset( $this->files[$key] ) )
      {
        $classname = 'LibUpload'.SParserString::subToCamelCase($type);

        if( !WebFrap::loadable($classname) )
        {
          throw new LibUploadException('Uploadtype: '.ucfirst($type).' not exists');
        }
        else
        {
          $upload = new $classname($this->files[$key]);
        }

        return $upload;

      }
      else
      {
        return null;
      }
    }
    else
    {
      if( isset( $this->files[$key] ) )
      {

        return $this->files[$key];
      }
      else
      {
        return array();
      }
    }
  } // end public function getUploadedFile( $key,$typ) )

  /**
  * request if we have a cookie with this name
  *
  * @param string Key Name des zu testenden Cookies
  * @return bool
  */
  public function serverExists( $key  )
  {

    if( isset( $this->server[$key] ) )
    {
      return true;
    }
    else
    {
      return false;
    }
  } // end of member function serverExists

  /**
  * Abfragen einer bestimmten Postvariable
  *
  * @param string Key Name des angefragten Cookies
  * @return string
  */
  public function server( $key = null , $validator = null, $message = null )
  {

    if( is_null($key) )
    {
      return Db::addSlashes($this->server);
    }

    if($validator)
    {
      $filter = Validator::getActive();
      $filter->clean(); // first clean the filter

      if(isset( $this->server[$key] ))
      {
        $fMethod = 'add'.ucfirst($validator);
        $filter->$fMethod($this->server[$key],$key);

        return Db::addSlashes($filter->getData($key));
      }
      else
      {
        return null;
      }
    }
    else
    {
      if(isset( $this->server[$key] ))
      {
        return Db::addSlashes($this->server[$key]);
      }
      else
      {
        return null;
      }
    }
  } // end public function server( $key = null , $validator = null )

  /**
  * request if we have a cookie with this name
  *
  * @param string Key Name des zu testenden Cookies
  * @return bool
  */
  public function envExists( $key  )
  {

    if( isset( $_ENV[$key] ) )
    {
      return true;
    }
    else
    {
      return false;
    }

  } // end public function envExists */

  /**
  * Abfragen einer bestimmten Postvariable
  *
  * @param string $key name of the requested env value
  * @param string $validator the validatorname
  * @return mixed
  */
  public function env( $key = null , $validator = null, $message = null )
  {
    if( is_null($key) )
    {
      return Db::addSlashes($_ENV);
    }

    if($validator)
    {
      $filter = Validator::getActive();
      $filter->clean(); // first clean the filter

      if(isset( $_ENV[$key] ))
      {
        $fMethod = 'add'.ucfirst($validator);
        $filter->$fMethod($_ENV[$key],$key);

        return Db::addSlashes($filter->getData($key));
      }
      else
      {
        return null;
      }
    }
    else
    {
      if(isset( $_ENV[$key] ))
      {
        return Db::addSlashes($this->server[$key]);
      }
      else
      {
        return null;
      }
    }
  } // end public function env */


  /** method for validating formdata
   * if an error is found an message will be send to system, if you want to find
   * out if the test failed ask the system if there are any error messages
   *
   *
   * @param array $values
   * @param array $messages
   * @param string $subkey
   * @return ObjValidatorUserinputAbstract
   *
   */
  public function checkFormInput( $values , $messages, $subkey = null , $rules = array(), $ruleMessages = array() )
  {

    $sys = Webfrap::getActive();

    // get Validator from Factory
    $filter = Validator::getValidator();
    $filter->clean();

    if( $subkey )
    {// check if we have a subkey
      foreach( $values as $key => $value )
      {
        $method = 'add'.$value[0] ;

        if( isset($this->post[$subkey][$key]) )
        {
          $data = $this->post[$subkey][$key];
        }
        else
        {
          $data = null;
        }

        if( $error = $filter->$method( $key , $data, $value[1] , $value[2] , $value[3] ) )
        {
          if( isset( $messages[$key][$error] ) )
          {
            $sys->addError( $messages[$key][$error] );
          }
          elseif( isset( $messages[$key]['default'] ) )
          {
            $sys->addError( $messages[$key]['default'] );
          }
          else
          {
            $sys->addError( 'Wrong data for '.$key  );
          }
        }
      }
    }
    else
    {// we have no subkey geht direct
      foreach( $values as $key => $value )
      {
        $method = 'add'.$value[0] ;

        if( isset($this->post[$key]) )
        {
          $data = $this->post[$key];
        }
        else
        {
          continue;
        }

        if( $error = $filter->$method( $key , $data, $value[1] , $value[2] , $value[3] ) )
        {
          if( isset( $messages[$key][$error] ) )
          {
            $sys->addError( $messages[$key][$error] );
          }
          elseif( isset( $messages[$key]['default'] ) )
          {
            $sys->addError( $messages[$key]['default'] );
          }
          else
          {
            $sys->addError( 'Wrong data for '.$key  );
          }
        }

      }
    }

    return $filter;

  }//end public function checkFormInput

  /** method for validating formdata
   * if an error is found an message will be send to system, if you want to find
   * out if the test failed ask the system if there are any error messages
   *
   *
   * @param array $values
   * @param array $messages
   * @param string $subkey
   * @return ObjValidatorUserinputAbstract
   *
   */
  public function checkSearchInput( $values , $messages, $subkey = null , $rules = array(), $ruleMessages = array() )
  {

    $sys = Webfrap::getActive();

    // get Validator from Factory
    $filter = Validator::getActive();
    $filter->clean();

    if( $subkey )
    {// check if we have a subkey
      foreach( $values as $key => $value )
      {
        if(Log::$levelTrace)
          Log::logTrace(__file__,__line__, "with Subjey: $subkey Key $key");

        $method = 'add'.$value[0] ;

        if( isset($this->get[$subkey][$key]) )
        {
          $data = $this->get[$subkey][$key];
        }
        else
        {
          $data = null;
        }

        if( $error = $filter->$method( $key , $data, false , $value[2] , $value[3] ) )
        {
          if( isset( $messages[$key][$error] ) )
          {
            $sys->addError( $messages[$key][$error] );
          }
          elseif( isset( $messages[$key]['default'] ) )
          {
            $sys->addError( $messages[$key]['default'] );
          }
          else
          {
            $sys->addError( 'Wrong data for '.$key  );
          }
        }
      }
    }
    else
    {// we have no subkey geht direct
      foreach( $values as $key => $value )
      {
        if(Log::$levelTrace)
          Log::logTrace(__file__,__line__, "Key $key");

        $method = 'add'.$value[0] ;

        if( isset($this->get[$key]) )
        {
          $data = $this->get[$key];
        }
        else
        {
          continue;
        }

        if( $error = $filter->$method( $key , $data, false , $value[2] , $value[3] ) )
        {
          if( isset( $messages[$key][$error] ) )
          {
            $sys->addError( $messages[$key][$error] );
          }
          elseif( isset( $messages[$key]['default'] ) )
          {
            $sys->addError( $messages[$key]['default'] );
          }
          else
          {
            $sys->addError( 'Wrong data for '.$key  );
          }
        }

      }
    }

    if(Log::$levelTrace)
    {
      Debug::logDump( '$filter: '.__file__.':'.__line__, $filter);
      Debug::console('$filter search input',$filter);
    }

    return $filter;

  }//end public function checkSearchInput

  /** method for validating formdata
   * if an error is found an message will be send to system, if you want to find
   * out if the test failed ask the system if there are any error messages
   *
   *
   * @param array $values
   * @param array $messages
   * @param string $subkey
   * @return array
   *
   */
  public function checkMultiFormInput( $values , $messages, $subkey = null , $rules = array() , $ruleMessages = array() )
  {

    // check if data exists, if not return an empty array
    if(!isset($this->post[$subkey]) || !is_array($this->post[$subkey]) )
    {
      Log::warn( 'invalid data for subkey: '.$subkey );
      return array();
    }

    $sys = Webfrap::getActive();

    // get Validator from Factory
    $filter = Validator::getActive();
    $filtered = array();

    foreach( $this->post[$subkey] as $rowPos => $row )
    {
      $filter->clean();

      foreach( $values as $key => $value )
      {

        $method = 'add'.$value[0] ;

        if( !isset($row[$key]) )
        {
          continue;
        }

        $data = $row[$key];

        if( $error = $filter->$method( $key , $data, $value[1] , $value[2] , $value[3] ) )
        {
          if( isset( $messages[$key][$error] ) )
          {
            $sys->addError( $messages[$key][$error] );
          }
          elseif( isset( $messages[$key]['default'] ) )
          {
            $sys->addError( $messages[$key]['default'] );
          }
          else
          {
            $sys->addError( 'Wrong data for '.$key  );
          }
        }
      }//end foreach

      $filtered[$rowPos] = $filter->getData();

    }//end foreach( $this->post[$subkey] as $id => $row )

    return $filtered;

  }//end public function checkMultiFormInput

  /** method for validating formdata
   * if an error is found an message will be send to system, if you want to find
   * out if the test failed ask the system if there are any error messages
   *
   *
   * @param array $values
   * @param array $messages
   * @param string $subkey
   * @return ObjValidatorUserinputAbstract
   *
   */
  public function checkMultiInputLang( $values , $messages, $subkey = null , $rules = array() , $ruleMessages = array() )
  {

    $sys = Webfrap::getActive();

    // get Validator from Factory
    $filter = Validator::getActive();

    $filtered = array();

    foreach( $this->post[$subkey] as $id => $row )
    {
      $filter->clean();

      foreach( $values as $key => $value )
      {

        $method = 'add'.$value[0] ;

        if( isset($row[$key]) )
        {
          $data = $row[$key];
        }
        else
        {
          $data = null;
        }

        if( $error = $filter->$method( $key , $data, $value[1] , $value[2] , $value[3] ) )
        {
          if( isset( $messages[$key][$error] ) )
          {
            Error::report( $messages[$key][$error] );
          }
          elseif( isset( $messages[$key]['default'] ) )
          {
            Error::report( $messages[$key]['default'] );
          }
          else
          {
            Error::report( 'Wrong data for '.$key  );
          }
        }
      }

      // now we check if the input ist empty
      // if there are any other data then the language id the entry gets kicked
      $filtr = $filter->getData();

      $isEmpty = true;

      foreach( $filtr as $key => $tmpVal )
      {
        //test if we have a non row oder lang id attribute thats not empty
        if( $key != WBF_DB_KEY && $key != 'id_lang' && trim($tmpVal) != '' )
        {
          $isEmpty = false;
          break;
        }
      }

      if( !$isEmpty )
      {
        $filtered[$id] = $filtr;
      }

    }//end foreach( $this->post[$subkey] as $id => $row )


    return $filtered;

  }//end public function checkMultiInputLang

  /**
   * @param string $key
   * @param string $subkey
   */
  public function checkMultiIds( $key , $subkey = null )
  {

    $ids = array();

    if($subkey)
    {
      foreach( $this->post[$key][$subkey] as $val )
      {
        if( is_numeric($val) )
        {
          $ids[] = $val;
        }
      }
    }
    else
    {
      foreach( $this->post[$key] as $val )
      {
        if( is_numeric($val) )
        {
          $ids[] = $val;
        }
      }
    }

    return $ids;

  }//end public function checkMultiIds */


  /**
   * @return string
   */
  public function dumpAsJson()
  {

    $requestData = array();
    $requestData['server'] = $this->server;
    $requestData['params'] = $this->get;
    $requestData['cookie'] = $this->cookie;
    $requestData['data'] = $this->post;

    return json_encode( $requestData );

  }//end public function dumpAsJson */

}// end class LibRequestPool


