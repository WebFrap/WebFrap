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
 * @lang:de
 * Der Rollencontainer ist dazu gedacht die Relativen Rollen für eine Reihe von
 * Datensätzen aus einer oder mehrere Quellen zu verwalten.
 * ( Mehrere Quellen setzen vorraus, dass alle IDs im System unique sind, also
 * eine globale Sequence im Datenmodell )
 *
 * @example
 * <code>
 *
 *  $container = new LibAclRoleContainer( $roles );
 *
 *  if( $container->hasRole($someId,'role_name') )
 *  {
 *    echo 'user has role role_name';
 *  }
 *
 *  $roles = $container->getRoles($someId);
 *
 * </code>
 *
 * @package WebFrap
 * @subpackage tech_core
 * @author dominik alexander bonsch <dominik.bonsch@webfrap.net>
 */
class LibAclRoleContainer
  implements ArrayAccess, Countable
{
/*//////////////////////////////////////////////////////////////////////////////
// Attributes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang de:
   * Liste der Angefragen Datensätze mit den dazugehörigen rollen
   * @var array
   */
  public $roles     = array();

  /**
   * @lang de:
   * der area key
   * @var array
   */
  public $key       = null;

/*//////////////////////////////////////////////////////////////////////////////
// Constructor
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang:de
   */
  public function __construct( $roles )
  {

    $this->roles = $roles;

  }//end public function __construct */

  /**
   * @lang:de
   *
   * gibt einfach das level als string mit, um das einbinden des
   * containers zu erleichtern
   *
   * @return string das level als string
   */
  public function __toString()
  {
    return 'Datasets: '.implode( ',', array_keys( $this->roles ) );
  }//end public function __toString */

/*//////////////////////////////////////////////////////////////////////////////
// Interface: ArrayAccess
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see ArrayAccess:offsetSet
   */
  public function offsetSet( $offset, $value )
  {

    if( is_null($offset) )
      $this->roles[] = $value;
    else
      $this->roles[$offset] = $value;

  }//end public function offsetSet */

  /**
   * @see ArrayAccess:offsetGet
   */
  public function offsetGet($offset)
  {
    return $this->roles[$offset];
  }//end public function offsetGet */

  /**
   * @see ArrayAccess:offsetUnset
   */
  public function offsetUnset($offset)
  {
    unset($this->roles[$offset]);
  }//end public function offsetUnset */

  /**
   * @see ArrayAccess:offsetExists
   */
  public function offsetExists($offset)
  {
    return isset($this->roles[$offset])?true:false;
  }//end public function offsetExists */
  
/*//////////////////////////////////////////////////////////////////////////////
// Interface: Countable
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @see Countable::count
   */
  public function count()
  {
    return count($this->roles);
  }//end public function count */

/*//////////////////////////////////////////////////////////////////////////////
// Methodes
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @lang de:
   * Check ob der User eine bestimmte Rolle in Relation zu einem Datensatz hat
   *
   * @param int $key die ID für eine Entity
   * @param string $roleName den Namen einer Rolle
   * 
   * @return boolean
   */
  public function hasRole( $key, $roleName )
  {

    if (!isset( $this->roles[$key] ) )
      return false;

    if( is_array( $roleName ) )
    {
      foreach( $roleName as $roleKey )
      {
        if( in_array( $roleKey, $this->roles[$key] ) )
          return true;
      }

      return false;
    }
    else
    {
      return in_array( $roleName, $this->roles[$key] );
    }

  }//end public function hasRole */

  
  /**
   * @lang de:
   * Alle Rollen ion relation zu einem Datensatz anfragen
   *
   * @param int $key  die ID für eine Entity
   * @param string $roleName 
   *  
   * @return array / null im Fehlerfall
   */
  public function getNum( $key, $roleName )
  {

    if (!isset( $this->roles[$key][$roleName] ) )
      return 0;

    return $this->roles[$key][$roleName];

  }//end public function getNum */


  /**
   * @lang de:
   * Alle Rollen ion relation zu einem Datensatz anfragen
   *
   * @param int $key  die ID für eine Entity
   * 
   * @return array / null im Fehlerfall
   */
  public function getRoles( $key )
  {

    if (!isset( $this->roles[$key] ) )
      return null;

    return $this->roles[$key];

  }//end public function getRoles */
  
  /**
   * Der Container zusätzliche Rollen hinzufügen
   *
   * @param int $key  die ID für eine Entity
   * @param [string] $roles 
   * @return array / null im Fehlerfall
   */
  public function addRoles( $key, $roles = array() )
  {

    if( is_array($key) )
    {
      
      foreach( $key as $dsetId => $rows)
      {
        if( isset( $this->roles[$dsetId] ) )
        {
          $this->roles[$dsetId] = array_merge( $this->roles[$dsetId], $roles );
        }
        else 
        {
          $this->roles[$dsetId] = $roles;
        }
      }
      
    } else {
      
      if( isset( $this->roles[$key] ) )
      {
        $this->roles[$key] = array_merge( $this->roles[$key], $roles );
      } else {
        $this->roles[$key] = $roles;
      }
      
    }

  }//end public function addRoles */
  
  /**
   * Der Container zusätzliche Rollen hinzufügen
   *
   * @param LibAclRoleContainer $container der Container welcher in
   * die brereits vorandenen daten gemerged werden soll
   */
  public function merge( $container )
  {

    foreach( $container->roles as $dsetId => $roles)
    {
      if( isset( $this->roles[$dsetId] ) )
      {
        $this->roles[$dsetId] = array_merge( $this->roles[$dsetId], $roles );
      } else {
        $this->roles[$dsetId] = $roles;
      }
    }

  }//end public function merge */
  

}//end class LibAclRoleContainer

