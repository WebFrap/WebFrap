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
class LibRequestCli
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var array
   */
  protected $params = null;

  /**
   * @var array
   */
  protected $data = null;
  
  /**
   * @var string
   */
  public $type = 'cli';


  /**
   *
   */
  public function init()
  {


    /*
    if ( isset($_SERVER['argv'][2] ) )
    {
      parse_str($_SERVER['argv'][2], $this->params );
      echo $_SERVER['argv'][2];
    }
    */


    if ( isset($_SERVER['argv'][1]) )
    {
      $this->params['c'] = $_SERVER['argv'][1];
    }

    for($nam = 2 ; $nam < $_SERVER['argc'] ; ++$nam )
    {
      $tmp = explode('=',$_SERVER['argv'][$nam],2);
      $this->params[$tmp[0]] = isset($tmp[1])?$tmp[1]:true;
    }


  }//end public function init */


/*//////////////////////////////////////////////////////////////////////////////
// getter for the parameters
//////////////////////////////////////////////////////////////////////////////*/


/**
   * Funktion zum testen ob eine bestimmte Urlvariable existiert
   *
   * @param string Key Name der zu erfragende $this->params Variable
   * @return bool
   */
  public function paramExists($key )
  {

    if ( isset($this->params[$key] ) )
    {
      return true;
    } else {
      return false;
    }
  } // end public function paramExists */

  /**
  * Daten einer bestimmten Urlvariable erfragen
  *
  * @param string Key Name der zu erfragende $this->params Variable
  * @return string
  */
  public function param($key = null , $validator = null , $message = null )
  {

    if ($validator)
    {
      $filter = Validator::getActive();
      $filter->clean(); //

      if ( is_string($key) )
      {

        if (isset($this->params[$key]) )
        {
          $fMethod = 'add'.ucfirst($validator);

          if ($error = $filter->$fMethod($key , $this->params[$key] ) )
          {
            if ($message === true)
            {
              throw new Security_Exception($error);
            }
            elseif ( is_string($message) )
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
      elseif ( is_array($key) )
      {
        $data = array();

        if ( is_array($validator) )
        {
          foreach($key as $id )
          {
            $fMethod = 'add'.ucfirst($validator[$id] );

            if ( isset($this->params[$id]) )
            {
              $filter->$fMethod($this->params[$id], $id );
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
          foreach($key as $id )
          {
            $fMethod = 'add'.ucfirst($validator);

            if ( isset($this->params[$id]) )
            {
              $filter->$fMethod($this->params[$id], $id );
              $data[$id] = $filter->getData($id);
            }
            else
            {
              $data[$id] = null;
            }
          }
        }

        return $data;
      } else {
        Log::warn(
          'Falschen Datentyp zum Variablen anfordern übergeben' );

        return null;
      }
    }// if ($validator)
    else
    {
      if ( is_string($key) )
      {
        return isset($this->params[$key] )? $this->params[$key] :null;
      }
      elseif ( is_array($key) )
      {
        $data = array();

        foreach($key as $id )
        {
          $data[$id] = isset($this->params[$id] )? $this->params[$id] :null;
        }

        return $data;
      }
      elseif (is_null($key) )
      {
        return $this->params;
      } else {
        Log::warn(
          'Falschen Datentyp zum Variablen anfordern übergeben' );

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
  public function addParam($key, $data = null  )
  {

    if ( is_array($key) )
    {
      $this->params = array_merge($this->params,$key);
    } else {
      $this->params[$key] = $data;
    }

  } // end public function addParam */

  /**
   * remove some variables from the url
   * @param string $key
   */
  public function removeParam($key )
  {
    if ( isset($this->params[$key]) )
    {
      unset($this->params[$key]);
    }

  }//end public function removeParam */

/*//////////////////////////////////////////////////////////////////////////////
// data
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Abfragen des Status einer POST Variable
   *
   * @param string Key Name der zu prüfenden Variable
   * @return bool
   */
  public function dataExists($key , $subkey = null )
  {

    if (!is_null($subkey) )
    {
      if (isset($this->data[$key][$subkey] ))
      {
        return true;
      } else {
        return false;
      }
    } else {
      if (isset($this->data[$key] ))
      {
        return true;
      } else {
        return false;
      }
    }

  } // end public function dataExists */

  /**
   * Abfragen des Status einer POST Variable
   *
   * @param string Key Name der zu prüfenden Variable
   * @return bool
   */
  public function dataSearchIds($key )
  {

    if (!isset($this->data[$key] ) || !is_array($this->data[$key] ) )
      return array();

    $keys = array_keys($this->data[$key]);

    $tmp = array();

    foreach($keys as $key )
    {

      if ( 'id_' == substr($key , 0, 3 ) )
        $tmp[] = $key;
    }

    return $tmp;

  } // end public function dataSearchIds */

  /**
  * Auslesen einer Postvariable
  *
  * @param array/string[optional] Array mit Namen von Keys / Key Name der Variable
  * @return array
  */
  public function data($key = null , $validator = null , $subkey = null , $message = null  )
  {

    if ($validator )
    {
      $filter = Validator::getActive();
      $filter->clean(); // first clean the filter

      if ( is_string($key) )
      {

        if ($subkey)
        {
          if (isset($this->data[$key][$subkey]))
          {
            $data = $this->data[$key][$subkey];
          }
          else
          {
            return null;
          }
        }//end if $subkey
        else
        {
          if (isset($this->data[$key]))
          {
            $data = $this->data[$key];
          }
          else
          {
            return null;
          }
        }

        $fMethod = 'add'.ucfirst($validator);

        if ( is_array($data) )
        {
          // Clean all the same way
          // Good architecture :-)
          return $this->validateArray($fMethod , $data );
        }
        else
        {
          // clean only one
          if (!$error = $filter->$fMethod($key,$data))
          {
            return $filter->getData($key);
          }
          else
          {
            Message::addError( ($message?$message:$error) ) ;
            return;
          }

        }

      }// end is_string($key)
      elseif ( is_array($key) )
      {
        $data = array();

        if ( is_array($validator) )
        {
          foreach($key as $id )
          {
            $fMethod = 'add'.ucfirst($validator[$id] );

            if ( isset($this->data[$id]) )
            {
              $filter->$fMethod($this->data[$id], $id );
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
          foreach($key as $id )
          {
            $fMethod = 'add'.ucfirst($validator);

            if ( isset($this->data[$id]) )
            {
              $filter->$fMethod($this->data[$id], $id );
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
      if ( is_string($key) )
      {
        if ($subkey)
        {
          return isset($this->data[$key][$subkey])
            ?$this->data[$key][$subkey]:null;
        }
        else
        {
          return isset($this->data[$key])
            ?$this->data[$key]:null;
        }
      }
      elseif ( is_array($key) )
      {
        $data = array();

        foreach($key as $id )
        {
          $data[$id] = isset($this->data[$id] )? $this->data[$id] :null;
        }

        return $data;
      }
      elseif (is_null($key) )
      {
        return $this->data;
      } else {
        return null;
      }
    }

  } // end public function data */

  /**
   * remove some variables from the url
   *
   */
  public function removeData($key , $subkey = null )
  {

    if (is_null($subkey) )
    {
      if ( isset($this->data[$key]) )
      {
        unset($this->data[$key]);
      }
    } else {
      if ( isset($this->data[$key][$subkey]) )
      {
        unset($this->data[$key][$subkey]);
      }
    }

  }//end public function removeData */

  /**
   * request if one or more values are empty
   *
   * @param string Key Name der zu prüfenden Variable
   * @return bool
   */
  public function dataEmpty($keys , $subkey = null )
  {

    if ($subkey )
    {
      if ( is_array($keys) )
      {

        foreach($keys as $key )
        {

          if (!isset($this->data[$subkey][$key] ) )
          {
            return true;
          }

          if (trim($this->data[$subkey][$key]) == '' )
          {
            return true;
          }

          return false;

        }

      } else {

        if (!isset($this->data[$subkey][$keys] ) )
        {
          return true;
        }

        if (trim($this->data[$subkey][$keys]) == '' )
        {
          return true;
        }

        return false;

      }
    } else {
      if ( is_array($keys) )
      {

        foreach($keys as $key )
        {

          if (!isset($this->data[$key] ) )
            return true;

          if (trim($this->data[$key]) == '' )
            return true;

          return false;

        }

      } else {

        if (!isset($this->data[$keys] ) )
          return true;

        if (trim($this->data[$keys]) == '' )
          return true;

        return false;

      }
    }

  } // end public function dataEmpty */


  public function method()
  {
    return 'CLI';
  }
  
/*//////////////////////////////////////////////////////////////////////////////
// read
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   */
  public function read()
  {
    return fgets(STDIN);
  }//end public function read */

}// end class RequestCli

