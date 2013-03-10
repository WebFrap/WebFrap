<h1>WebFrap PHP Codekonvention</h1>

<label>Code Head</label>

<?php start_highlight(); ?>
<?php echo PHP_TAG; ?>

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
<?php display_highlight( 'php' ); ?>


<?php start_highlight();  ?>
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////
<?php display_highlight( 'php' ); ?>



<label>Code Head</label>
<?php start_highlight();  ?>

/**
* @package
* @subpackage
* @author
*/
class Fubar
{
  
  /**
  * What, 
  * Why, 
  * Since Version if public and part of the interface
  * @var string
  */
  public $publicValue = null;

}

<?php display_highlight( 'php' ); ?>