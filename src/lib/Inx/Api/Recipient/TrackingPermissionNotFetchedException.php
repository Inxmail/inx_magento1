<?php
/**
 * An exception thrown to signal that tracking permission attributes have not been fetched and therefore, can not be
 * used.
 *
 * @see Inx_Api_Session::createRecipientContext($blIncludeTrackingPermissions)
 * @see Inx_Api_Recipient_RecipientContext::includesTrackingPermissions()
 * 
 * @since API 16.0.0
 */
class Inx_Api_Recipient_TrackingPermissionNotFetchedException extends Exception
{
    /**
     * Constructs a <i>Inx_Api_Recipient_TrackingPermissionNotFetchedException</i>.
     */
    public function __construct()
    {
        parent::__construct( 'tracking permissions have not been fetched' );
    }
}