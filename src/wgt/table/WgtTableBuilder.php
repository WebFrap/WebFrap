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
class WgtTableBuilder
{
////////////////////////////////////////////////////////////////////////////////
// attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * the dom id for the html output
   *
   * @var string
   */
  public $id = null;

  /**
   * @var int
   */
  public $anzMenuNumbers = 5;

  /**
   * @var int
   */
  public $stepSize       = Wgt::LIST_SIZE_CHUNK;

  /**
   * @var int
   */
  public $numOfColors    = 2;

  /**
   * wo fängt die pagingtabelle mit dem zählen an
   * @var int
   */
  public $start           = 0;

  /**
   * @var int
   */
  public $tableSize      = null;

  /**
   * @var string
   */
  public $dropRef        = null ;

  /**
   * the actions that should be shown in the table
   *
   * @var array
   */
  public $actions        = array() ;

  /**
   * pool for all type of actions and urls which have no own member attributes
   *
   * @var array()
   */
  public $actionPool = array();

  /**
   * data structur for the item
   * @var array
   */
  public $data = null;

  /**
   * this is the name of the object which indentifies it in templates
   * @var string
   */
  public $name = null;

  /**
   * the paging url
   * if null theres no paging menu
   * @var string
   */
  public $pagingUrl = null;

  /**
   * this is the name of the object which indentifies it in templates
   * @var string
   */
  public $pagingId = null;

  /**
   *
   * @var string
   */
  public $template = null;

  /**
   *
   * @var array
   */
  public $params = array();

  /**
   *
   * @var string
   */
  protected $assembled = null;



////////////////////////////////////////////////////////////////////////////////
// Constructors and Magic Functions
////////////////////////////////////////////////////////////////////////////////

  /**
   * default constructor
   *
   * @param int $name the name of the wgt object
   */
  public function __construct( $name )
  {
    if(Log::$levelVerbose)
      Log::create(get_class($this) , array($name) );

    $this->name = $name;

  } // end public function __construct( $name )


  /**
   * the to string method
   * @return string
   */
  public function __toString()
  {

    if( $this->assembled )
    {
      return $this->assembled;
    }

    try
    {
      return $this->build();
    }
    catch( Exception $e )
    {

      Error::addError
      (
      'failed to build wgt item: '.get_class($this),
      null,
      $e
      );

      if(Log::$levelDebug)
      {
        return '<b>failed to create: '.get_class($this).': '.$this->id.' </b>';
      }
      else
      {
        return '<b>failed to create</b>';
      }
    }//end catch( Exception $e )

  }// end public function __toString()



////////////////////////////////////////////////////////////////////////////////
// Getter and Setter
////////////////////////////////////////////////////////////////////////////////

  /**
   * get the id of the wgt object
   *
   */
  public function getId()
  {
    if(!$this->id)
    {
      $this->id = 'wgt_'.uniqid();
    }

    return $this->id;
  }//end public function getId()

  /**
   * @param int $anz
   */
  public function setMenuNumbers( $anz )
  {
    $this->anzMenuNumbers = $anz;
  }//end public function setMenuNumbers */

  /**
   * Setter for template
   * @param string $template
   * @return void
   */
  public function setTemplate( $template )
  {
    $this->template = $template;
  }//end public function setTemplate */

  /**
   * @param int $stepSize
   */
  public function setStepSize( $stepSize )
  {
    $this->stepSize = $stepSize;
  }//end public function setStepSize */

  /**
   * @param int $stepSize
   */
  public function setTableSize( $tableSize )
  {
    $this->tableSize = $tableSize;
  }//end public function setTableSize */

  /**
   * @param int $numOfColors
   */
  public function setNumOfCols( $numOfColors )
  {
    $this->numOfColors = $numOfColors;
  }//end public function setNumOfCols  */

  /**
   * @param array $data
   * @param string $value
   * @return void
   */
  public function setData( $data , $value = null )
  {

    if( is_object($data) && $data instanceof LibSqlQuery  )
    {
      $this->data       = $data;
      $this->tableSize  = $this->data->getSourceSize();
    }
    else if( is_array($data) && is_array( current( $data ) ) )
    {
      $this->data       = $data;
    }
    else if( is_array( $data ) )
    {
      $this->data       = array( $data );
    }
    else
    {
      return false;
    }

  } // end public function setData  */

  /**
   * @param array $row
   * @param mixed $value
   * @param boolean $multi
   * @return void
   */
  public function addData( $data , $value = null , $multi = true )
  {

    if( is_object($data) and $data instanceof LibSqlQuery  )
    {
      $this->data       = $data;
      $this->tableSize  = $this->data->getSourceSize();
    }
    elseif( is_numeric($data) and is_array($value) )
    {
      $this->data[$data] =  $value;
    }
    elseif( is_array($data) and is_array( current( $data ) ) )
    {
      $this->data = array_merge( $this->data , $data );
    }
    elseif( is_array($data) )
    {
      if($value)
      {
        $this->data = array_merge($this->data,$data) ;
      }
      else
      {
        $this->data[] = $data;
      }
    }
    else
    {
      return false;
    }

  } // end public function addData */

  /**
   * request the existing tables
   *
   * @return array
   */
  public function getData( )
  {
    return $this->data;
  } // end public function getData  */

  /**
   * @param string $linkTarget
   * @return void
   */
  public function setPagingUrl( $pagingUrl )
  {
    $this->pagingUrl = $pagingUrl;
    $this->pagingId = null;
  }//end public function setLinkTarget  */

  /**
   * @param string $linkTitle
   * @return void
   */
  public function setpagingId(  $pagingId )
  {

    $this->pagingId = $pagingId;
    $this->pagingUrl = null;

  }//end public function setpagingId */


  /**
   * @param int $numOfColors
   */
  public function setNumOfColors( $numOfColors )
  {

    $this->numOfColors = $numOfColors;

  }//end  public function setNumOfColors */

  /**
   *
   * @param $pos
   * @return unknown_type
   */
  public function rowClass( $pos )
  {
    return 'row'.(string)(($pos % $this->numOfColors)+1);
  }//end public function rowClass */

////////////////////////////////////////////////////////////////////////////////
// Parser Method
////////////////////////////////////////////////////////////////////////////////

 /**
   * Loading the tabledata from the database
   *
   * @return void
   */
  public function build( )
  {


    if(!$this->template)
    {
      Error::addError
      (
        'Not Template set in Table Builder'
      );

      return '<p class="wgt-box error" >Error :-(</p>';
    }

    if(!$template = View::getActive()->templatePath( $this->template ) )
    {
      Error::addError
      (
        'Did not found Template : '.$this->template
      );

      return '<p class="wgt-box error" >Error :-(</p>';
    }

    ob_start();
    include $template;
    $this->assembled = ob_get_contents();
    ob_end_clean();

    return $this->assembled;

  } // end public function build */

////////////////////////////////////////////////////////////////////////////////
// Table Navigation
////////////////////////////////////////////////////////////////////////////////

  /**
   * @param string $linkTarget
   * @param string $linkTitle
   * @return void
   *
   */
  public function pagingMenu( $start = null )
  {


    if( $this->tableSize <= $this->stepSize )
    {
      // if no paging needed just return a protected whitespace
      return '&nbsp;';
    }


    if(is_null($start))
    {
      $activPos = $this->start;
    }
    else
    {
      $activPos = $start;
    }


    $activPos = floor($activPos / $this->stepSize);
    $startPos = $activPos - floor( $this->anzMenuNumbers / 2 );

    if( $startPos < 0 )
    {
      $startPos = 0;
    }

    $endPos = $startPos + $this->anzMenuNumbers;

    $last = floor( $this->tableSize / $this->stepSize );

    if( $activPos >  $last )
    {
      $activPos = $last;
    }

    if( $endPos >  $last )
    {
      $endPos = $last + 1;
    }

    $oneVor     = $activPos + 1;
    $oneZurueck = $activPos - 1;

    if( $oneVor > $last )
    {
      $oneVor = $last;
    }

    if( $oneZurueck < $startPos )
    {
      $oneZurueck = $startPos;
    }

    $html = '';

    if( $this->pagingUrl )
    {
      $start = '0';
      $html .= '<a class="ajax" title="Zum ersten Eintrag"
        href="'.$this->pagingUrl.'&amp;start='.$start.'" >
        <img  src="'.View::$iconsWeb.'xsmall/webfrap/back.png"
              style="border:0px"
              alt="Zum ersten Eintrag" />
        </a>&nbsp;&nbsp;';

      $start = (string)($oneZurueck * $this->stepSize);
      $html .= '<a class="ajax" title="'.$this->stepSize.' Einträge zurück"
        href="'.$this->pagingUrl.'&amp;start='.$start.'" >
        <img  src="'.View::$iconsWeb.'xsmall/webfrap/toStart.png"
              style="border:0px"
              alt="'.$this->stepSize.' Einträge zurück" />
        </a>&nbsp;&nbsp;';

      for ( $nam = $startPos; $nam < $endPos ; ++$nam )
      {
        $urlClass = $nam == $activPos ? 'class="wgtLinkActiv"':'';

        $start = (string)($nam * $this->stepSize);
        $html .='<a class="ajax" '.$urlClass.' title="Zeige die '.$nam.'ten '.$this->stepSize
          .' Einträge"'.' href="'.$this->pagingUrl.'&start='.$start.'" >'.$nam.'</a>&nbsp;' ;

        $urlClass ='';
      }

      $html .= '&nbsp;...&nbsp;&nbsp;';

      // Testen ob die Letze Zahl notwendig ist
      $start = (string)($last * $this->stepSize);
      $html .='<a class="ajax" title="Zeige die '.$last.'ten '.$this->stepSize
          .' Einträge"'.' href="'.$this->pagingUrl.'&amp;start='.$start.'" >'.$last.'</a>&nbsp;' ;

      $start = (string)($oneVor * $this->stepSize);
      $html .= '<a class="ajax" title="Die nächsten '.$this->stepSize.' Einträge zeigen"
        href="'.$this->pagingUrl.'&amp;start='.$start.'" >
        <img  src="'.View::$iconsWeb.'xsmall/webfrap/forward.png"
              style="border:0px"
              alt="'.$this->stepSize.' Einträge vorwärts" /></a>&nbsp;&nbsp;';

      $start = (string)($last * $this->stepSize);
      $html .= '<a class="ajax" title="Zum letzen Eintrag"
        href="'.$this->pagingUrl.'&amp;start='.$start.'" >
        <img  src="'.View::$iconsWeb.'xsmall/webfrap/toEnd.png"
              style="border:0px"
              alt="Zum letzen Eintrag" /></a>';
    }//end if( $this->pagingUrl )
    else if( $this->pagingId )
    {

      $start = '0';
      $html .= '<a class="ajax" title="Zum ersten Eintrag"
        href="#" onClick"wgt.ajaxTablePaging( \''.$this->pagingId.'\', \''.$start.'\' );" >
        <img  src="'.View::$iconsWeb.'xsmall/webfrap/back.png"
              style="border:0px"
              alt="Zum ersten Eintrag" />
        </a>&nbsp;&nbsp;';

      $start = (string)($oneZurueck * $this->stepSize);
      $html .= '<a class="ajax" title="'.$this->stepSize.' Einträge zurück"
        href="#" onClick"wgt.ajaxTablePaging( \''.$this->pagingId.'\' , \''.$start.'\' );" >
        <img  src="'.View::$iconsWeb.'xsmall/webfrap/toStart.png"
              style="border:0px"
              alt="'.$this->stepSize.' Einträge zurück" />
        </a>&nbsp;&nbsp;';

      for ( $nam = $startPos; $nam < $endPos ; ++$nam )
      {
        $urlClass = $nam == $activPos ? 'class="wgtLinkActiv"':'';

        $start = (string)($nam * $this->stepSize);
        $html .='<a class="ajax" '.$urlClass.' title="Zeige die '.$nam.'ten '.$this->stepSize
          .' Einträge"'.' href="#" onClick"wgt.ajaxTablePaging( \''.$this->pagingId.'\' , \''.$start.'\' );" >'
          .$nam.'</a>&nbsp;' ;

        $urlClass ='';
      }

      $html .= '&nbsp;...&nbsp;&nbsp;';

      // Testen ob die Letze Zahl notwendig ist
      $start = (string)($last * $this->stepSize);
      $html .='<a class="ajax" title="Zeige die '.$last.'ten '.$this->stepSize
          .' Einträge"'.' href="#" onClick"wgt.ajaxTablePaging( \''.$this->pagingId.'\' , \''.$start.'\' );" >'
          .$last.'</a>&nbsp;' ;

      $start = (string)($oneVor * $this->stepSize);
      $html .= '<a class="ajax" title="Die nächsten '.$this->stepSize.' Einträge zeigen"
        href="#" onClick"wgt.ajaxTablePaging( \''.$this->pagingId.'\' , \''.$start.'\' );" >
        <img  src="'.View::$iconsWeb.'xsmall/webfrap/forward.png"
              style="border:0px"
              alt="'.$this->stepSize.' Einträge vorwärts" /></a>&nbsp;&nbsp;';

      $start = (string)($last * $this->stepSize);
      $html .= '<a class="ajax" title="Zum letzen Eintrag"
        href="#" onClick"wgt.ajaxTablePaging( \''.$this->pagingId.'\' , \''.$start.'\' );" >
        <img  src="'.View::$iconsWeb.'xsmall/webfrap/toEnd.png"
              style="border:0px"
              alt="Zum letzen Eintrag" /></a>';

    }//end else


    return $html;

  } // end public function inTableNavigation( $linkTarget = null, $linkTitle = null )

} // end class WgtTableBuilder

