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
 * @subpackage ModDeveloper
 */
class LibDbSyncMetadata extends LibDbSync
{

/*//////////////////////////////////////////////////////////////////////////////
// sync methods
//////////////////////////////////////////////////////////////////////////////*/

 /**
   * @param string $tableName
   * @param LibGenfTreeNodeEntity $entity
   */
  public function syncEntityTable($tableName, $entity, $multiSeq = false)
  {

    foreach ($entity as $attribute) {

      $colName = $attribute->name();

      // never change rowid or any m_ flags
      //if ($attribute->inCategory('meta'))
      //  continue;

      if ($this->columnExists($colName , $tableName)) {

        if (!$this->syncAttributeColumn($tableName, $attribute, $multiSeq)) {
          //$this->dropColumn($colName,$tableName);
          //$this->createAttributeColumn($tableName, $attribute, $multiSeq);
        }
      } else {  // colum not exists
        $this->createAttributeColumn($tableName, $attribute, $multiSeq);
      }

    }

    $this->setTableOwner($tableName);

  }//end protected function syncTable */

  /**
   * @param $tableName
   * @param $entity
   */
  public function createEntityTable($tableName, $entity, $multiSeq = false)
  {

    $colData = array();

    //<attribute name="name" type="varchar" size="120" required="false"  >

    foreach ($entity as $attribute) {
      $colData[] = $this->columnAttributeData($attribute, $tableName, $multiSeq);
    }

    $this->createTable($tableName, $colData);
    Message::addMessage('Tabelle '.$tableName.' wurde erfolgreich erstellt');

  }//end protected function createTable */

  /**
   *
   * @param $dbAdmin
   * @param $tableName
   * @param $attribute
   * @return unknown_type
   */
  public function syncAttributeColumn($tableName, $attribute, $multiSeq)
  {

    //TODO maybe this should be a "little" more genereric
    $orgType = trim($attribute->dbType());

    $mapping = $this->nameMapping;

    if (isset($mapping[$orgType])) {
      $type = $mapping[$orgType];
    } else {
      Error::addError('missing $orgType'.$orgType);
      $type = 'text';
    }

    if ($seqName = $attribute->sequence()) {
      $default =  "nextval('{$seqName}'::regclass)";
    } elseif ($attribute->name('rowid')) {
      $seqName = Db::SEQUENCE;
      $default =  "nextval('{$seqName}'::regclass)";
    } elseif ($def = $attribute->defaultValue()) {
      if (!$attribute->target()  )
        $default = $def;
      else
        $default = '';
    } else {
      $default = '';
    }

    $precision = null;
    $scale = null;
    $length = null;
    $size = $attribute->size();

    if ($orgType == 'numeric') {
      $tmp = explode('.'  , $size);

      $precision = $tmp[0];

      if (isset($tmp[1]))
        $scale = $tmp[1];
      else
        $scale = 0;

    } elseif ($orgType == 'integer' || $orgType == 'int') {
      $precision = '32';
      $scale = '0';
    } elseif ($orgType == 'char') {
      if (trim($size) == '') {
        $length = '1';
      } else {
        $length = trim($size);
      }
    } else {
      $length = trim($size);
    }

    if ($attribute->required()) {
      $nullAble = 'NO';
    } else {
      $nullAble = 'YES';
    }

    $colName = $attribute->name();

    $data = array
    (
      LibDbAdmin::COL_NAME => $colName,
      LibDbAdmin::COL_DEFAULT => $default,
      LibDbAdmin::COL_NULL_ABLE => $nullAble,
      LibDbAdmin::COL_TYPE => $type,
      LibDbAdmin::COL_LENGTH => $length,
      LibDbAdmin::COL_PRECISION => $precision,
      LibDbAdmin::COL_SCALE => $scale,
    );

    if ($diff = $this->diffColumn($colName , $data, $tableName  )) {
      try {
        $this->alterColumn($colName , $data, $diff, $tableName);
        Message::addMessage('Column: '.$colName.' in Tabelle '.$tableName.' wurde angepasst');

        return true;
      } catch (LibDb_Exception $e) {
        // error was allready reported in the exception
        return false;
      }
    }

    return true;

  }//end protected function syncColumn */

  /**
   *
   * @param $dbAdmin
   * @param $tableName
   * @param LibGenfTreeNodeAttribute $attribute
   * @return unknown_type
   */
  public function createAttributeColumn($tableName, $attribute, $multiSeq  )
  {

    $colName = $attribute->name();

    $this->addColumn($colName , $this->columnAttributeData($attribute, $tableName),  $tableName);
    Message::addMessage('Column: '.$colName.' in Tabelle '.$tableName.' wurde erstellt');

  }//end protected function createColumn */

  /**
   *
   */
  public function columnAttributeData($attribute, $tableName = null, $multiSeq = false)
  {

    if (!$tableName)
      $tableName = $attribute->name->source;

    if ($sequence = $attribute->sequence()) {
      if ($multiSeq) {
        if (is_string($sequence)) {
          $default =  "nextval('".$sequence."'::regclass)";
        } else {
          $default =  "nextval('".$tableName."_".$attribute->name()."_seq'::regclass)";
        }

        //$dbAdmin->createSequence($tableName."_".$attribute->name()."_seq");
      } else {

        if (!is_string($sequence)) {
          $sequence =  Db::SEQUENCE;
        }

        $default = "nextval('{$sequence}'::regclass)";
      }
    } elseif ($attribute->name(Db::PK)) {
      $seqName = Db::SEQUENCE;
      $default = "nextval('{$seqName}'::regclass)";
    } elseif ($def = $attribute->defaultValue()) {
      if (!$attribute->target())
        $default = $def;
      else
        $default = '';
    } else {
      $default = '';
    }

    $type = $attribute->dbType();
    $size = str_replace('.' , ',', $attribute->size());

    $colData = array
    (
      'name' => $attribute->name(),
      'type' => $type,
      'size' => $size,
      'required' => $attribute->required()?'true':'false',
      'default' => $default,
    );

    return $colData;

  }//end protected function columnData */

} // end class LibDbAdminPostgresql

