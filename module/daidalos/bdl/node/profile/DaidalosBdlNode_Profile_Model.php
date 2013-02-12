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
 * @subpackage Daidalos
 * @author Dominik Bonsch <dominik.bonsch@webfrap.net>
 * @copyright Webfrap Developer Network <contact@webfrap.net>
 */
class DaidalosBdlNode_Profile_Model
  extends DaidalosBdlNode_Model
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @var BdlNodeEntity
   */
  public $node = null;

////////////////////////////////////////////////////////////////////////////////
// Methodes
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param $modeller DaidalosBdlModeller_Model
   */
  public function loadBdlNode( $modeller )
  {

    $this->modeller = $modeller;
    $this->node     = new BdlNodeProfile( $this->modeller->bdlFile );

  }//end public function loadBdlNode */

  /**
   * Speichern des HTTP Requests
   * @param LibRequestHttp $request
   */
  public function saveRequest( $request )
  {

    $response = $this->getResponse();

    if( $name = $request->data( 'profile', Validator::CKEY, 'name' ) )
      $this->node->setName( $name );

    if( $extends = $request->data( 'profile', Validator::CKEY, 'extends' ) )
      $this->node->setExtends( $extends );

    if( $module = $request->data( 'profile', Validator::CKEY, 'module' ) )
      $this->node->setModule( $module );

    if( $panel = $request->data( 'profile', Validator::CKEY, 'panel' ) )
      $this->node->setPanel( $panel );

    if( $desktop = $request->data( 'profile', Validator::CKEY, 'desktop' ) )
      $this->node->setDesktop( $desktop );

    if( $mainmenu = $request->data( 'profile', Validator::CKEY, 'mainmenu' ) )
      $this->node->setMainmenu( $mainmenu );

    if( $navigation = $request->data( 'profile', Validator::CKEY, 'navigation' ) )
      $this->node->setNavigation( $navigation );

    // label / description / docu
    $labels = $request->data( 'profile', Validator::TEXT, 'label' );
    if ($labels) {
      foreach ($labels as $lang => $content) {
        $this->node->setLabel( $lang, $content );
      }
    } else {
      if( !$this->node->hasLabel( 'de' ) )
        $this->node->setLabel( 'de', $this->node->getName() );
      if( !$this->node->hasLabel( 'en' ) )
        $this->node->setLabel( 'en', $this->node->getName() );
    }

    $descriptions = $request->data( 'profile', Validator::TEXT, 'description' );
    if ($descriptions) {
      foreach ($descriptions as $lang => $content) {
        $this->node->setDescription( $lang, $content );
      }
    } else {
      if( !$this->node->hasDescription( 'de' ) )
        $this->node->setDescription( 'de', $this->node->getLabelByLang( 'de' ) );
      if( !$this->node->hasDescription( 'en' ) )
        $this->node->setDescription( 'en', $this->node->getLabelByLang( 'en' ) );
    }

    $docus = $request->data( 'profile', Validator::TEXT, 'docu' );
    if ($docus) {
      foreach ($docus as $lang => $content) {
        $this->node->setDocu( $lang, $content );
      }
    } else {
      if( !$this->node->hasDocu( 'de' ) )
        $this->node->setDocu( 'de', $this->node->getDescriptionByLang( 'de' ) );
      if( !$this->node->hasDocu( 'en' ) )
        $this->node->setDocu( 'en', $this->node->getDescriptionByLang( 'en' ) );
    }

    $shortDescs = $request->data( 'profile', Validator::TEXT, 'short_desc' );
    if ($shortDescs) {
      foreach ($shortDescs as $lang => $content) {
        $this->node->setShortDesc( $lang, $content );
      }
    } else {
      if( !$this->node->hasShortDesc( 'de' ) )
        $this->node->setShortDesc( 'de', $this->node->getDescriptionByLang( 'de' ) );

      if( !$this->node->hasShortDesc( 'en' ) )
        $this->node->setShortDesc( 'en', $this->node->getDescriptionByLang( 'en' ) );
    }

    $this->modeller->save();

  }//end public function saveRequest */

}//end class DaidalosBdlNodeProfile_Model
