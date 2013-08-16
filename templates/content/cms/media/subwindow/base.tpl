<?php

$iconDelete = $this->icon( 'control/delete.png', 'xsmall', 'Delete' );
$iconEdit = $this->icon( 'control/edit.png', 'xsmall', 'Edit' );

$iconUploadImg = $this->icon( 'cms/upload_image.png', 'xsmall', 'Upload Image' );

?>

<div class="window_body" >

<style type="text/css" >

.wgt-mediathek{
  position:absolute;
}

.wgt-mediathek h2.head,
.wgt-mediathek h3.head
{
  width:120px;
  float:left;
  text-align:left;
}

</style>

<?php

$key = 'thek1';
$editorId = 'wgt-wysiwyg-cms';

$images = array
(
  array
  (
    'src' => '../files/images/thumb_small.jpg',
    'name' => 'fubar.jpg',
    'type' => 'Portrait',
    'title' => 'Hans',
    'label' => 'Wurst',
    'author' => 'Ollum',
    'created' => '2012-12-12 13:01:23',
    'licence' => 'Commons',
    'description' => 'jaja soso jaja, mhm...',
    'dimensions' => array
    (
      '100x200' => array( 'small', '../files/images/thumb_small.jpg' ),
      '1000x2000' => array( 'original', '../files/images/thumb_small.jpg' ),
    )
  ),
  array
  (
    'src' => '../files/images/thumb_small.jpg',
    'name' => 'fubar.jpg',
    'type' => 'Portrait',
    'title' => 'Hans',
    'label' => 'Wurst',
    'author' => 'Ollum',
    'created' => '2012-12-12 13:01:23',
    'licence' => 'Commons',
    'description' => 'jaja soso jaja, mhm...',
    'dimensions' => array
    (
      '100x200' => array( 'small', '../files/images/thumb_small.jpg' ),
      '1000x2000' => array( 'original', '../files/images/thumb_small.jpg' ),
    )
  ),
  array
  (
    'src' => '../files/images/thumb_small.jpg',
    'name' => 'fubar.jpg',
    'type' => 'Portrait',
    'title' => 'Hans',
    'label' => 'Wurst',
    'author' => 'Ollum',
    'created' => '2012-12-12 13:01:23',
    'licence' => 'Commons',
    'description' => 'jaja soso jaja, mhm...',
    'dimensions' => array
    (
      '100x200' => array( 'small', '../files/images/thumb_small.jpg' ),
      '1000x2000' => array( 'original', '../files/images/thumb_small.jpg' ),
    )
  ),
);

?>

  <!-- Tab Details -->
  <div  class="window_tab"
    id="<?php echo $this->id?>_tab_images"
    title="Images (1)"  >

    <div class="wgt-panel title" >
      <h3 class="head" >Images</h3>
      <div class="inline" >

        <button
          class="wcm wcm_ui_dropform wgt-button"
          id="wgt-dropform-upload-image-<?php echo $key; ?>" ><?php echo $iconUploadImg; ?> Upload Image</button>

          <div class="wgt-dropform-upload-image-<?php echo $key; ?> hidden"  >

            <div style="width:100%;height:400px;"  >
              <div class="wgt-panel title" >
                <h2>Upload a new Image</h2>
              </div>

                <form
                  method="post"
                  id="wgt-form-image-cms_mediathek-<?php echo $key ?>"
                  action="ajax.php?c=Cms.Mediathek.uploadImage&amp;key=<?php echo $key ?>" ></form>

                <div
                  style="position:absolute;top:70px;left:70px;height:330px; width:330px;border: 1px solid black;"
                  onclick="$S('#wgt-upload-image-cms_mediathek-<?php echo $key ?>').click();" >
                  Klick to upload
                </div>

                <input
                  type="file"
                  name="hans"
                  class="asgd-wgt-form-image-cms_mediathek-<?php echo $key ?>"
                  id="wgt-upload-image-cms_mediathek-<?php echo $key ?>"
                  style="position:absolute;top:70px;left:70px;height:330px; width:330px;opacity: 0.1;"
                  onchange="$R.form('wgt-form-image-cms_mediathek-<?php echo $key ?>');"  />

              <div class="wgt-clear" ></div>
            </div>

          </div>

        </div>
        <div class="bw3 right" >
          <div class="right">
            <span>Search</span>
            <input
              type="text"
              name="free_search"
              id="wgt-inp-search-cms_mediathek-image-<?php echo $key ?>"
              class="wcm wcm_req_search medium wgt-no-save fparam-wgt-form-search-cms_mediathek-<?php echo $key ?>" />
            <button class="wgt-button append" id="wgt-image-search-button">
              <?php echo $iconSearch ?>
            </button>

            <form
              id="wgt-form-search-cms_mediathek-<?php echo $key ?>"
              action="ajax.php?c=Cms.Mediathek.searchImage&amp;key=<?php echo $key ?>"
            ></form>

          </div>
        </div>
      </div>

      <div class="wgt-grid full" id="wgt-grid-mediathek-image-<?php echo $key ?>" >
        <table class="wcm wcm_widget_grid full" id="wgt-grid-mediathek-image-<?php echo $key ?>-table" >
          <thead>
            <tr>
              <th class="pos" style="width:30px;" >Pos</th>
              <th style="width:120px;" >Image</th>
              <th>Description</th>
              <th style="width:120px;" >Author</th>
              <th style="width:60px;" >Nav</th>
            </tr>
          </thead>
          <tbody>

            <?php foreach( $images as $pos => $img ){ ?>
            <tr>
              <td valign="top" class="pos" ><?php echo $pos +1 ?></td>
              <td valign="top"  >
                <img
                  onclick="$S('#<?php echo $editorId ?>').tinymce().execCommand('mceInsertContent',false,'<img src=\'<?php echo $img['src']; ?>\' />');"
                  src="<?php echo $img['src']; ?>"
                  title="<?php echo $img['title']; ?>"
                  alt="<?php echo $img['label']; ?>"  /></td>
              <td valign="top" >
                <span><?php echo $img['name']; ?></span> <span><?php echo $img['type']; ?></span><br />
                <p>
                  <?php echo $img['description']; ?>
                </p>
                <div class="wgt-menu bar" >
                  <ul>
                    <?php
                      $tmp = array();
                      foreach( $img['dimensions'] as $res => $data )
                      {
                        $tmp[] = '<li><a href="#" onclick="$S(\'#'.$editorId.'\').tinymce().execCommand(\'mceInsertContent\',false,\'<img src=\\\''.$data[1].'\\\' />\');"  >'.$data[0].' : '.$res.'</a></li>';
                      }

                      echo implode( '<li> | </li>',$tmp  );
                    ?>
                  </ul>
                </div>
              </td>
              <td valign="top" >
                <?php echo $img['author']; ?><br />
                <?php echo $img['created']; ?><br />
                <?php echo $img['licence']; ?>
              </td>
              <td valign="top" >
                <button
                  class="wgt-button" ><?php echo $iconEdit; ?></button><button
                  class="wgt-button" ><?php echo $iconDelete; ?></button>
              </td>
            </tr>
            <?php } ?>

          </tbody>
        </table>
    </div>

  </div>

  <div  class="window_tab"
    id="<?php echo $this->id?>_tab_videos"
    title="Videos (6)"  >

  Videos

  </div>

  <div  class="window_tab"
    id="<?php echo $this->id?>_tab_documents"
    title="Documents (6)"  >

    Documents

  </div>

</div>

<div class="wgt-clear xsmall">&nbsp;</div>


<!-- Window -->
<div title="Image Editor" style="display:none;" id="wgt-mediathek-<?php echo $key ?>-image-dialog"  >

  <fieldset>
    <div id="wgt-box-input-mediathek-<?php echo $key ?>-image_src-box" class="wgt_box input">
      <label for="wgt-box-wgt-input" class="wgt-label">Src</label>
      <div class="wgt-input medium"><input
        type="text"
        value=""
        class="large"
        id="wgt-box-input-mediathek-<?php echo $key ?>-image_src"
        name="image[src]" /></div>
      <div class="wgt-clear tiny">&nbsp;</div>
    </div>
    <div id="wgt-box-input-mediathek-<?php echo $key ?>-image_title-box" class="wgt_box input">
      <label for="wgt-box-wgt-input" class="wgt-label">Title</label>
      <div class="wgt-input medium"><input
        type="text"
        value=""
        class="large"
        id="wgt-box-input-mediathek-<?php echo $key ?>-image_title"
        name="input[title]" /></div>
      <div class="wgt-clear tiny">&nbsp;</div>
    </div>
    <div id="wgt-box-input-mediathek-<?php echo $key ?>-image_alt-box" class="wgt_box input">
      <label for="wgt-box-wgt-input" class="wgt-label">Alt</label>
      <div class="wgt-input medium"><input
        type="text"
        value=""
        class="large"
        id="wgt-box-input-mediathek-<?php echo $key ?>-image_alt"
        name="input[alt]" /></div>
      <div class="wgt-clear tiny">&nbsp;</div>
    </div>

  </fieldset>

  <fieldset>

    <div id="wgt-box-input-mediathek-<?php echo $key ?>-image_id-box" class="wgt_box input">
      <label for="wgt-box-wgt-input" class="wgt-label">Id</label>
      <div class="wgt-input medium"><input
        type="text"
        value=""
        class="large"
        id="wgt-box-input-mediathek-<?php echo $key ?>-image_id"
        name="input[id]" /></div>
      <div class="wgt-clear tiny">&nbsp;</div>
    </div>

    <div id="wgt-box-input-mediathek-<?php echo $key ?>-image_class-box" class="wgt_box input">
      <label for="wgt-box-wgt-input" class="wgt-label">Class</label>
      <div class="wgt-input medium"><input
        type="text"
        value=""
        class="large"
        id="wgt-box-input-mediathek-<?php echo $key ?>-image_class"
        name="input[class]" /></div>
      <div class="wgt-clear tiny">&nbsp;</div>
    </div>

    <div id="wgt-box-input-mediathek-<?php echo $key ?>-image_style-box" class="wgt_box input" >
      <label for="wgt-box-wgt-input" class="wgt-label" >Style</label>
      <div class="wgt-input medium" ><textarea
        class="large medium-height"
        id="wgt-box-input-mediathek-<?php echo $key ?>-image_style"
        name="input[alt]" ></textarea></div>
      <div class="wgt-clear tiny">&nbsp;</div>
    </div>

  </fieldset>

</div>

