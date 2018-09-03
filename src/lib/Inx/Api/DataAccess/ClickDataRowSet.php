<?php
/**
 * @package Inxmail
 * @subpackage DataAccess
 */
/**
 * An <i>Inx_Api_DataAccess_ClickDataRowSet</i> is used to access rows of click data resulting from a query.
 * <p>
 * The following data can be retrieved:
 * <ul>
 * <li><i>Click id</i>: the unique identifier of the click.
 * <li><i>Link id</i>: which link was clicked?
 * <li><i>Recipient id</i>: which recipient clicked the link?
 * <li><i>Click date</i>: when did the click occur?
 * <li><i>User agent</i>: which user agent was used by the recipient?
 * <li><i>Remote host</i>: the recipient's host address.
 * <li><i>Recipient data</i>: various data about the recipient (like state or attributes).
 * <li><i>Sending id</i>: which is the associated sending id?
 * <li><i>Sending</i>: which is the associated sending?
 * </ul>
 * The recipient state can be one of the following:
 * <ul>
 * <li>RECIPIENT_STATE_UNKNOWN - if the click is anonymous or no attributes are queried.
 * <li>RECIPIENT_STATE_EXISTENT - if the recipient exists.
 * <li>RECIPIENT_STATE_DELETED - if the recipient was deleted.
 * </ul>
 * For information on how to navigate through an <i>Inx_Api_DataAccess_ClickDataRowSet</i>, see the 
 * <i>Inx_Api_InxRowSet</i> documentation.
 * For information on how to retrieve recipient meta data, see the 
 * <i>Inx_Api_Recipient_ReadOnlyRecipientRowSet</i> documentation.
 * <p>
 * For an example on how to query click data, see the <i>Inx_Api_DataAccess_ClickData</i> documentation.
 * <p>
 * 
 * @see Inx_Api_DataAccess_ClickData
 * @see Inx_Api_DataAccess_DataRowSet
 * @since API 1.4.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage DataAccess
 */
interface Inx_Api_DataAccess_ClickDataRowSet extends Inx_Api_DataAccess_DataRowSet, 
        Inx_Api_Recipient_ReadOnlyRecipientRowSet
{	
	/**
	 * State for missing recipient information. This state will be used when no <i>Inx_Api_Recipient_RecipientContext</i> 
	 * and/or no attributes are specified in the query or in case of an unknown recipient.
	 */
	const RECIPIENT_STATE_UNKNOWN = 0;
	
	/** State for existent recipient. */
	const RECIPIENT_STATE_EXISTENT = 1;
	
	/** State for non existing (deleted) recipient. */
	const RECIPIENT_STATE_DELETED = 2;
	

	/**
	 * Returns the unique identifier for the current click.
	 * 
	 * @return int the id of the current click.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	public function getClickId();
	
	
	/**
	 * Returns the timestamp (date) when the current click occurred.
	 * 
	 * @return string the timestamp (date) of the current click. The date will be returned as ISO 8601 formatted date string.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	public function getClickTimestamp();
	
	
	/**
	 * Returns the remote host which triggered the current click.
	 * 
	 * @return string the remote host of the current click.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	public function getRemoteHost();
	
	/**
	 * Returns the user agent which was used for the current click.
	 * 
	 * @return string the user agent of the current click.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	public function getUserAgent();
	
	
	/**
	 * Returns the id of the link which was clicked.
	 * 
	 * @return int the link id of the current click.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	public function getLinkId();
	
	/**
	 * Returns the id of the recipient who performed the current click.
	 * 
	 * @return int the recipient id of the current click.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	public function getRecipientId();
	
	/**
	 * Returns the state of the recipient who performed the current click.
	 * The possible recipient states are:
	 * <ul>
	 * <li>RECIPIENT_STATE_UNKNOWN - if the click is anonymous or no attributes are queried.
	 * <li>RECIPIENT_STATE_EXISTENT - if the recipient exists.
	 * <li>RECIPIENT_STATE_DELETED - if the recipient was deleted.
	 * </ul>
	 * 
	 * @return int the recipient state.
	 * @throws Inx_Api_DataException if no row is selected (e.g. you forgot to call next()).
	 */
	public function getRecipientState();
        
        /**
	 * Returns the id of the sending associated with this click.
	 * 
	 * @return int the id of the sending associated with this click.
	 * @throws DataException
	 * @since API 1.12.1
	 */
	public function getSendingId();


	/**
	 * Returns the sending of this click. This method causes a server call.
	 * 
	 * @return Inx_Api_Sending_Sending the sending
	 * @throws DataException
	 * @since API 1.12.1
	 */
	public function getSending();
	
	/**
	 * Returns the anonymized hash of the recipient identifier within the sending of the current click.
	 *
	 * @return the tracking hash of the current click.
	 * @throws DataException if no row is selected (e.g. you forgot to call next()).
	 * @since API 1.15.0
	 */
	public function getTrackingHash();
	
}