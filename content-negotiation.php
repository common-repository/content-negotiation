<?php
/*                                                                                                                                      
Plugin Name: Content-negotiation                                                                                    
Version: 1.0                                                                                                                            
Plugin URI: http://m0n5t3r.info/work/wordpress-plugins/content-negotiation/                                                                                                       
Description: Automatically select the best content type based on what the browser accepts
Author: m0n5t3r                                                                                
Author URI: http://m0n5t3r.info/                                                                                                                                        
*/

function selctype($ctype)
{
    if(preg_match("/wp-admin/",$_SERVER["REQUEST_URI"])){
	    return "text/html";
    }
    $accept=$_SERVER["HTTP_ACCEPT"];
    if(preg_match("|application/xhtml\+xml(;q=0\.([1-9]+))?|i",$accept,$m)){
		$q1 = $m[2];
		if($q1){
			$q2 = 10;
			if(preg_match("|text/html;q=0\.([1-9]+)?|i",$accept,$m)){
     			$q2 = $m[1];
     		}
     		if($q1 >= $q2)
				return "application/xhtml+xml";
			else
				return "text/html";
		}
		return "application/xhtml+xml"; 
    }elseif(preg_match("|text/xml(;q=0\.([1-9]+))?|i",$accept,$m)){
		$q1 = $matches[2];
		if($q1){
			$q2 = 0;
     		if(preg_match("|text/html;q=0(\.[1-9]+)|i",$accept, $m))
     			$q2 = $matches[1];
     		if($q1 >= $q2)
				return "text/xml";
			else
				return "text/html";
		}
	    return "text/xml";
    }
    return $ctype;
}
add_filter('option_html_type','selctype')                                                             
?>