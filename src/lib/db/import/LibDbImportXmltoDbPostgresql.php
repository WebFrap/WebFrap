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
class LibDbImportXmltoDbPostgresql
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   *
   * @var unknown_type
   */
  protected $quotesMap = array
  (
  'int'       =>  false,
  'float'     =>  false,
  'text'      =>  true,
  'varchar'   =>  true,
  'numeric'   =>  false,
  'decimal'   =>  false,
  'char'      =>  true,
  'date'      =>  true,
  'time'      =>  true,
  'timestamp' =>  true
  );

  /**
   *
   */
  /**
   *
   */
  public function import($tableName , $xml , $fields = array() )
  {

    if ($fields)
      $this->importByField($tableName , $xml , $fields );
    else
      $this->importAll($tableName , $xml );

  }//end public function import */

  /**
   *
   */
  protected function importAll($tableName , $xml )
  {

    $cols = array();
    $types = array();
    $vals = array();

    $num = 1;
    foreach($xml->cols->c as $col )
    {
      $cols[] = trim($col);
      $types[] = trim($col['t']);
      $vals[] = '$'.$num;

      ++$num;
    }

    /*
      PREPARE fooplan (int, text, bool, numeric) AS
      INSERT INTO foo VALUES($1, $2, $3, $4);
     */

    //INSERT INTO '.$tableName.' ( '.implode(',',$cols).' ) VALUES

    $prepare = ' PREPARE import_'.$tableName.' ('.implode(',',$types).') AS ' ;
    $prepare .= ' INSERT INTO '.$tableName.' ('.implode(',',$cols).')  VALUES  ( '.implode(',',$vals).' ); ';

    $db = Db::getActive();

    $db->exec($prepare );

    foreach($xml->rows->r as $row )
    {
      $pos = 0;

      $values = array();
      foreach($row->v as $val )
      {
        $values[$cols[$pos]] = $val;
      }

      $santisized = $db->convertData($tableName , $values );
      $execute = 'EXECUTE import_'.$tableName.'( '.implode(',',$santisized).' );';

      $db->exec($execute );

    }

    $db->exec( 'DEALOCATE import_'.$tableName.';' );

  }//end protected function importAll


} // end class LibDbImportXmltoDbPostgresql

