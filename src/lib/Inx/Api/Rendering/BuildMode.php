<?php

/**
 * @package Inxmail
 * @subpackage Rendering
 */

/**
 * The <i>Inx_Api_Rendering_BuildMode</i> determines how a mailing is built by the
 * <i>Inx_Api_Rendering_GeneralMailingRenderer</i>.
 *
 * @since API 1.11.10
 */
final class Inx_Api_Rendering_BuildMode
{
    private static $NORMAL = null;
    private static $ALTERNATIVEVIEW_ACTIVE = null;
    private static $ALTERNATIVEVIEW_INACTIVE = null;
    private static $PREVIEW = null;
    private static $ARCHIVE = null;
    private static $ALTERNATIVEVIEW_ACTIVE_SIMPLE_LINKS = null;
    private static $NEWSLETTER_SIMPLE_LINKS = null;
    private static $UNKNOWN = null;

    /**
     * Mode for generating a normal mailing, ready to be sent.
     *
     * @return Inx_Api_Rendering_BuildMode the 'normal' build mode.
     */
    public static final function NORMAL()
    {
        if (self::$NORMAL === null)
            self::$NORMAL = new Inx_Api_Rendering_BuildMode(100);

        return self::$NORMAL;
    }

    /**
     * Mode for alternative view. Standard links are fully functional, tracking links are functional but will not
     * trigger any event or generate any click. Embedded images are replaced with http references to image resources on
     * the Inxmail server.
     *
     * @return Inx_Api_Rendering_BuildMode the 'alternative view active' build mode.
     */
    public static final function ALTERNATIVEVIEW_ACTIVE()
    {
        if (self::$ALTERNATIVEVIEW_ACTIVE === null)
            self::$ALTERNATIVEVIEW_ACTIVE = new Inx_Api_Rendering_BuildMode(101);

        return self::$ALTERNATIVEVIEW_ACTIVE;
    }

    /**
     * Mode for mail preview. Standard links are fully functional, tracking links are functional but will not trigger
     * any event or generate any click, unsubscription links will redirect but not unsubscribe anybody. Embedded images
     * are replaced with http references to image resources on the Inxmail server. The function InInboxView() will
     * return true while building the mailing.
     *
     * @return Inx_Api_Rendering_BuildMode the 'alternative view inactive' build mode.
     */
    public static final function ALTERNATIVEVIEW_INACTIVE()
    {
        if (self::$ALTERNATIVEVIEW_INACTIVE === null)
            self::$ALTERNATIVEVIEW_INACTIVE = new Inx_Api_Rendering_BuildMode(104);

        return self::$ALTERNATIVEVIEW_INACTIVE;
    }

    /**
     * Mode for mail preview. Standard links are fully functional, tracking links are functional but will not trigger
     * any event or generate any click, unsubscription links will redirect but not unsubscribe anybody. Embedded images
     * are replaced with http references to image resources on the Inxmail server. The function InInboxView() will
     * return true while building the mailing.
     *
     * @return Inx_Api_Rendering_BuildMode the 'preview' build mode.
     */
    public static final function PREVIEW()
    {
        if (self::$PREVIEW === null)
            self::$PREVIEW = new Inx_Api_Rendering_BuildMode(102);

        return self::$PREVIEW;
    }

    /**
     * Mode for archive view. Standard links are fully functional, tracking links are functional but will not trigger
     * any event or generate any click, unsubscription links will redirect but not unsubscribe anybody. Embedded images
     * are replaced with http references to image resources on the Inxmail server. The function InInboxView() will
     * return true while building the mailing.
     *
     * @return Inx_Api_Rendering_BuildMode the 'archive' build mode.
     */
    public static final function ARCHIVE()
    {
        if (self::$ARCHIVE === null)
            self::$ARCHIVE = new Inx_Api_Rendering_BuildMode(103);

        return self::$ARCHIVE;
    }

    /**
     * Mode for alternative view. All links are fully functional but converted to simple links. Embedded images are
     * replaced with http references to image resources on the Inxmail server.
     *
     * @return Inx_Api_Rendering_BuildMode the 'alternative view active simple links' build mode.
     */
    public static final function ALTERNATIVEVIEW_ACTIVE_SIMPLE_LINKS()
    {
        if (self::$ALTERNATIVEVIEW_ACTIVE_SIMPLE_LINKS === null)
            self::$ALTERNATIVEVIEW_ACTIVE_SIMPLE_LINKS = new Inx_Api_Rendering_BuildMode(105);

        return self::$ALTERNATIVEVIEW_ACTIVE_SIMPLE_LINKS;
    }

    /**
     * All links are fully functional but converted to simple links. Embedded images are replaced with http references
     * to image resources on the Inxmail server. The function InInboxView() will return true while building the mailing.
     *
     * @return Inx_Api_Rendering_BuildMode the 'newsletter simple links' build mode.
     */
    public static final function NEWSLETTER_SIMPLE_LINKS()
    {
        if (self::$NEWSLETTER_SIMPLE_LINKS === null)
            self::$NEWSLETTER_SIMPLE_LINKS = new Inx_Api_Rendering_BuildMode(106);

        return self::$NEWSLETTER_SIMPLE_LINKS;
    }

    /**
     * Constant for an unknown build mode. This mode indicates a version mismatch between API and server.
     *
     * @return Inx_Api_Rendering_BuildMode an unknown build mode.
     */
    public static final function UNKNOWN()
    {
        if (self::$UNKNOWN === null)
            self::$UNKNOWN = new Inx_Api_Rendering_BuildMode(-1);

        return self::$UNKNOWN;
    }
    private $id;

    private function __construct($iId)
    {
        $this->id = $iId;
    }

    /**
     * Returns the ID of the <i>Inx_Api_Rendering_BuildMode</i>. The ID is used for transmission purposes and should
     * not be used inside client code.
     *
     * @return int the ID of the <i>Inx_Api_Rendering_BuildMode</i>.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the <i>Inx_Api_Rendering_BuildMode</i> corresponding to the given ID. If the ID is unknown, the
     * <i>UKNOWN</i> build mode will be returned. The ID is used for transmission purposes and should not be used
     * inside client code.
     *
     * @param int $iId the ID of the <i>Inx_Api_Rendering_BuildMode</i> to retrieve.
     * @return Inx_Api_Rendering_BuildMode the <i>Inx_Api_Rendering_BuildMode</i> corresponding to the given ID.
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
     * Returns an array containing all available <i>Inx_Api_Rendering_BuildMode</i>s including UNKNOWN.
     *
     * @return array an array containing all available <i>Inx_Api_Rendering_BuildMode</i>s including UNKNOWN.
     */
    public static function values()
    {
        return array(self::NORMAL(), self::ALTERNATIVEVIEW_ACTIVE(), self::ALTERNATIVEVIEW_INACTIVE(),
            self::PREVIEW(), self::ARCHIVE(), self::ALTERNATIVEVIEW_ACTIVE_SIMPLE_LINKS(),
            self::NEWSLETTER_SIMPLE_LINKS(), self::UNKNOWN());
    }
}
