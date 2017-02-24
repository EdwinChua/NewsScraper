<?php

function GetArticleBody($href)
{
	//$html = file_get_contents($href); //get the html returned from the following url

	$html = "compress.zlib://" . $href;
	$html = file_get_contents($html, false, stream_context_create(array('http'=>array('header'=>"Accept-Encoding: gzip\r\n"))));

	$articlebody = "";
	$date ="";

	$news_doc = new DOMDocument;

	libxml_use_internal_errors(TRUE); //disable libxml errors

	if(!empty($html))
	{ //if any html is actually returned

		$news_doc->loadHTML($html);
		libxml_clear_errors(); //remove errors for yucky html

		$news_xpath = new DOMXPath($news_doc);

		//get all the h2's with an id
		$news_row = $news_xpath->query('//div[@itemprop="articleBody"] //p');
		$news_date = $news_xpath ->query('//div[@class="story-postdate"]');


		if($news_date->length >0)
		{
			foreach($news_date as $date)
			{
				$date = $date -> nodeValue;
				$date = str_replace("Published","",$date);
			}
		}

		if($news_row->length > 0)
		{
			foreach($news_row as $row)
			{
				$articlebody = $articlebody . $row -> nodeValue . "\n \n<br> <br>";
			}
		}
		return array ($date,$articlebody);
	}
}
