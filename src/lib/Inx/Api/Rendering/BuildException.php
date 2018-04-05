<?php

/**
 * @package Inxmail
 * @subpackage Rendering
 */

/**
 * An <i>Inx_Api_Rendering_BuildException</i> is thrown when the building of a mailing fails. This may be due to an
 * illegal recipient address or a general building failure. For a deeper insight on the error, consult the
 * <i>Inx_Api_Rendering_RenderError</i> associated with the exception.
 *
 * @see Inx_Api_Rendering_RenderError
 * @see Inx_Api_Rendering_GeneralMailingRenderer::build($iRecipientId, $preferredMailType)
 * @since API 1.11.10
 */
class Inx_Api_Rendering_BuildException extends Exception
{
    /**
     * @var string The email address of the recipient for which the mailing was built.
     */
    protected $emailAddress;

    /**
     * @var Inx_Api_Rendering_RenderError Error associated with the exception, contains detailed information about its
     * cause.
     */
    protected $error;

    /**
     * Creates an <i>Inx_Api_Rendering_BuildException</i> with the given recipient address and render error.
     *
     * @param string $sEmailAddress the email address of the recipient for which the mailing was built.
     * @param Inx_Api_Rendering_RenderError $error the error associated with the exception.
     */
    public function __construct($sEmailAddress, Inx_Api_Rendering_RenderError $error)
    {
        parent::__construct($sEmailAddress . ' caused render error at line ' . $error->getBeginLine());
        $this->emailAddress = $sEmailAddress;
        $this->error = $error;
    }

    /**
     * Returns the error associated with the exception that contains detailed information about its cause.
     *
     * @return Inx_Api_Rendering_RenderError returns the error associated with the exception.
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Returns the email address of the recipient for which the mailing was built.
     *
     * @return string the email address of the recipient for which the mailing was built.
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }
}
