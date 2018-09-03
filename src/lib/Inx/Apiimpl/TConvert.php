<?php

class Inx_Apiimpl_TConvert 
{
    
    const DATETIMEFORMAT = "Y-m-d\TH:i:s.uT";
    
    /**
     * Convert a time representing string to {@link DateTime} object
     * 
     * @param String $sString
     * @return DateTime
     */
    public static function stringToDateTime( $sString )
    {
        return DateTime::createFromFormat( self::DATETIMEFORMAT, $sString, new DateTimeZone( "Z" ) );
    }
    
    /**
     * Convert a {@link DateTime} object to string
     * 
     * @param DateTime $oDate
     * @return String
     */
    public static function DateTimeToString( DateTime $oDate )
    {
        return $oDate->format( self::DATETIMEFORMAT );
    }


    public static function stringToTString($sString) {
        if ($sString == null) {
            return null;
        }
        $oRet = new stdClass;
        $oRet->value = (string) $sString;
        return $oRet;
    }
    
    public static function arrBoolToArrTBool($aBool) {
        if ($aBool == null)
            return null;
        $aRet = array();
        foreach($aBool as $blVal) {
            
            $oVal = new stdClass;
            $oVal->value = $blVal;
            $aRet[] = $oVal; 
        }
        return $aRet;
        
    }
    
    public static function TArrToArr($aTArr) {
        $aRet = array();
        if ($aTArr === null) {
            return null;
        }
        foreach($aTArr as $mVal) {
            
            $aRet[] = isset($mVal->value) ? $mVal->value : null;
        }
        return $aRet;
    }
    
    public static function arrToTArr($arr) {
    	//fixes XAPI-54: added null check to return null instead of an empty array
    	if($arr == null)
    	{
    		return null;
    	}
    	
        $aRet = array();
        if (is_array($arr) || ( class_exists( "SplFixedArray" ) && $arr instanceof SplFixedArray ) ) {
            foreach($arr as $val) {
            	if (! is_null($val)) {
    				$oVal = new stdClass();
    				$oVal->value = $val;     		
            	} else {
            		$oVal = null;
            	}
                
                $aRet[] = $oVal;
            }
        }
        return $aRet;
    }
    
    /**
     * Create an array with predefined size.
     * 
     * If class {@link SplFixedArray} exists, an instance will be returned. 
     * {@link SplFixedArray} will provide an object that can handled as an 
     * array but with fixed size. It it not possible to alter the size of 
     * that array. 
     * 
     * @param int $count the size of the array
     * @return array|SplFixedArray
     */
    public static function fixSizeArray( $count )
    {
        if( class_exists( "SplFixedArray" ) )
        {
            return new SplFixedArray( $count );
        }
        else
        {
            return array_fill(0, $count, NULL);
        }
    }
    
    public static function convert($oValue) {
        if (isset($oValue->value))
        	return $oValue->value;
        else return null;
    }
    
    public static function TConvert($sValue) {
    	if ($sValue===null) {
    		return null;
    	}
    	$retObj = new stdClass();
    	$retObj->value = $sValue;
    	
        return $retObj;
    }
}