<?php

/*
=====================================================
 Extract Image
-----------------------------------------------------
 http://www.intoeetive.com/
-----------------------------------------------------
 Copyright (c) 2013 Yuri Salimovskiy
-----------------------------------------------------
 Based on 'Extract URL' plugin by Chris Ruzin
 http://www.chrisruzin.net/
=====================================================
 This software is intended for usage with
 ExpressionEngine CMS, version 2.0 or higher
=====================================================
 File: pi.protected_links.php
-----------------------------------------------------
 Purpose: Encrypt and protect download links
=====================================================
*/

if ( ! defined('BASEPATH'))
{
    exit('Invalid file request');
}

$plugin_info = array(
	'pi_name'			=> 'Extract Image',
	'pi_version'		=> '1.0',
	'pi_author'			=> 'Yuri Salimovskiy',
	'pi_author_url'		=> 'http://www.intoeetive.com/',
	'pi_description'	=> 'Extracts image URLs from given text',
	'pi_usage'			=> Extract_image::usage()
);


class Extract_image
{
	var $return_data = '';

    function Extract_image($str = "")
	{
        $this->EE =& get_instance();

        $vars = array();

		if ($str == '')
        	$str = $this->EE->TMPL->tagdata;

        $found = preg_match_all('/src="(.+?)"/is', $str, $urls);
        
        if ($found==0)
        {
        	return $this->EE->TMPL->no_results();
        }
        
        $prepend = $this->EE->TMPL->fetch_param('prepend');
        $append = $this->EE->TMPL->fetch_param('append');
        
        for ($i = 0; $i < $found; $i++)
        {
        	$this->return_data .= $prepend.$urls[1][$i].$append."\n";
        }

		return $this->return_data;
	}

    /**
	 * Usage
	 *
	 * This function describes how the plugin is used.
	 *
	 * @access	public
	 * @return	string
	 */

    function usage()
	{
		ob_start();
?>
{exp:channel:entries limit="1"}
Set OpenGraph tags using images in body
{exp:extract_image prepend='<meta property="og:image" content="' append='" />'}
{body}
{/exp:extract_image}
{/exp:channel:entries}

<?php
		$buffer = ob_get_contents();

		ob_end_clean();

		return $buffer;
	}

}

?>
