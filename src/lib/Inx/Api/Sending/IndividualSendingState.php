<?php

/**
 * @package Inxmail
 * @subpackage Sending
 */

/**
 * The <i>Inx_Api_Sending_IndividualSendingState</i> enumeration defines the states in which an individual sending -
 * the sending of a personalized mailing to an individual recipient - may transit.
 *
 * @see Inx_Api_Sending_IndividualSendingRowSet::getState()
 * @since API 1.11.1
 * @author chge, 29.04.2013
 */
final class Inx_Api_Sending_IndividualSendingState
{
    private static $NOT_SENT = null; // = 1
    private static $SENT = null; // = 2
    private static $RECIPIENT_NOT_FOUND = null; // = 3
    private static $ERROR = null; // = 4
    private static $ADDRESS_REJECTED = null; // = 5
    private static $HARDBOUNCE = null; // = 6
    private static $SOFTBOUNCE = null; // = 7
    private static $UNKNOWNBOUNCE = null; // = 8
    private static $SPAMBOUNCE = null; // = 9
    private static $MUST_ATTRIBUTE = null; // = 10
    private static $NO_MAIL = null; // = 11
    private static $UNKNOWN = null; // = -1


    /**
     * The NOT_SENT state indicates that the mail has not yet been sent to the recipient.
     *
     * @return Inx_Api_Sending_IndividualSendingState The NOT_SENT state.
     */

    public static final function NOT_SENT()
    {
        if (null === self::$NOT_SENT)
            self::$NOT_SENT = new Inx_Api_Sending_IndividualSendingState(1);

        return self::$NOT_SENT;
    }

    /**
     * The SENT state indicates that the mail has been sent to the recipient.
     *
     * @return Inx_Api_Sending_IndividualSendingState The SENT state.
     */
    public static final function SENT()
    {
        if (null === self::$SENT)
            self::$SENT = new Inx_Api_Sending_IndividualSendingState(2);

        return self::$SENT;
    }

    /**
     * The RECIPIENT_NOT_FOUND state indicates that the recipient has been deleted from the system during the sending
     * process.
     *
     * @return Inx_Api_Sending_IndividualSendingState The RECIPIENT_NOT_FOUND state.
     */
    public static final function RECIPIENT_NOT_FOUND()
    {
        if (null === self::$RECIPIENT_NOT_FOUND)
            self::$RECIPIENT_NOT_FOUND = new Inx_Api_Sending_IndividualSendingState(3);

        return self::$RECIPIENT_NOT_FOUND;
    }

    /**
     * The ERROR state indicates that an error occurred during the sending process.
     *
     * @return Inx_Api_Sending_IndividualSendingState The ERROR state.
     */
    public static final function ERROR()
    {
        if (null === self::$ERROR)
            self::$ERROR = new Inx_Api_Sending_IndividualSendingState(4);

        return self::$ERROR;
    }

    /**
     * The ADDRESS_REJECTED state indicates that the mail server rejected the address of the recipient.
     *
     * @return Inx_Api_Sending_IndividualSendingState The ADDRESS_REJECTED state.
     */
    public static final function ADDRESS_REJECTED()
    {
        if (null === self::$ADDRESS_REJECTED)
            self::$ADDRESS_REJECTED = new Inx_Api_Sending_IndividualSendingState(5);

        return self::$ADDRESS_REJECTED;
    }

    /**
     * The HARDBOUNCE state indicates that the recipient caused a hard bounce. A common reason for a hard bounce is an
     * invalid email address.
     *
     * @return Inx_Api_Sending_IndividualSendingState The HARDBOUNCE state.
     */
    public static final function HARDBOUNCE()
    {
        if (null === self::$HARDBOUNCE)
            self::$HARDBOUNCE = new Inx_Api_Sending_IndividualSendingState(6);

        return self::$HARDBOUNCE;
    }

    /**
     * The SOFTBOUNCE state indicates that the recipient caused a soft bounce. Soft bounces may occur due to temporary
     * problems like exceeded recipient inbox disk quota.
     *
     * @return Inx_Api_Sending_IndividualSendingState The SOFTBOUNCE state.
     */
    public static final function SOFTBOUNCE()
    {
        if (null === self::$SOFTBOUNCE)
            self::$SOFTBOUNCE = new Inx_Api_Sending_IndividualSendingState(7);

        return self::$SOFTBOUNCE;
    }

    /**
     * The UNKNOWNBOUNCE state indicates that the recipient caused a bounce of unknown type.
     *
     * @return Inx_Api_Sending_IndividualSendingState The UNKNOWNBOUNCE state.
     */
    public static final function UNKNOWNBOUNCE()
    {
        if (null === self::$UNKNOWNBOUNCE)
            self::$UNKNOWNBOUNCE = new Inx_Api_Sending_IndividualSendingState(8);

        return self::$UNKNOWNBOUNCE;
    }

    /**
     * The SPAMBOUNCE state indicates that the recipient caused a spam bounce. Perform a quality check of your mailing
     * prior to sending to avoid this kind of bounce.
     *
     * @return Inx_Api_Sending_IndividualSendingState The SPAMBOUNCE state.
     */
    public static final function SPAMBOUNCE()
    {
        if (null === self::$SPAMBOUNCE)
            self::$SPAMBOUNCE = new Inx_Api_Sending_IndividualSendingState(9);

        return self::$SPAMBOUNCE;
    }

    /**
     * The MUST_ATTRIBUTE state indicates that no mail was sent to the recipient due to a [xxx,MUST] condition which the
     * recipient did not satisfy.
     *
     * @return Inx_Api_Sending_IndividualSendingState The MUST_ATTRIBUTE state.
     */
    public static final function MUST_ATTRIBUTE()
    {
        if (null === self::$MUST_ATTRIBUTE)
            self::$MUST_ATTRIBUTE = new Inx_Api_Sending_IndividualSendingState(10);

        return self::$MUST_ATTRIBUTE;
    }

    /**
     * The NO_MAIL state indicates that no mail was sent to the recipient due to a [%no-mail] for the recipient.
     *
     * @return Inx_Api_Sending_IndividualSendingState The NO_MAIL state.
     */
    public static final function NO_MAIL()
    {
        if (null === self::$NO_MAIL)
            self::$NO_MAIL = new Inx_Api_Sending_IndividualSendingState(11);

        return self::$NO_MAIL;
    }

    /**
     * The UNKNOWN state indicates a version mismatch between API and server.
     *
     * @return Inx_Api_Sending_IndividualSendingState The UNKNOWN state.
     */
    public static final function UNKNOWN()
    {
        if (null === self::$UNKNOWN)
            self::$UNKNOWN = new Inx_Api_Sending_IndividualSendingState(-1);

        return self::$UNKNOWN;
    }
    private $id;

    private function __construct($iId)
    {
        $this->id = $iId;
    }

    /**
     * Returns the ID of the <i>IndividualSendingState</i>. The ID is used for transmission purposes and should
     * not be used inside client code.
     *
     * @return int the ID of the <i>IndividualSendingState</i>.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the <i>Inx_Api_Sending_IndividualSendingState</i> corresponding to the given id. If the id is unknown,
     * the <i>UNKNOWN</i> state will be returned. The ID is used for transmission purposes and should not be used
     * inside client code.
     *
     * @param int $iId the ID of the <i>IndividualSendingState</i> to retrieve.
     * @return Inx_Api_Sending_IndividualSendingState the <i>IndividualSendingState</i> corresponding to the given ID.
     */
    public static function byId($iId)
    {
        foreach (self::values() as $state)
        {
            if ($state->getId() === $iId)
                return $state;
        }

        return self::UNKNOWN();
    }

    /**
     * Returns all valid <i>IndividualSendingState</i>s.
     *
     * @return array All valid <i>IndividualSendingState</i>s.
     */
    public static function values()
    {
        return array(self::NOT_SENT(), self::SENT(), self::RECIPIENT_NOT_FOUND(), self::ERROR(),
            self::ADDRESS_REJECTED(), self::HARDBOUNCE(), self::SOFTBOUNCE(), self::UNKNOWNBOUNCE(),
            self::SPAMBOUNCE(), self::MUST_ATTRIBUTE(), self::NO_MAIL(), self::UNKNOWN());
    }
}
