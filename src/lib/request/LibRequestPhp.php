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
class LibRequestPhp
{
/*//////////////////////////////////////////////////////////////////////////////
// Attribute
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $type = 'http';

  /**
   *
   * @var array
   */
  protected $browserInfo = array();

  /**
   * @var LibResponseHttp
   */
  protected $response = null;

  /**
   * @var LibDbConnection
   */
  protected $db = null;

  /**
   * @var string
   */
  protected $serverAddress = null;

  /**
   * @var string
   */
  protected $fullRequest = null;

/*//////////////////////////////////////////////////////////////////////////////
// Init
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   *
   */
  public function init()
  {

    // bei PUT requests PUT in $_POST schieben
    if ($this->method('PUT')) {
      mb_parse_str(file_get_contents("php://input"),$_POST);
    }

    if (DEBUG) {
      Debug::console('Data URL' , $_SERVER['REQUEST_URI']);
      Debug::console('Data GET' , $_GET);
      Debug::console('Data POST' , $_POST);
      Debug::console('Data FILES' , $_FILES);
      Debug::console('Data COOKIE' , $_COOKIE);
      Debug::console('Data SERVER' , $_SERVER);
    }

  }//end public function init */

  /**
   * @param string $key
   */
  public function getSubRequest($key)
  {

    if (!isset($_POST[$key])) {

      return null;

    } else {

      return new LibRequestSubrequest(
        $this,
        $_POST[$key],
        (isset($_FILES[$key])?$_FILES[$key]:array())
      );
    }

  }//end public function getSubRequest */

  /**
   * @param LibResponseHttp $response
   */
  public function setResponse($response)
  {

    $this->response = $response;

  }//end public function getResponse */

  /**
   * @param LibResponseHttp $response
   */
  public function resetResponse($response = null)
  {

    if ($response)
      $this->response = $response;
    else
      $this->response = Webfrap::$env->getResponse();

  }//end public function resetResponse */

  /**
   * @return LibResponseHttp
   */
  public function getResponse()
  {

    if (!$this->response) {
      $this->response = Webfrap::$env->getResponse();
    }

    return $this->response;

  }//end public function getResponse */

  /**
   * @return LibDbOrm
   */
  public function getOrm()
  {

    if (!$this->db) {
      $this->db = Webfrap::$env->getDb();
    }

    return $this->db->getOrm();

  }//end public function getOrm */

  /**
   * @return LibDbOrm
   */
  public function getDb()
  {

    if (!$this->db) {
      $this->db = Webfrap::$env->getDb();
    }

    return $this->db;

  }//end public function getDb */

/*//////////////////////////////////////////////////////////////////////////////
// getter + setter Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Funktion zum testen ob eine bestimmte Urlvariable existiert
   *
   * @param string Key Name der zu erfragende $_GET Variable
   * @return bool
   */
  public function getExists($key)
  {

    if (isset($_GET[$key])) {
      return true;
    } else {
      return false;
    }

  }// end public function getExists */

  /**
  * Daten einer bestimmten Urlvariable erfragen
  *
  * @param string $key Name der zu erfragende $_GET Variable
  * @param string $validator Name der zu erfragende $_GET Variable
  * @param string $message Name der zu erfragende $_GET Variable
  * @return string
  *
  * @deprecated
  */
  public function get($key = null, $validator = null, $message = null)
  {

    return $this->param($key, $validator, $message);

  } // end public function get */

 /**
  * Hinzufügen oder ersetzten einer Variable in der URL
  *
  * @param string $key Name des Urlkeys
  * @param string $data Die Daten für die Urlvar
  * @return bool
  *
  * @deprecated
  */
  public function addGet($key, $data = null)
  {

    if (is_array($key)) {
      $_GET = array_merge($_GET,$key);
    } else {
      $_GET[$key] = $data;
    }

  } // end public function addGet */

  /**
   * Funktion zum testen ob eine bestimmte Urlvariable existiert
   *
   * @param string Key Name der zu erfragende $_GET Variable
   * @return bool
   */
  public function paramExists($key)
  {

    if (isset($_GET[$key])) {
      return true;
    } else {
      return false;
    }

  } // end public function paramExists */

  /**
  * Daten einer bestimmten Urlvariable erfragen
  *
  * @param string Key Name der zu erfragende $_GET Variable
  * @param string $validator
  * @param boolean $onlyTrue wenn true werden nur werte zurückgegeben die auf true casten
  * @param boolean $asArray Rückgabe als array und nicht als TArray
  * @return TArray
  */
  public function paramList($key, $validator, $onlyTrue = false, $asArray = false)
  {

    $response = $this->getResponse();

    $filter = Validator::getActive();
    $filter->clean(); // first clean the filter

    $paramList = new TArray();

    if (isset($_GET[$key])) {
      $data = $_GET[$key];

      if (!is_array($data)) {
        Debug::console("Expexted an array but got a scalar in paramList key: {$validator}");

        // nur den array zurück geben
        if ($asArray)
          return array();

        return $paramList;
      }

    } else {

      // nur den array zurück geben
      if ($asArray)
        return array();

      return $paramList;
    }

    $fMethod = 'add'.ucfirst($validator);

    // clean only one
    foreach ($data as $key => $value) {
      $error = $filter->$fMethod($key, $value);
      if (!$error) {

        if ($onlyTrue) {

          $tmp = $filter->getData($key);

          if ((int)$tmp) {
            $paramList->$key = $tmp;
          }

        } else {
          $paramList->$key = $filter->getData($key);
        }

      } else {

        $response->addError($error) ;
        continue;
      }
    }

    // nur den array zurück geben
    if ($asArray)
      return $paramList->content();

    return $paramList;

  } // end public function paramList */

  /**
  * Daten einer bestimmten Urlvariable erfragen
  *
  * @param string Key Name der zu erfragende $_GET Variable
  * @return string
  */
  public function param($key = null, $validator = null, $subkey = null, $message = null)
  {

    $response = $this->getResponse();

    if ($validator) {
      $filter = Validator::getActive();
      $filter->clean(); // first clean the filter

      if (is_string($key)) {

        if ($subkey) {

          if (isset($_GET[$key][$subkey])) {
            $data = $_GET[$key][$subkey];
          } else {
            return null;
          }

        }//end if $subkey
        else {

          if (isset($_GET[$key])) {
            $data = $_GET[$key];
          } else {
            return null;
          }

        }

        $fMethod = 'add'.ucfirst($validator);

        if (is_array($data)) {
          // Clean all the same way
          // Good architecture :-)
          return $this->validateArray($fMethod , $data);

        } else {
          // clean only one
          if (!$error = $filter->$fMethod($key, $data)) {
            return $filter->getData($key);
          } else {

            $response->addError(($message?$message:$error)) ;

            return;

          }

        }

      }// end is_string($key)
      elseif (is_array($key)) {
        $data = array();

        if (is_array($validator)) {
          foreach ($key as $id) {
            $fMethod = 'add'.ucfirst($validator[$id]);

            if (isset($_GET[$id])) {
              $filter->$fMethod($id, $_GET[$id]);
              $data[$id] = $filter->getData($id);
            } else {
              //$filter->checkRequired($id);
              //$data[$id] = null;
            }

          }

        } else {

          foreach ($key as $id) {
            $fMethod = 'add'.ucfirst($validator);

            if (isset($_GET[$id])) {
              $filter->$fMethod($id, $_GET[$id]);
              $data[$id] = $filter->getData($id);
            } else {
              //$filter->checkRequired($id);
              //$data[$id] = null;
            }
          }

        }

        return $data;
      }

    }//end if $validator
    else { // else $validator

      if (is_string($key)) {

        if ($subkey) {
          return isset($_GET[$key][$subkey])
            ?$_GET[$key][$subkey]:null;
        } else {
          return isset($_GET[$key])
            ?$_GET[$key]:null;
        }

      } elseif (is_array($key)) {

        $data = array();
        foreach ($key as $id) {

          if (array_key_exists($id, $_GET))
            $data[$id] = $_GET[$id];

          //$data[$id] = isset($_POST[$id])? $_POST[$id] :null;
        }

        return $data;
      } elseif (is_null($key)) {

        return $_GET;
      } else {

        return null;
      }

    }

  } // end public function param */

  /**
   * Daten einer bestimmten Urlvariable erfragen
   *
   * @param string $key Name der zu erfragende $_GET Variable
   * @param string $validator Der Validator key
   * @param string $subkey Wenn wir einen Wert aus einer Matrix möchten
   * @param LibDbConnection $db wenn mit übergeben wird das objekt zum escapen verwendet
   *  ist nicht zwangweise nötig da einige validatoren gar keine gefährlichen zeichen durch lassen
   *
   * @return string
   */
  public function paramQList($key, $validator, $subkey = null, $db = null)
  {

    $response = $this->getResponse();

    if ($subkey) {

      if (isset($_GET[$key][$subkey])) {
        $data = $_GET[$key][$subkey];
      } else {
        return "''";
      }

    } else {

      if (isset($_GET[$key])) {
        $data = $_GET[$key];
      } else {
        return "''";
      }

    }


    $filter = Validator::getActive();
    $filter->clean(); // first clean the filter

    $fMethod = 'add'.ucfirst($validator);
    $values = $this->validateArray($fMethod, $data, $db);

    return "'".implode("','",$values)."'";

  } // end public function paramQList */



 /**
  * Hinzufügen oder ersetzten einer Variable in der URL
  *
  * @param string $key Name des Urlkeys
  * @param string $data Die Daten für die Urlvar
  * @return bool
  */
  public function addParam($key, $data = null)
  {

    if (is_array($key)) {
      $_GET = array_merge($_GET,$key);
    } else {
      $_GET[$key] = $data;
    }

  } // end public function addParam */

  /**
   * remove some variables from the url
   *
   */
  public function removeParam($key)
  {
    if (isset($_GET[$key])) {
      unset($_GET[$key]);
    }

  }//end public function removeParam */

/*//////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////*/


  /**
  * Auslesen einer Postvariable
  *
  * @param array/string[optional] Array mit Namen von Keys / Key Name der Variable
  * @return array
  *
  * @deprecated
  */
  public function post($key = null , $validator = null , $subkey = null , $message = null , $required = false)
  {

    Log::warn('Called Request POST with key: '.$key);

    return $this->data($key, $validator, $subkey, $message, $required);

  }//end public function post */


/*//////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Abfragen des Status einer POST Variable
   *
   * @param string $key Name der zu prüfenden Variable
   * @param string $subkey
   *
   * @return bool
   */
  public function dataExists($key, $subkey = null)
  {

    if (!is_null($subkey)) {
      if (isset($_POST[$key][$subkey])) {
        return true;
      } else {
        return false;
      }
    } else {
      if (isset($_POST[$key])) {
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
  public function dataSearchIds($key)
  {

    if (!isset($_POST[$key]) || !is_array($_POST[$key]))
      return array();

    $keys = array_keys($_POST[$key]);

    $tmp = array();

    foreach ($keys as $key) {

      if ('id_' == substr($key , 0, 3))
        $tmp[] = $key;
    }

    return $tmp;

  } // end public function dataSearchIds */

  /**
   * Abfragen des Status einer POST Variable
   *
   * @param string Key Name der zu prüfenden Variable
   * @return bool
   */
  public function paramSearchIds($key)
  {

    if (!isset($_GET[$key]) || !is_array($_GET[$key]))
      return array();

    $keys = array_keys($_GET[$key]);

    $tmp = array();

    foreach ($keys as $key) {

      if ('id_' == substr($key , 0, 3))
        $tmp[] = $key;
    }

    return $tmp;

  } // end public function dataSearchIds */

  /**
  * Auslesen einer Postvariable
  *
  * @param string $key
  * @param string $validator
  * @param string $subkey
  * @param string $message
  *
  * @return array
  */
  public function data($key = null, $validator = null, $subkey = null, $message = null)
  {

    $response = $this->getResponse();

    if ($validator) {

      $filter = Validator::getActive();
      $filter->clean(); // first clean the filter

      if (is_string($key)) {

        if ($subkey) {

          if (isset($_POST[$key][$subkey])) {
            $data = $_POST[$key][$subkey];
          } else {
            return null;
          }

        }//end if $subkey
        else {

          if (isset($_POST[$key])) {
            $data = $_POST[$key];
          } else {
            return null;
          }

        }

        $fMethod = 'add'.ucfirst($validator);

        if (is_array($data)) {
          // Clean all the same way
          // Good architecture :-)
          return $this->validateArray($fMethod , $data);

        } else {
          // clean only one
          if (!$error = $filter->$fMethod($key, $data)) {
            return $filter->getData($key);
          } else {

            $response->addError(($message?$message:"{$key} was ".$error)) ;

            return;

          }

        }

      }// end is_string($key)
      elseif (is_array($key)) {
        $data = array();

        if (is_array($validator)) {
          foreach ($key as $id) {
            $fMethod = 'add'.ucfirst($validator[$id]);

            if (isset($_POST[$id])) {
              $filter->$fMethod($id, $_POST[$id]);
              $data[$id] = $filter->getData($id);
            } else {
              //$filter->checkRequired($id);
              //$data[$id] = null;
            }

          }

        } else {

          foreach ($key as $id) {
            $fMethod = 'add'.ucfirst($validator);

            if (isset($_POST[$id])) {
              $filter->$fMethod($id, $_POST[$id]);
              $data[$id] = $filter->getData($id);
            } else {
              //$filter->checkRequired($id);
              //$data[$id] = null;
            }
          }

        }

        return $data;
      }

    }//end if $validator
    else { // else $validator

      if (is_string($key)) {

        if ($subkey) {
          return isset($_POST[$key][$subkey])
            ?$_POST[$key][$subkey]:null;
        } else {
          return isset($_POST[$key])
            ?$_POST[$key]:null;
        }

      } elseif (is_array($key)) {
        $data = array();

        foreach ($key as $id) {

          if (array_key_exists($id, $_POST))
            $data[$id] = $_POST[$id];

          //$data[$id] = isset($_POST[$id])? $_POST[$id] :null;
        }

        return $data;
      } elseif (is_null($key)) {
        return $_POST;
      } else {
        return null;
      }

    }

  } // end public function data */

  /**
   * remove some variables from the url
   *
   */
  public function removeData($key , $subkey = null)
  {

    if (is_null($subkey)) {
      if (isset($_POST[$key])) {
        unset($_POST[$key]);
      }
    } else {
      if (isset($_POST[$key][$subkey])) {
        unset($_POST[$key][$subkey]);
      }
    }

  }//end public function removeData */

  /**
   * request if one or more values are empty
   *
   * @param string Key Name der zu prüfenden Variable
   * @return bool
   */
  public function dataEmpty($keys , $subkey = null)
  {

    if ($subkey) {
      if (is_array($keys)) {

        foreach ($keys as $key) {

          if (!isset($_POST[$subkey][$key])) {
            return true;
          }

          if (trim($_POST[$subkey][$key]) == '') {
            return true;
          }

          return false;

        }

      } else {

        if (!isset($_POST[$subkey][$keys])) {
          return true;
        }

        if (trim($_POST[$subkey][$keys]) == '') {
          return true;
        }

        return false;

      }

    } else {
      if (is_array($keys)) {

        foreach ($keys as $key) {

          if (!isset($_POST[$key]))
            return true;

          if (trim($_POST[$key]) == '')
            return true;

          return false;

        }

      } else {

        if (!isset($_POST[$keys]))
          return true;

        if (trim($_POST[$keys]) == '')
          return true;

        return false;

      }

    }

  } // end public function dataEmpty */

/*//////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Enter description here...
   *
   * @param string $fMethod
   * @param array $data
   * @param LibDbConnection $db wenn mit übergeben wird das objekt zum escapen verwendet
   *  ist nicht zwangweise nötig da einige validatoren gar keine gefährlichen zeichen durch lassen
   * @return array
   */
  protected function validateArray($fMethod , $data, $db = null)
  {

    $filter = Validator::getActive();

    /// TODO checken ob das hier eine Fehlerquelle ist
    /// da validate Array ja rekursiv augerufen werdden kann
    //$filter->clean();

    $back = array();

    // Clean all the same way
    // Good architecture :-)
    foreach ($data as $key => $value) {
      if (is_array($value)) {
        $back[$key] = $this->validateArray($fMethod , $value);
      } else {
        // jedes mal ein clean
        $filter->clean();
        $filter->$fMethod($key,$value);

        $tmp = $filter->getData();

        if ($db) {

          $back[$key] = $db->escape($tmp[$key]);
        } else {

          $back[$key] = $tmp[$key];
        }

      }
    }

    return $back;

  }//end protected function validateArray */

/*//////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////*/

  /**
  * request if we have a cookie with this name
  *
  * @param string Key Name des zu testenden Cookies
  * @return bool
  */
  public function issetCookie($key)
  {
    return isset($_COOKIE[$key]);

  } // end public function issetCookie */

 /**
  * Abfragen einer bestimmten Postvariable
  *
  * @param string Key Name des angefragten Cookies
  * @return string
  */
  public function cookie($key = null , $validator = null, $message = null)
  {

    if (is_null($key)) {
      return Db::addSlashes($_COOKIE);
    }

    if ($validator) {
      $filter = Validator::getActive();
      $filter->clean(); // first clean the filter

      if (isset($_COOKIE[$key])) {
        $fMethod = 'add'.ucfirst($validator);
        $filter->$fMethod($_COOKIE[$key],$key);

        return Db::addSlashes($filter->getData($key));
      } else {
        return null;
      }
    } else {
      if (isset($_COOKIE[$key])) {
         return Db::addSlashes($this->cookie[$key]);
      } else {
        return null;
      }
    }
  } // end public function cookie */

 /**
  * Request if a File Upload Exists
  *
  * @param string Key Name des zu testenden Cookies
  * @return bool
  */
  public function fileExists($key)
  {

    if (isset($_FILES[$key])) {
      return true;
    } else {
      return false;
    }

  } // end public function fileExists */

 /**
  * Request if a File Upload Exists
  *
  * @param string $key
  * @param string $type
  * @param string $subkey
  * @param string $message
  *
  * @return LibUploadFile
  */
  public function file($key = null, $type = null, $subkey = null, $message = null)
  {

    if (is_null($key)) {
      return $_FILES;
    }

    $filter = Validator::getActive();
    $filter->clean(); // first clean the filter

    if ($subkey) {
      // asume this was just an empty file
      if (!isset($_FILES[$subkey]) || '' == trim($_FILES[$subkey]['name'][$key])) {
        $data = null;
      } else {
        $data = array();
        $data['name'] = $_FILES[$subkey]['name'][$key];
        $data['type'] = $_FILES[$subkey]['type'][$key];
        $data['tmp_name'] = $_FILES[$subkey]['tmp_name'][$key];
        $data['error'] = $_FILES[$subkey]['error'][$key];
        $data['size'] = $_FILES[$subkey]['size'][$key];
      }
    } else {
      // asume this was just an empty file
      if (!isset($_FILES[$key]) || '' == trim($_FILES[$key]['name'])) {
        $data = null;
      } else {
        $data = $_FILES[$key];
      }
    }

    if (!$data)
      return null;

    if ($type) {
      $classname = 'LibUpload'.SParserString::subToCamelCase($type);

      if (!Webfrap::classExists($classname))
        throw new LibFlow_Exception('Requested nonexisting upload type: '.$classname);

      return new $classname($data, $key);

    } else {
      return new LibUploadFile($data);
    }

  } // end public function file */

  /**
   * Request if a File Upload Exists
   *
   * @param string $key
   * @param string $type
   * @param string $subkey
   * @param string $message
   *
   * @return LibUploadFile
   */
  public function files($key, $type = null, $subkey = null, $message = null)
  {

    $filter = Validator::getActive();
    $filter->clean(); // first clean the filter

    if ($type) {

      $classname = 'LibUpload'.SParserString::subToCamelCase($type);
      if (!Webfrap::classExists($classname))
        throw new LibFlow_Exception('Requested nonexisting upload type: '.$classname);

    } else {

      $classname = 'LibUploadFile';
    }

    $files = array();

    // asume this was just an empty file
    if (!isset($_FILES[$key]) || !count($_FILES[$key])) {

    } else {

      $numFiles = count($_FILES[$key]['name']);

      for ($pos = 0; $pos < $numFiles; ++$pos) {
        $file = array(
          'name' => $_FILES[$key]['name'][$pos],
          'type' => $_FILES[$key]['type'][$pos],
          'tmp_name' => $_FILES[$key]['tmp_name'][$pos],
          'error' => $_FILES[$key]['error'][$pos],
          'size' => $_FILES[$key]['size'][$pos]
        );

        Debug::console('got file '.$_FILES[$key]['name'][$pos]);

        $files[] = new $classname($file);
      }

    }

    return $files;


  } // end public function files */

  /**
  * request if we have a cookie with this name
  *
  * @param string Key Name des zu testenden Cookies
  * @return bool
  */
  public function serverExists($key)
  {

    if (isset($_SERVER[$key])) {
      return true;
    } else {
      return false;
    }
  } // end public function serverExists */

  /**
  * Abfragen einer bestimmten Postvariable
  *
  * @param string Key Name des angefragten Cookies
  * @return string
  */
  public function server($key = null , $validator = null, $message = null)
  {

    if (is_null($key))
      return Db::addSlashes($_SERVER);

    if ($validator) {
      $filter = Validator::getActive();
      $filter->clean(); // first clean the filter

      if (isset($_SERVER[$key])) {
        $fMethod = 'add'.ucfirst($validator);
        $filter->$fMethod($_SERVER[$key], $key);

        return Db::addSlashes($filter->getData($key));
      } else {
        return null;
      }
    } else {
      if (isset($_SERVER[$key])) {
        return Db::addSlashes($_SERVER[$key]);
      } else {
        return null;
      }
    }

  } // end public function server */

  /**
  * request if we have a cookie with this name
  *
  * @param string Key Name des zu testenden Cookies
  * @return bool
  */
  public function envExists($key)
  {
    return isset($_ENV[$key]);
  } // end public function envExists */

  /**
  * Abfragen einer bestimmten Postvariable
  *
  * @param string $key name of the requested env value
  * @param string $validator the validatorname
  * @return mixed
  */
  public function env($key = null , $validator = null, $message = null)
  {

    if (is_null($key)) {
      return Db::addSlashes($_ENV);
    }

    if ($validator) {

      $filter = Validator::getActive();
      $filter->clean(); // first clean the filter

      if (isset($_ENV[$key])) {
        if (Log::$levelDebug)
          Log::debug('env['.$key.'] ist gesetzt');

        $fMethod = 'add'.ucfirst($validator);
        $filter->$fMethod($_ENV[$key],$key);

        return Db::addSlashes($filter->getData($key));

      } else {
        return null;
      }

    } else {

      if (isset($_ENV[$key])) {
        return Db::addSlashes($_SERVER[$key]);
      } else {
        return null;
      }

    }

  } // end public function env */

/*//////////////////////////////////////////////////////////////////////////////
// Form input
//////////////////////////////////////////////////////////////////////////////*/


  /**
   *
   * get the main oid, can be overwritten if needed
   * @param string $key
   * @param string $accessKey
   * @param string $validator
   * @return int/string
   */
  public function getOID($key = null, $accessKey = null, $validator = Validator::CKEY)
  {


    if ($key) {
      $id = $this->data($key, Validator::INT, 'rowid');

      if ($id) {
        Debug::console('got post rowid: '.$id);

        return $id;
      }
    }

    $id = $this->param('objid', Validator::INT);

    if (!$id && $accessKey) {
      if ($key) {
        $id = $this->data($key, $validator, $accessKey);

        if ($id) {
          Debug::console('got post rowid: '.$id);

          return $id;
        }
      }

      $id = $this->param($accessKey, $validator);

      Debug::console('got param '.$accessKey.': '.$id);

    } else {
      Debug::console('got param objid: '.$id);
    }

    return $id;

  }//end public function getOID

  /** method for validating Formdata
   * if an error is found an message will be send to system, if you want to find
   * out if the test failed ask the system if there are any error messages
   *
   *
   * @param array $values
   * @param array $messages
   * @param string $subkey
   * @param array $required
   * @param State $state
   * @return Validator
   *
   */
  public function checkFormInput($values , $messages, $subkey = null, $required = array(), $state = null)
  {

    // get Validator from Factory
    $filter = Validator::getActive();
    $filter->clean();

    if ($subkey) {// check if we have a subkey

      foreach ($values as $key => $value) {

        if (isset($required[$key])) {
          $nullAble = true;
        } else {
          $nullAble = $value[1];
        }

        $valType = ucfirst($value[0]);

        $method = 'add'.$valType ;

        if (Validator::FILE == $valType || Validator::IMAGE == $valType) {
          if (isset($_FILES[$subkey])) {
            // asume this was just an empty file
            if ('' == trim($_FILES[$subkey]['name'][$key])) {
              continue;
              //$data = null;
            } else {
              $data = array();
              $data['name'] = $_FILES[$subkey]['name'][$key];
              $data['type'] = $_FILES[$subkey]['type'][$key];
              $data['tmp_name'] = $_FILES[$subkey]['tmp_name'][$key];
              $data['error'] = $_FILES[$subkey]['error'][$key];
              $data['size'] = $_FILES[$subkey]['size'][$key];
            }
          } else {
            continue;
            //$data = null;
          }
        } else {

          if (isset($_POST[$subkey][$key])) {
            $data = $_POST[$subkey][$key];
          } else {
            continue;
            //$data = null;
          }

        }

        if ($error = $filter->$method($key, $data, $nullAble, $value[2], $value[3])) {

          if (isset($messages[$key][$error])) {
            if ($state)
              $state->addError($messages[$key][$error]);
            else
              $filter->addErrorMessage($messages[$key][$error]);
          } elseif (isset($messages[$key]['default'])) {
            if ($state)
              $state->addError($messages[$key]['default']);
            else
              $filter->addErrorMessage($messages[$key]['default']);
          } else {
            ///TODO missing i18n
            if ($state)
              $state->addError('Wrong data for '.$key);
            else
              $filter->addErrorMessage('Wrong data for '.$key);
          }

        }

      }

    } else {// we have no subkey geht direct

      foreach ($values as $key => $value) {

        $method = 'add'.$value[0] ;

        if (Validator::FILE == ucfirst($value[0])) {

          if (isset($_FILES[$key])) {
            $data = $_FILES[$key];
          } else {
            continue;
          }

        } else {

          if (isset($_POST[$key])) {
            $data = $_POST[$key];
          } else {
            continue;
          }

        }

        if ($error = $filter->$method($key , $data, $nullAble , $value[2] , $value[3])) {

          if (isset($messages[$key][$error])) {
            if ($state)
              $state->addError($messages[$key][$error]);
            else
              $filter->addErrorMessage($messages[$key][$error]);
          } elseif (isset($messages[$key]['default'])) {
            if ($state)
              $state->addError($messages[$key]['default']);
            else
              $filter->addErrorMessage($messages[$key]['default']);
          } else {
            ///TODO missing i18n
            if ($state)
              $state->addError('Wrong data for '.$key);
            else
              $filter->addErrorMessage('Wrong data for '.$key);
          }

        }

      }

    }//end else

    return $filter;

  }//end public function checkFormInput */

  /** method for validating Formdata
   * if an error is found an message will be send to system, if you want to find
   * out if the test failed ask the system if there are any error messages
   *
   *
   * @param array $values
   * @param array $messages
   * @param string $subkey
   * @param State $state
   * @return Validator
   *
   */
  public function checkSearchInput($values , $messages, $subkey = null, $state = null)
  {

    // get Validator from Factory
    $filter = Validator::getActive();
    $filter->clean();

    $response = $this->getResponse();

    $validator = null;

    if ($subkey) {// check if we have a subkey

      foreach ($values as $key => $value) {
        $method = 'add'.$value[0] ;

        if (isset($_GET[$subkey][$key]))
          $data = $_GET[$subkey][$key];
        else
          $data = null;

        if (is_array($data)) {

          if (!$validator)
            $validator = new LibValidatorBase();

          $checkMethod = 'check'.ucfirst($value[0]);

          $filtered = array();

          foreach ($data as $dataValue) {
            if ($validator->$checkMethod($dataValue, false , $value[2] , $value[3])) {
              $filtered[] = $validator->sanitized;
              $validator->clean();
            }
          }

          if ($filtered)
            $filter->appendCleanData($key, $filtered);

        } else {
          if ($error = $filter->$method($key , $data, false , $value[2] , $value[3])) {
            if (isset($messages[$key][$error])) {
              if ($state)
                $state->addError($messages[$key][$error]);
              else
                $response->addError($messages[$key][$error]);
            } elseif (isset($messages[$key]['default'])) {
              if ($state)
                $state->addError($messages[$key]['default']);
              else
                $response->addError($messages[$key]['default']);
            } else {
              if ($state)
                $state->addError('Wrong data for '.$key);
              else
                $response->addError('Wrong data for '.$key);
            }
          }
        }

      }
    } else {// we have no subkey geht direct

      foreach ($values as $key => $value) {

        $method = 'add'.$value[0] ;

        if (isset($_GET[$key]))
          $data = $_GET[$key];
        else
          continue;

        if ($error = $filter->$method($key , $data, false , $value[2] , $value[3])) {
          if (isset($messages[$key][$error])) {
            if ($state)
              $state->addError($messages[$key][$error]);
            else
              $response->addError($messages[$key][$error]);
          } elseif (isset($messages[$key]['default'])) {
            if ($state)
              $state->addError($messages[$key]['default']);
            else
              $response->addError($messages[$key]['default']);
          } else {
            if ($state)
              $state->addError('Wrong data for '.$key);
            else
              $response->addError('Wrong data for '.$key);
          }
        }

      }

    }

    if (Log::$levelTrace)
      Debug::console('checkSearchInput filter data',$filter->data);

    return $filter;

  }//end public function checkSearchInput */

  /** method for validating Formdata
   * if an error is found an message will be send to system, if you want to find
   * out if the test failed ask the system if there are any error messages
   *
   * @param array $values are the tablefields
   * @param array $messages
   * @param string $subkey  subkey is the tablename
   * @param string $required  subkey is the tablename
   * @param State $state
   * @return array
   */
  public function checkMultiFormInput(
    $values,
    $messages,
    $subkey = null,
    $required = array(),
    $state = null
  ) {

    // check if data exists, if not return an empty array
    if (!isset($_POST[$subkey]) or !is_array($_POST[$subkey])) {
      Log::warn('invalid data for subkey: '.$subkey);

      return array();
    }

    $response = $this->getResponse();

    // get Validator from Factory
    $filter = Validator::getActive();
    $filtered = array();

    foreach ($_POST[$subkey] as $rowPos => $row) {
      $filter->clean();

      foreach ($values as $key => $value) {

        $method = 'add'.$value[0] ;

        if (!isset($row[$key]))
          continue;

        if (isset($required[$key])) {
          $nullAble = true;
        } else {
          $nullAble = $value[1];
        }

        $data = $row[$key];

        if ($error = $filter->$method($key , $data, $nullAble , $value[2] , $value[3])) {
          if (isset($messages[$key][$error])) {
            if ($state)
              $state->addError($messages[$key][$error]);
            else
              $response->addError($messages[$key][$error]);
          } elseif (isset($messages[$key]['default'])) {
            if ($state)
              $state->addError($messages[$key]['default']);
            else
              $response->addError($messages[$key]['default']);
          } else {
            if ($state)
              $state->addError('Wrong data for '.$key);
            else
              $response->addError('Wrong data for '.$key);
          }
        }

      }//end foreach

      $filtered[$rowPos] = $filter->getData();

    }//end foreach */

    return $filtered;

  }//end public function checkMultiFormInput */

  /** method for validating Formdata
   * if an error is found an message will be send to system, if you want to find
   * out if the test failed ask the system if there are any error messages
   *
   *
   * @param array $values are the tablefields
   * @param array $messages
   * @param string $subkey  subkey is the tablename
   * @param string $required  subkey is the tablename
   * @param State $state
   * @return array
   *
   */
  public function validateMultiData(
    $values,
    $subkey = null,
    $messages = array(),
    $state = null
  ) {

    $post = array();

    if ($subkey) {
      // check if data exists, if not return an empty array
      if (!isset($_POST[$subkey]) or !is_array($_POST[$subkey])) {
        Log::warn('invalid data for subkey: '.$subkey);

        return array();
      }

      $post = $_POST[$subkey];

    } else {

      $post = $_POST;
    }

    $response = $this->getResponse();

    // get Validator from Factory
    $filter = Validator::getActive();
    $filtered = array();

    foreach ($post as $rowPos => $row) {
      $filter->clean();

      foreach ($values as $key => $value) {
        $method = 'add'.$value[0];

        if (!isset($row[$key]))
          continue;

        if (isset($value[1])) {
          $nullAble = $value[1];
        } else {
          $nullAble = true;
        }

        $data = $row[$key];

        if ($error = $filter->$method($key, $data, $nullAble)) {
          if (isset($messages[$key][$error])) {
            if ($state)
              $state->addError($messages[$key][$error]);
            else
              $response->addError($messages[$key][$error]);
          } elseif (isset($messages[$key]['default'])) {
            if ($state)
              $state->addError($messages[$key]['default']);
            else
              $response->addError($messages[$key]['default']);
          } else {
            if ($state)
              $state->addError('Wrong data for '.$key);
            else
              $response->addError('Wrong data for '.$key);
          }
        }

      }//end foreach

      $filtered[$rowPos] = $filter->getData();

    }//end foreach */

    return $filtered;

  }//end public function checkMultiFormInput */

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
  public function checkMultiInputLang($values , $messages, $subkey = null, $required = array())
  {

    // get Validator from Factory
    $filter = Validator::getActive();
    $response = $this->getResponse();

    $filtered = array();

    foreach ($_POST[$subkey] as $id => $row) {
      $filter->clean();

      foreach ($values as $key => $value) {

        $method = 'add'.$value[0] ;

        if (isset($row[$key]))
          $data = $row[$key];
        else
          $data = null;

        if (isset($required[$key])) {
          $nullAble = true;
        } else {
          $nullAble = $value[1];
        }

        if ($error = $filter->$method($key , $data, $nullAble , $value[2] , $value[3])) {
          if (isset($messages[$key][$error]))
            $response->addError($messages[$key][$error]);
          elseif (isset($messages[$key]['default']))
            $response->addError($messages[$key]['default']);
          else
            $response->addError('Wrong data for '.$key);
        }
      }

      // now we check if the input ist empty
      // if there are any other data then the language id the entry gets kicked
      $filtr = $filter->getData();

      $isEmpty = true;

      foreach ($filtr as $key => $tmpVal) {
        //test if we have a non row oder lang id attribute thats not empty
        if ($key != WBF_DB_KEY and $key != 'id_lang' && trim($tmpVal) != '') {
          $isEmpty = false;
          break;
        }
      }

      if (!$isEmpty) {
        $filtered[$id] = $filtr;
      }

    }//end foreach ($_POST[$subkey] as $id => $row)

    return $filtered;

  }//end public function checkMultiInputLang */

  /**
   * @param string $key
   * @param string $subkey
   */
  public function checkMultiIds($key , $subkey = null)
  {

    $ids = array();

    if ($subkey) {
      foreach ($_POST[$key][$subkey] as $val) {
        if (is_numeric($val))
          $ids[] = $val;
      }
    } else {
      foreach ($_POST[$key] as $val) {
        if (is_numeric($val))
          $ids[] = $val;
      }
    }

    return $ids;

  }//end public function checkMultiIds */

/*//////////////////////////////////////////////////////////////////////////////
// Get Client Informations
//////////////////////////////////////////////////////////////////////////////*/

 /**
  * just validate the post data
  * this method just returns an array an no entity as the other validate methodes
  * @param Entity $entity
  * @param string $keyName
  * @param array $fields
  * @param array $required
  * @param State $state
  *
  * @return array
  */
  public function validate(
    $entity,
    $keyName,
    $fields = array(),
    $required = array(),
    $state = null
  ) {

    $filter = $this->checkSearchInput(
      $entity->getValidationData($fields),
      $entity->getErrorMessages(),
      $keyName,
      $required
    );

    $entity->addData($filter->getData());

    // wenn ein State object übergeben wurde ist dieses mit höchster priorität
    // zu behandeln
    if ($state)
      return $state->isOk();

    if ($filter->hasErrors()) {

      $response = $this->getResponse();
      $response->addError($filter->getErrorMessages());

      return false;
    }

    return true;

  }//end public function validate */

 /**
  * just validate the post data
  * this method just returns an array an no entity as the other validate methodes
  * @return array
  */
  public function validateSearch($entity, $keyName, $fields = array(), $required = array()  )
  {

    $filter = $this->checkSearchInput(
      $entity->getValidationData($fields),
      $entity->getErrorMessages(),
      $keyName,
      $required
    );

    $entity->addData($filter->getData());

    if ($filter->hasErrors()) {

      $response = $this->getResponse();
      $response->addError($filter->getErrorMessages());

      return false;
    }

    return true;

  }//end public function validateSearch */

  /**
   * check the values for an insert
   * @param Entity $entity an enity object
   * @param array $fields if fetch is empty fetch all
   * @param string $keyName if is null use default keyname
   * @param State $state
   * @return Entity
   */
  public function validateInsert($entity, $keyName, $fields = array(), $required = array(), $state = null)
  {

    $filter = $this->checkFormInput(
      $entity->getValidationData($fields, true),
      $entity->getErrorMessages(),// return all so it's just an internal reference for reading
      $keyName,
      $required,
      $state
    );

    $entity->addData($filter->getData());

    // wenn ein State object übergeben wurde ist dieses mit höchster priorität
    // zu behandeln
    if ($state)
      return $state->isOk();

    if ($filter->hasErrors()) {

      $response = $this->getResponse();
      $response->addError($filter->getErrorMessages());

      return false;
    }

    return true;

  }//end public function validateInsert */

  /**
   * Basierend auf den übergebenen Metadaten werden Informationen aus dem Databody
   * des Requests extrahiert, validiert und ein ein Entity Objekt geschrieben
   *
   * @param Entity $entity
   * @param string $keyName
   * @param array $fields
   * @param array $required
   * @param TState $state
   * @return void
   */
  public function validateUpdate(
    $entity,
    $keyName,
    $fields = array(),
    $required = array(),
    $state = null
  ) {

    $filter = $this->checkFormInput(
      $entity->getValidationData($fields),
      $entity->getErrorMessages(),
      $keyName,
      $required,
      $state
    );

    $data = $filter->getData();
    $entity->addData($data);

    // wenn ein State object übergeben wurde ist dieses mit höchster priorität
    // zu behandeln
    if ($state)
      return $state->isOk();


    if ($filter->hasErrors()) {

      $response = $this->getResponse();
      $response->addError($filter->getErrorMessages());
      return false;
    }

    return true;

  }//end public function validateUpdate */

  /**
   * check the values for an insert
   *
   * @param array $fields
   * @param array $keyName
   * @param array $fields
   * @param array $required
   * @param State $state
   * @return array all filtered data
   */
  public function validateMultiInsert(
    $entityName,
    $keyName,
    $fields = array(),
    $required = array(),
    $state = null
  ) {

    $orm = $this->getOrm();

    $filtered = $this->checkMultiFormInput(
      $orm->getValidationData($entityName,$fields),
      $orm->getErrorMessages($entityName),
      $keyName,
      $required,
      $state
    );

    $entityName = $entityName.'_Entity';

    $tmp = array();
    foreach ($filtered as $rowid => $data) {
      $tpObj = new $entityName(null, array(), $this->getDb());
      // unset rowids without merci, THIS... IS... INSERT... einseinself!!
      if (array_key_exists(Db::PK, $data))
        unset($data[Db::PK]);

      $tpObj->addData($data);
      $tmp[$rowid] = $tpObj;
    }

    return $tmp;

  }//end public function validateMultiInsert */

  /**
   * check the values for an update
   *
   * @param string $entityName
   * @param string $keyName
   * @param array $fields
   * @param array $required
   */
  public function validateMultiUpdate($entityName, $keyName, $fields = array(), $required = array())
  {

    $orm = $this->getOrm();
    $response = $this->getResponse();

    $filtered = $this->checkMultiFormInput(
      $orm->getValidationData($entityName, $fields),
      $orm->getErrorMessages($entityName),
      $keyName,
      $required
    );

    $entityName = $entityName.'_Entity';

    $entityList = array();
    foreach ($filtered as $rowid => $data) {

      $tpObj = new $entityName(null, array(), $this->getDb());

      // ignore rowid
      if (array_key_exists(Db::PK, $data)) {
        // must convert to boolean true
        if ($data[Db::PK])
          $rowid = $data[Db::PK];

        unset($data[Db::PK]);
      }//end if

      if (is_numeric($rowid)) {

        $tpObj->setId((int) $rowid);
        $tpObj->addData($data);
        $entityList[$rowid] = $tpObj;

      }//end if
      else {
        $response->addWarning('Got an invalid dataset for update');
      }

    }//end foreach

    return $entityList;

  }//end public static function validateMultiUpdate */


  /**
   * check the values for an update
   *
   * @param string $entityName
   * @param string $keyName
   * @param array $fields
   * @param array $required
   */
  public function validateMultiSave(
    $entityName,
    $keyName,
    $fields = array(),
    $required = array(),
    $defaults = array()
  ) {

    $orm = $this->getOrm();

    $filtered = $this->checkMultiFormInput(
      $orm->getValidationData($entityName, $fields),
      $orm->getErrorMessages($entityName),
      $keyName,
      $required
    );

    $entityClass = $entityName.'_Entity';

    $entityList = array();
    foreach ($filtered as $rowid => $data) {

      if(is_numeric($rowid)){
        $tpObj = $orm->get($entityName, $rowid);
      } else{
        $tpObj = new $entityClass(null, array(), $this->getDb());
      }

      // ignore rowid
      if (array_key_exists(Db::PK, $data)) {
        unset($data[Db::PK]);
      }//end if

      if (!is_numeric($rowid)) {
        $tpObj->tmpId = $rowid;

        if ($defaults) {
          foreach ($defaults as $defKey => $defValue) {
            $tpObj->$defKey = $defValue;
          }
        }
      }


      $tpObj->addData($data);
      $entityList[$rowid] = $tpObj;

    }//end foreach

    return $entityList;

  }//end public static function validateMultiSave */



/*//////////////////////////////////////////////////////////////////////////////
// Get Client Informations
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * Enter description here...
   * @return string
   */
  public function getBrowser()
  {

    if (isset($this->browserInfo['name']))
      return $this->browserInfo['name'];

    $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);

    if (preg_match('/opera/', $userAgent)) {
      $this->browserInfo['name'] = 'opera';
    } elseif (preg_match('/chrome/', $userAgent)) {
      $this->browserInfo['name'] = 'chrome';
    } elseif (preg_match('/webkit/', $userAgent)) {
      $this->browserInfo['name'] = 'safari';
    } elseif (preg_match('/msie/', $userAgent)) {
      $this->browserInfo['name'] = 'msie';
    } elseif (preg_match('/firefox/', $userAgent)) {
      $this->browserInfo['name'] = 'firefox';
    } elseif (preg_match('/mozilla/', $userAgent) && !preg_match('/compatible/', $userAgent)) {
      $this->browserInfo['name'] = 'mozilla';
    } else {
      $this->browserInfo['name'] = 'unknown';
    }

    return $this->browserInfo['name'];

  }//end public function getBrowser */

  /**
   * Get the Browser Version
   * @return string
   */
  public function getBrowserVersion()
  {
    if (isset($this->browserInfo['version']))
      return $this->browserInfo['version'];

    $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);

    // What version?
    if (preg_match('/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/', $userAgent, $matches)) {
      $this->browserInfo['version'] = $matches[1];
    } else {
      $this->browserInfo['version'] = 0;
    }

    return $this->browserInfo['version'];

  }//end public function getBrowserVersion */

  /**
   * Get the Platform
   * @return string
   */
  public function getPlatform()
  {
    if (isset($this->browserInfo['platform']))
      return $this->browserInfo['platform'];

    $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);

    // Running on what platform?
    if (preg_match('/linux/', $userAgent)) {
      $this->browserInfo['platform'] = 'linux';
    } elseif (preg_match('/macintosh|mac os x/', $userAgent)) {
      $this->browserInfo['platform'] = 'mac';
    } elseif (preg_match('/windows|win32/', $userAgent)) {
      $this->browserInfo['platform'] = 'windows';
    } else {
      $this->browserInfo['platform'] = 'unknown';
    }

    return $this->browserInfo['platform'];

  }//end public function getPlatform */

  /**
   * @return string
   */
  public function getUseragent()
  {
    return strtolower($this->server('HTTP_USER_AGENT'));
  }//end public function getUseragent */

  /**
   * @return string
   */
  public function getClientIp()
  {

    // den port abhacken wenn vorhanden
    //$tmp = explode(':', $this->server('REMOTE_ADDR'));
    return $this->server('REMOTE_ADDR');

  }//end public function getClientIp */

  /**
   * @return string
   */
  public function getEncoding()
  {
    // 'gzip,deflate'
    return explode(',', $this->server('HTTP_ACCEPT_ENCODING'));
  }//end public function getClientIp */

  /**
   * @return string
   */
  public function getClientLanguage()
  {
    // 'de-de,de;q=0.8,en-us;q=0.5,en;q=0.3'
    return explode(';', $this->server('HTTP_ACCEPT_LANGUAGE'));
  }//end public function getClientLanguage */

  /**
   * Hauptsprache des Clients ermitteln
   * @return string
   */
  public function getMainClientLanguage()
  {
    // 'de-de,de;q=0.8,en-us;q=0.5,en;q=0.3'
    $tmp = explode(',', $this->server('HTTP_ACCEPT_LANGUAGE'));

    if (strpos($tmp[0], '-')) {
      $tmp = explode('-', $tmp[0]);
      return $tmp[0];
    } else {
      return $tmp[0];
    }

  }//end public function getMainClientLanguage */

  /**
   * @return string
   */
  public function getCharset()
  {
    // 'ISO-8859-1,utf-8;q=0.7,*;q=0.7'
    return explode(';', $this->server('HTTP_ACCEPT_CHARSET')) ;
  }//end public function getCharset */


  /**
   * @return string
   */
  public function getClientRefer()
  {
    return $this->server('HTTP_REFERER');
  }//end public function getClientRefer */


/*//////////////////////////////////////////////////////////////////////////////
// Static Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * get the request method
   *
   * @return string
   */
  public function method($requested = null)
  {

    if (!isset($_SERVER['REQUEST_METHOD'])) {
      Error::report('Got no request method, asumig this was a get request');
      $method = 'GET';
    } else {
      $method = strtoupper($_SERVER['REQUEST_METHOD']);
    }

    //this should always be uppper, but no risk here
    if (!$requested)
      return $method;
    else {

      if (is_array($requested)) {

        foreach ($requested as $reqKey) {
          if ($method == $reqKey)
            return true;
        }

        return false;
      } else {
        return $requested == $method ? true:false;
      }
    }


  }//end public function method */

  /**
   * get the request method
   *
   * @return string
   */
  public function inMethod($methodes)
  {

    if (!isset($_SERVER['REQUEST_METHOD'])) {
      Error::report('Got no request method, asumig this was a get request');
      $method = 'GET';
    } else {
      $method = strtoupper($_SERVER['REQUEST_METHOD']);
    }

    //this should always be uppper, but no risk here
    return in_array($method, $methodes);

  }//end public function inMethod */

  /**
   * @return boolean
   */
  public function isAjax()
  {
    return isset($_GET['rqt']);
  }//end public function isAjax */


  /**
   * @return boolean
   */
  public function getResource()
  {
    return $_SERVER['QUERY_STRING'];
  }//end public function getResource */


  /**
   * @return string
   */
  public function getServerName()
  {
    return $_SERVER['SERVER_NAME'];

  }//end public function getServerName */

  /**
   * Die Addresse zum Server bekommen,
   * checken was bei URL Design passiert
   * @param boolean $forceHttps
   * @return string
   */
  public function getServerAddress($forceHttps = false)
  {

    if (!$this->serverAddress) {

      $this->serverAddress = ((isset($_SERVER['HTTPS']) && 'on' == $_SERVER['HTTPS']) || $forceHttps)
        ? 'https://'
        : 'http://';

      $this->serverAddress .= $_SERVER['SERVER_NAME'];

      if (isset($_SERVER['HTTPS']) && 'on' == $_SERVER['HTTPS']) {
        if ($_SERVER['SERVER_PORT'] != '443') {
          $this->serverAddress .= ':'.$_SERVER['SERVER_PORT'];
        }
      } else {
        if ($_SERVER['SERVER_PORT'] != '80') {
          $this->serverAddress .= ':'.$_SERVER['SERVER_PORT'];
        }
      }

      $this->serverAddress .='/'.SParserString::getFileFolder($_SERVER['REQUEST_URI']);

      $length = strlen($this->serverAddress);

      if ('/' != $this->serverAddress[($length-1)])
        $this->serverAddress .= '/';

    }

    return $this->serverAddress;

  }//end public function getServerAddress */

  /**
   * Die volle Angefragte URL bekommen mit Servername und allen Parametern
   * @param boolean $forceHttps einen https link erzwingen
   * @return string
   */
  public function getFullRequest($forceHttps = false)
  {

    if (!$this->fullRequest) {

      $this->fullRequest = ((isset($_SERVER['HTTPS']) && 'on' == $_SERVER['HTTPS']) || $forceHttps)
      ? 'https://'
      : 'http://';

      $this->fullRequest .= $_SERVER['SERVER_NAME'];

      if (isset($_SERVER['HTTPS']) && 'on' == $_SERVER['HTTPS']) {
        if ($_SERVER['SERVER_PORT'] != '443') {
          $this->fullRequest .= ':'.$_SERVER['SERVER_PORT'];
        }
      } else {
        if ($_SERVER['SERVER_PORT'] != '80') {
          $this->fullRequest .= ':'.$_SERVER['SERVER_PORT'];
        }
      }

      $this->fullRequest .= $_SERVER['REQUEST_URI'];

    }

    return $this->fullRequest;

  }//end public function getFullRequest */

  /**
   * @param string $domainName
   * @param boolean $https
   * @return string
   */
  public function createRedirectAddress($domainName, $https = null)
  {

    $httpsOn = (isset($_SERVER['HTTPS']) && 'on' == $_SERVER['HTTPS']);

    if (1 === (int) $https)
      $httpsOn = false;
    elseif (2 === (int) $https)
      $httpsOn = true;

    $serverAddress = $httpsOn ? 'https://' : 'http://';

    $serverAddress .= $domainName;

    if ($httpsOn) {
      if ((isset($_SERVER['HTTPS']) && 'on' == $_SERVER['HTTPS'])) {
        if ($_SERVER['SERVER_PORT'] != '443') {
          $serverAddress .= ':'.$_SERVER['SERVER_PORT'];
        }
      }
    } else {
      if (!(isset($_SERVER['HTTPS']) && 'on' == $_SERVER['HTTPS'])) {
        if ($_SERVER['SERVER_PORT'] != '80') {
          $serverAddress .= ':'.$_SERVER['SERVER_PORT'];
        }
      }

    }

    $serverAddress .='/'.SParserString::getFileFolder($_SERVER['REQUEST_URI']);

    $length = strlen($serverAddress);

    if ('/' != $serverAddress[($length-1)])
      $serverAddress .= '/';

    return $serverAddress;

  }//end public function createRedirectAddress */

  /**
   * Checken ob es eine HTTPS Verbindung ist
   * @return boolean
   */
  public function isSecure()
  {
    return (isset($_SERVER['HTTPS']) && 'on' == $_SERVER['HTTPS']);

  }//end public function isSecure */

  /**
   * @return string
   */
  public function dumpAsJson()
  {

    $requestData = array();
    $requestData['server'] = $_SERVER;
    $requestData['params'] = $_GET;
    $requestData['cookie'] = $_COOKIE;
    $requestData['data'] = isset($_POST)?$_POST:array();

    return json_encode($requestData);

  }//end public function dumpAsJson */

}// end class LibRequestPhp

