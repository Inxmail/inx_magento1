<?php

/**
 * @package Inxmail
 * @subpackage Rendering
 */

/**
 * An <i>Inx_Api_Rendering_RenderError</i> object describes the details of an error which occurred during the parsing
 * or building of a mailing. <i>Inx_Api_Rendering_RenderError</i> offers the following information:
 * <ul>
 * <li><i>Error type</i>: an internal error code</li>
 * <li><i>Mail part</i>: the internal mail part code</li>
 * <li><i>Begin line / column</i>: the line and column where the malicious token begins</li>
 * <li><i>End line / column</i>: the line and column where the malicious token ends.</li>
 * <li><i>Error messages</i>: the error messages</li>
 * </ul>
 * <p>
 * <i>Inx_Api_Rendering_RenderError</i> is mainly used internally but may provide some insight on the error source to
 * API developers. For example, the token position will assist you in identifying syntax errors. The error messages may
 * also be analyzed to identify the error source.
 *
 * @see Inx_Api_Rendering_BuildException::getError()
 * @see Inx_Api_Rendering_ParseException::getError($iIndex)
 * @since API 1.11.10
 */
class Inx_Api_Rendering_RenderError
{
    private $errorType;
    private $mailPart;
    private $beginLine;
    private $endLine;
    private $beginColumn;
    private $endColumn;
    private $msgArgs;

    /**
     * Creates an <i>Inx_Api_Rendering_RenderError</i> with the given details.
     *
     * @param int $iErrorType the internal error code.
     * @param int $iMailPart the internal mail part code.
     * @param int $iBeginLine the line where the malicious token begins.
     * @param int $iEndLine the line where the malicious token ends.
     * @param int $iBeginColumn the column where the malicious token begins.
     * @param int $iEndColumn the column where the malicious token ends.
     * @param array() of string $iMsgArgs the error messages.
     */
    public function __construct($iErrorType, $iMailPart, $iBeginLine, $iEndLine, $iBeginColumn, $iEndColumn, $aMsgArgs)
    {
        $this->errorType = $iErrorType;
        $this->mailPart = $iMailPart;
        $this->beginLine = $iBeginLine;
        $this->endLine = $iEndLine;
        $this->beginColumn = $iBeginColumn;
        $this->endColumn = $iEndColumn;
        $this->msgArgs = $aMsgArgs;
    }

    /**
     * Returns the internal error code.
     *
     * @return int the internal error code.
     */
    public function getErrorType()
    {
        return $this->errorType;
    }

    /**
     * Returns the internal mail part code.
     *
     * @return int the internal mail part code.
     */
    public function getMailPart()
    {
        return $this->mailPart;
    }

    /**
     * Returns the line where the malicious token begins.
     *
     * @return int the line where the malicious token begins.
     */
    public function getBeginLine()
    {
        return $this->beginLine;
    }

    /**
     * Returns the line where the malicious token ends.
     *
     * @return int the line where the malicious token ends.
     */
    public function getEndLine()
    {
        return $this->endLine;
    }

    /**
     * Returns the column where the malicious token begins.
     *
     * @return int the column where the malicious token begins.
     */
    public function getBeginColumn()
    {
        return $this->beginColumn;
    }

    /**
     * Returns the column where the malicious token ends.
     *
     * @return int the column where the malicious token ends.
     */
    public function getEndColumn()
    {
        return $this->endColumn;
    }

    /**
     * Returns the error messages.
     *
     * @return array() of string the error messages.
     */
    public function getMsgArgs()
    {
        return $this->msgArgs;
    }
}
