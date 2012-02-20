// assuming jQuery
function toggleWindow(windowId, relativeTo, xOffset, yOffset, noResize)
{
	var pos = {};
	
	pos.left = 0;
	pos.top = 0;
	
	// is the current one showing, if so then hide otherwise show
	var windowIdVar = '#' + windowId;
	
	if ($(windowIdVar).css("display") == "none")
	{
		if (relativeTo != null)
		{
			var relativeId = $('#' + relativeTo);
			
			pos.left = relativeId.offset().left + (relativeId.width() / 2) + xOffset;
			pos.top = relativeId.offset().top - (relativeId.height() * 2) + yOffset;
		}
		
		if (noResize == true)
		{
			//make sure parent item doesn't resize by setting max height and width
			var parent = $(windowIdVar).parent();
			
			if (parent)
			{
				var width = parent.css("width");
				var height = parent.css("height");
				parent.css("max-width", width);
				parent.css("max-height", height);
			}
		}
		$(windowIdVar).show();
		$(windowIdVar).offset(pos);
	}
	else
	{
		$(windowIdVar).hide();
	}
}

function addButtonClass(componentId, subItemType, glossy, colored)
{
	var component = $('#' + componentId);
	
	if (subItemType != null)
	{
		component = $('#' + componentId).find(subItemType);
	}

	component.addClass("button");

	if (glossy == true)
	{
		component.addClass("glossy");
	}
	
	if (colored == true)
	{
		component.addClass("light");
	}
}

function addLedgeClass(componentId, subItemType, glossy, colored)
{
	var component = $('#' + componentId);
	
	if (subItemType != null)
	{
		component = $('#' + componentId).find(subItemType);
	}

	component.addClass("ledge");

	if (glossy == true)
	{
		component.addClass("glossy");
	}
	
	if (colored == true)
	{
		component.addClass("light");
	}
}

function addLinkClass(componentId, subItemType, glossy, colored)
{
	var component = $('#' + componentId);
	
	if (subItemType != null)
	{
		component = $('#' + componentId).find(subItemType);
	}
	
	component.addClass("link");

	if (glossy == true)
	{
		component.addClass("glossy");
	}
	
	if (colored == true)
	{
		component.addClass("light");
	}
}

/*
 * To be called when the document is ready
 */
function Initializer()
{
	this.callList = new Array();
	
	this.initialize = function ()
	{
		// Call each of the methods or code snippets
		for (var index = 0; index < this.callList.length; index++)
		{
			this.callList[index]();
		}
	}
	
	this.addCallback = function (callback)
	{
		this.callList[this.callList.length] = callback;
	}
}

function retrieveParams(formId, paramList)
{
	$('#' + formId).children().each(function (index)
		{
			paramList[$(this).attr('name')] = $(this).attr('value');
		});
}

function HandleOptionChange(resultSet)
{
//	var parsedData = $.parseXML(resultSet);
//	$xml = $(parsedData);
    var results = $(resultSet).find("success");
    
    if (results.length > 0)
    {
      if (results.text() == 1)
      {
    	  var command = $(resultSet).find("command");
    	  switch (command.text())
    	  {
    	  	case 'theme_color':
    	  	{
        		var themeColor = $(resultSet).find("theme_color");
        		
        		// load the selected color
        		setCookie('userColor', themeColor.text(), null, null);
        		
        		var node = document.getElementById('colorcss');
        		var parent = node.parentNode;
        		parent.removeChild(node);
        		var element = document.createElement('link');
                element.type = 'text/css';
                element.rel = 'stylesheet';
                element.id = 'colorcss';
                
                var cssPath = $(resultSet).find("cssAddr");
                element.href = cssPath.text() + themeColor.text() + ".css";
                document.getElementsByTagName('head')[0].appendChild(element);
        	}
    	  	break;
    	  }
      }
    }
}

function issuePost(actionUrl, paramFunc, callback)
{
	var paramList = {};
	
	if (paramFunc != null)
	{
		paramFunc(paramList);
	}
  $.post(actionUrl, paramList, function(retData)
    {
      var results = $(retData).find("results");

      if (results.length > 0)
      {
       	callback(retData);
      }
      else
      {
        alert("Error: Unable to process request - " + actionUrl + paramList);
      }
    });
}
