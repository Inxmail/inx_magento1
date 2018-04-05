<?php

/**
 * @package Inxmail
 * @subpackage Sending
 */

/**
 * The <i>Inx_Api_Sending_SendingState</i> enumeration defines the states in which a sending may transit.
 *
 * @see Inx_Api_Sending_Sending::getState()
 * @since API 1.11.1
 * @author chge, 29.04.2013
 */
final class Inx_Api_Sending_SendingState
{
    private static $NOT_STARTED = null;
    private static $SENDING = null;
    private static $USER_INTERRUPTED = null;
    private static $CRASHED = null;
    private static $FINISHED = null;
    private static $PREPARED = null;
    private static $UNKNOWN = null;

    /**
     * The NOT_STARTED state is the initial state of a sending, stating that the sending has not yet been started or
     * prepared.
     *
     * @return Inx_Api_Sending_SendingState the NOT_STARTED state.
     */
    public static final function NOT_STARTED()
    {
        if (null === self::$NOT_STARTED)
            self::$NOT_STARTED = new Inx_Api_Sending_SendingState(1);

        return self::$NOT_STARTED;
    }

    /**
     * The SENDING state indicates that the sending is in process.
     *
     * @return Inx_Api_Sending_SendingState the SENDING state.
     */
    public static final function SENDING()
    {
        if (null === self::$SENDING)
            self::$SENDING = new Inx_Api_Sending_SendingState(2);

        return self::$SENDING;
    }

    /**
     * The USER_INTERRUPTED state indicates that the sending process was interrupted by a user.
     *
     * @return Inx_Api_Sending_SendingState the USER_INTERRUPTED state.
     */
    public static final function USER_INTERRUPTED()
    {
        if (null === self::$USER_INTERRUPTED)
            self::$USER_INTERRUPTED = new Inx_Api_Sending_SendingState(3);

        return self::$USER_INTERRUPTED;
    }

    /**
     * The CRASHED state indicates that the sending process crashed and could not be finished.
     *
     * @return Inx_Api_Sending_SendingState the CRASHED state.
     */
    public static final function CRASHED()
    {
        if (null === self::$CRASHED)
            self::$CRASHED = new Inx_Api_Sending_SendingState(4);

        return self::$CRASHED;
    }

    /**
     * The FINISHED state indicates that the sending was successfully completed.
     *
     * @return Inx_Api_Sending_SendingState the FINISHED state.
     */
    public static final function FINISHED()
    {
        if (null === self::$FINISHED)
            self::$FINISHED = new Inx_Api_Sending_SendingState(5);

        return self::$FINISHED;
    }

    /**
     * The PREPARED state indicates that the mailing has been prepared for all recipients and is ready to be sent.
     *
     * @return Inx_Api_Sending_SendingState the PREPARED state.
     */
    public static final function PREPARED()
    {
        if (null === self::$PREPARED)
            self::$PREPARED = new Inx_Api_Sending_SendingState(6);

        return self::$PREPARED;
    }

    /**
     * The UNKNOWN state indicates a version mismatch between API and server.
     *
     * @return Inx_Api_Sending_SendingState the UNKNOWN state.
     */
    public static final function UNKNOWN()
    {
        if (null === self::$UNKNOWN)
            self::$UNKNOWN = new Inx_Api_Sending_SendingState(-1);

        return self::$UNKNOWN;
    }
    private $id;

    private function __construct($iId)
    {
        $this->id = $iId;
    }

    /**
     * Returns the ID of the <i>SendingState</i>. The ID is used for transmission purposes and should not be used
     * inside client code.
     *
     * @return int the ID of the <i>SendingState</i>.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the <i>SendingState</i> corresponding to the given id. If the id is unknown, the
     * <i>UNKNOWN</i> state will be returned. The ID is used for transmission purposes and should not be used
     * inside client code.
     *
     * @param int $iId the ID of the <i>SendingState</i> to retrieve.
     * @return Inx_Api_Sending_SendingState the <i>SendingState</i> corresponding to the given ID.
     */
    public static function byId($iId)
    {
        foreach (self::values() as $state)
        {
            if ($state->getId() == $iId)
                return $state;
        }

        return self::UNKNOWN();
    }

    /**
     * Returns all valid <i>SendingState</i>s.
     *
     * @return array All valid <i>SendingState</i>s.
     */
    public static function values()
    {
        return array(self::NOT_STARTED(), self::SENDING(), self::FINISHED(), self::CRASHED(),
            self::USER_INTERRUPTED(), self::PREPARED(), self::UNKNOWN());
    }
}
