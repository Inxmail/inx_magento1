<?php
/**
 * The <i>Inx_Api_Recipient_RecipientState</i> enumeration defines the states of a recipient. 
 * These states are used in query results to indicate whether the associated recipient is known and still available. 
 * There are three possible values:
 * <ul>
 * <li><b>UNKNOWN</b>: Used if the recipient (or its state) is unknown. This can have various reasons:
 * <ul>
 * <li>The recipient ID refers to an invalid recipient (e.g. ID = 0)</li>
 * <li>No <i>Inx_Api_Recipient_RecipientContext</i> was provided in the query</li>
 * <li>No <i>Inx_Api_Recipient_Attribute</i>s were fetched in the query</li>
 * </ul>
 * </li>
 * <li><b>EXISTENT</b>: Used if the recipient is known and active.</li>
 * <li><b>DELETED</b>: Used if the recipient is known but was deleted.</li>
 * </ul>
 * 
 * @author chge, 20.11.2012
 */
final class Inx_Api_Recipient_RecipientState
{	
	private static $UNKNOWN = null;
	
	private static $EXISTENT = null;

	private static $DELETED = null;
        
        
        /**
	 * Used if the recipient (or its state) is unknown. This can have various reasons:
	 * <ul>
	 * <li>The recipient ID refers to an invalid recipient (e.g. ID = 0)</li>
         * <li>No <i>Inx_Api_Recipient_RecipientContext</i> was provided in the query</li>
         * <li>No <i>Inx_Api_Recipient_Attribute</i>s were fetched in the query</li>
	 * </ul>
         * 
         * @return Inx_Api_Recipient_RecipientState the unknown state.
	 */
        public static final function UNKNOWN()
        {
            if(null === self::$UNKNOWN)
                self::$UNKNOWN = new Inx_Api_Recipient_RecipientState(0);
            
            return self::$UNKNOWN;
        }
        
        /**
	 * Used if the recipient is known and active.
         * 
         * @return Inx_Api_Recipient_RecipientState the existent state.
	 */
        public static final function EXISTENT()
        {
            if(null === self::$EXISTENT)
                self::$EXISTENT = new Inx_Api_Recipient_RecipientState(1);
            
            return self::$EXISTENT;
        }
        
        /**
	 * Used if the recipient is known but was deleted.
         * 
         * @return Inx_Api_Recipient_RecipientState the deleted state.
	 */
        public static final function DELETED()
        {
            if(null === self::$DELETED)
                self::$DELETED = new Inx_Api_Recipient_RecipientState(2);
            
            return self::$DELETED;
        }
        

	private $id;

	private function __construct( $iId )
	{
		$this->id = $iId;
	}


	/**
	 * Returns the ID of this <i>Inx_Api_Recipient_RecipientState</i>. 
         * The ID is used for transmission purposes and should not be used inside client code.
	 * 
	 * @return int the ID of this <i>RecipientState</i>.
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * Returns the <i>Inx_Api_Recipient_RecipientState</i> corresponding to the given id. 
         * If the id is unknown, the <i>UNKNOWN</i> state will be returned. 
         * The ID is used for transmission purposes and should not be used inside client code.
	 * 
	 * @param int $iId the ID of the <i>RecipientState</i> to retrieve.
	 * @return Inx_Api_Recipient_RecipientState the <i>RecipientState</i> corresponding to the given ID.
	 */
	public static function byId( $iId )
	{
		foreach( self::values() as $state )
		{
			if( $state->getId() === $iId )
				return $state;
		}

		return self::UNKNOWN();
	}
        
        
        /**
         * Returns an array containing all available <i>RecipientState</i>s including UNKNOWN.
         * 
         * @return array an array containing all available <i>RecipientState</i>s including UNKNOWN.
         */
	public static function values()
	{
		return array(self::UNKNOWN(), self::EXISTENT(), self::DELETED());
	}
}