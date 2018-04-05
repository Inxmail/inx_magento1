<?php

/**
 * @package Inxmail
 * @subpackage Rendering
 */

/**
 * An <i>Inx_Api_Rendering_ParseException</i> is thrown when the parsing of a mailing fails. The reason for such a
 * failure usually is a syntax error. For a deeper insight on the error, consult the
 * <i>Inx_Api_Rendering_RenderError</i>s associated with the exception.
 *
 * @see Inx_Api_Rendering_RenderError
 * @see Inx_Api_Rendering_GeneralMailingRenderer::parse($iMailingId, $buildMode, $iSendingId)
 * @since API 1.11.10
 */
class Inx_Api_Rendering_ParseException extends Exception
{
    /**
     * @var array Inx_Api_Rendering_RenderError Errors associated with the exception.
     */
    protected $errors;

    /**
     * Creates an <i>Inx_Api_Rendering_ParseException</i> with the given render errors.
     *
     * @param array() of Inx_Api_Rendering_RenderError errors the render errors which occurred during the parsing.
     */
    public function __construct(array $errors)
    {
        parent::__construct('parse encountered ' . sizeof($errors) . ' render errors');
        $this->errors = $errors;
    }

    /**
     * Returns the error with the given index.
     *
     * @param int $iIndex the index of the render error to be returned.
     * @return Inx_Api_Rendering_RenderError the render error with the given index.
     */
    public function getError($iIndex)
    {
        return $this->errors[$iIndex];
    }

    /**
     * Returns the number of render errors associated with this <i>Inx_Api_Rendering_ParseException</i>.
     *
     * @return int the number of render errors.
     */
    public function getErrorCount()
    {
        return sizeof($this->errors);
    }
}
