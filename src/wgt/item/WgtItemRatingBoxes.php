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
 * @subpackage tech_core
 */
class WgtItemRatingBoxes
  extends WgtItemAbstract
{

////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  protected $activ = null;

////////////////////////////////////////////////////////////////////////////////
// getter and Setter
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   */
  public function setActiv($activ)
  {
    $this->activ = $activ;
  }//end setActiv

  /**
   *
   */
  public function build( )
  {


    // Deliverd in Time
    $radio = new WgtItemRadiobox( 'temp'.$this->name );
    $radio->setActiv( $this->activ );
    $radio->addAttributes( $this->attributes );

    $radioN = $radio->addRadio();
    $radioN->addTdAttributes( 'class' , 'wgtRadionNotRated' );
    $radioN->addAttributes
    (
    array
    (
    'name'      => $this->attributes['name'],
    'type'      => 'radio',
    'value'     => '0',
    'title'      => 'noch keine Bewertung',
    )
    );

    $radioG = $radio->addRadio();
    $radioG->addTdAttributes('class' , 'wgtRadionGodRated' );
    $radioG->addAttributes
    (
    array
    (
    'name'      => $this->attributes['name'],
    'type'      => 'radio',
    'value'     => '1',
    'title'      => 'Leistung is gut',
    )
    );

    $radioA = $radio->addRadio();
    $radioA->addTdAttributes('class' , 'wgtRadionAverageRated' );
    $radioA->addAttributes
    (
    array
    (
    'name'      => $this->attributes['name'],
    'type'      => 'radio',
    'value'     => '2',
    'title'      => 'Leistung is akzeptabel',
    )
    );

    $radioB = $radio->addRadio();
    $radioB->addTdAttributes('class' , 'wgtRadionBadRated' );
    $radioB->addAttributes
    (
    array
    (
    'name'      => $this->attributes['name'],
    'type'      => 'radio',
    'value'     => '3',
    'title'      => 'Leistung ist nicht akzeptabel!',
    )
    );

    return $radio->toHtml();

  }//end public function build( )

}//end class WgtItemRatingBoxes

