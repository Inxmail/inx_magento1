<?php

/**
 * @package Inxmail
 * @subpackage TriggerMail
 */

/**
 * The <i>BuildMode</i> determines how a mailing is built by the {@link TriggerMailingRenderer}.
 *
 * @author chge, 02.08.2012
 * @deprecated As of 1.11.10, Inx_Api_TriggerMail_TriggerMailingRenderer has been replaced with Inx_Api_Rendering_GeneralMailingRenderer
 */
final class Inx_Api_TriggerMail_BuildMode
{
    private static $NORMAL = null;
    private static $ALTERNATIVEVIEW_ACTIVE = null;

    /** Mode for generating a normal trigger mailing, ready to be sent. */
    public static final function NORMAL()
    {
        return new Inx_Api_TriggerMail_BuildMode(100);
    }

    /**
     * Mode for alternative view: All links are fully functional. Embedded images are replaced with http references to
     * image resources on the Inxmail server.
     */
    public static final function ALTERNATIVEVIEW_ACTIVE()
    {
        return new Inx_Api_TriggerMail_BuildMode(101);
    }

    /**
     * Mode for alternative view. Standard links are fully functional, tracking links are functional but will not
     * trigger any event or generate any click. Embedded images are replaced with http references to image resources on
     * the Inxmail server.
     */
    public static final function ALTERNATIVEVIEW_INACTIVE()
    {
        return new Inx_Api_TriggerMail_BuildMode(104);
    }

    /**
     * Mode for mail preview. Standard links are fully functional, tracking links are functional but will not trigger
     * any event or generate any click, unsubscription links will redirect but not unsubscribe anybody. Embedded images
     * are replaced with http references to image resources on the Inxmail server. The function InInboxView() will
     * return true while building the mailing.
     */
    public static final function PREVIEW()
    {
        return new Inx_Api_TriggerMail_BuildMode(102);
    }

    /**
     * Mode for archive view. Standard links are fully functional, tracking links are functional but will not trigger
     * any event or generate any click, unsubscription links will redirect but not unsubscribe anybody. Embedded images
     * are replaced with http references to image resources on the Inxmail server. The function InInboxView() will
     * return true while building the mailing.
     */
    public static final function ARCHIVE()
    {
        return new Inx_Api_TriggerMail_BuildMode(103);
    }

    /**
     * Mode for alternative view: All links are fully functional but converted to simple links. Embedded images are
     * replaced with http references to image resources on the Inxmail server.
     */
    public static final function ALTERNATIVEVIEW_ACTIVE_SIMPLE_LINKS()
    {
        return new Inx_Api_TriggerMail_BuildMode(105);
    }

    /**
     * All links are fully functional but converted to simple links. Embedded images are replaced with http references
     * to image resources on the Inxmail server. The function InInboxView() returns true for this call.
     */
    public static final function NEWSLETTER_SIMPLE_LINKS()
    {
        return new Inx_Api_TriggerMail_BuildMode(106);
    }

    /**
     * Constant for an unknown build mode. This mode indicates a version mismatch between API and server.
     */
    public static final function UNKNOWN()
    {
        return new Inx_Api_TriggerMail_BuildMode(-1);
    }
    private $id;

    private function __construct($iId)
    {
        $this->id = $iId;
    }

    /**
     * Returns the ID of the <i>BuildMode</i>. The ID is used for transmission purposes and should not be used
     * inside client code.
     *
     * @return the ID of the <i>BuildMode</i>.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the <i>BuildMode</i> corresponding to the given ID. If the ID is unknown, the <i>UKNOWN</i>
     * build mode will be returned. The ID is used for transmission purposes and should not be used inside client code.
     *
     * @param id the ID of the <i>BuildMode</i> to retrieve.
     * @return the <i>BuildMode</i> corresponding to the given ID.
     */
    public static function byId($iMode)
    {
        foreach (self::values() as $m)
        {
            if ($m->getId() == $iMode)
            {
                return $m;
            }
        }

        return self::UNKNOWN();
    }

    public static function values()
    {
        return array(self::NORMAL(), self::ALTERNATIVEVIEW_ACTIVE(), self::ALTERNATIVEVIEW_INACTIVE(), self::PREVIEW(),
            self::ARCHIVE(), self::ALTERNATIVEVIEW_ACTIVE_SIMPLE_LINKS(), self::NEWSLETTER_SIMPLE_LINKS(),
            self::UNKNOWN());
    }
}
