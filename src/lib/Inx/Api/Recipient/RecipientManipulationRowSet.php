<?php
/**
 * <i>Inx_Api_Recipient_RecipientManipulationRowSet</i> provides a common base for row sets which enable the 
 * manipulation of recipients and their meta data (i.e. attributes).
 * <p>
 * <i>Inx_Api_Recipient_RecipientManipulationRowSet</i> combines the capabilities of 
 * <i>Inx_Api_Recipient_ReadOnlyRecipientRowSet</i> (access to recipient meta data), 
 * <i>Inx_Api_ManipulationRowSet</i> (removal and basic committing / rollback mechanisms) and adds write
 * access to recipient meta data.
 * <p>
 * The following snippet shows how to update the <i>Lastname</i> attribute in the fifth row of the
 * <i>Inx_Api_Recipient_RecipientManipulationRowSet</i> object <i>rrs</i> and then uses the method
 * <i>commitRowUpdate</i> to commit the changed data from which <i>rrs</i> was derived:
 * 
 * <PRE>
 * $oAttribute = $oMetaData->getUserAttribute( 'Lastname' );
 * $oRrs->setRow( 4 ); // moves the cursor to the fifth row of rrs
 * // updates the 'Lastname' attribute of row 4 (fifth row) to be 'Smith'
 * $oRrs->updateString( $oAttribute, 'Smith' );
 * $oRrs->commitRowUpdate(); // updates the row in the data source
 * </PRE>
 * 
 * @author chge, 16.05.2013
 * @since API 1.11.1
 */
interface Inx_Api_Recipient_RecipientManipulationRowSet extends Inx_Api_Recipient_ReadOnlyRecipientRowSet, 
        Inx_Api_ManipulationRowSet
{
	/**
	 * Updates the designated attribute with a <i>Boolean</i> value. The update methods are used to update
	 * attribute values in the current row or the insert row. The update methods do not update the underlying recipient
	 * on the server; instead the <i>commitRowUpdate</i> method has to be called to commit the changes.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the designated attribute.
	 * @param bool value the new attribute value. May be <i>null</i>.
	 * @exception Inx_Api_DataException if the recipient was deleted or no recipient is selected (e.g. you forgot to call
	 *                <i>next()</i>).
	 * @exception Inx_Api_IllegalStateException if the attribute is not of type <i>Boolean</i>.
	 */
	public function updateBoolean( Inx_Api_Recipient_Attribute $attr, $blValue );


	/**
	 * Updates the designated attribute with a <i>Integer</i> value. The update methods are used to update
	 * attribute values in the current row or the insert row. The update methods do not update the underlying recipient
	 * on the server; instead the <i>commitRowUpdate</i> method has to be called to commit the changes.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the designated attribute.
	 * @param int value the new attribute value. May be <i>null</i>.
	 * @exception Inx_Api_DataException if the recipient was deleted or no recipient is selected (e.g. you forgot to call
	 *                <i>next()</i>).
	 * @exception Inx_Api_IllegalStateException if the attribute is not of type <i>Integer</i>.
	 */
	public function updateInteger( Inx_Api_Recipient_Attribute $attr, $iValue );


	/**
	 * Updates the designated attribute with a <i>Double</i> value. The update methods are used to update
	 * attribute values in the current row or the insert row. The update methods do not update the underlying recipient
	 * on the server; instead the <i>commitRowUpdate</i> method has to be called to commit the changes.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the designated attribute.
	 * @param float value the new attribute value. May be <i>null</i>.
	 * @exception Inx_Api_DataException if the recipient was deleted or no recipient is selected (e.g. you forgot to call
	 *                <i>next()</i>).
	 * @exception Inx_Api_IllegalStateException if the attribute is not of type <i>Double</i>.
	 */
	public function updateDouble( Inx_Api_Recipient_Attribute $attr, $fValue );


	/**
	 * Updates the designated attribute with a <i>Date</i> value. The update methods are used to update
	 * attribute values in the current row or the insert row. The update methods do not update the underlying recipient
	 * on the server; instead the <i>commitRowUpdate</i> method has to be called to commit the changes.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the designated attribute.
	 * @param string value the new attribute value. The date has to be passed as ISO-8601 formatted date string. May be 
         *      <i>null</i>.
	 * @exception Inx_Api_DataException if the recipient was deleted or no recipient is selected (e.g. you forgot to call
	 *      <i>next()</i>).
	 * @exception Inx_Api_IllegalStateException if the attribute is not of type <i>Date</i>.
	 */
	public function updateDate( Inx_Api_Recipient_Attribute $attr, $sValue );


	/**
	 * Updates the designated attribute with a <i>Time</i> value. The update methods are used to update
	 * attribute values in the current row or the insert row. The update methods do not update the underlying recipient
	 * on the server; instead the <i>commitRowUpdate</i> method has to be called to commit the changes.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the designated attribute.
	 * @param string value the new attribute value. The time has to be passed as ISO-8601 formatted time string. May be 
         *      <i>null</i>.
	 * @exception Inx_Api_DataException if the recipient was deleted or no recipient is selected (e.g. you forgot to call
	 *      <i>next()</i>).
	 * @exception Inx_Api_IllegalStateException if the attribute is not of type <i>Time</i>.
	 */
	public function updateTime( Inx_Api_Recipient_Attribute $attr, $sValue );


	/**
	 * Updates the designated attribute with a <i>Datetime</i> value. The update methods are used to update
	 * attribute values in the current row or the insert row. The update methods do not update the underlying recipient
	 * on the server; instead the <i>commitRowUpdate</i> method has to be called to commit the changes.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the designated attribute.
	 * @param string value the new attribute value. The datetime has to be passed as ISO-8601 formatted datetime string. 
         *      May be <i>null</i>.
	 * @exception Inx_Api_DataException if the recipient was deleted or no recipient is selected (e.g. you forgot to call
	 *      <i>next()</i>).
	 * @exception Inx_Api_IllegalStateException if the attribute is not of type <i>Datetime</i>.
	 */
	public function updateDatetime( Inx_Api_Recipient_Attribute $attr, $sValue );


	/**
	 * Updates the designated attribute with a <i>string</i> value. The update methods are used to update
	 * attribute values in the current row or the insert row. The update methods do not update the underlying recipient
	 * on the server; instead the <i>commitRowUpdate</i> method has to be called to commit the changes.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the designated attribute.
	 * @param string value the new attribute value. May be <i>null</i>.
	 * @exception Inx_Api_DataException if the recipient was deleted or no recipient is selected (e.g. you forgot to call
	 *                <i>next()</i>).
	 * @exception Inx_Api_IllegalStateException if the attribute is not of type <i>String</i>.
	 */
	public function updateString( Inx_Api_Recipient_Attribute $attr, $sValue );


	/**
	 * Updates the designated attribute with a <i>Object</i> value. The update methods are used to update
	 * attribute values in the current row or the insert row. The update methods do not update the underlying recipient
	 * on the server; instead the <i>commitRowUpdate</i> method has to be called to commit the changes.
	 * 
	 * @param Inx_Api_Recipient_Attribute $attr the designated attribute.
	 * @param mixed value the new attribute value. May be <i>null</i>.
	 * @exception Inx_Api_DataException if the recipient was deleted or no recipient is selected (e.g. you forgot to call
	 *                <i>next()</i>).
	 */
	public function updateObject( Inx_Api_Recipient_Attribute $attr, $oValue );
}