<?php echo Wgt::XML_HEAD ?>
<wgt>
  <gui>
    <head>

      <?php
      if( $this->title )
        echo '<title><![CDATA['.$this->title.']]></title>'.NL;

      foreach( $this->fileJs as $script )
        echo '<script action="add" src="'.$script.'" />'.NL;

      foreach( $this->fileStyles as $style )
        echo '<css action="add" src="'.$style.'" />'.NL;

      if( $this->redirectUrl ){
      ?>
        <redirect><?php echo htmlentities($this->redirectUrl)?></redirect>
      <?php } ?>

    </head>
    
    <?php 
    
    if( DEBUG )
    {
      echo "<!--".NL;
      
      $className = get_class( $this );
      $trace = Debug::backtrace();
      
      
      echo <<<HTML
Class: {$className}
Trace: {$trace}

HTML;

      echo "-->".NL;

    }
    
    ?>

    <messages>
      <?php echo $this->buildMessages(); ?>
      <?php echo $this->buildWallmessage(); ?>
    </messages>

    <body>
    
      <htmlArea
        selector="<?php echo htmlentities($this->getPosition())?>"
        action="<?php echo $this->getAction()?>"
        check="<?php echo $this->getCheck()?>"
        not="<?php echo $this->getCheckNot()?'true':'false'; ?>" >
        <![CDATA[<?php echo $this->buildContent();?>]]>
      </htmlArea>

    <?php foreach( $this->area->content as $key => $area ){
      if( is_object($area) ){ ?>
      <htmlArea
        selector="<?php echo htmlentities($area->getPosition())?>"
        action="<?php echo $area->getAction()?>"
        check="<?php echo $area->getCheck()?>"
        not="<?php echo $area->getCheckNot()?'true':'false'; ?>" >
        <![CDATA[<?php echo $area->build();?>]]>
      </htmlArea>
    <?php }else if( is_array($area) ){ ?>
     <htmlArea
        selector="<?php echo htmlentities($key);?>"
        action="<?php echo $area[0];?>"
        check="<?php echo isset($area[2])?$area[2]:'';?>"
        not="<?php echo isset($area[3])?($area[3]?'true':'false'):'false';?>"  >
        <![CDATA[<?php echo $area[1];?>]]>
      </htmlArea>
    <?php }else{
      echo $area;
    }} ?>

    <?php
    /**
     <htmlArea selector="<?php echo $key;?>" action="html" >
      <![CDATA[<?php echo $area;?>]]>
      </htmlArea>
     */
    ?>


    <?php
    foreach( $this->object->content as $item )
    {
      if($item->refresh)
      {
        echo $item->buildAjaxArea();
      }
    }


    if(Webfrap::$numPhpErrors){

      if(Webfrap::$numPhpErrors == 1)
      {
        $errorMsg = 'the last request had one php error';
      }
      else
      {
        $errorMsg = 'the last request had '.Webfrap::$numPhpErrors.' errors';
      }
    ?>
      <htmlArea selector="img#wgt_status_lasterror" action="replace" ><![CDATA[<img title="<?php echo $errorMsg?>" id="wgt_status_lasterror" class="icon small" alt="no errors" src="<?php echo View::$iconsWeb?>small/desktop/error.png"/>]]></htmlArea>
    <?php }else{ ?>
      <htmlArea selector="img#wgt_status_lasterror" action="replace" ><![CDATA[<img title="no errors" id="wgt_status_lasterror" class="icon small" alt="no errors" src="<?php echo View::$iconsWeb?>small/desktop/ok.png"/>]]></htmlArea>
    <?php } ?>

    <?php foreach( $this->winclose as $window ){ echo $window->build(); }?>
    <?php foreach( $this->windows as $window ){ echo $window->build(); }?>

    <?php foreach( $this->tabclose as $tab ){ echo $tab->build(); }?>
    <?php foreach( $this->tabs as $tab ){ echo $tab->build(); }?>

    <?php if( defined('DEBUG_CONSOLE') &&  DEBUG_CONSOLE) { ?>
      <htmlArea selector="div#wgt_debug_console div.content" action="html" ><![CDATA[<?php echo Debug::consoleHtml()?>]]></htmlArea>
    <?php } ?>

    </body>
  </gui>

  <code><![CDATA[<?php echo $this->assembledJsCode; ?>]]></code>
  <data type="<?php echo $this->returnType; ?>" ><![CDATA[<?php echo $this->jsonData; ?>]]></data>

</wgt>