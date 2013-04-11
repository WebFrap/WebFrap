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

try {

  include './conf/bootstrap.php';

  // Buffer Output
  if (BUFFER_OUTPUT)
    ob_start();

  $errors = '';
  $webfrap = Webfrap::init();

  $request  = Request::getInstance();
  $key      = $request->get('f',Validator::CKEY);
  $size     = $request->get('s',Validator::CKEY);

  $tmp = explode('-', $key);

  $id = (int) $tmp[2];

  if ($name = $request->get('n',Validator::TEXT)) {
    $name = base64_decode($name);
  } else {
    $name = $id;
  }

  $fileName = PATH_GW.'data/uploads/'.$tmp[0].'/'.$tmp[1].SParserString::idToPath($id).'/'.$id;

  if (file_exists(PATH_GW.'data/images/missing/'.$tmp[0].'_'.$tmp[1].'.png')) {
    $errorpic = PATH_GW.'data/images/missing/'.$tmp[0].'_'.$tmp[1].'.png';
  } else {
    $errorpic = View::$themeWeb."/images/wgt/not_available.png";
  }

  if (file_exists($fileName)) {
    $pic = $fileName;
  } else {
    $pic = $errorpic;
  }

  if ($size) {
    
    $layouts = array(
      'toosmall' => array(25 , 25),
      'xxsmall' => array(50 , 50),
      'xsmall' => array(75 , 75),
      'small' => array(100 , 100),
      'medium' => array(200 , 200),
      'large' => array(300 , 300),
      'xlarge' => array(400 , 400),
      'xxlarge' => array(500 , 500),
    );

    if (!isset($layouts[$size])) {
      
      $size       = 'medium';
      $maxWidth   = 200;
      $maxHeight  = 200;
      
    } else {
      
      // X / Y
      $maxWidth   = $layouts[$size][0];
      $maxHeight  = $layouts[$size][1];
    }

  } else {
    
    $size       = 'medium';
    $maxWidth   = 200;
    $maxHeight  = 200;
  }

  $thumbFolder = PATH_GW.'data/thumbs/'.$tmp[0].'/'.$tmp[1].SParserString::idToPath($id).'/'.$id.'/';
  $newName     = PATH_GW.'data/thumbs/'.$tmp[0].'/'.$tmp[1].SParserString::idToPath($id).'/'.$id.'/'.$size;
  //$newName = PATH_GW.'tmp/'.Webfrap::uniqid();

  if (!file_exists($newName)) {
    try {
      $imgdata      = getimagesize ($pic);
      $org_width    = $imgdata[0];
      $org_height   = $imgdata[1];
      $type         = $imgdata[2];

      switch ($type) {

        case IMAGETYPE_GIF :{
          if (!$im = ImageCreateFromGif ($pic)) {
            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
          }
          break;
        } // ENDE CASE

        case IMAGETYPE_JPEG :{
          if (!$im = ImageCreateFromJPEG($pic)) {
            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
          }
          break;
        } // ENDE CASE

        case IMAGETYPE_PNG :{
          if (!$im = ImageCreateFromPNG($pic)) {
            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
          }
          break;
        } // ENDE CASE

        // Erstellen eines eigenen Vorschaubilds
        default: {
          // Standartbild hinkopieren
          if (!$im = ImageCreateFromJPEG($errorpic)) {
            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
          }
          // Neueinlesen der benötigten Daten
          $imgdata    = getimagesize ($errorpic);
          $org_width  = $imgdata[0];
          $org_height = $imgdata[1];
        }

      } // ENDE SWITCH

      // Errechnen der neuen Größe
      if ($org_width > $org_height) {
        $verhaltnis = $org_width / $org_height;
        $new_width  = $maxWidth;
        $new_height = round(($new_width / $verhaltnis)  ) ;
      } else {
        $verhaltnis = $org_height / $org_width ;
        $new_height = $maxHeight;
        $new_width = round(($new_height / $verhaltnis)  ) ;
      }

      // neugenerieren des THUMBS
      $thumb = imagecreatetruecolor($new_width, $new_height);

      imagecopyresampled(
        $thumb,
        $im,
        0,0,0,0,
        $new_width,$new_height,$org_width,$org_height
      );

      if (!file_exists($thumbFolder))
        mkdir($thumbFolder, 0777, true);

      if (!imagejpeg($thumb, $newName, 95)) {
        throw new LibImage_Exception('Failed to create '.$this->thumbName);
      }
    } catch (Exception $e) {
      $newName = $errorpic;
    }
  }

  $errors .= ob_get_contents();
  ob_end_clean();

  header('Content-Type: image/jpeg');
  header('Content-Disposition: attachment;filename="'.urlencode($size.'_'.$name).'"');
  header('ETag: '.md5_file($newName));
  header('Content-Length: '.filesize($newName));

  readfile($newName);

} // ENDE TRY
catch(Exception $exception) {
  
  $extType = get_class($exception);

  Error::addError(
    'Uncatched  Exception: '.$extType.' Message:  '.$exception->getMessage() ,
    null,
    $exception
  );

  if (BUFFER_OUTPUT) {
    $errors .= ob_get_contents();
    ob_end_clean();
  }

  if (!DEBUG) {
    
    $view = Webfrap::$env->getView();
    
    if (isset($view) and is_object($view)) {
      $view->publishError($exception->getMessage() , $errors);
    } else {
      View::printErrorPage
      (
        $exception->getMessage(),
        '500',
        $errors
      );
    }
  } else {
    echo $errors;
  }

}