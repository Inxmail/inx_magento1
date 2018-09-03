<?php
/**
 * The <i>Inx_api_ROBOManager</i> interface defines the basic requirements of a read-only business object manager,
 * including retrieval of the managed objects.
 * 
 * @see Inx_Api_BOManager
 * @author chge, 13.08.2013
 * @since API 1.11.1
 */
interface Inx_Api_ROBOManager
{
        /**
	 * Returns the <i>Inx_Api_ReadOnlyBusinessObject</i> with the specified id.
	 * 
	 * @param int $iId the id of the <i>Inx_Api_ReadOnlyBusinessObject</i> to retrieve.
	 * @return Inx_Api_ReadOnlyBusinessObject the <i>ReadOnlyBusinessObject</i>.
	 * @throws Inx_Api_DataException if no <i>Inx_Api_ReadOnlyBusinessObject</i> could be found 
         * (e.g. the object was deleted).
	 */
	public function get( $iId );

        /**
	 * Returns an <i>Inx_Api_ROBOResultSet</i> containing all managed <i>Inx_Api_ReadOnlyBusinessObject</i>s. If there are no
	 * business objects to return, an empty result set will be returned.
	 * 
	 * @return Inx_Api_ROBOResultSet a <i>ROBOResultSet</i> containing all managed 
         * <i>Inx_Api_ReadOnlyBusinessObject</i>s.
	 */
	public function selectAll();
}