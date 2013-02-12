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
class LibValidatorBase
{
////////////////////////////////////////////////////////////////////////////////
// Attributes
////////////////////////////////////////////////////////////////////////////////

  /**
   *
   * @var array
   */
  public $raw         = null;
  
  /**
   *
   * @var array
   */
  public $sanitized   = null;

  /**
   * array for saving if a value ist valid or invalid
   *
   * @var array
   */
  public $errors      = array();

  /**
   *
   * @var array
   */
  public $metadata    = array();

  /**
   * list with secific error messages
   * @var array
   */
  public $messages    = array
  (
    'wrong' => '',
    'empty' => '',
    'min'   => '',
    'max'   => '',
  );



  /**
   * @return array
   */
  public function valid( )
  {
    return !(boolean)$this->errors;
  }//end public function valid


  /**
   */
  public function clean()
  {
    
    $this->raw         = null;
    $this->sanitized   = null;
    $this->errors      = array();
    $this->metadata    = array();
    $this->messages    = array
    (
      'wrong' => '',
      'empty' => '',
      'min'   => '',
      'max'   => '',
    );
    
  }//end public function clean */
  
  
  /**
   */
  public function cleanValue()
  {
    
    $this->raw         = null;
    $this->sanitized   = null;
    $this->errors      = array();
    
  }//end public function clean */


////////////////////////////////////////////////////////////////////////////////
// Add Validator
////////////////////////////////////////////////////////////////////////////////


  /**
   * Warning will deliver unfilterd Userinput
   * Only Use this if you really know what you do!!
   * REALY KNOW!!
   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   * @return String
   */
  public function checkRaw( $value, $required = false, $maxSize = null, $minSize = null  )
  {
    
    $this->raw = $value;

    if( $required )
    {
      if( '' == trim($value) )
      {
        $this->errors['emtpy']  = $this->messages['emtpy'];
        return false;
      }
    }
    else
    {
      if( '' == trim($value) )
      {
        $this->sanitized = null;
        return true;
      }
    }
    
    $valid = true;

    if( $maxSize )
    {
      if( strlen($value) > $maxSize )
      {
        $this->errors['max']  = $this->messages['max'];
        $valid = false;
      }
    }

    if( $minSize )
    {
      if( strlen($value) < $minSize )
      {
        $this->errors['min']  = $this->messages['min'];
        $valid = false;
      }
    }
    
    $this->sanitized = $value; 

    return $valid;

  }//end public function checkRaw

  /**
   * 
   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   * @return String
   */
  public function checkBitmask( $value, $required = false, $maxSize = null, $minSize = null  )
  {

    if(!is_array($value) && !is_null($value))
    {
      $this->errors['wrong']  = $this->messages['wrong'];
      return false;
    }

    if( $required && count($value) == 0 )
    {
      $this->errors['empty']  = $this->messages['empty'];
      return false;
    }

    $this->sanitized  = new TBitmask($value);
    return true;

  }//end public function checkBitmask



  /**
   *
   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   * @return String
   */
  public function checkNotags( $value, $required = false, $maxSize = null, $minSize = null  )
  {
    
    $this->raw = $value;

    if( $required )
    {
      if( '' == trim($value) )
      {
        $this->errors['emtpy']  = $this->messages['emtpy'];
        return false;
      }
    }
    else
    {
      if( '' == trim($value) )
      {
        $this->sanitized = null;
        return true;
      }
    }
    
    $valid = true;

    if( $maxSize )
    {
      if( strlen($value) > $maxSize )
      {
        $this->errors['max']  = $this->messages['max'];
        $valid = false;
      }
    }

    if( $minSize )
    {
      if( strlen($value) < $minSize )
      {
        $this->errors['min']  = $this->messages['min'];
        $valid = false;
      }
    }
    
    $this->sanitized = strip_tags($value);

    return $valid;

  }//end public function checkNotags

  /**

   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   */
  public function checkInt( $value, $required = false, $maxSize = null, $minSize = null   )
  {
      
    $this->raw = $value;

    if( $required )
    {
      if( '' == trim($value) )
      {
        $this->errors['emtpy']  = $this->messages['emtpy'];
        return false;
      }
    }
    else
    {
      if( '' == trim($value) )
      {
        $this->sanitized = null;
        return true;
      }
    }
    
    $valid = true;

    if( $maxSize )
    {
      if( strlen($value) > $maxSize )
      {
        $this->errors['max']  = $this->messages['max'];
        $valid = false;
      }
    }

    if( $minSize )
    {
      if( strlen($value) < $minSize )
      {
        $this->errors['min']  = $this->messages['min'];
        $valid = false;
      }
    }

    if( !ctype_digit( $value ) )
    {
      $this->errors['wrong']  = $this->messages['wrong'];
      $valid = false;
    }
    
    $this->sanitized = (int)$value;

    return $valid;


  }//end function checkInt



  /**
   * check if the value is a valid EID  Entity id:
   *
   * must be a int and bigger than 0
   *

   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   */
  public function checkEid( $value, $required = false, $maxSize = null, $minSize = null   )
  {
    
    $this->raw = $value;

    if( $required )
    {
      if( '' == trim($value) )
      {
        $this->errors['emtpy']  = $this->messages['emtpy'];
        return false;
      }
    }
    else
    {
      if( '' == trim($value) )
      {
        $this->sanitized = null;
        return true;
      }
    }
    
    $valid = true;

    if( $maxSize )
    {
      if( strlen($value) > $maxSize )
      {
        $this->errors['max']  = $this->messages['max'];
        $valid = false;
      }
    }

    if( $minSize )
    {
      if( strlen($value) < $minSize )
      {
        $this->errors['min']  = $this->messages['min'];
        $valid = false;
      }
    }

    if( !ctype_digit( $value ) )
    {
      $this->errors['wrong']  = $this->messages['wrong'];
      $valid = false;
    }
    
    $this->sanitized = (int)$value;

    return $valid;


  }//end public function checkEid */

  /**

   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   */
  public function checkNumeric( $value, $required = false, $maxSize = null, $minSize = null   )
  {

    $this->raw = $value;

    if( $required )
    {
      if( '' == trim($value) )
      {
        $this->errors['emtpy']  = $this->messages['emtpy'];
        return false;
      }
    }
    else
    {
      if( '' == trim($value) )
      {
        $this->sanitized = null;
        return true;
      }
    }
    
    $valid = true;

    if( $maxSize )
    {
      if( strlen($value) > $maxSize )
      {
        $this->errors['max']  = $this->messages['max'];
        $valid = false;
      }
    }

    if( $minSize )
    {
      if( strlen($value) < $minSize )
      {
        $this->errors['min']  = $this->messages['min'];
        $valid = false;
      }
    }

    if( !ctype_digit( $value ) )
    {
      $this->errors['wrong']  = $this->messages['wrong'];
      $valid = false;
    }
    
    $formatter = LibFormatterNumeric::getActive();
    $formatter->setNumericLanguage($value);
    $this->sanitized = (float)$formatter->formatToEnglish();
    
    return $valid;

  }//end function checkNumeric */

  /**

   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   */
  public function checkBoolean( $value, $required = false, $maxSize = null, $minSize = null   )
  {
    
    $this->raw = $value;
    
    if( is_null($value) )
    {
      $this->sanitized = false;
    }

    // litle hack for search fields
    /*
    if( $value == '0' )
    {
      $this->data[$key] = '-1';
    }
    else
    {
      $this->data[$key] = $value ? '1':'0';
    }
    */

    $this->sanitized     = $value ? '1':'0';

    return true;

  }//end function checkBoolean

  /**

   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   */
  public function checkText( $value, $required = false, $maxSize = null, $minSize = null   )
  {
    $this->raw = $value;

    if( $required )
    {
      if( '' == trim($value) )
      {
        $this->errors['emtpy']  = $this->messages['emtpy'];
        return false;
      }
    }
    else
    {
      if( '' == trim($value) )
      {
        $this->sanitized = null;
        return true;
      }
    }
    
    $valid = true;

    if( $maxSize )
    {
      if( strlen($value) > $maxSize )
      {
        $this->errors['max']  = $this->messages['max'];
        $valid = false;
      }
    }

    if( $minSize )
    {
      if( strlen($value) < $minSize )
      {
        $this->errors['min']  = $this->messages['min'];
        $valid = false;
      }
    }
    
    $this->sanitized = $value; 
    
    return true;

  }//end function checkText


  /**
   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   */
  public function checkHtml( $value, $required = false, $maxSize = null, $minSize = null   )
  {
    
    $this->raw = $value;

    if( $required )
    {
      if( '' == trim($value) )
      {
        $this->errors['emtpy']  = $this->messages['emtpy'];
        return false;
      }
    }
    else
    {
      if( '' == trim($value) )
      {
        $this->sanitized = null;
        return true;
      }
    }
    
    $valid = true;

    if( $maxSize )
    {
      if( strlen($value) > $maxSize )
      {
        $this->errors['max']  = $this->messages['max'];
        $valid = false;
      }
    }

    if( $minSize )
    {
      if( strlen($value) < $minSize )
      {
        $this->errors['min']  = $this->messages['min'];
        $valid = false;
      }
    }
    
    $this->sanitized = $value; 
    
    return true;

  }//end function checkHtml

  /**

   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   */
  public function checkDate( $value, $required = false, $maxSize = null, $minSize = null   )
  {
    
    $this->raw = $value;

    if( $required )
    {
      if( '' == trim($value) )
      {
        $this->errors['emtpy']  = $this->messages['emtpy'];
        return false;
      }
    }
    else
    {
      if( '' == trim($value) )
      {
        $this->sanitized = null;
        return true;
      }
    }
    
    $valid = true;
    
    /*
    if( $maxSize )
    {
      if( strlen($value) > $maxSize )
      {
        $this->errors['max']  = $this->messages['max'];
        $valid = false;
      }
    }

    if( $minSize )
    {
      if( strlen($value) < $minSize )
      {
        $this->errors['min']  = $this->messages['min'];
        $valid = false;
      }
    }
    */

    $formatter = LibFormatterDate::getActive();

    if( !$formatter->setDateLanguage($value) )
    {
        $this->errors['wrong']  = $this->messages['wrong'];
        return false;
    }

    $this->sanitized = $formatter->formatToEnglish();
    
    return false;

  }//end function checkDate

  /**

   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   */
  public function checkTime( $value, $required = false, $maxSize = null, $minSize = null   )
  {

    $this->raw = $value;

    if( $required )
    {
      if( '' == trim($value) )
      {
        $this->errors['emtpy']  = $this->messages['emtpy'];
        return false;
      }
    }
    else
    {
      if( '' == trim($value) )
      {
        $this->sanitized = null;
        return true;
      }
    }

    $this->sanitized = $value;
    return true;

  }//end function checkTime

  /**

   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   */
  public function checkTimestamp( $value, $required = false, $maxSize = null, $minSize = null   )
  {

    $this->raw = $value;

    if( $required )
    {
      if( '' == trim($value) )
      {
        $this->errors['emtpy']  = $this->messages['emtpy'];
        return false;
      }
    }
    else
    {
      if( '' == trim($value) )
      {
        $this->sanitized = null;
        return true;
      }
    }

    $this->sanitized = $value;
    return true;

  }//end function checkTimestamp

  /**

   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   */
  public function checkUrl( $value, $required = false, $maxSize = null, $minSize = null   )
  {

    $this->raw = $value;

    if( $required )
    {
      if( '' == trim($value) )
      {
        $this->errors['emtpy']  = $this->messages['emtpy'];
        return false;
      }
    }
    else
    {
      if( '' == trim($value) )
      {
        $this->sanitized = null;
        return true;
      }
    }
    
    $valid = true;

    if( $maxSize )
    {
      if( strlen($value) > $maxSize )
      {
        $this->errors['max']  = $this->messages['max'];
        $valid = false;
      }
    }

    // makes sense?
    if( $minSize )
    {
      if( strlen($value) < $minSize )
      {
        $this->errors['min']  = $this->messages['min'];
        $valid = false;
      }
    }

    if( !preg_match( self::VALIDATE_URL ,$value )  )
    {
      $this->errors['wrong']  = $this->messages['wrong'];
      $valid = false;
    }
    
    $this->sanitized = $value;
    
    return $valid;

  }//end function checkUrl

  /**
   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   */
  public function checkEmail( $value, $required = false, $maxSize = null, $minSize = null   )
  {

    $this->raw = $value;

    if( $required )
    {
      if( '' == trim($value) )
      {
        $this->errors['emtpy']  = $this->messages['emtpy'];
        return false;
      }
    }
    else
    {
      if( '' == trim($value) )
      {
        $this->sanitized = null;
        return true;
      }
    }
    
    $valid = true;

    if( $maxSize )
    {
      if( strlen($value) > $maxSize )
      {
        $this->errors['max']  = $this->messages['max'];
        $valid = false;
      }
    }

    // makes sense?
    if( $minSize )
    {
      if( strlen($value) < $minSize )
      {
        $this->errors['min']  = $this->messages['min'];
        $valid = false;
      }
    }

    if( !preg_match( self::VALIDATE_MAIL ,$value )  )
    {
      $this->errors['wrong']  = $this->messages['wrong'];
      $valid = false;
    }
    
    if($valid)
      $this->sanitized = $value;
    
    return $valid;

  }//end function checkEmail

  /**
   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   */
  public function checkUsername( $value, $required = false, $maxSize = null, $minSize = null   )
  {

    $this->raw = $value;

    if( $required )
    {
      if( '' == trim($value) )
      {
        $this->errors['emtpy']  = $this->messages['emtpy'];
        return false;
      }
    }
    else
    {
      if( '' == trim($value) )
      {
        $this->sanitized = null;
        return true;
      }
    }
    
    $valid = true;

    if( $maxSize )
    {
      if( strlen($value) > $maxSize )
      {
        $this->errors['max']  = $this->messages['max'];
        $valid = false;
      }
    }

    // makes sense?
    if( $minSize )
    {
      if( strlen($value) < $minSize )
      {
        $this->errors['min']  = $this->messages['min'];
        $valid = false;
      }
    }

    if($valid)
      $this->sanitized = $value;
    
    return $valid;

  }//end function checkUsername

  /**
   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   */
  public function checkPassword( $value, $required = false, $maxSize = null, $minSize = null   )
  {
    $this->raw = $value;

    if( $required )
    {
      if( '' == trim($value) )
      {
        $this->errors['emtpy']  = $this->messages['emtpy'];
        return false;
      }
    }
    else
    {
      if( '' == trim($value) )
      {
        $this->sanitized = null;
        return true;
      }
    }
    
    $valid = true;

    if( $maxSize )
    {
      if( strlen($value) > $maxSize )
      {
        $this->errors['max']  = $this->messages['max'];
        $valid = false;
      }
    }

    // makes sense?
    if( $minSize )
    {
      if( strlen($value) < $minSize )
      {
        $this->errors['min']  = $this->messages['min'];
        $valid = false;
      }
    }

    if($valid)
      $this->sanitized = SEncrypt::passwordHash($value);
    
    return $valid;

  }//end function checkPassword

  /**
   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   */
  public function checkCname( $value, $required = false, $maxSize = null, $minSize = null   )
  {
    $this->raw = $value;

    if( $required )
    {
      if( '' == trim($value) )
      {
        $this->errors['emtpy']  = $this->messages['emtpy'];
        return false;
      }
    }
    else
    {
      if( '' == trim($value) )
      {
        $this->sanitized = null;
        return true;
      }
    }
    
    $valid = true;

    if( $maxSize )
    {
      if( strlen($value) > $maxSize )
      {
        $this->errors['max']  = $this->messages['max'];
        $valid = false;
      }
    }

    // makes sense?
    if( $minSize )
    {
      if( strlen($value) < $minSize )
      {
        $this->errors['min']  = $this->messages['min'];
        $valid = false;
      }
    }

    // remove all __
    $testVal = str_replace( '_','',$value);

    // musn't start with a number
    if( !ctype_alnum($testVal) )
    {
      $this->errors['wrong']  = $this->messages['wrong'];
      return false;
    }
    
    if($valid)
      $this->sanitized = $testVal;
    
    return $valid;

  }//end function checkCname

  /**
   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   */
  public function checkFilename( $value, $required = false, $maxSize = null, $minSize = null   )
  {
    if( !$required and trim($value) == '' )
    {
      $this->data[$key]   = null;
      $this->invalid[$key]  = false;
      return false;
    }

    // here we just get the filename
    $this->data[$key] = SFiles::getFilename($value);

    if( $required and trim($value) == '' )
    {
      $this->invalid[$key]  = 'emtpy';
      return 'emtpy';
    }

    if( $maxSize )
    {
      if( strlen($value) > $maxSize )
      {
        $this->invalid[$key]  = 'max';
        return 'max';
      }
    }

    if( $minSize )
    {
      if( strlen($value) < $minSize )
      {
        $this->invalid[$key]  = 'min';
        return 'min';
      }
    }

    $this->invalid[$key]  = false;
    return false;

  }//end function checkFilename

  /**
   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   */
  public function checkFullname( $value, $required = false, $maxSize = null, $minSize = null   )
  {

    if( !$required and trim($value) == '' )
    {
      $this->data[$key]   = null;
      $this->invalid[$key]  = false;
      return false;
    }

    //TODO add a correct filter
    $this->data[$key] = $value;

    if( $required and trim($value) == '' )
    {
      $this->invalid[$key]  = 'emtpy';
      return 'emtpy';
    }

    if( $maxSize )
    {
      if( strlen($value) > $maxSize )
      {
        $this->invalid[$key]  = 'max';
        return 'max';
      }
    }

    if( $minSize )
    {
      if( strlen($value) < $minSize )
      {
        $this->invalid[$key]  = 'min';
        return 'min';
      }
    }

    $this->invalid[$key]  = false;
    return false;

  }//end function checkFullname

  /**
   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   */
  public function checkFoldername( $value, $required = false, $maxSize = null, $minSize = null   )
  {

    if( !$required and trim($value) == '' )
    {
      $this->data[$key]   = null;
      $this->invalid[$key]  = false;
      return false;
    }

    $this->data[$key] = SFiles::getPath($value);

    if( $required and trim($value) == '' )
    {
      $this->invalid[$key]  = 'emtpy';
      return 'emtpy';
    }

    if( $maxSize )
    {
      if( strlen($value) > $maxSize )
      {
        $this->invalid[$key]  = 'max';
        return 'max';
      }
    }

    if( $minSize )
    {
      if( strlen($value) < $minSize )
      {
        $this->invalid[$key]  = 'min';
        return 'min';
      }
    }

    $this->invalid[$key]  = false;
    return false;

  }//end function checkFoldername

  /**
   * @param scalar $value
   * @param boolean $required
   * @param int $maxSize
   * @param int $minSize
   */
  public function checkUuid( $value, $required = false, $maxSize = null, $minSize = null   )
  {
    if( !$required and trim($value) == '' )
    {
      $this->data[$key]     = null;
      $this->invalid[$key]  = false;
      return false;
    }

    $this->data[$key] = $value;

    if( $required )
    {
      if( trim($value) == ''  )
      {
        return 'empty';
      }
    }

    if( $maxSize )
    {
      if( strlen( $this->data[$key] ) > $maxSize )
      {
        return 'max';
      }
    }

    if( $minSize )
    {
      if( strlen( $this->data[$key] ) < $minSize )
      {
        return 'min';
      }
    }

    $this->invalid[$key]  = false;
    return false;

  }//end public function checkUuid



} // end class ValidatorBase

