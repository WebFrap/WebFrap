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
class CrudFormValidator
{
/*//////////////////////////////////////////////////////////////////////////////
// Attribute
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @var string
   */
  public $request = null;
  
  /**
   * Liste mit den Fehlern der letzten Validierung
   * @var array
   */
  public $lastErrors = null;

  /**
   * @param LibRequestHttp $request
   */
  public function __construct($request)
  {
    $this->request = $request;
  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * Basierend auf den übergebenen Metadaten werden Informationen aus dem Databody
   * des Requests extrahiert, validiert und ein ein Entity Objekt geschrieben
   *
   * @param Entity $entity
   * @param string $keyName
   * @param array $fields
   * @param array $required liste der required fields
   * @param array $publishErrors true
   * @return void
   * 
   * @throws InvalidRequest_Exception
   */
  public function validateUpdate(
      $entity,
      $keyName,
      $fields = array(),
      $required = array(),
      $publishErrors = true
  ) {
  
      $filter = $this->checkFormInput(
          $entity->getValidationData($fields),
          $entity->getErrorMessages(),
          $keyName,
          $required
      );
  
      $data = $filter->getData();
      $entity->addData($data);

      $this->lastErrors = $filter->getErrorMessages();
  
      if ($this->lastErrors) {
          
          if ($publishErrors ) {
              $response = $this->getResponse();
              $response->addError($this->lastErrors);
          }
          
          throw new InvalidRequest_Exception(
  	         'One or more invalid values',
             'One or more invalid values'
          );
      }
      
  
  }//end public function validateUpdate */



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
   * @param array $required
   * @return Validator
   *
   */
  public function checkFormInput($values , $messages, $subkey = null, $required = array())
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
          if (isset($this->request->files[$subkey])) {
            // asume this was just an empty file
            if ('' == trim($this->request->files[$subkey]['name'][$key])) {
              continue;
              //$data = null;
            } else {
              $data = array();
              $data['name'] = $this->request->files[$subkey]['name'][$key];
              $data['type'] = $this->request->files[$subkey]['type'][$key];
              $data['tmp_name'] = $this->request->files[$subkey]['tmp_name'][$key];
              $data['error'] = $this->request->files[$subkey]['error'][$key];
              $data['size'] = $this->request->files[$subkey]['size'][$key];
            }
          } else {
            continue;
            //$data = null;
          }
          
        } else {

          if (isset($this->request->data[$subkey][$key])) {
            $data = $this->request->data[$subkey][$key];
          } else {
            continue;
          }

        }

        if ($error = $filter->$method($key, $data, $nullAble, $value[2], $value[3])) {

          if (isset($messages[$key][$error])) {
            $filter->addErrorMessage($messages[$key][$error]);
          } elseif (isset($messages[$key]['default'])) {
            $filter->addErrorMessage($messages[$key]['default']);
          } else {
            $filter->addErrorMessage('Wrong data for '.$key);
          }

        }

      }

    } else {// we have no subkey geht direct

      foreach ($values as $key => $value) {

        $method = 'add'.$value[0] ;

        if (Validator::FILE == ucfirst($value[0])) {

          if (isset($this->request->files[$key])) {
            $data = $this->request->files[$key];
          } else {
            continue;
          }

        } else {

          if (isset($this->request->data[$key])) {
            $data = $this->request->data[$key];
          } else {
            continue;
          }

        }

        if ($error = $filter->$method($key , $data, $nullAble , $value[2] , $value[3])) {

          if (isset($messages[$key][$error])) {
            $filter->addErrorMessage($messages[$key][$error]);
          } elseif (isset($messages[$key]['default'])) {
            $filter->addErrorMessage($messages[$key]['default']);
          } else {
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

        if (isset($this->request->params[$subkey][$key]))
          $data = $this->request->params[$subkey][$key];
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

        if (isset($this->request->params[$key]))
          $data = $this->request->params[$key];
        else
          continue;

        if ($error = $filter->$method($key , $data, false , $value[2] , $value[3])) {
          if (isset($messages[$key][$error])) {
              $response->addError($messages[$key][$error]);
          } elseif (isset($messages[$key]['default'])) {
              $response->addError($messages[$key]['default']);
          } else {
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
    if (!isset($this->request->data[$subkey]) or !is_array($this->request->data[$subkey])) {
      Log::warn('invalid data for subkey: '.$subkey);

      return array();
    }

    $response = $this->getResponse();

    // get Validator from Factory
    $filter = Validator::getActive();
    $filtered = array();

    foreach ($this->request->data[$subkey] as $rowPos => $row) {
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
      if (!isset($this->request->data[$subkey]) or !is_array($this->request->data[$subkey])) {
        Log::warn('invalid data for subkey: '.$subkey);

        return array();
      }

      $post = $this->request->data[$subkey];

    } else {

      $post = $this->request->data;
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

    foreach ($this->request->data[$subkey] as $id => $row) {
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

    }//end foreach ($this->request->data[$subkey] as $id => $row)

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
      foreach ($this->request->data[$key][$subkey] as $val) {
        if (is_numeric($val))
          $ids[] = $val;
      }
    } else {
      foreach ($this->request->data[$key] as $val) {
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

}// end class CrudFormValidator

