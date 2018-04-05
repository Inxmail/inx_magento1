<?php
/**
 * The API gives access to objects of Inxmail, which are called "BusinessObjects". For example, a mailing list in
 * Inxmail is such a Business Object. <i>Inx_Api_ReadOnlyBusinessObject</i>s are Business Objects which cannot be
 * manipulated by the Inxmail Professional API.
 * 
 * @see Inx_Api_BusinessObject
 * @author chge, 13.08.2013
 * @since API 1.11.1
 */
interface Inx_Api_ReadOnlyBusinessObject
{
        /**
	 * Returns the unique identifier of this <i>Inx_Api_ReadOnlyBusinessObject</i>.
	 * 
	 * @return int the unique identifier.
	 */
	public function getId();

        /**
	 * Reloads this business object from the server.
	 * 
	 * @throws Inx_Api_DataException if this business object could not be found on the server 
         * (e.g. the object was deleted).
	 */
	public function reload();
}
