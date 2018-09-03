<?php

/**
 * @package Inxmail
 * @subpackage TriggerMail
 */

/**
 * A <i>Inx_Api_TriggerMail_RenderError</i> object describes the details of an error which occurred during the parsing
 * or building of a trigger mailing. <i>Inx_Api_TriggerMail_RenderError</i> offers the following information:
 * <ul>
 * <li><i>Error type</i>: an internal error code
 * <li><i>Mail part</i>: the internal mail part code
 * <li><i>Begin line / column</i>: the line and column where the malicious token begins
 * <li><i>End line / column</i>: the line and column where the malicious token ends.
 * <li><i>Error messages</i>: the error messages
 * </ul>
 * <p>
 * <i>Inx_Api_TriggerMail_RenderError</i> is mainly used internally but may provide some insight on the error source to
 * API developers. For example, the token position will assist you in identifying syntax errors. The error messages may
 * also be analyzed to identify the error source.
 *
 * @see BuildException#getError()
 * @see ParseException#getError(int)
 * @since API 1.10.0
 * @author chge, 09.07.2012
 * @deprecated As of 1.11.10, Inx_Api_TriggerMail_TriggerMailingRenderer has been replaced with Inx_Api_Rendering_GeneralMailingRenderer
 */
class Inx_Api_TriggerMail_RenderError extends Inx_Api_Rendering_RenderError
{

    /**
     * Creates a <i>Inx_Api_TriggerMail_RenderError</i> with the given details.
     *
     * @param errorType the internal error code.
     * @param mailPart the internal mail part code.
     * @param beginLine the line where the malicious token begins.
     * @param endLine the line where the malicious token ends.
     * @param beginColumn the column where the malicious token begins.
     * @param endColumn the column where the malicious token ends.
     * @param msgArgs the error messages.
     */
    public function __construct($iErrorType, $iMailPart, $iBeginLine, $iEndLine, $iBeginColumn, $iEndColumn, $aMsgArgs)
    {
        parent::__construct($iErrorType, $iMailPart, $iBeginLine, $iEndLine, $iBeginColumn, $iEndColumn, $aMsgArgs);
    }
}
