<?php

class Hex
{

	var $file;
	var $hex;

	function __construct($file)
	{
		$this->file = $file;
	}
	
	
	function gethex()
	{
		$handle = fopen($this->file, 'r') or die('Hai i permessi?');
		
			while(!feof($handle))
			{
				foreach(unpack('C*',fgets($handle)) as $dec)
				{
					$tmp = dechex($dec);
					$this->hex[] .= strtoupper(str_repeat('0',2-strlen($tmp)).$tmp);	
				}
			}
		
		return join($this->hex);
	}
	
	function writehex($hexcode)
	{
		
		foreach(str_split($hexcode,2) as $hex)
		{
			$tmp .= pack('C*', hexdec($hex));
		}
		
			$handle = fopen($this->file, 'w+') or die('Hai i permessi?');
			fwrite($handle, $tmp);
		
	}
		
}

?>