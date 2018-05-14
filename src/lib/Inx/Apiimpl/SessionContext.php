<?php
interface Inx_Apiimpl_SessionContext
{
	
	const CORE2_SERVICE = "Core2Service";

	const RECIPIENT_SERVICE = "RecipientService";

	const LIST_SERVICE = "ListService";

	const MAILING7_SERVICE = "Mailing7Service";
        
    const TRIGGER_MAILING_SERVICE = "TriggerMailingService";
        
    const SENDING_SERVICE = "SendingService";

	const PROPERTY_SERVICE = "PropertyService";

	const RESOURCE_SERVICE = "ResourceService";

	const REPORTING_SERVICE = "ReportingService";

	const BLACKLIST_SERVICE = "BlacklistService";

	const FILTER_SERVICE = "FilterService";

	const ACTION2_SERVICE = "Action2Service";

	const TEXTMODULE_SERVICE = "TextmoduleService";
	
	const MAILING_TEMPLATE_SERVICE = "MailingTemplateService";

	const DATAACCESS4_SERVICE = "DataAccess4Service";

	const DESIGN_COLLECTION2_SERVICE = "DesignTemplate2Service";
        
	const BOUNCE3_SERVICE = "Bounce3Service";
	
	const APPROVER_SERVICE = "ApproverService";
	
	const TESTRECIPIENT_SERVICE = "TestrecipientService";
	
	const UNSUBSCRIBER_SERVICE = "UnsubscriberService";
	
	const PLUGIN_SERVICE = "PluginService";
	
	const INBOX_SERVICE = "InboxService";
	
	const WEBPAGE2_SERVICE = "Webpage2Service";
        
	const GENERAL_MAILING_SERVICE = "GeneralMailingService";
        
	const TRANSFORMATION_SERVICE = "TransformationService";
	
	const SPLIT_TEST_MAILING_SERVICE = "SplitTestMailingService";

	const SPLIT_TEST_SERVICE = "SplitTestService";

	const TRACKING_PERMISSION_SERVICE = "TrackingPermissionService";
	
//	public function sessionId();

	
	public function createCxt();

	
	public function createRemoteRef( $sRemoteRefId );

	
	public function getService( $sKey );
	
	public function getIntProperty( $sKey );

	public function notify( Inx_Api_RemoteException $x );

}
