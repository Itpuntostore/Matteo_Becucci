<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

 
function anchor($uri = '', $title = '', $attributes = '')
{
	$title = (string) $title;

	if ( ! is_array($uri))
	{
		$site_url = ( ! preg_match('!^\w+://!i', $uri)) ? site_url($uri) : $uri;
	}
	else
	{
		$site_url = site_url($uri);
	}

	if ($title == '')
	{
		$title = $site_url;
	}

	if ($attributes == '')
	{
		$attributes = ' title="'.$title.'"';
	}
	else
	{
		$attributes = _parse_attributes($attributes);
	}

	return '<a href="'.$site_url.'"'.$attributes.'><span>'.$title.'</span></a>';
}
