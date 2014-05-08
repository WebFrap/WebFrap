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
 * class LibImageThumbGd
 *
 * @package WebFrap
 * @subpackage tech_core
 */
class LibImageThumbGd extends LibImageThumbAdapter
{

    /**
     * Enter description here...
     */
    public function genThumb()
    {
        $errorpic = View::$themeWeb . "/images/wgt/not_available.png";
        
        if (file_exists($this->origName)) {
            $pic = $this->origName;
        } else {
            $pic = $errorpic;
        }
        
        try {
            $imgdata = getimagesize($pic);
            $org_width = $imgdata[0];
            $org_height = $imgdata[1];
            $type = $imgdata[2];
            
            switch ($type) {
                case 1:
                    {
                        if (! $im = ImageCreateFromGif($pic)) {
                            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
                        }
                        break;
                    } // ENDE CASE
                
                case 2:
                    {
                        if (! $im = ImageCreateFromJPEG($pic)) {
                            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
                        }
                        break;
                    } // ENDE CASE
                
                case 3:
                    {
                        if (! $im = ImageCreateFromPNG($pic)) {
                            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
                        }
                        break;
                    } // ENDE CASE
                      
                // Erstellen eines eigenen Vorschaubilds
                default:
                    {
                        // Standartbild hinkopieren
                        if (! $im = ImageCreateFromJPEG($errorpic)) {
                            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
                        }
                        // Neueinlesen der benötigten Daten
                        $imgdata = getimagesize($errorpic);
                        $org_width = $imgdata[0];
                        $org_height = $imgdata[1];
                    }
            } // ENDE SWITCH
              
            // Errechnen der neuen Größe
            if ($org_width > $org_height) {
                $verhaltnis = $org_width / $org_height;
                $new_width = $this->maxWidth;
                $new_height = round(($new_width / $verhaltnis));
            } else {
                $verhaltnis = $org_height / $org_width;
                $new_height = $this->maxHeight;
                $new_width = round(($new_height / $verhaltnis));
            }
            
            // neugenerieren des THUMBS
            $thumb = imagecreatetruecolor($new_width, $new_height);
            
            imagecopyresampled($thumb, $im, 0, 0, 0, 0, $new_width, $new_height, $org_width, $org_height);
            
            if (! imagejpeg($thumb, $this->thumbName, 95)) {
                throw new LibImage_Exception('Failed to create ' . $this->thumbName);
            }
            
            return true;
        } catch (LibImage_Exception $e) {
            return false;
        }
    } // end public function genThumb
    
    /**
     * @param string $fileName
     * @param string $newName
     * @param int $maxWidth
     * @param int $maxHeight
     * @throws LibImage_Exception
     * @return boolean
     */
    public function resize($newName = null, $maxWidth = null, $maxHeight = null)
    {
        if ($maxWidth) {
            $this->maxWidth = $maxWidth;
        }
        
        if ($maxHeight) {
            $this->maxHeight = $maxHeight;
        }
        
        try {
            
            $imgData = $this->openImage($this->origName);
            
            // Errechnen der neuen Größe
            if ($imgData->width > $imgData->height) {
                
                $relation = $imgData->width / $imgData->height;
                $newWidth = $this->maxWidth;
                $newHeight = round(($newWidth / $relation));
            } else {
                
                $relation = $imgData->height / $imgData->width;
                $newHeight = $this->maxHeight;
                $newWidth = round(($newHeight / $relation));
            }
            
            // neugenerieren des THUMBS
            $thumb = imagecreatetruecolor($newWidth, $newHeight);
            
            imagecopyresampled($thumb, $imgData->res, 0, 0, 0, 0, $newWidth, $newHeight, $imgData->width, $imgData->height);
            
            $path = pathinfo($newName);
            
            if (! file_exists($path['dirname'])) {
                SFilesystem::mkdir($path['dirname'], '0755');
            }
            
            if (! imagejpeg($thumb, $newName, 95)) {
                throw new LibImage_Exception('Failed to create ' . $newName);
            }
            
            return true;
        } catch (LibImage_Exception $e) {
            
            return false;
        }
    } // end public function resize
    
    /**
     *
     * @param string $fileName            
     * @param string $posX            
     * @param string $posY            
     * @param string $width            
     * @param string $height            
     * @param string $newName            
     * @throws LibImage_Exception
     * @return boolean
     */
    public function crop($fileName, $posX = null, $posY = null, $width = null, $height = null, $newName = null)
    {
        if (! $newName)
            $newName = $fileName;
        
        try {
            
            if (! file_exists($fileName)) {
                throw new LibImage_Exception('Versucht ein nichtvorhandenes Bild zu resizen');
            }
            
            $errorpic = '';
            
            $imgdata = getimagesize($fileName);
            $org_width = $imgdata[0];
            $org_height = $imgdata[1];
            $type = $imgdata[2];
            
            switch ($type) {
                case 1:
                    {
                        if (! $im = ImageCreateFromGif($fileName)) {
                            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
                        }
                        break;
                    } // ENDE CASE
                case 2:
                    {
                        if (! $im = ImageCreateFromJPEG($fileName)) {
                            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
                        }
                        break;
                    } // ENDE CASE
                
                case 3:
                    {
                        if (! $im = ImageCreateFromPNG($fileName)) {
                            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
                        }
                        break;
                    } // ENDE CASE
                
                default:
                    {
                        
                        throw new LibImage_Exception('Bild Format nicht unterstüzt');
                    }
            } // ENDE SWITCH
              
            // Errechnen der neuen Größe
            if ($org_width > $org_height) {
                
                $relation = $org_width / $org_height;
                $newWidth = $this->maxWidth;
                $newHeight = round(($newWidth / $relation));
            } else {
                
                $relation = $org_height / $org_width;
                $newHeight = $this->maxHeight;
                $newWidth = round(($newHeight / $relation));
            }
            
            // neugenerieren des THUMBS
            $thumb = imagecreatetruecolor($newWidth, $newHeight);
            
            imagecopyresampled($thumb, $im, 0, 0, 0, 0, $newWidth, $newHeight, $org_width, $org_height);
            
            if (! imagejpeg($thumb, $newName, 95)) {
                throw new LibImage_Exception('Failed to create ' . $newName);
            }
            
            return true;
        } catch (LibImage_Exception $e) {
            
            return false;
        }
    } // end public function crop */
    
    /**
     * Diese Funktion erzeugt ein Bild mit Exakt der angegebenen
     * Breite und Höhe.
     * Ein allfälliger Überhang wird dabei
     * gleichmässig auf beiden Seiten abgeschnitten.
     *
     * @param string $fileName            
     * @param float $width            
     * @param float $height            
     * @param string $newName            
     */
    public function resizeCropOverflow($fileName, $width, $height, $newName = null)
    {
        if (! $newName)
            $newName = $fileName;
        
        $imgData = $this->openImage($fileName);
        
        // Seitenverhältnis neu/alt bestimmen
        $scaleX = (float) $width / $imgData->width;
        $scaleY = (float) $height / $imgData->height;
        
        // Grösseres Seitenverhältnis zählt.
        $scale = max($scaleX, $scaleY);
        
        $dstW = $width;
        $dstH = $height;
        $dstX = $dstY = 0;
        
        // neue grösse berechnen, damit mindestens höhe bzw. breite korrekt ist
        $dstW = (int) ($scale * $imgData->width + 0.5);
        $dstH = (int) ($scale * $imgData->height + 0.5);
        
        // zielposition bestimmen
        $dstX = (int) (0.5 * ($width - $dstW));
        $dstY = (int) (0.5 * ($height - $dstH));
        
        // bild auf neue zielgrösse bestimmen. dabei ist erst eine seite korrekt
        $resizedImg = imagecreatetruecolor($dstW, $dstH);
        imagecopyresampled($resizedImg, $imgData->res, 0, 0, 0, 0, $dstW, $dstH, $imgData->width, $imgData->height);
        
        // prüfen ob abgeschnitten werden muss. falls ja neues bild mit definitiver grösse erstellen und altes verschoben einkopieren.
        if ($dstW != $width || $dstH != $height || $dstX != 0 || $dstY != 0) {
            $croppedImg = imagecreatetruecolor($width, $height);
            imagecopyresampled($croppedImg, $resizedImg, 0, 0, - $dstX, - $dstY, $width, $height, $width, $height);
            $resizedImg = $croppedImg;
        }
        
        $path = pathinfo($newName);
        if (! file_exists($path['dirname'])) {
            Fs::mkdir($path['dirname'], '0755');
        }
        
        if (! imagejpeg($resizedImg, $newName, 95)) {
            throw new LibImage_Exception('Failed to create ' . $newName);
        }
    }

    /**
     *
     * @param string $fileName            
     * @param string $fallbackImg
     *            Bild welches verwendet werden soll wenn sich das Bild mit GD nicht öffnen lässt
     * @return LibImageData
     * @throws LibImage_Exception
     */
    public function openImage($fileName, $fallbackImg = null)
    {
        $imgData = new LibImageData();
        
        $imgData->imagePath = $fileName;
        
        if (! file_exists($fileName)) {
            throw new LibImage_Exception('Versucht ein nicht vorhandene Bild zu öffnen');
        }
        
        $errorpic = '';
        
        $imgdata = getimagesize($fileName);
        $imgData->width = $imgdata[0];
        $imgData->height = $imgdata[1];
        $imgData->type = $imgdata[2];
        
        switch ($imgData->type) {
            case 1:
                {
                    if (! $imgData->res = ImageCreateFromGif($fileName)) {
                        throw new LibImage_Exception("Konnte das Bild nicht erstellen");
                    }
                    break;
                } // ENDE CASE
            
            case 2:
                {
                    if (! $imgData->res = ImageCreateFromJPEG($fileName)) {
                        throw new LibImage_Exception("Konnte das Bild nicht erstellen");
                    }
                    break;
                } // ENDE CASE
            
            case 3:
                {
                    if (! $imgData->res = ImageCreateFromPNG($fileName)) {
                        throw new LibImage_Exception("Konnte das Bild nicht erstellen");
                    }
                    break;
                } // ENDE CASE
                  
            // Erstellen eines eigenen Vorschaubilds
            default:
                {
                    if($fallbackImg){
                        // Standartbild hinkopieren
                        if (! $im = ImageCreateFromJPEG($fallbackImg)) {
                            throw new LibImage_Exception("Konnte das Bild nicht erstellen");
                        }
                        // Neueinlesen der benötigten Daten
                        $imgdata = getimagesize($errorpic);
                        $imgData->width = $imgdata[0];
                        $imgData->height = $imgdata[1];
                        $imgData->type = $imgdata[2];
                    } else {
                        throw new LibImage_Exception("Das Angefragte Bild existiert nicht");
                    }

                }
        } // ENDE SWITCH
        
        return $imgData;
    
    } // end public function openImage
    
}// end class LibImageThumbGd
