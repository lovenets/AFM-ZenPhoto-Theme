<?php
/*
 * Created on Jul 21, 2005
 *
 * Author: D.W. Milligan
 * Copyright: AFM Software 2005
 * Project: package_name
 * File: displayObject.php
 */

define("COMMENT_DATA", "COMMENT_DATA");
define("HEADER_DATA", "HEADER_DATA");
define("RSS_FEED_LINK", "RSS_FEED_LINK");
define("STYLESHEET_DATA", "STYLESHEET_DATA");
define("STYLESHEET_LINK", "STYLESHEET_LINK");
define("JAVASCRIPT_DATA", "JAVASCRIPT_DATA");
define("JAVASCRIPT_LINK", "JAVASCRIPT_LINK");
define("TITLE_DATA", "TITLE_DATA");
define("BODY_DATA", "BODY_DATA");
 
class DisplayObject
{
    private $m_data;        /*!< The data to be displayed */
    private $m_type;        /*!< The type of data being displayed */
    private $m_id;
    
	public function __construct()
	{
        $this->DisplayObject();
	}
    
	public function DisplayObject()
    {
        $this->m_data = "";
        $this->m_type = COMMENT_DATA;
        $this->m_id = null;
    }
    	
    function setData($data) { $this->m_data = $data; }
    function getData() { return $this->m_data; }
    function addData($data) { $this->m_data .= $data; }

    function setDataType($type) { $this->m_type = $type; }
    function getDataType() { return $this->m_type; }
    
    function setId($id) { $this->m_id = $id; }
    function getId() { return $this->m_id; }
};

class HeaderObject extends DisplayObject
{
    function HeaderObject()
    {
		$this->setDataType(HEADER_DATA);
    }
};

class RssFeedLink extends DisplayObject
{
	var $rssTitle;
	
	function RssFeedLink()
	{
		$this->setDataType(RSS_FEED_LINK);
		$this->rssTitle = "none";
	}
	
	function setRssTitle($title)
	{
		$this->rssTitle = $title;
	}
	
	function getRssTitle()
	{
		return $this->rssTitle;
	}
}

class StyleSheetDataObject extends DisplayObject
{
    function StyleSheetDataObject()
    {
		$this->setDataType(STYLESHEET_DATA);
    }
};

class StyleSheetLinkObject extends DisplayObject
{
    function StyleSheetLinkObject()
    {
		$this->setDataType(STYLESHEET_LINK);
    }
};

class TitleObject extends DisplayObject
{
    function TitleObject()
    {
		$this->setDataType(TITLE_DATA);
    }
};

class BodyObject extends DisplayObject
{
    function BodyObject()
    {
		$this->setDataType(BODY_DATA);
    }
};

class JavaScriptObject extends DisplayObject
{
    function JavaScriptObject()
    {
		$this->setDataType(JAVASCRIPT_DATA);
    }
};

class JavaScriptLink extends DisplayObject
{
	private $canFlatten = false;
	
	function JavaScriptLink()
	{
		$this->setDataType(JAVASCRIPT_LINK);
	}
	
	function setCanFlatten($flatten)
	{
		$this->canFlatten = $flatten;
	}
	
	function getCanFlatten()
	{
		return $this->canFlatten;
	}
};
?>