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
class LibRequestSubrequest
{

  /**
   * Der Vate request Knoten
   * @var LibRequestHttp
   */
  protected $request = null;

  /**
   * Das Response Objekt
   * @var LibResponse
   */
  protected $response = null;

  /**
   * post data array
   * @var array
   */
  protected $data = array();

  /**
   * files data array
   * @var array
   */
  protected $files = array();

  /**
   *
   * @var LibDbConnection
   */
  protected $db = null;

  /**
   *
   * @var LibDbOrm
   */
  protected $orm = null;

  /**
   * @var Validator
   */
  protected $validator = null;

  /**
   * @var string
   */
  public $type = 'sub';

/*//////////////////////////////////////////////////////////////////////////////
// getter + setter Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param LibDbOrm $orm
   */
  public function setOrm($orm)
  {
    $this->orm = $orm;
  }//end public function setOrm */

  /**
   * @return LibDbOrm
   */
  public function getOrm()
  {
    // set default orm
    if (!$this->orm) {
      if (!$this->db)
        $this->db = Webfrap::$env->getDb();

      $this->orm = $this->db->getOrm();
    }

    return $this->orm;

  }//end public function getOrm */

  /**
   * @return LibDbConnection
   */
  public function getDb()
  {
    // set default orm
    if (!$this->db)
      $this->db = Webfrap::$env->getDb();

    return $this->db;

  }//end public function getDb */

  /**
   * @return LibResponseHttp
   */
  public function getResponse()
  {

    if (!$this->response)
      $this->response = Response::getActive();

    return $this->response;

  }//end public function getResponse */

  /**
   * @param Validator $validator
   */
  public function setValidator($validator)
  {

    $this->validator = $validator;

  }//end public function setValidator */

  /**
   * @return Validator
   */
  public function getValidator()
  {
    // set default orm
    if (!$this->validator)
      $this->validator = Validator::getActive();

    return $this->validator;

  }//end public function getValidator */

  /**
   * @param LibRequestPhp $request
   * @param array $data
   * @param array $files
   */
  public function __construct($request, $data, $files)
  {

    $this->request = $request;
    $this->data = $data;
    $this->files = $files;

    $this->db = $request->getDb();

  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// param methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Funktion zum testen ob eine bestimmte Urlvariable existiert
   *
   * @param string Key Name der zu erfragende $_GET Variable
   * @return bool
   */
  public function paramExists($key)
  {
    return $this->request->paramExists($key);

  } // end public function paramExists */

  /**
  * Daten einer bestimmten Urlvariable erfragen
  *
  * @param string Key Name der zu erfragende $_GET Variable
  * @return string
  */
  public function param($key = null , $validator = null , $message = null)
  {
    return $this->request->param($key, $validator, $message  );

  }//end public function param */

 /**
  * Hinzufügen oder ersetzten einer Variable in der URL
  *
  * @param string $key Name des Urlkeys
  * @param string $data Die Daten für die Urlvar
  * @return bool
  */
  public function addParam($key, $data = null  )
  {

    $this->request->addParam($key, $data);

  }//end public function addParam */

  /**
   * remove some variables from the url
   * @param string $key
   */
  public function removeParam($key)
  {

    $this->request->removeParam($key  );

  }//end public function removeParam */

/*//////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Abfragen des Status einer POST Variable
   *
   * @param string Key Name der zu prüfenden Variable
   * @return bool
   */
  public function dataExists($key , $subkey = null)
  {

    if (!is_null($subkey)) {
      return isset($this->data[$key][$subkey]);
    } else {
      return isset($this->data[$key]);
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

    if (!isset($this->data[$key]) || !is_array($this->data[$key]))
      return array();

    $keys = array_keys($this->data[$key]);

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
  * @param array/string[optional] Array mit Namen von Keys / Key Name der Variable
  * @return array
  */
  public function data($key = null , $validator = null , $subkey = null , $message = null  )
  {

    $response = $this->getResponse();

    if ($validator) {
      $filter = $this->getValidator();
      $filter->clean(); // first clean the filter

      if (is_string($key)) {

        if ($subkey) {

          if (isset($this->data[$key][$subkey])) {
            $data = $this->data[$key][$subkey];
          } else {
            return null;
          }

        }//end if $subkey
        else {

          if (isset($this->data[$key])) {
            $data = $this->data[$key];
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

            if (isset($this->data[$id])) {
              $filter->$fMethod($this->data[$id], $id);
              $data[$id] = $filter->getData($id);
            } else {
              $data[$id] = null;
            }
          }
        } else {
          foreach ($key as $id) {
            $fMethod = 'add'.ucfirst($validator);

            if (isset($this->data[$id])) {
              $filter->$fMethod($this->data[$id], $id);
              $data[$id] = $filter->post($id);
            } else {
              $data[$id] = null;
            }
          }
        }

        return $data;

      }
    }//end if $validator
    else { // else $validator
      if (is_string($key)) {
        if ($subkey) {
          return isset($this->data[$key][$subkey])
            ?$this->data[$key][$subkey]:null;
        } else {
          return isset($this->data[$key])
            ?$this->data[$key]:null;
        }
      } elseif (is_array($key)) {
        $data = array();

        foreach ($key as $id) {
          $data[$id] = isset($this->data[$id])? $this->data[$id] :null;
        }

        return $data;
      } elseif (is_null($key)) {
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
  public function removeData($key , $subkey = null)
  {

    /*
    $subkey
      ? isset($this->data[$key][$subkey])
        ? unset($this->data[$key][$subkey])
        : null

      : isset($this->data[$key])
        ? unset($this->data[$key])
        : null;
    */

    if (is_null($subkey)) {
      if (isset($this->data[$key])) {
        unset($this->data[$key]);
      }
    } else {
      if (isset($this->data[$key][$subkey])) {
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
  public function dataEmpty($keys , $subkey = null)
  {

    if ($subkey) {
      if (is_array($keys)) {

        foreach ($keys as $key) {

          if (!isset($this->data[$subkey][$key])) {
            return true;
          }

          if (trim($this->data[$subkey][$key]) == '') {
            return true;
          }

          return false;

        }

      } else {

        if (!isset($this->data[$subkey][$keys])) {
          return true;
        }

        if (trim($this->data[$subkey][$keys]) == '') {
          return true;
        }

        return false;

      }
    } else {
      if (is_array($keys)) {

        foreach ($keys as $key) {

          if (!isset($this->data[$key]))
            return true;

          if (trim($this->data[$key]) == '')
            return true;

          return false;

        }

      } else {

        if (!isset($this->data[$keys]))
          return true;

        if (trim($this->data[$keys]) == '')
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
   * @param unknown_type $fMethod
   * @param unknown_type $data
   * @return unknown
   */
  protected function validateArray($fMethod , $data)
  {

    $filter = $this->getValidator();

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
        $back[$key] = $tmp[$key];
      }

    }

    return $back;

  }//end protected function validateArray */

/*//////////////////////////////////////////////////////////////////////////////
// Cookie
//////////////////////////////////////////////////////////////////////////////*/

  /**
  * request if we have a cookie with this name
  *
  * @param string Key Name des zu testenden Cookies
  * @return bool
  */
  public function issetCookie($key  )
  {
    return $this->request->issetCookie($key  );
  } // end public function issetCookie */

 /**
  * Abfragen einer bestimmten Postvariable
  *
  * @param string Key Name des angefragten Cookies
  * @return string
  */
  public function cookie($key = null , $validator = null, $message = null)
  {
    return $this->request->issetCookie($key, $validator, $message);
  } // end public function cookie */

 /**
  * Request if a File Upload Exists
  *
  * @param string Key Name des zu testenden Cookies
  * @return bool
  */
  public function fileExists($key)
  {

    if (isset($this->files[$key])) {
      return true;
    } else {
      return false;
    }

  } // end public function fileExists */

 /**
  * Request if a File Upload Exists
  *
  * @param string Key Name des zu testenden Cookies
  * @param string Key Name des zu testenden Cookies
  * @return bool
  */
  public function file($key = null, $type = null, $subkey = null, $message = null)
  {
    if (is_null($key)) {
      return $this->files;
    }

    $filter = $this->getValidator();
    $filter->clean(); // first clean the filter

    if ($subkey) {

      // asume this was just an empty file
      if (!isset($this->files[$subkey]) || '' == trim($this->files[$subkey]['name'][$key])) {
        $data = null;
      } else {
        $data = array();
        $data['name'] = $this->files[$subkey]['name'][$key];
        $data['type'] = $this->files[$subkey]['type'][$key];
        $data['tmp_name'] = $this->files[$subkey]['tmp_name'][$key];
        $data['error'] = $this->files[$subkey]['error'][$key];
        $data['size'] = $this->files[$subkey]['size'][$key];
      }

    } else {
      // asume this was just an empty file
      if (!isset($this->files[$key]) || '' == trim($this->files[$key]['name'])) {
        $data = null;
      } else {
        $data = $this->files[$key];
      }

    }

    if (!$data)
      return null;

    if ($type) {
      $classname = 'LibUpload'.SParserString::subToCamelCase($type);

      if (!Webfrap::classExists($classname))
        throw new LibFlow_Exception('Requested nonexisting upload type: '.$classname);

      return new $classname($data,$key);

    } else {
      return new LibUploadFile($data);
    }

  } // end public function getUploadedFile */

  /**
  * request if we have a cookie with this name
  *
  * @param string Key Name des zu testenden Cookies
  * @return bool
  */
  public function serverExists($key  )
  {
    return $this->request->serverExists($key  );

  } // end public function serverExists */

  /**
  * Abfragen einer bestimmten Postvariable
  *
  * @param string Key Name des angefragten Cookies
  * @return string
  */
  public function server($key = null , $validator = null, $message = null)
  {
    return $this->request->server($key, $validator, $message  );

  } // end public function server */

  /**
  * request if we have a cookie with this name
  *
  * @param string Key Name des zu testenden Cookies
  * @return bool
  */
  public function envExists($key  )
  {
    return $this->request->envExists($key);
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
    return $this->request->env($key, $validator, $message);

  } // end public function env */

/*//////////////////////////////////////////////////////////////////////////////
// Form input
//////////////////////////////////////////////////////////////////////////////*/

  /** method for validating Formdata
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
  public function checkFormInput($values , $messages, $subkey = null  )
  {

    // get Validator from Factory
    $filter = $this->getValidator();
    $filter->clean();

    if ($subkey) {// check if we have a subkey
      foreach ($values as $key => $value) {

        $method = 'add'.ucfirst($value[0]) ;

        if (Validator::FILE == ucfirst($value[0])) {
          if (isset($this->files[$subkey])) {
            // asume this was just an empty file
            if ('' == trim($this->files[$subkey]['name'][$key])  ) {
              $data = null;
            } else {
              $data = array();
              $data['name'] = $this->files[$subkey]['name'][$key];
              $data['type'] = $this->files[$subkey]['type'][$key];
              $data['tmp_name'] = $this->files[$subkey]['tmp_name'][$key];
              $data['error'] = $this->files[$subkey]['error'][$key];
              $data['size'] = $this->files[$subkey]['size'][$key];
            }
          } else {
            $data = null;
          }
        } else {

          if (isset($this->data[$subkey][$key])) {
            $data = $this->data[$subkey][$key];
          } else {
            $data = null;
          }
        }

        if ($error = $filter->$method($key , $data, $value[1] , $value[2] , $value[3])) {
          if (isset($messages[$key][$error])) {
            $filter->addErrorMessage($messages[$key][$error]);
          } elseif (isset($messages[$key]['default'])) {
            $filter->addErrorMessage($messages[$key]['default']);
          } else {
            $filter->addErrorMessage('Wrong data for '.$key  );
          }

        }

      }

    } else {// we have no subkey geht direct

      foreach ($values as $key => $value) {

        $method = 'add'.$value[0] ;

        if (Validator::FILE == ucfirst($value[0])) {
          if (isset($this->files[$key])) {
            $data = $this->files[$key];
          } else {
            $data = null;
          }
        } else {
          if (isset($this->data[$key])) {
            $data = $this->data[$key];
          } else {
            $data = null;
          }
        }

        if ($error = $filter->$method($key , $data, $value[1] , $value[2] , $value[3])) {
          if (isset($messages[$key][$error])) {
            $filter->addErrorMessage($messages[$key][$error]);
          } elseif (isset($messages[$key]['default'])) {
            $filter->addErrorMessage($messages[$key]['default']);
          } else {
            $filter->addErrorMessage('Wrong data for '.$key  );
          }

        }

      }

    }

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
   * @return Validator
   *
   */
  public function checkSearchInput($values , $messages, $subkey = null)
  {
    return $this->request->checkSearchInput($values , $messages, $subkey);

  }//end public function checkSearchInput */

  /** method for validating Formdata
   * if an error is found an message will be send to system, if you want to find
   * out if the test failed ask the system if there are any error messages
   *
   *
   * @param array $values are the tablefields
   * @param array $messages
   * @param string $subkey  subkey is the tablename
   * @return array
   *
   */
  public function checkMultiFormInput($values , $messages, $subkey = null  )
  {

    // check if data exists, if not return an empty array
    if (!isset($this->data[$subkey]) or !is_array($this->data[$subkey])) {
      Log::warn('invalid data for subkey: '.$subkey);

      return array();
    }

    $response = $this->getResponse();

    // get Validator from Factory
    $filter = $this->getValidator();
    $filtered = array();

    foreach ($this->data[$subkey] as $rowPos => $row) {
      $filter->clean();

      foreach ($values as $key => $value) {
        $method = 'add'.$value[0] ;

        if (!isset($row[$key]))
          continue;

        $data = $row[$key];

        if ($error = $filter->$method($key , $data, $value[1] , $value[2] , $value[3])) {
          if (isset($messages[$key][$error])) {
            $response->addError($messages[$key][$error]);
          } elseif (isset($messages[$key]['default'])) {
            $response->addError($messages[$key]['default']);
          } else {
            $response->addError('Wrong data for '.$key  );
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
  public function checkMultiInputLang($values , $messages, $subkey = null)
  {

    // get Validator from Factory
    $filter = $this->getValidator();
    $response = $this->getResponse();

    $filtered = array();

    foreach ($this->data[$subkey] as $id => $row) {
      $filter->clean();

      foreach ($values as $key => $value) {

        $method = 'add'.$value[0] ;

        if (isset($row[$key]))
          $data = $row[$key];
        else
          $data = null;

        if ($error = $filter->$method($key , $data, $value[1] , $value[2] , $value[3])) {

          if (isset($messages[$key][$error])) {
            $response->addError($messages[$key][$error]);
          } elseif (isset($messages[$key]['default'])) {
            $response->addError($messages[$key]['default']);
          } else {
            $response->addError('Wrong data for '.$key  );
          }

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

    }//end foreach ($this->data[$subkey] as $id => $row)

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
      foreach ($this->data[$key][$subkey] as $val) {
        if (is_numeric($val))
          $ids[] = $val;
      }
    } else {
      foreach ($this->data[$key] as $val) {
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
  * @return array
  */
  public function validate($entity, $keyName, $fields = array()  )
  {

    if (DEBUG)
      Debug::console('validate fields for key: '.$keyName , $entity->getValidationData($fields));

    $filter = $this->checkSearchInput
    (
      $entity->getValidationData($fields),
      $entity->getErrorMessages(),
      $keyName
    );

    if (DEBUG)
      Debug::console('got data: '.$keyName , $filter->getData());

    $entity->addData($filter->getData());

    if ($filter->hasErrors()) {
      $response = $this->getResponse();

      $response->addError($filter->getErrorMessages());

      return false;
    }

    return true;

  }//end public function validate */

  /**
   * check the values for an insert
   * @param Entity $entity an enity object
   * @param array $fields if fetch is empty fetch all
   * @param string $keyName if is null use default keyname
   * @return Entity
   */
  public function validateInsert($entity, $keyName, $fields = array())
  {

    $filter = $this->checkFormInput
    (
      $entity->getValidationData($fields, true),
      $entity->getErrorMessages(),// return all so it's just an internal reference for reading
      $keyName
    );

    $entity->addData($filter->getData());

    if ($filter->hasErrors()) {

      $response = $this->getResponse();

      $response->addError($filter->getErrorMessages());

      return false;
    }

    return true;

  }//end public function validateInsert */

  /**
   * check the values for an update
   *
   * @param Entity $entity
   * @param array $fields
   * @return void
   */
  public function validateUpdate($entity, $keyName, $fields = array())
  {

    $filter = $this->checkFormInput
    (
      $entity->getValidationData($fields),
      $entity->getErrorMessages(),
      $keyName
    );

    $entity->addData($filter->getData());

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
   * @return array all filtered data
   */
  public function validateMultiInsert($entityName, $keyName, $fields = array())
  {

    $orm = $this->getOrm();

    $filtered = $this->checkMultiFormInput
    (
      $orm->getValidationData($entityName,$fields),
      $orm->getErrorMessages($entityName),
      $keyName
    );

    $entityName = ''.$entityName.'_Entity';

    $tmp = array();
    foreach ($filtered as $rowid => $data) {
      $tpObj = new $entityName();
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
   * @param Entity $entity
   * @param array $fields
   */
  public function validateMultiUpdate($entityKey, $keyName, $fields = array())
  {

    $orm = $this->getOrm();

    $filtered = $this->checkMultiFormInput
    (
      $orm->getValidationData($entityKey,$fields),
      $orm->getErrorMessages($entityKey),
      $keyName
    );

    $entityName = ''.$entityKey.'_Entity';

    $entityList = array();
    foreach ($filtered as $rowid => $data) {

      $tpObj = new $entityName();

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
        Message::addWarning('Got an invalid dataset for update');
      }

    }//end foreach

    return $entityList;

  }//end public static function validateMultiUpdate */

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


  /**
   * check the values for an update
   *
   * @param array $fields
   * @param string $keyName
   */
  public function validateMultiSave($entityName, $keyName, $fields = array())
  {

    $orm = $this->getOrm();

    $filtered = $this->checkMultiFormInput
    (
      $orm->getValidationData($entityName,$fields),
      $orm->getErrorMessages($entityName),
      $keyName
    );

    $entityName = ''.$entityName.'_Entity';

    $entityList = array();
    foreach ($filtered as $rowid => $data) {

      $tpObj = new $entityName();

      // ignore rowid
      if (array_key_exists(Db::PK, $data)) {
        unset($data[Db::PK]);
      }//end if

      if (is_numeric($rowid)) {
        $tpObj->setId((int) $rowid);

        if (DEBUG)
          Debug::console('the id '.$tpObj->id , $data);

      }//end if

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
    return $this->request->getBrowser();
  }//end public function getBrowser */

  /**
   *
   * Enter description here...
   * @return string
   */
  public function getBrowserVersion()
  {
    return $this->request->getBrowserVersion();

  }//end public function getBrowserVersion */

  /**
   *
   * Enter description here...
   * @return string
   */
  public function getPlatform()
  {
    return $this->request->getPlatform();

  }//end public function getPlatform */

  /**
   *
   * Enter description here...
   * @return string
   */
  public function getUseragent()
  {
    return $this->request->getUseragent();

  }//end public function getUseragent */

  /**
   *
   * Enter description here...
   * @return string
   */
  public function getClientIp()
  {
    return $this->request->getClientIp();

  }//end public function getClientIp */

  /**
   *
   * Enter description here...
   * @return string
   */
  public function getEncoding()
  {
    return $this->request->getEncoding();
  }//end public function getEncoding */

  /**
   *
   * Enter description here...
   * @return string
   */
  public function getClientLanguage()
  {
    return $this->request->getClientLanguage();

  }//end public function getClientLanguage */

  /**
   *
   * Enter description here...
   * @return string
   */
  public function getCharset()
  {
    return $this->request->getCharset();

  }//end public function getClientIp */

  /**
   * @return string
   */
  public function getClientRefer()
  {
    return $this->request->getClientRefer();

  }//end public function getClientHref */

  /**
   * @return string
   */
  public function getServerAddress($forceHttp=false)
  {
    return $this->request->getServerAddress($forceHttp);

  }//end public function getServerAddress */

  /**
   * @return string
   */
  public function getFullRequest($forceHttp=false)
  {
    return $this->request->getFullRequest($forceHttp);

  }//end public function getFullRequest */

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
    return $this->request->method($requested);

  }//end public function method */

  /**
   * get the request method
   *
   * @return string
   */
  public function inMethod($methodes)
  {
    return $this->request->inMethod($methodes);

  }//end public function inMethod */

  /**
   * @return boolean
   */
  public function isAjax()
  {
    return $this->request->isAjax();

  }//end public function isAjax */

  /**
   * @return boolean
   */
  public function getResource()
  {
    return $this->request->getResource();

  }//end public function getResource */

}// end class LibRequestSubrequest

