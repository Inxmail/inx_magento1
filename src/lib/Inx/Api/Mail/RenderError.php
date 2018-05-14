<?php

/**
 * @package Inxmail
 * @subpackage Mail
 */

/**
 * An <i>Inx_Api_Mail_RenderError</i> object describes the details of an error which occurred during the parsing or building of
 * a mailing.
 * <i>Inx_Api_Mail_RenderError</i> offers the following information:
 * <ul>
 * <li><i>Error type</i>: an internal error code
 * <li><i>Mail part</i>: the internal mail part code
 * <li><i>Begin line / column</i>: the line and column where the malicious token begins
 * <li><i>End line / column</i>: the line and column where the malicious token ends.
 * <li><i>Error messages</i>: the error messages
 * </ul>
 * <p>
 * <i>Inx_Api_Mail_RenderError</i> is mainly used internally but may provide some insight on the error source to API developers.
 * For example, the token position will assist you in identifying syntax errors.
 * The error messages may also be analyzed to identify the error source.
 *
 * @see Inx_Api_Mail_BuildException::getError()
 * @see Inx_Api_Mail_ParseException::getError($iIndex)
 * @version $Revision: 9479 $ $Date: 2007-12-18 15:43:23 +0200 (An, 18 Grd 2007) $ $Author: aurimas $
 * @package Inxmail
 * @subpackage Mail
 * @deprecated As of 1.11.10, Inx_Api_Mail_MailingRenderer has been replaced with Inx_Api_Rendering_GeneralMailingRenderer
 */
class Inx_Api_Mail_RenderError extends Inx_Api_Rendering_RenderError
{

    /**
     * Creates an <i>Inx_Api_Mail_RenderError</i> with the given details.
     *
     * @param $iErrorType the internal error code.
     * @param $iMailPart the internal mail part code.
     * @param $iBeginLine the line where the malicious token begins.
     * @param $iEndLine the line where the malicious token ends.
     * @param $iBeginColumn the column where the malicious token begins.
     * @param $iEndColumn the column where the malicious token ends.
     * @param $aMsgArgs the string error messages.
     */
    public function __construct($iErrorType, $iMailPart, $iBeginLine, $iEndLine, $iBeginColumn, $iEndColumn, $aMsgArgs)
    {
        parent::__construct($iErrorType, $iMailPart, $iBeginLine, $iEndLine, $iBeginColumn, $iEndColumn, $aMsgArgs);
    }
}
