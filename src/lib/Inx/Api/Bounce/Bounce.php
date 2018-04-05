<?php
/**
 * @package Inxmail
 * @subpackage Bounce
 */
/**
 * An <i>Inx_Api_Bounce_Bounce</i> object contains information related to a bounce. 
 * With this object you can access data of the bounced mail as well as the bounce message itself. 
 * For example you can retrieve the id of the recipient, the mailing id or the content of the bounce message.
 * <p>
 * A bounce message or notification is an error message automatically generated by a destination mail server when a mail
 * cannot be delivered. There are two categories of bounces: hard bounces and soft bounces. A hard bounce indicates a
 * permanent delivery problem (e.g. an unknown email address). A soft bounce indicates a temporary delivery problem
 * (e.g. the recipient inbox disk quota is exceeded).
 * <p>
 * Note: The usage of bounces requires the api user right:
 * <i>Inx_Api_UserRights::ERRORMAIL_FEATURE_USE</i>
 * <p>
 * For an example on how to use bounces, see the <i>Inx_Api_Bounce_BounceManager</i> documentation.
 * 
 * @see Inx_Api_Bounce_BounceManager
 * @since API 1.4.3
 * @version $Revision: 9482 $ $Date: 2007-12-18 16:42:11 +0200 (An, 18 Grd 2007) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Bounce
 */
interface Inx_Api_Bounce_Bounce extends Inx_Api_BusinessObject
{
	/** This category represents a hard bounce. A common reason for a hard bounce is an invalid email address. */
	const CATEGORY_HARD_BOUNCE = 0;

	/**
	 * This category represents a soft bounce. Soft bounces may occur due to temporary problems like exceeded recipient
	 * inbox disk quota.
	 */
	const CATEGORY_SOFT_BOUNCE = 1;

	/** This category represents a bounce of unknown type. */
	const CATEGORY_UNKNOWN_BOUNCE = 2;

    /** This category represents a bounce of auto responder type. */
    const CATEGORY_AUTO_RESPONDER_BOUNCE = 3;

    /** This category represents a bounce of spam type. */
    const CATEGORY_SPAM_BOUNCE = 4;

	/**
	 * State for missing recipient information. This state will be used when no <i>RecipientContext</i> and/or no
	 * attributes are specified in the query or in case of an unknown recipient.
	 */
	const RECIPIENT_STATE_UNKNOWN = 0;

	/** State for existent recipient. */
	const RECIPIENT_STATE_EXISTENT = 1;

	/** State for non existing (deleted) recipient. */
	const RECIPIENT_STATE_DELETED = 2;
	
	
	
	/**
	 * Returns the category of this bounce. May be one of:
	 * <ul>
	 * <li>CATEGORY_HARD_BOUNCE
	 * <li>CATEGORY_SOFT_BOUNCE
	 * <li>CATEGORY_UNKNOWN_BOUNCE
	 * </ul>
	 * 
	 * @return int the category of this bounce.
	 */
	public function getCategory();


	/**
	 * Returns the date when the bounce occurred as ISO 8601 formatted date string.
	 * 
	 * @return string the date of the bounce message as ISO 8601 formatted date string.
	 */
	public function getReceptionDate();


	/**
	 * Returns the sender address.
	 * 
	 * @return string the sender address as string.
	 */
	public function getSender();


	/**
	 * Returns the subject of the bounce message.
	 * 
	 * @return string the subject of the bounce message as string.
	 */
	public function getSubject();


	/**
	 * Returns the bounce message content as text.
	 * 
	 * @return string the bounce message content as string.
	 */
	public function getTextContent();


	/**
	 * Returns the recipient id for which the bounce occurred.
	 * 
	 * @return int the recipient id.
	 */
	public function getRecipientId();


	/**
	 * Returns the list id of the list in which the bounce occurred.
	 * 
	 * @return int the list id.
	 */
	public function getListId();


	/**
	 * Returns the id of the bounced mailing.
	 * 
	 * @return int the mailing id.
	 */
	public function getMailingId();


	/**
	 * Returns the id of the bounced sending. Returns null if the sending cannot be determined.
	 * 
	 * @return long|null the sending id.
	 */
	public function getSendingId();

	/**
	 * Returns the header of the bounce message as string.
	 * 
	 * @return string the header of the bounce message as string.
	 */
	public function getHeaders();


	/**
	 * Returns the complete bounce message as mime message stream.
	 * 
	 * @return Inx_Api_InputStream the mime message as input stream.
	 */
	public function getMIMEMessageAsStream();
	
	/**
	 * Returns the matched e-mail address (i.e. the e-mail address of the recipient).
	 * 
	 * @return string the e-mail address.
	 * @since API 1.6.1
	 */
	public function getMatchedEmailAddress();
	
	/**
	 * Returns the state of the recipient for the current bounce.<br>
	 * The possible recipient states are:
	 * <ul>
	 * <li>RECIPIENT_STATE_UNKNOWN - no attributes are queried or recipient is unknown.
	 * <li>RECIPIENT_STATE_EXISTENT - recipient exists.
	 * <li>RECIPIENT_STATE_DELETED - recipient is deleted.
	 * </ul>
	 * 
	 * @return int the recipient state.
	 * @since API 1.6.1
	 */
	public function getRecipientState();


	/**
	 * Returns the integer value for the given recipient Attribute.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the recipient attribute to be retrieved.
	 * @return int the integer value.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>int</i>.
	 * @since API 1.6.1
	 */
	public function getInteger( $attr );


	/**
	 * Returns the string value for the given recipient Attribute.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the recipient attribute to be retrieved.
	 * @return string the string value.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>string</i>.
	 * @since API 1.6.1
	 */
	public function getString( $attr );


	/**
	 * Returns the datetime value for the given recipient Attribute.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the recipient attribute to be retrieved.
	 * @return string the datetime value as ISO 8601 formatted datetime string.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>datetime</i>.
	 * @since API 1.6.1
	 */
	public function getDatetime( $attr );


	/**
	 * Returns the date value for the given recipient Attribute.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the recipient attribute to be retrieved.
	 * @return string the date value as ISO 8601 formatted date string.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>date</i>.
	 * @since API 1.6.1
	 */
	public function getDate( $attr );


	/**
	 * Returns the time value for the given recipient Attribute.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the recipient attribute to be retrieved.
	 * @return string the time value as ISO 8601 formatted time string.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>time</i>.
	 * @since API 1.6.1
	 */
	public function getTime( $attr );


	/**
	 * Returns the Double value for the given recipient Attribute.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the recipient attribute to be retrieved.
	 * @return double the Double value.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>double</i>.
	 * @since API 1.6.1
	 */
	public function getDouble( $attr );


	/**
	 * Returns the Boolean value for the given recipient Attribute.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the recipient attribute to be retrieved.
	 * @return bool the Boolean value.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @throws Inx_Api_IllegalStateException if the requested attribute is not of type <i>bool</i>.
	 * @since API 1.6.1
	 */
	public function getBoolean( $attr );


	/**
	 * Returns the Object value for the given recipient Attribute.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the recipient attribute to be retrieved.
	 * @return mixed the value.
	 * @throws Inx_Api_IllegalArgumentException if the requested attribute was not fetched.
	 * @since API 1.6.1
	 */
	public function getObject( $attr );

	
}
