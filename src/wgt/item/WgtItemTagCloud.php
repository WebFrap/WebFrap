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
class WgtItemTagCloud
  extends WgtItemEntityAbstract
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   * the preid of the tag cloud
   *
   * @var string
   */
  public $preId = 'wgtid_tag_cloud';

  /**
   * request just the tags of the user
   *
   * @var boolean
   */
  protected $justUser = false;

  /**
   * Enter description here...
   *
   * @var string
   */
  protected $searchUrl = null;

////////////////////////////////////////////////////////////////////////////////
// Constructor
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// Getter, Setter, Adder, Remover
////////////////////////////////////////////////////////////////////////////////


  /**
   * Enter description here...
   *
   */
  protected function load()
  {

    $where = ' and tag.m_deleted is null ';

    if( !$this->multiLingual )
    {
      $where .= ' and tag.id_lang = '.Controller::activLang();
    }

    if( $this->vid )
    {
      $where .= ' and ref.vid = '.$this->vid;
    }

    if( $this->justUser )
    {
      $where .= ' and ref.m_created = '.$this->vid;
    }

    $sql = 'SELECT
        tag.rowid as tag_id,
        tag.tagname,
        ref.rowid as ref_id,
        entity.rowid  as entity_id
      from chinou_tag tag
        join chinou_tag_reference ref on tag.rowid = ref.id_tag
        join chinou_entity entity on ref.id_entity = entity.rowid
      where entity.name = \''.$this->entity.'\' '.$where.'
      order by tag.tagname ';



  }//end protected function load()


  /**
   * public function build the tabs
   * @return string
   */
  public function build( )
  {
    if(Log::$levelDebug)
      Log::start( __file__ , __line__ ,__method__ );

    try
    {
      $this->load();
    }
    catch( LibDb_Exception $e )
    {
      return I18n::s('wbf.error.failedToLoadData');
    }

    $html = '<div id="'.$this->preId.'" class="wgtTagCloud" >'.NL;
    $html .= $this->buildJsCode();
    $html .= $this->buildForm( );
    $html .= $this->buildCloud( );
    $html .= '</div>';

    return $html;

  } // end public function build( )

  /**
   * Enter description here...
   *
   * @param string $pos
   * @return string
   */
  protected function buildCloud(  )
  {

    $html = '<div style="padding:5px;margin-top:10px;border:1px solid grey;width:200px;min-height:50px;" >'.NL;

    foreach( $this->data as $tag )
    {

      $actions = 'onmouseover="obj'.$this->preId.'.showDelete(\''.$tag['ref_id'].'\')"
        onmouseout="obj'.$this->preId.'.hideDelete(\''.$tag['ref_id'].'\')"';

      $buttonDelete = Wgt::icon
      (
        'webfrap/delete.png',
        'xsmall',
        array
        (
        'class'   =>  'hidden',
        'title'   =>  'delete tag',
        'alt'     =>  'delete tag',
        'id'      =>  $this->preId.'_'.$tag['ref_id'].'_tagicon'
        )
      );


      $html .= '<span '.$actions.' class="tag" id="'.$this->preId.'_'.$tag['ref_id'].'_tag">'.
      $tag['tagname'].$buttonDelete.'</span>'.NL.'&nbsp;&nbsp;';
    }

    $html .= '</div>'.NL;

    return $html;


  }//end protected function buildCloud(  )

  /**
   * build the form
   *
   */
  protected function buildForm( )
  {

    $saveUrl = 'index.php?mod=Core&amp;mex=TagReference&amp;do=insert';

    // add
    $buttonAdd = Wgt::icon
    (
      'webfrap/add.png',
      'xsmall',
      array
      (
      'title'   =>  'open form',
      'alt'     =>  'open form',
      'onclick' =>  "wgt.registry.request('$this->preId}').openForm()"
      )
    );
    //\add

    $idEntity   = WgtRndForm::hidden( "chinou_tag_reference[id_entity]" , '{$idEntity}' );
    $idDataset  = WgtRndForm::hidden( "chinou_tag_reference[vid_dataset]" , $this->vid );

    $inpTagname   = Wgt::item('Autocomplete');
    $inpTagname->addAttributes
    (array
    (
    'class' => 'wgtInputSmall',
    'name'  => "chinou_tag[tagname]" ,
    'id'    => $this->preId.'_title',
    ));
    $inpTagname->setLoadParam('ChinouTag','Tagname');

    $butSubmit = WgtRndForm::button
    (
    "add tag",
    array('onclick' =>  "\$REG.request('$this->preId}').addComment()")
    );

    // close
    $buttonClose = WgtRndForm::inputImage
    (
      'abortInsert',
      'webfrap/cancel.png',
      'abort insert',
      array
      (
      'class'   => 'wgtButtonReset',
      'title'   =>  'abort insert',
      'alt'     =>  'abort insert',
      'onclick' =>  "\$REG.request('$this->preId}').closeForm()"
      )
    );
    //\close


    $selLang = Wgt::item( 'CoreLanguage' , 'Selectbox'  );
    $selLang->addAttributes
    (array(
    'name'  => "chinou_tag[id_lang]",
    'class' => 'wgtInputSmall'
    )
    );
    $selLang->setActiv(Controller::activLang());


    $userId = User::getActive()->getId();

    $html = <<<CODE

<div style="width:200px;" >
  <div id="{$this->preId}_opener" style="text-align:left" >{$buttonAdd} add tag</div>

  <div class="hidden" id="{$this->preId}_form" class="wgtForm"  >
    <form method="post" action="{$saveUrl}" class="ajax" >
      {$idEntity}
      {$idDataset}

      <div class="label">Language:</div>
      <div class="data">{$selLang}</div>

      <div class="label">Tag:</div>
      <div class="data">{$inpTagname}</div>

      <div class="submit">{$butSubmit} {$buttonClose}</div>
    </form>
  </div>

</div>


<div class="hidden" id="{$this->preId}_hiddenTemplate" >
<span class="" id="{$this->preId}_{\$refId}_tag">{\$tagName}</span>
</div>


CODE;

    return $html;

  }//end protected function buildForm()

  /**
   * return assembled js code
   *
   * @return string
   */
  protected function buildJsCode()
  {

    $js = <<<CODE
<script type="text/javascript" >
  wgt.registry.register('{$this->preId}',new WgtItemTagcloud( '{$this->preId}' ));
</script>
CODE;

    return $js;

  }//end protected function buildJsCode()

} // end class WgtItemTagCloud


