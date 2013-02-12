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
 * Read before change:
 * It's not recommended to change this file inside a Mod or App Project.
 * If you want to change it copy it to a custom project.

 *
 * @package WebFrap
 * @subpackage Acl
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright webfrap.net <contact@webfrap.net>
 */
class AclMgmt_Qfdu_Multi_Model
  extends Model
{
////////////////////////////////////////////////////////////////////////////////
// getter & setter methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * multi save action, with this action you can save multiple entries
   * for this model in the database
   * save means create if not exist and update if allready exists
   *
   * @param TFlag $params named parameters
   * @return void
   */
  public function update( $params   )
  {

    $orm  = $this->getOrm();
    $db   = $this->getDb();
    $view = $this->getView();
    $response = $this->getResponse();

    try
    {
      // start a transaction in the database
      $db->begin();

      // for insert there has to be a list of values that have to be saved
      $listWbfsysGroupUsers = $this->getRegisterd( 'listWbfsysGroupUsers' );

      if( is_null( $listWbfsysGroupUsers ) )
      {
        throw new WebfrapSys_Exception
        (
          'Internal Error',
          'listWbfsysGroupUsers was not registered'
        );
      }

      $entityTexts = array();

      foreach( $listWbfsysGroupUsers as $entityWbfsysGroupUsers )
      {
        if(!$orm->update( $entityWbfsysGroupUsers) )
        {
          $entityText = $entityWbfsysGroupUsers->text();
          $response->addError
          (
            $view->i18n->l
            (
              'Failed to save Area: '.$entityText,
              'enterprise.employee.message',
              array( $entityText )
            )
          );
        }
        else
        {
          $text = $entityWbfsysGroupUsers->text();
          if( trim($text) == '' )
          {
            $text = 'Assignment: '.$entityWbfsysGroupUsers->getid();
          }

          $entityTexts[] = $text;
        }
      }

      $textSaved = implode( $entityTexts,', ' );
      $this->getResponse()->addMessage
      (
        $view->i18n->l
        (
          'Successfully saved: '.$textSaved,
          'enterprise.employee.message',
          array( $textSaved )
        )
      );

      // everything ok
      $db->commit();

    }
    catch( LibDb_Exception $e )
    {
      $response->addError( $e->getMessage() );
      $db->rollback();
    }
    catch( WebfrapSys_Exception $e )
    {
      $response->addError( $e->getMessage() );
    }

    // check if there were any errors, if not fine
    return !$this->getResponse()->hasErrors();

  }//end public function update */

  /**
   * fetch the data from the http request object for an insert
   * @param TFlag $params named parameters
   * @return boolean
   */
  public function fetchUpdateData( $params  )
  {

    $httpRequest = $this->getRequest();
    $orm         = $this->getOrm();

    try
    {

      // if the validation fails report
      $listWbfsysGroupUsers = $httpRequest->validateMultiUpdate
      (
        'WbfsysGroupUsers',
        'group_users',
        array( 'date_start', 'date_end' )
      );

      $this->register( 'listWbfsysGroupUsers', $listWbfsysGroupUsers );
      return true;

    }
    catch( InvalidInput_Exception $e )
    {
      return false;
    }

  }//end public function fetchUpdateData */

} // end class AclMgmt_Qfdu_Multi_Model */

