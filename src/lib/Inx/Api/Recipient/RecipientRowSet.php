<?php

/**
 * @package Inxmail
 * @subpackage Recipient
 */
/**
 * An <i>Inx_Api_Recipient_RecipientRowSet</i> is best explained as a table of data representing a set of recipients, 
 * which is usually generated by executing a selection that queries the recipient context.
 * <P>
 * An <i>Inx_Api_Recipient_RecipientRowSet</i> object maintains a cursor pointing to its current row of data. 
 * Initially the cursor is positioned before the first row. 
 * The <i>next()</i> method moves the cursor to the next row (recipient), and because it returns <i>false</i> when 
 * there are no more rows in the <i>Inx_Api_Recipient_RecipientRowSet</i> object, it can be used in a <i>while</i> 
 * loop to iterate through the result set.
 * <p>
 * Be sure to call <i>next()</i> before the first retrieval statement on the row set. 
 * As stated above, initially the cursor is before the first row, thus no data can be retrieved from the row set 
 * before calling <i>next()</i>. 
 * Doing so will trigger an <i>Inx_Api_DataException</i>.
 * <P>
 * The <i>Inx_Api_Recipient_RecipientRowSet</i> interface provides <i>getter</i> methods (<i>getString</i>,
 * <i>getInteger</i>, and so on) for retrieving attribute values from the current row. 
 * Values can be retrieved using the attribute object.
 * <p>
 * The following snippet shows how to retrieve the email address of all recipients in the row set, thus also
 * illustrating how to iterate over an <i>Inx_Api_Recipient_RecipientRowSet</i>:
 * 
 * <pre>
 * $oRecipientContext = $oSession->createRecipientContext();
 * $oAttribute = $oRecipientContext->getMetaData()->getEmailAttribute();
 * $oRecipientRowSet = $oRecipientContext->select();
 * 
 * while( $oRecipientRowSet->next() )
 * {
 * 	echo $oRecipientRowSet->getString( $oAttribute ).&quot;&#60;br&#62;&quot;;
 * }
 * </pre>
 * <P>
 * The update methods may be used in two ways:
 * <ol>
 * <LI>To update a column value in the current row. 
 * In an <i>Inx_Api_Recipient_RecipientRowSet</i> object, the cursor can be moved backwards and forwards, to an absolute position. 
 * The following snippet shows how to update the <i>Lastname</i> attribute in the fifth row of the <i>RecipientRowSet</i> 
 * object <i>rrs</i> and then uses the method <i>commitRowUpdate</i> to commit the changed data from which <i>rrs</i> was derived:
 * 
 * <PRE>
 * $oAttribute = $oRecipientMetaData->getUserAttribute( &quot;Lastname&quot; );
 * $oRecipientRowSet->setRow(4); // moves the cursor to the fifth row of $recipientRowSet
 * // updates the 'Lastname' attribute of row 4 (fifth row) to be 'Smith'
 * $oRecipientRowSet->updateString( $oAttribute, "Smith" ); 
 * $oRecipientRowSet->commitRowUpdate(); // updates the row in the data source
 * </PRE>
 * <LI>To insert attribute values into the insert row. 
 * The <i>Inx_Api_Recipient_RecipientRowSet</i> object has a special row associated with it that serves as a staging area for 
 * building a recipient to be inserted. 
 * The following snippet shows how to move the cursor to the insert row and insert the new recipient data into <i>rrs</i> 
 * and into the data source table using the method <i>commitRowUpdate</i>:
 * 
 * <PRE>
 * $oAttribute_email = $oRecipientMetaData->getEmailAttribute();
 * $oAttribute_attr = $oRecipientMetaData->getUserAttribute( &quot;Lastname&quot; );
 * $oRecipientRowSet->moveToInsertRow(); // moves cursor to the insert row
 * // email attribute of the insert row to be <i>smith@gmx.com</i>
 * $oRecipientRowSet->updateString( $oAttribute_email, &quot;smith@gmx.com&quot;);
 * $oRecipientRowSet->updateString( $oAttribute_attr, &quot;Smith&quot;);
 * $oRecipientRowSet->commitRowUpdate();  // insert the row in the data source
 * </PRE>
 * 
 * The code above will create a new recipient with the address smith@gmx.com and the last name Smith. 
 * Usually creating new recipients is accomplished using an empty <i>Inx_Api_Recipient_RecipientRowSet</i>. 
 * Such a row set can be obtained using the <i>Inx_Api_Recipient_RecipientContext::createRowSet()</i> method. 
 * However, the returned row set can only be used to create recipients, as there are no recipients in the row set.
 * </ol>
 * <p>
 * All row changes except for the <i>remove()</i> and <i>setAttributeValue()</i> methods require a call of
 * <i>commitRowUpdate()</i> to be reflected on the server. 
 * Any uncommitted changes will be lost once the <i>Inx_Api_Recipient_RecipientRowSet</i> is closed. 
 * However, calling <i>commitRowUpdate()</i> on deleted rows will trigger an <i>Inx_Api_DataException</i>, as the 
 * recipient in the current row no longer exists.
 * <p>
 * Note: To safely abandon all changes of the current row, use the <i>rollbackRowUpdate()</i> method. 
 * This will prevent any changes to the current row from being committed through <i>commitRowUpdate()</i>. 
 * Be aware that <i>rollbackRowUpdate</i> will only undo <i>uncommitted</i> changes to the current row. 
 * So, once you called <i>commitRowUpdate()</i> there is &quot;no way back&quot;.
 * <p>
 * <b>Note:</b> An <i>Inx_Api_Recipient_RecipientContext</i> object <b>must</b> be closed once it
 * is not needed anymore to prevent memory leaks and other potentially harmful side effects.
 * <p>
 * For more information about recipients and the operations that can be performed on them, see the
 * <i>Inx_Api_Recipient_RecipientContext</i> documentation.
 * 
 * @see Inx_Api_Recipient_RecipientContext  
 * @since   API 1.0
 * @version $Revision: 9553 $ $Date: 2008-01-04 11:28:41 +0200 (Pn, 04 Sau 2008) $ $Author: vladas $
 * @package Inxmail
 * @subpackage Recipient
 */
interface Inx_Api_Recipient_RecipientRowSet extends Inx_Api_Recipient_RecipientManipulationRowSet, 
    Inx_Api_InsertionRowSet
{    
    /**
     * Sets the specified attribute value to the recipients in the specified selection. 
     * This method does <b>not</b> require a call to <i>commitRowUpdate()</i> to be reflected on the server.
     * The selection parameter may be ommitted to set the attribute value for all recipients in this row set.
	 * 
	 * @param Inx_Api_Recipient_Attribute $oAttr the designated attribute.
	 * @param mixed $oNewValue the new attribute value.
	 * @param Inx_Api_IndexSelection $oSelection the recipient rows to change the value of. May be ommitted.
	 * @return bool <i>true</i> if the attribute was updated, <i>false</i> otherwise.
     */
    public function setAttributeValue( Inx_Api_Recipient_Attribute $oAttr, $mNewValue, Inx_Api_IndexSelection $oSelection=null );
  
    /**
     * Retrieves the recipient id of the current row of this <i>Inx_Api_Recipient_RecipientRowSet</i> object.
     *
     * @return int the recipient id in the current recipient.
     * @throws Inx_Api_DataException if the recipient was deleted or no recipient is selected (e.g. you forgot to call
	 *                <i>next()</i>).
     */
    public function getId();

    /**
     * Retrieves the tracking permission state of the current row of this <i>Inx_Api_Recipient_RecipientRowSet</i> object.
     *
     * @param Inx_Api_List_ListContext $oList the list context of the tracking permission
     * @return Inx_Api_TrackingPermission_TrackingPermissionState the tracking permission state
     * @throws Inx_Api_DataException if the recipient was deleted or no recipient is selected (e.g. you forgot to call
     * <i>next()</i>).
     * @throws Inx_Api_Recipient_AttributeNotFoundException if the list is not a standard list.
     * @throws Inx_Api_Recipient_TrackingPermissionNotFetchedException if the underlying 
     * <i>Inx_Api_Recipient_RecipientContext</i> does not contain tracking permission attributes, see
     * <i>Inx_Api_Recipient_RecipientContext::includesTrackingPermissions()</i>.
     * 
     * @since API 1.15.0
     */
    public function getTrackingPermission( Inx_Api_List_ListContext $oList );

    /**
     * Updates the tracking permission of the recipients in the specified selection.
     *
     * @param Inx_Api_List_ListContext $oList the list context
     * @param Inx_Api_TrackingPermission_TrackingPermissionState $oValue the tracking permission state
     * @throws Inx_Api_DataException if the recipient was deleted or no recipient is selected (e.g. you forgot to call
     * <i>next()</i>).
     * @throws Inx_Api_Recipient_AttributeNotFoundException if the list is not a standard list.
     * @throws Inx_Api_Recipient_TrackingPermissionNotFetchedException if the underlying 
     * <i>Inx_Api_Recipient_RecipientContext</i> does not contain tracking permission attributes, see
     * <i>Inx_Api_Recipient_RecipientContext::includesTrackingPermissions()</i>.
     * 
     * @since API 1.15.0
     */
    public function updateTrackingPermission( Inx_Api_List_ListContext $oList, Inx_Api_TrackingPermission_TrackingPermissionState $oValue );

}
