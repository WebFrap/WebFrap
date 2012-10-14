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
class DeveloperPacker_Controller
  extends Controller
{

  protected $defaultAction = 'listpackages';

  protected $callAble = array('listpackages','pack');

////////////////////////////////////////////////////////////////////////////////
// Der Controller
////////////////////////////////////////////////////////////////////////////////


  /**
   * Enter description here...
   *
   */
  public function listPackages()
  {
    if( $this->view->isType( View::WINDOW ) )
    {
      $view = $this->view->newWindow('WindowDeveloperPackages');
    }
    else
    {
      $view = $this->view;
    }


    $view->setTitle('WebFrap Packages');
    $view->setTemplate( 'TablePackage' , 'developer' );
    $table = $view->newItem( 'tablePackage' , 'TableDeveloperPackage'  );

  }//end public function listPackages()

  /**
   * Enter description here...
   *
   */
  public function pack()
  {

    $request = $this->getRequest();

    $package = $request->param('objid',Validator::CNAME);

    $fileName = PATH_GW.'data/wbf_package/'.$package.'.xml';

    $xml = LibXml::load( $fileName );

    $packageName = PATH_GW.'src/'.trim($xml['package']).'.php';

    $fileList = array();

    foreach( $xml->classes->class as $class )
    {
      $fileList[] = trim($class);
    }

    $packer = new LibCodePackerPhp();
    $packer->fileName = $packageName;
    $packer->setFilesAsClasses( array_reverse($fileList) );
    $packer->pack();

    Controller::addMessage( 'Successfully packed '.trim($xml['package']) );

  }//end public function pack()



} // end class MexGenfPacker

