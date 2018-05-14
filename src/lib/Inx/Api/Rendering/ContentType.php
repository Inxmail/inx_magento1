<?php

/**
 * @package Inxmail
 * @subpackage Rendering
 */

/**
 * The <i>Inx_Api_Rendering_ContentType</i> enumeration defines the format of the content of a mailing.
 *
 * @see Inx_Api_Rendering_GeneralMailingRenderer::build($iRecipientId, $iPreferredContentType)
 * @see Inx_Api_Rendering_Content::getContentType()
 * @since API 1.11.10
 */
final class Inx_Api_Rendering_ContentType
{
    private static $HTML_TEXT = null;
    private static $PLAIN_TEXT = null;
    private static $MULTIPART = null;
    private static $SYSTEM = null;
    private static $UNKNOWN = null;

    /**
     * Content type indicating a HTML content. A mailing with this content type has only a HTML text part.
     *
     * @return Inx_Api_Rendering_ContentType the HTML text content type.
     */
    public static final function HTML_TEXT()
    {
        if (self::$HTML_TEXT === null)
            self::$HTML_TEXT = new Inx_Api_Rendering_ContentType(0);

        return self::$HTML_TEXT;
    }

    /**
     * Content type indicating a plain text content. A mailing with this content type has only a plain text part.
     *
     * @return Inx_Api_Rendering_ContentType the plain text content type.
     */
    public static final function PLAIN_TEXT()
    {
        if (self::$PLAIN_TEXT === null)
            self::$PLAIN_TEXT = new Inx_Api_Rendering_ContentType(1);

        return self::$PLAIN_TEXT;
    }

    /**
     * Content type indicating a multipart content. A mailing with this content type has a HTML and a plain text part.
     *
     * @return Inx_Api_Rendering_ContentType the multipart content type.
     */
    public static final function MULTIPART()
    {
        if (self::$MULTIPART === null)
            self::$MULTIPART = new Inx_Api_Rendering_ContentType(2);

        return self::$MULTIPART;
    }

    /**
     * Unspecified content type that can only be used to build a mailing. In this case, the content type used for
     * building the mailing is the one associated with the mailing in the remote system i.e. the format of the mailing.
     *
     * @return Inx_Api_Rendering_ContentType the default system content type.
     */
    public static final function SYSTEM()
    {
        if (self::$SYSTEM === null)
            self::$SYSTEM = new Inx_Api_Rendering_ContentType(-1);

        return self::$SYSTEM;
    }

    /**
     * Unknown content type, not a legal value for building a mailing.
     *
     * @return Inx_Api_Rendering_ContentType an unknown content type.
     */
    public static final function UNKNOWN()
    {
        if (self::$UNKNOWN === null)
            self::$UNKNOWN = new Inx_Api_Rendering_ContentType(-2);

        return self::$UNKNOWN;
    }
    private $id;

    private function __construct($iId)
    {
        $this->id = $iId;
    }

    /**
     * Returns the ID of the <i>Inx_Api_Rendering_ContentType</i>. The ID is used for transmission purposes and should
     * not be used inside client code.
     *
     * @return int the ID of the <i>Inx_Api_Rendering_ContentType</i>
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the <i>Inx_Api_Rendering_ContentType</i> corresponding to the given <i>id</i>. If the ID is unknown, the
     * <i>UNKNOWN</i> type will be returned. The ID is used for transmission purposes and should not be used
     * inside client code.
     *
     * @param int id the ID of the <i>Inx_Api_Rendering_ContentType</i> to retrieve.
     * @return Inx_Api_Rendering_ContentType the <i>Inx_Api_Rendering_ContentType</i> corresponding to the given ID.
     */
    public static function byId($iId)
    {
        foreach (self::values() as $value)
        {
            if ($value->getId() === $iId)
                return $value;
        }

        return self::UNKNOWN();
    }

    /**
     * Returns an array containing all available <i>Inx_Api_Rendering_ContentType</i>s including UNKNOWN.
     *
     * @return array an array containing all available <i>Inx_Api_Rendering_ContentType</i>s including UNKNOWN.
     */
    public static function values()
    {
        return array(self::HTML_TEXT(), self::PLAIN_TEXT(), self::MULTIPART(), self::SYSTEM(), self::UNKNOWN());
    }
}
