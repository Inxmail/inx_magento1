<?php

/**
 * @package Inxmail
 * @subpackage TriggerMail
 */

/**
 * An <i>Inx_Api_TriggerMail_BuildException</i> is thrown when the building of a trigger mailing fails. This may be due
 * to an illegal recipient address or a general building failure. For a deeper insight on the error, consult the
 * <i>Inx_Api_TriggerMail_RenderError</i> associated with the exception.
 *
 * @see com.inxmail.xpro.api.triggermail.RenderError
 * @see com.inxmail.xpro.api.triggermail.TriggerMailingRenderer#build(int)
 * @see com.inxmail.xpro.api.triggermail.TriggerMailingRenderer#build(int, int)
 * @since API 1.10.0
 * @author chge, 09.07.2012
 * @deprecated As of 1.11.10, Inx_Api_TriggerMail_TriggerMailingRenderer has been replaced with Inx_Api_Rendering_GeneralMailingRenderer
 */
class Inx_Api_TriggerMail_BuildException extends Inx_Api_Rendering_BuildException
{
    /** Contains detail information about the error. */
    protected $error;

    /**
     * Creates an <i>Inx_Api_TriggerMail_BuildException</i> with the given recipient address and render error.
     *
     * @param emailAddress the email address of the recipient for which the trigger mailing was built.
     * @param error contains detail information about the error.
     */
    public function __construct($sEmailAddress, Inx_Api_TriggerMail_RenderError $error)
    {
        parent::__construct($sEmailAddress, $error);
        $this->error = $error;
    }

    /**
     * Returns detail information about the error.
     *
     * @return detail information about the error.
     */
    public function getError()
    {
        return $this->error;
    }
}
