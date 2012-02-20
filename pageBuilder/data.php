<?php
/*
 * data.php
 * 
 * Used to manage data associated with this extension.
 */

$baseSiteDir = System::getInstance()->getBaseSystemDir();

include_once $baseSiteDir . 'pageBuilder/xmlPage.php';
include_once $baseSiteDir . 'pageBuilder/paramManager.php';

//include_once 'xmlPage.php';
//include_once 'paramManager.php';

define('NEW_DATABASE_ITEM', 0);

define('COMMAND_VIEW', "view");
define('COMMAND_CREATE', "create");
define('COMMAND_MODIFY', "modify");
define('COMMAND_DELETE', "delete");
define('COMMAND_ACTIVATE', "activate");
define('COMMAND_TAG', "tag");

class Data extends ParamManager
{
	private $m_id;
	private $m_isActive;
	private $m_timeStamp;
	private $m_tableName;
	
	function __construct()
	{
		$this->Data();
	}
	
	function Data()
	{
		parent::ParamManager();
		$this->reset();
		
		// load my params
		$fileBase = dirname(__FILE__);
		$this->loadCommandFile($fileBase . '/commandparam.xml');
	}
	
	function reset()
	{
		$this->m_id = NEW_DATABASE_ITEM;
		$this->m_isActive = false;
		$this->m_timeStamp = null;
		$this->m_tableName = null;
	}

	function setId($id)
	{
		$this->m_id = $id;
	}
	
	function getId()
	{
		return $this->m_id;
	}
	
	function setActive($isActive)
	{
		$this->m_isActive = $isActive;
	}
	
	function getActive()
	{
		return $this->m_isActive;
	}
	
	function setTimeStamp($timeStamp)
	{
		$this->m_timeStamp = $timeStamp;
	}
	
	function getTimeStamp()
	{
		return $this->m_timeStamp;
	}
	
	function setTableName($tableName)
	{
		$this->m_tableName = $tableName;
	}
	
	function getTableName()
	{
		return $this->m_tableName;
	}
	
	function loadData($id)
	{
		$this->setId($id);
		
		// DWM currently we are not doing much more than this as we don't want to have mutliple calls to the db
		// we will need update a db request using class level methods and do the same on saving
	}
	
	function saveData()
	{
		error_log("Saving data");
	}
	
	/*
	 * getLastInsertId
	 * 
	 * used to get the last id inserted into a table for this extension assuming each table has a timeStamp and id column
	 * 
	 * @return integer indicating the last id of the table or 0 for none
	 */
	function getLastInsertId()
	{
		$retVal = 0;
		$systemObject = getSystemObject();
		$dbInstance = $systemObject->getDbInstance();
		
		$queryString = "select id, timeStamp from " . $this->m_tableName . " order by timeStamp desc limit 1";
		$queryId = 0;
		$dbInstance->issueCommand($queryString, $queryId);
		$resultSet = $dbInstance->getResult($queryId);
		if ($resultSet != FALSE)
		{
			$retVal = $resultSet->id;
		}
		$dbInstance->releaseResults($queryId);
		return $retVal;
	}
	
	function toXml($name = "data")
	{
		$node = new XmlDataObject();
		
		$node->setName($name);
		
		$node->addAttribute("id", $this->getId());
		$node->addAttribute("active", $this->getActive());
		$node->addAttribute("timeStamp", $this->getTimeStamp());
		
		return $node;
	}
	
	function fromSql($resultSet)
	{
		$this->setId($resultSet->id);
		if ($resultSet->activeFlag == 1)
		{
			$this->setActive(true);
		}
		else
		{
			$this->setActive(false);
		}
		
		$this->setTimeStamp($resultSet->timeStamp);
	}
}
?>