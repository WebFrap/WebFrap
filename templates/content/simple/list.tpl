<h2><?php echo $VAR->title?></h2>

<div class="wgtTree">
  <ul>
    <?php foreach( $VAR->exampleList as $position ){ ?>
      <li>  
        <a class="ajax_window" href="window.php?mod=Test&amp;mex=Simpletest&amp;do=<?php echo $position[1]?>">
          <?php echo $position[0] ?>
        </a>
      </li>
    <?php } ?>
  </ul>
</div>