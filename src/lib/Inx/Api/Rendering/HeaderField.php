<?php

/**
 * @package Inxmail
 * @subpackage Rendering
 */

/**
 * An <i>Inx_Api_Rendering_HeaderField</i> stores a name/value pair of an email header field.
 *
 * @since API 1.11.10
 */
class Inx_Api_Rendering_HeaderField
{
    private $sName;
    private $sValue;

    /**
     * Creates an <i>Inx_Api_Rendering_HeaderField</i> with the specified name and value.
     *
     * @param string $sName the name of the header field.
     * @param string $sValue the value of the header field.
     */
    public function __construct($sName, $sValue)
    {
        $this->sName = $sName;
        $this->sValue = $sValue;
    }

    /**
     * Returns the name of the header field.
     *
     * @return string the name of the header field.
     */
    public function getName()
    {
        return $this->sName;
    }

    /**
     * Returns the value of the header field.
     *
     * @return string the value of the header field.
     */
    public function getValue()
    {
        return $this->sValue;
    }
}
