<?php

/**
 * @package Inxmail
 * @subpackage TriggerMail
 */

/**
 * A <i>Inx_Api_TriggerMail_ParseException</i> is thrown when the parsing of a trigger mailing fails. The reason for
 * such a failure usually is a syntax error. For a deeper insight on the error, consult the {@link RenderError}s
 * associated with the exception.
 *
 * @see com.inxmail.xpro.api.triggermail.RenderError
 * @see com.inxmail.xpro.api.triggermail.TriggerMailingRenderer#parse(int, int)
 * @see com.inxmail.xpro.api.triggermail.TriggerMailingRenderer#parse(int, long, int)
 * @since API 1.10.0
 * @author chge, 09.07.2012
 * @deprecated As of 1.11.10, Inx_Api_TriggerMail_TriggerMailingRenderer has been replaced with Inx_Api_Rendering_GeneralMailingRenderer
 */
class Inx_Api_TriggerMail_ParseException extends Inx_Api_Rendering_ParseException
{
    /** Contains detail information about the error. */
    protected $errors;

    /**
     * Creates a <i>Inx_Api_TriggerMail_ParseException</i> with the given render errors.
     *
     * @param errors the render errors which occurred during the parsing.
     */
    public function __construct(array $errors)
    {
        parent::__construct($errors);
        $this->errors = $errors;
    }

    /**
     * Returns detail information about the error by returning the render error with the given index.
     *
     * @param index the index of the render error to be returned.
     * @return the render error with the given index.
     */
    public function getError($iIndex)
    {
        return $this->errors[$iIndex];
    }

    /**
     * Returns the number of render errors associated with this <i>Inx_Api_TriggerMail_ParseException</i>.
     *
     * @return the number of render errors.
     */
    public function getErrorCount()
    {
        return sizeof($this->errors);
    }
}
