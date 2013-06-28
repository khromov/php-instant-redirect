<?php
	/**
	 * A redirect script written for PHP/Apache.
	 * Makes it easy to temporarily or permanently redirect an entire homepage.
	 */
	
	/**
	 * Config section.
	 *
	 * Select from one of the following, that best suits your redirect:
	 *
	 * 301 = Permanent redirect
	 * 302 = Temporary redirect
	 * 503 = Service temporarily unavailable
	 *
	 * For more info, see:
	 * http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
	 */
	$error_code = 302;

	/** The new hostname to redirect to **/
	$new_host = 'static.idg.se';

	/** 
	 * Should we send the path to the new domain?
	 *
	 * Example, if enabled:
	 * http://oldsite.com/page1?query=vars -> http://newsite.com/page1?query=vars
	 *
	 * Example, if disabled:
	 * http://oldsite.com/page1?query=vars -> http://newsite.com/
	 **/
	$new_url_send_path = true;

	if($error_code==503)
	{
		header('HTTP/1.1 503 Service Temporarily Unavailable');
		header('Status: 503 Service Temporarily Unavailable');
		header('Retry-After: 300');		
	}
	else if($error_code==301)
	{
		header ('HTTP/1.1 301 Moved Permanently');
	}
	//302 is the default status code for header Location:. No else is needed to support 302

	$url_raw = "http" . (($_SERVER['SERVER_PORT']==443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$url_substituted = str_replace($_SERVER['HTTP_HOST'], $new_host, $url_raw);

	header("Location: {$url_substituted}");