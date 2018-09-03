<?php
/**
 * The <i>Inx_Api_Reporting_ReportMailingType</i> enumeration defines the types of mailings for which reports can 
 * be created. Some reports require you to specify the type of the mailing, as stated in the reports reference of 
 * the Inxmail Professional API Developer Guide. You can specify the type of the mailing by using the
 * <i>Inx_Api_Reporting_ReportRequest::putMailingTypeParameter($sKey, $oMailingType)} method.
 * 
 * @author chge, 16.08.2013
 * @since API 1.11.1
 */
final class Inx_Api_Reporting_ReportMailingType
{
    private static $MAILING = null;

    private static $SPLIT_TEST_MAILING = null;

    private static $ACTION_MAILING = null;

    private static $SUBSCRIPTION_WELCOME = null;

    private static $TIME_TRIGGER_INTERVAL_MAILING = null;

    private static $TIME_TRIGGER_BIRTHDAY_MAILING = null;

    private static $TIME_TRIGGER_ANNIVERSARY_MAILING = null;

    private static $TIME_TRIGGER_REMINDER_MAILING = null;

    private static $TIME_TRIGGER_FOLLOW_UP_MAILING = null;
    
    /** 
     * Mailing type for an ordinary mailing. 
     * 
     * @return Inx_Api_Reporting_ReportMailingType the oridnary mailing type.
     */
    public static final function MAILING() 
    { 
        if( null === self::$MAILING) 
            self::$MAILING = new Inx_Api_Reporting_ReportMailingType( -1 ); 
        
        return self::$MAILING;         
    }

    /** 
     * Mailing type for split test mailings. 
     * 
     * @return Inx_Api_Reporting_ReportMailingType the split test mailing type.
     */
    public static final function SPLIT_TEST_MAILING() 
    { 
        if( null === self::$SPLIT_TEST_MAILING) 
            self::$SPLIT_TEST_MAILING = new Inx_Api_Reporting_ReportMailingType( -2 ); 
        
        return self::$SPLIT_TEST_MAILING;         
    }

    /** 
     * Mailing type for action mailings. 
     * 
     * @return Inx_Api_Reporting_ReportMailingType the action mailing type.
     */
    public static final function ACTION_MAILING() 
    { 
        if( null === self::$ACTION_MAILING) 
            self::$ACTION_MAILING = new Inx_Api_Reporting_ReportMailingType( 1 ); 
        
        return self::$ACTION_MAILING; 
    }

    /** 
     * Mailing type for welcome mailings used in the subscription process. 
     * 
     * @return Inx_Api_Reporting_ReportMailingType the subscription welcome mailing type.
     */
    public static final function SUBSCRIPTION_WELCOME() 
    { 
        if( null === self::$SUBSCRIPTION_WELCOME) 
            self::$SUBSCRIPTION_WELCOME = new Inx_Api_Reporting_ReportMailingType( 4 ); 
        
        return self::$SUBSCRIPTION_WELCOME; 
    }

    /** 
     * Mailing type for interval trigger mailings. 
     * 
     * @return Inx_Api_Reporting_ReportMailingType the interval trigger mailing type.
     */
    public static final function TIME_TRIGGER_INTERVAL_MAILING() 
    { 
        if( null === self::$TIME_TRIGGER_INTERVAL_MAILING) 
            self::$TIME_TRIGGER_INTERVAL_MAILING = new Inx_Api_Reporting_ReportMailingType( 8 ); 
        
        return self::$TIME_TRIGGER_INTERVAL_MAILING; 
    }

    /** 
     * Mailing type for birthday trigger mailings. 
     * 
     * @return Inx_Api_Reporting_ReportMailingType the birthday trigger mailing type.
     */
    public static final function TIME_TRIGGER_BIRTHDAY_MAILING() 
    { 
        if( null === self::$TIME_TRIGGER_BIRTHDAY_MAILING) 
            self::$TIME_TRIGGER_BIRTHDAY_MAILING = new Inx_Api_Reporting_ReportMailingType( 9 ); 
        
        return self::$TIME_TRIGGER_BIRTHDAY_MAILING; 
    }

    /** 
     * Mailing type for anniversary trigger mailings. 
     * 
     * @return Inx_Api_Reporting_ReportMailingType the anniversary trigger mailing type.
     */
    public static final function TIME_TRIGGER_ANNIVERSARY_MAILING() 
    { 
        if( null === self::$TIME_TRIGGER_ANNIVERSARY_MAILING) 
            self::$TIME_TRIGGER_ANNIVERSARY_MAILING = new Inx_Api_Reporting_ReportMailingType( 10 ); 
        
        return self::$TIME_TRIGGER_ANNIVERSARY_MAILING; 
    }

    /** 
     * Mailing type for reminder trigger mailings. 
     * 
     * @return Inx_Api_Reporting_ReportMailingType the reminder trigger mailing type.
     */
    public static final function TIME_TRIGGER_REMINDER_MAILING() 
    { 
        if( null === self::$TIME_TRIGGER_REMINDER_MAILING) 
            self::$TIME_TRIGGER_REMINDER_MAILING = new Inx_Api_Reporting_ReportMailingType( 11 ); 
        
        return self::$TIME_TRIGGER_REMINDER_MAILING; 
    }

    /** 
     * Mailing type for follow up trigger mailings. 
     * 
     * @return Inx_Api_Reporting_ReportMailingType the follow up trigger mailing type.
     */
    public static final function TIME_TRIGGER_FOLLOW_UP_MAILING() 
    { 
        if( null === self::$TIME_TRIGGER_FOLLOW_UP_MAILING) 
            self::$TIME_TRIGGER_FOLLOW_UP_MAILING = new Inx_Api_Reporting_ReportMailingType( 12 ); 
        
        return self::$TIME_TRIGGER_FOLLOW_UP_MAILING; 
    }
    
    private $reportId;
    
    private function __construct( $iReportId )
    {
        $this->reportId = $iReportId;
    }
    
    /**
     * Returns the ID of this <i>Inx_Api_Reporting_ReportMailingType</i>.
     * 
     * @return the ID of this <i>Inx_Api_Reporting_ReportMailingType</i>.
     */
    public function getReportId()
    {
            return $this->reportId;
    }
}
?>
