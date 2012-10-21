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
 */
class WebfrapDocu_Edit_Modal_View
  extends WgtModal
{
  
  public $width = 850;
  
  public $height = 500;

////////////////////////////////////////////////////////////////////////////////
// form export methodes
////////////////////////////////////////////////////////////////////////////////
    
 /**
  * @param WbfsysDocuPage $helpPage
  */
  public function displayForm( $helpPage )
  {

    // fetch the i18n text for title, status and bookmark
    $i18nText = $this->i18n->l
    (
      'Edit Help for: {@label@}',
      'wbf.label',
      array
      ( 
        'label' => $helpPage->title 
      )
    );

    // set the window title
    $this->setTitle( $i18nText );

    // set the window status text
    $this->setStatus( $i18nText );

    // set the from template
    $this->addVar( 'entity' , $helpPage );
    $this->setTemplate( 'webfrap/docu/modal/edit' );

    $this->addActions( $helpPage );
    

    // kein fehler aufgetreten
    return null;

  }//end public function displayForm */

////////////////////////////////////////////////////////////////////////////////
// protocol for entities
////////////////////////////////////////////////////////////////////////////////

  /**
   * this method is for adding the buttons in a create window
   * per default there is only one button added: save with the action
   * to save the window onclick
   *
   * @param TFlag $params the named parameter object that was created in
   *   the controller
   * {
   *   string formId: the id of the form;
   * }
   */
  public function addActions( $helpPage )
  {

    // add the button actions for create in the window
    // the code will be binded direct on a window object and is removed
    // on window Close
    // all buttons with the class save will call that action
    $code = <<<BUTTONJS

    self.find(".wgtac_save").click(function(){      
      \$R.form('wgt-form-webfrap-docu-{$helpPage->access_key}-edit');
    });
    
    self.find(".wgtac_save_a_close").click(function(){      
      \$R.form( 'wgt-form-webfrap-docu-{$helpPage->access_key}-edit', null, { success:function(){ 
        \$S.modal.close(); 
        \$R.get('modal.php?c=Webfrap.Docu.open&key={$helpPage->access_key}');
    	}});
      
    });

BUTTONJS;

    $this->addJsCode( $code );

  }//end public function addActions */



}//end class WebfrapDocu_Modal_View

