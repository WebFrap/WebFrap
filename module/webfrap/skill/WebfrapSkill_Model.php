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
 * @subpackage Core
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 * @licence BSD
 */
class WebfrapSkill_Model extends Model
{

  /**
   * @param int $skillId
   * @return CoreSkill_Entity
   */
  public function getTag($skillId )
  {

    $orm = $this->getOrm();

    return $orm->get( "CoreSkill",  $skillId );

  }//end public function getTag */

  /**
   * @param string $skillName
   * @return CoreSkill_Entity
   */
  public function addTag($skillName )
  {

    $orm       = $this->getOrm();
    $skillNode = $orm->getWhere( "CoreSkill",  "name ilike '".$orm->escape($skillName)."' " );

    if ($skillNode) {
      return $skillNode;
    } else {
      $skillNode = $orm->newEntity( "CoreSkill" );
      $skillNode->name = $skillName;
      $skillNode->access_key  = SFormatStrings::nameToAccessKey($skillName);
      $skillNode = $orm->insertIfNotExists($skillNode, array( 'name' ) );

      return $skillNode;
    }

  }//end public function addTag */

  /**
   * @param CoreSkill_Entity|int $skillId
   * @param int $objid
   *
   * @return CoreSkillRequirement_Entity | null gibt null zurück wenn die Verbindung bereits existiert
   */
  public function addConnection($skillId, $objid )
  {

    $orm    = $this->getOrm(  );
    $skillRef = $orm->newEntity( 'CoreSkillRequirement' );

    $skillRef->id_skill  = (string) $skillId;
    $skillRef->vid     = $objid;

    if (!$skillRef->id_skill) {
      throw new LibDb_Exception( "Missing Skill Id" );
    }

    return $orm->insertIfNotExists($skillRef, array( 'id_skill', 'vid' ) );

  }//end public function addConnection */

  /**
   * @param int $objid
   * @return int
   */
  public function cleanDsetTags($objid )
  {

    $orm    = $this->getOrm(  );
    $orm->deleteWhere( 'CoreSkillRequirement', "vid=".$objid );

  }//end public function cleanDsetTags */

  /**
   * @param int $objid
   * @return int
   */
  public function disconnect($objid )
  {

    $orm    = $this->getOrm(  );
    $orm->delete( 'CoreSkillRequirement', $objid );

  }//end public function disconnect */

  /**
   * @param string $key
   * @param int $refId
   *
   * @return LibDbPostgresqlResult
   */
  public function autocompleteByName($key, $refId  )
  {

    $db = $this->getDb();

    $sql = <<<SQL
SELECT
  skill.name as label,
  skill.name as value,
  skill.rowid as id
FROM
  core_skill skill
WHERE
  NOT skill.rowid IN( select ref.id_skill from core_skill_requirement ref where ref.vid = {$refId} )
  AND upper( skill.name ) like upper( '{$db->addSlashes($key)}%' )
ORDER BY
  skill.name
LIMIT 10;
SQL;

    return $db->select($sql )->getAll();

  }//end public function autocompleteByName */

  /**
   * @param string $key
   * @param int $refId
   *
   * @return LibDbPostgresqlResult
   */
  public function getDatasetTaglist($refId  )
  {

    $db = $this->getDb();

    $sql = <<<SQL
SELECT
  skill.name as label,
  skill.rowid as skill_id,
  ref.rowid as ref_id
FROM
  core_skill skill
JOIN
  core_skill_requirement ref
    ON skill.rowid = ref.id_skill
WHERE
  ref.vid = {$refId}
ORDER BY
  skill.name;
SQL;

    return $db->select($sql )->getAll();

  }//end public function getDatasetTaglist */

} // end class WebfrapSkill_Model

