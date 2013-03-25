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
  * Das Ausgabemodul für die Seite
 * @package WebFrap
 * @subpackage tech_core
  */
class Item extends BaseChild
{
/*//////////////////////////////////////////////////////////////////////////////
// Attribute
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * sub Modul Extention
   * @var array
   */
  protected $models         = array();

  /**
   * @var Model
   */
  protected $model = null;

  /**
   * Der Name des Items
   * @var string
   */
  protected $itemName = null;

/*//////////////////////////////////////////////////////////////////////////////
// getter & setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param string $name
   * @param LibTemplateHtml $view
   */
  public function __construct($name, $view)
  {

    $this->env = $view;
    $this->setView($view);

    $this->itemName = $name;

    //$view->addItem($name, $this);

  }//end public function __construct */

/*//////////////////////////////////////////////////////////////////////////////
// getter & setter
//////////////////////////////////////////////////////////////////////////////*/

  /**
   * @param Model $model
   */
  public function setModel($model)
  {
    $this->model = $model;
  }//end public function setModel */

  /**
   * Eine Modelklasse laden
   *
   * @param string $modelName
   * @param string $key
   *
   * @return Model
   * @throws WebfrapSys_Exception wenn das angefragt Modell nicht existiert
   */
  public function loadModel($modelName , $key = null)
  {

    if (!$key)
      $key = $modelName;

    $modelClass    = $modelName.'_Model';

    if (!isset($this->models[$key]  )) {
      if (Webfrap::classLoadable($modelClass)) {
        $model = new $modelClass($this);
        $this->models[$key] = $model;
      } else {
        throw new WebfrapSys_Exception
        (
          'Internal Error',
          'Failed to load Submodul: '.$modelClass
        );
      }
    }

    return $this->models[$key];

  }//end public function loadModel */

  /**
   * de:
   * Erstellen eines UI Containers.
   * UI Container sind Hilfsobjekte welche Teilbereiche der Seite beschreiben.
   * z.B ein CRUD Formular, ein Suchformular, ein Listing Element, einen Graphen
   * etc.
   * In einem moderaten Maß ist die Logik durch Parameter konfigurierbar
   * Mehr Informationen dazu sind den jeweiligen Methoden auf den Containern zu
   * entnehmen.
   * @see Ui
   *
   * Dies Methode versucht ein Objekt eines Containers anhand eines übergeben
   * Keys zu erstellen.
   * Wenn die Klasse existiert wird ein  Objekt erstell und die View übergibt
   * sich direkt selbst.
   *
   * @param string $uiName
   * @return Ui ein UI Container
   * @throws WebfrapSys_Exception
   */
  public function loadUi($uiName)
  {

    $uiName       = ucfirst($uiName);
    $className    = $uiName.'_Ui';

    if (Webfrap::classLoadable($className)) {
      $ui = new $className($this);
      $ui->setView($this->getView());

      return $ui;
    } else {
      throw new WebfrapSys_Exception
      (
        'Internal Error',
        'Failed to load ui: '.$uiName
      );
    }

  }//end public function loadUi */

  /**
   * Enter description here...
   *
   * @param string $key
   * @return WgtForm
   */
  public function newForm($key , $type = null  )
  {

    $type = $type
      ? ucfirst($type)
      : ($key);

    $className    = $type.'_Form';
    $classNameOld = 'WgtForm'.$type;

    if (!WebFrap::classLoadable($className)) {
      // fall back to old name convention
      $className = $classNameOld;
      if (!WebFrap::classLoadable($className))
        throw new LibTemplate_Exception('Requested noexisting form '.$type);
    }

    $form = new $className($this->getView());

    return $form;

  }//end public function newForm */

}//end class Item

