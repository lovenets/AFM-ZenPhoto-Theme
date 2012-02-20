function FontObject()
{
	this.id = 0;
	this.name = 'Times';
	this.secondaryName = "Roman";
	this.type = "none";
	this.size = 12;
	this.decoration = 'italic';
	
	this.extractData = function (element)
	{
		this.setId($(element).attr("id"));
		this.setSize($(element).attr("fontSize"));
		this.setDecoration($(element).attr("fontDecoration"));

		this.setName($(element).attr("name"));
		this.setSecondaryName($(element).attr("secondaryName"));
		var fontType = $(element).find("fontType");
		if (fontType.length != 0)
		{
			this.setType($(fontType).attr("name"));
		}
	};
	
	this.getFontName = function ()
	{// {font-family:"Times New Roman", Times, serif;}
		var fontName = '"' + this.getName() + '"';
		var secondaryName = this.getSecondaryName();
		
		if (secondaryName.length != 0)
		{
			fontName += ', "' + secondaryName + '"';
		}
		var fontType = this.getType();
		if (fontType.length != 0)
		{
			fontName += ', "' + fontType + '"';
		}
		
		return fontName;
	};

	this.setId = function(id)
	{
		this.id = id;
	};
	
	this.getId = function ()
	{
		return this.id;
	};
	
	this.setName = function(name)
	{
		this.name = name;
	};
	
	this.getName = function()
	{
		return this.name;
	};
	
	this.setSecondaryName = function(secondaryName)
	{
		this.secondaryName = secondaryName;
	};
	
	this.getSecondaryName = function ()
	{
		return this.secondaryName;
	};
 
	this.setType = function (type)
	{
		this.type = type;
	};
	
	this.getType = function ()
	{
		return this.type;
	};
	
	this.setSize = function (size)
	{
		this.size = size;
	};
	
	this.getSize = function ()
	{
		return this.size;
	};
	
	this.setDecoration = function(decoration)
	{
		this.decoration = decoration;
	};
	
	this.getDecoration = function ()
	{
		return this.decoration;
	};
	
}