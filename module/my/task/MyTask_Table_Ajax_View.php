<?php
/*******************************************************************************
          _______          ______    _______      ______    _______
         |   _   | ______ |   _  \  |   _   \    |   _  \  |   _   |
         |   1___||______||.  |   \ |.  1   / __ |.  |   \ |.  1___|
         |____   |        |.  |    \|.  _   \|__||.  |    \|.  __)_
         |:  1   |        |:  1    /|:  1    \   |:  1    /|:  1   |
         |::.. . |        |::.. . / |::.. .  /   |::.. . / |::.. . |
         `-------'        `------'  `-------'    `------'  `-------'
                             __.;:-+=;=_.
                                    ._=~ -...    -~:
                     .:;;;:.-=si_=s%+-..;===+||=;. -:
                  ..;::::::..<mQmQW>  :::.::;==+||.:;        ..:-..
               .:.:::::::::-_qWWQWe .=:::::::::::::::   ..:::-.  . -:_
             .:...:.:::;:;.:jQWWWE;.+===;;;;:;::::.=ugwmp;..:=====.  -
           .=-.-::::;=;=;-.wQWBWWE;:++==+========;.=WWWWk.:|||||ii>...
         .vma. ::;:=====.<mWmWBWWE;:|+||++|+|||+|=:)WWBWE;=liiillIv; :
       .=3mQQa,:=====+==wQWBWBWBWh>:+|||||||i||ii|;=$WWW#>=lvvvvIvv;.
      .--+3QWWc:;=|+|+;=3QWBWBWWWmi:|iiiiiilllllll>-3WmW#>:IvlIvvv>` .
     .=___<XQ2=<|++||||;-9WWBWWWWQc:|iilllvIvvvnvvsi|\'\?Y1=:{IIIIi+- .
     ivIIiidWe;voi+|illi|.+9WWBWWWm>:<llvvvvnnnnnnn}~     - =++-
     +lIliidB>:+vXvvivIvli_."$WWWmWm;:<Ilvvnnnnonnv> .          .- .
      ~|i|IXG===inovillllil|=:"HW###h>:<lIvvnvnnvv>- .
        -==|1i==|vni||i|i|||||;:+Y1""'i=|IIvvvv}+-  .
           ----:=|l=+|+|+||+=:+|-      - --++--. .-
                  .  -=||||ii:. .              - .
                       -+ilI+ .;..
                         ---.::....

********************************************************************************
*
* @author      : Dominik Bonsch <db@s-db.de>
* @date        :
* @copyright   : s-db.de (Softwareentwicklung Dominik Bonsch) <contact@s-db.de>
* @distributor : s-db.de <contact@s-db.de>
* @project     : S-DB Modules
* @projectUrl  : http://s-db.de
* @version     : 1
* @revision    : 1
*
* @licence     : S-DB Business <contact@s-db.de>
*
* Changes:
*
*******************************************************************************/

/**
 * @package WebFrap
 * @subpackage Core
 * @author Dominik Bonsch <db@s-db.de>
 * @copyright Softwareentwicklung Dominik Bonsch <db@s-db.de>
 */
class MyTask_Table_Ajax_View
  extends LibTemplateAjaxView
{
 /**
  * de:
  * behandeln einer suchanfrage vom client
  * alles in allem recht unspektakulär, das ui element für die tabelle
  * wird geladen, mit daten befüllt und mit refresh als pushabel area objekt
  * direkt der ajax template engine übergeben
  *
  * @param TFlag $params
  * @return null|Error im Fehlerfall
  */
  public function displaySearch( $params )
  {

    $ui    = $this->loadUi( 'MyTask_Table' );
    $ui->setModel($this->model);
    $ui->createListItem
    (
      $this->model->search( $params ),
      $params
    );

    // keine fehler? bestens
    // exceptions werden fallen gelassen
    return null;

  }//end public function displaySearch */

 /**
  * de:
  * Einfache insert methode.
  * Es wird ein neuer eintrag für das listenelement erstellt und über
  * das ajax interface in die liste gepusht
  *
  * @param TFlag $params benamte parameter
  * @return boolean
  */
  public function displayInsert( $params )
  {

    $ui = $this->loadUi( 'MyTask_Table' );
    $ui->setModel( $this->model );

    $ui->listEntry( $params, true );

    // kein fehler? alles bestens
    return null;

  }//end public function displayInsert */

 /**
  * de:
  * Einfache insert methode.
  * Es wird ein neuer eintrag für das listenelement erstellt und über
  * das ajax interface in die liste gepusht
  *
  * @param TFlag $params benamte parameter
  * @return boolean
  */
  public function displayUpdate( $params )
  {

    $ui = $this->loadUi( 'MyTask_Table' );
    $ui->setModel( $this->model );

    $ui->listEntry( $params, false );

    // kein fehler? alles bestens
    return null;

  }//end public function displayUpdate */

 /**
  * de: entfernen eines eintrags aus dem listenelement
  *
  * @param int $objid die rowid des gelöschten listenelements
  * @param TFlag $params benamte parameter
  * @return boolean
  */
  public function displayDelete( $objid, $params )
  {

    // if we got a target id we remove the element from the client
    if ($params->targetId) {
      $ui = $this->loadUi( 'MyTask_Table' );

      $ui->setModel($this->model);
      $ui->removeListEntry( $objid, $params->targetId );
    }

    // kein fehler? alles bestens
    return null;

  }//end public function displayDelete */

}//end class MyTask_Table_Ajax_View
