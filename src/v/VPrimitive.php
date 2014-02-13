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
 * @subpackage Validator
 *
 */
class VPrimitive extends V_Adaper
{
    
    const INT = 'VPrimitive::isInt';
    
    const SMALLINT = 'VPrimitive::isSmallint';
    
    const BIGINT = 'VPrimitive::isBigint';
    
    const EID = 'VPrimitive::isEid';
    
    const NUMERIC = 'VPrimitive::isNumeric';
    
    const BOOLEAN = 'VPrimitive::isBoolean';
    
    const BOOLEAN3 = 'VPrimitive::isBoolean3';
    
    const TEXT = 'VPrimitive::isText';
    
    
    /**
     * @param scalar $value
     * @param array $constr
     */
    public function isInt($value, array $constr = array()  )
    {
        
        $this->clean();
        $this->origVal = $value;
        
        if (!isset($constr['nn']) and trim($value) == '') {
            $this->safeVal = null;
            return true;
        }
    
        if (!is_numeric($value)) {
            $this->errorKey = 'wrong'
            return false;
        }
        
        $checkVal = (int)$value;
        
    
        if (isset($constr['max'])) {
            if ($checkVal > $constr['max']) {
                $this->errorKey = 'max';
                return false;
            }
        }
    
        if (isset($constr['min'])) {
            if ($checkVal < $constr['min']) {
                $this->errorKey = 'min';
                return false;
            }
        }
    
        $this->safeVal = $checkVal;
    
        return true;
    
    }//end function isInt
    
    /**
     * @param scalar $value
     * @param array $constr
     */
    public function isSmallint($value, array $constr = array()  )
    {
        
        $this->clean();
        $this->origVal = $value;
        
        if (!isset($constr['nn']) and trim($value) == '') {
            $this->safeVal = null;
            return true;
        }
    
        if (!is_numeric($value)) {
            $this->errorKey = 'wrong'
            return false;
        }
        
        $checkVal = (int)$value;
        
    
        if (isset($constr['max'])) {
            if ($checkVal > $constr['max']) {
                $this->errorKey = 'max';
                return false;
            }
        }
    
        if (isset($constr['min'])) {
            if ($checkVal < $constr['min']) {
                $this->errorKey = 'min';
                return false;
            }
        }
    
        $this->safeVal = $checkVal;
    
        return true;
    
    }//end function isInt
    
    /**
     * @param scalar $value
     * @param array $constr
     */
    public function isBigInt($value, array $constr = array())
    {
        
        $this->clean();
        $this->origVal = $value;
        
        if (!isset($constr['nn']) and trim($value) == '') {
            $this->safeVal = null;
            return true;
        }
    
        if (!is_numeric($value)) {
            $this->errorKey = 'wrong'
            return false;
        }
        
        $checkVal = (int)$value;
        
    
        if (isset($constr['max'])) {
            if ($checkVal > $constr['max']) {
                $this->errorKey = 'max';
                return false;
            }
        }
    
        if (isset($constr['min'])) {
            if ($checkVal < $constr['min']) {
                $this->errorKey = 'min';
                return false;
            }
        }
    
        $this->safeVal = $checkVal;
    
        return true;
    
    }//end function isInt
    
    /**
     * check if the value is a valid EID  Entity id:
     * must be a int and bigger than 0
     * 
     * @param scalar $value
     * @param array $constr
     */
    public function isEid($value, array $constr = array())
    {
        $this->clean();
        $this->origVal = $value;
        
        if (!isset($constr['nn']) and trim($value) == '') {
            $this->safeVal = null;
            return true;
        }
    
        if (!ctype_digit($value)) {
            $this->errorKey = 'wrong'
            return false;
        }

        $this->safeVal = (int)$value;
    
        return true;
    
    }//end public function addEid */
    
    /**
     * @param scalar $value
     * @param array $constr
     */
    public function isNumeric($value, array $constr = array())
    {
    
        $this->clean();
        $this->origVal = $value;
        
        if (!isset($constr['nn']) and trim($value) == '') {
            $this->safeVal = null;
            return true;
        }
    
        $formatter = LibFormatterNumeric::getActive();
    
        $val = (float) $formatter->formatToEnglish($value);
    
        if (isset($constr['nn']) {
            if (trim($val) == ''  ) {
                $this->errorKey = 'empty';
                return false;
            }
        }
    
        if (isset($constr['max'])) {
            if ($val > $constr['max']) {
                $this->errorKey = 'max';
                return false;
            }
        }
    
        if (isset($constr['min'])) {
            if ($val < $constr['min']) {
                $this->errorKey = 'min';
                return false;
            }
        }
    
        $this->safeVal = $val;
    
        return true;
    
    }//end function isNumeric */
    
    /**
     * @param scalar $value
     * @param array $constr
     */
    public function isBoolean($value, array $constr = array())
    {
    
        $this->clean();
        $this->origVal = $value;
        
        $value = strtolower(trim($value));
    
        if ('f' == $value  || 'false' == $value || '0' == $value) {
            $value = false; //f
        } elseif ('' == $value) {
            $value = false; // f | false per default
        } else {
            $value = true; // t
        }
    
        $this->safeVal = $value
    
        return true;
    
    }//end function isBoolean */
    
    /**
     * Boolean mit 3 Werten, true,false, null
     * @param scalar $value
     * @param array $constr
     */
    public function isBoolean3($value, array $constr = array())
    {
        $this->clean();
        $this->origVal = $value;
    
        if(is_null($value)){
            $value = null;
        } else {
            $value = strtolower(trim($value));
    
            if ('f' == $value  || 'false' == $value || '0' == $value) {
                $value = false; //f
            } elseif ('' == $value) {
                $value = false; // f | false per default
            } else {
                $value = true; // t
            }
        }

        $this->safeVal = $value
        
        return true;
    
    }//end function isBoolean3 */
    
    /**
     * @param string $key
     * @param scalar $value
     * @param boolean $notNull
     * @param int $maxSize
     * @param int $minSize
     */
    public function isText($value, array $constr = array())
    {
        
        $this->clean();
        $this->origVal = $value;
    
        if (!isset($constr['nn']) and trim($value) == '') {
            $this->safeVal = null;
            return true;
        }
    
        if ($constr['max']) {
            if (mb_strlen($value) > $constr['max']) {
                $this->safeVal = mb_substr(0, $value, $constr['max']);
                $this->errorKey = 'max';
                return false;
            } else {
                $this->safeVal = $value;
            }
        } else {
            $this->safeVal = $value;
        }
    
        if (isset($constr['nn'])) {
            if (trim($value) == '') {
                $this->errorKey = 'empty';
                return false;
            }
        }
    
        if (isset($constr['max'])) {
            if (mb_strlen($value) > $constr['max']) {
                $this->errorKey = 'max';
                return false;
            }
        }
    
        if (isset($constr['min'])) {
            if (mb_strlen($value) < $constr['min']) {
                $this->errorKey = 'min';
                return false;
            }
        }
    
        $this->safeVal = $value;
    
        return true;
    
    }//end function addText

}//end class Validator_Primitive

