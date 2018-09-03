<?php
/**
 * <i>ReadOnlyRecipientRowSet</i> provides a common base for all row sets with the ability to retrieve recipient
 * meta data (i.e. recipient attributes). Attribute values are retrieved by data type or in a generic way using
 * {@link #getObject(Attribute)}.
 * 
 * @author chge, 16.05.2013
 * @since API 1.11.1
 */
interface Inx_Api_Recipient_ReadOnlyRecipientRowSet extends Inx_Api_InxRowSet
{
	/**
	 * Retrieves the value of the designated attribute in the current row of this row set as a <i>Boolean</i>.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the designated attribute.
	 * @return bool the attribute value as bool. May return <i>null</i>.
	 * @exception Inx_Api_DataException if the recipient was deleted or no recipient is selected (e.g. you forgot
         *       to call <i>next()</i>).
	 * @exception Inx_Api_IllegalStateException if the attribute is not of type <i>Boolean</i>.
	 */
	public function getBoolean( Inx_Api_Recipient_Attribute $attr );


	/**
	 * Retrieves the value of the designated attribute in the current row of this row set as an <i>Integer</i>.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the designated attribute.
	 * @return int the attribute value as int. May return <i>null</i>.
	 * @exception Inx_Api_DataException if the recipient was deleted or no recipient is selected (e.g. you forgot 
         *      to call <i>next()</i>).
	 * @exception Inx_Api_IllegalStateException if the attribute is not of type <i>Integer</i>.
	 */
	public function getInteger( Inx_Api_Recipient_Attribute $attr );


	/**
	 * Retrieves the value of the designated attribute in the current row of this row set as a <i>Double</i>.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the designated attribute.
	 * @return float the attribute value as double. May return <i>null</i>.
	 * @exception Inx_Api_DataException if the recipient was deleted or no recipient is selected (e.g. you forgot 
         *      to call <i>next()</i>).
	 * @exception Inx_Api_IllegalStateException if the attribute is not of type <i>Double</i>.
	 */
	public function getDouble( Inx_Api_Recipient_Attribute $attr );


	/**
	 * Retrieves the value of the designated attribute in the current row of this row set as a <i>Date</i>.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the designated attribute.
	 * @return string the attribute value as Date (ISO-8601 formatted date string). May return <i>null</i>.
	 * @exception Inx_Api_DataException if the recipient was deleted or no recipient is selected (e.g. you forgot 
         *      to call <i>next()</i>).
	 * @exception Inx_Api_IllegalStateException if the attribute is not of type <i>Date</i>.
	 */
	public function getDate( Inx_Api_Recipient_Attribute $attr );


	/**
	 * Retrieves the value of the designated attribute in the current row of this row set as a <i>Time</i>.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the designated attribute.
	 * @return string the attribute value as Time (ISO-8601 formatted time string). May return <i>null</i>.
	 * @exception Inx_Api_DataException if the recipient was deleted or no recipient is selected (e.g. you forgot 
         *      to call <i>next()</i>).
	 * @exception Inx_Api_IllegalStateException if the attribute is not of type <i>Time</i>.
	 */
	public function getTime( Inx_Api_Recipient_Attribute $attr );


	/**
	 * Retrieves the value of the designated attribute in the current row of this row set as a <i>Datetime</i>.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the designated attribute.
	 * @return string the attribute value as Datetime (ISO-8601 formatted datetime string). May return <i>null</i>.
	 * @exception Inx_Api_DataException if the recipient was deleted or no recipient is selected (e.g. you forgot 
         *      to call <i>next()</i>).
	 * @exception Inx_Api_IllegalStateException if the attribute is not of type <i>Datetime</i>.
	 */
	public function getDatetime( Inx_Api_Recipient_Attribute $attr );


	/**
	 * Retrieves the value of the designated attribute in the current row of this row set as a <i>String</i>.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the designated attribute.
	 * @return string the attribute value as string. May return <i>null</i>.
	 * @exception Inx_Api_DataException if the recipient was deleted or no recipient is selected (e.g. you forgot 
         *      to call <i>next()</i>).
	 * @exception Inx_Api_IllegalStateException if the attribute is not of type <i>String</i>.
	 */
	public function getString( Inx_Api_Recipient_Attribute $attr );


	/**
	 * Retrieves the value of the designated attribute in the current row of this row set as an <i>Object</i>.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the designated attribute.
	 * @return mixed the attribute value. May return <i>null</i>.
	 * @exception Inx_Api_DataException if the recipient was deleted or no recipient is selected (e.g. you forgot 
         *      to call <i>next()</i>).
	 */
	public function getObject( Inx_Api_Recipient_Attribute $attr );


	/**
	 * Retrieves the <i>Inx_Api_Recipient_RecipientContext</i> used to fetch the recipient attributes.
	 * 
	 * @return Inx_Api_Recipient_RecipientContext the <i>RecipientContext</i> used to fetch the recipient attributes.
	 */
	public function getContext();


	/**
	 * Retrieves the <i>Inx_Api_Recipient_RecipientMetaData</i> object used to fetch recipient attributes.
	 * 
	 * @return Inx_Api_Recipient_RecipientMetaData the <i>RecipientMetaData</i> object used to fetch recipient attributes.
	 */
	public function getMetaData();
}