<?php
function ScrapeThisSite($sitelink,$category)
{
	require_once("scraper2.php");
	require_once("Article.php");
	require_once("CurlToDB.php");

	$articles = array();

	//$html = file_get_contents($sitelink); //get the html returned from the following url

	$html = "compress.zlib://" . $sitelink;
	$html = file_get_contents($html, false, stream_context_create(array('http'=>array('header'=>"Accept-Encoding: gzip\r\n"))));
	
	$news_doc = new DOMDocument;

	libxml_use_internal_errors(TRUE); //disable libxml errors

	if(!empty($html)){ //if any html is actually returned

		$news_doc->loadHTML($html);
		libxml_clear_errors(); //remove errors for yucky html

		$news_xpath = new DOMXPath($news_doc);

		//get all the h2's with an id
		$news_row = $news_xpath->query('//span[@class="story-headline"] //a');

		if($news_row->length > 0)
		{
			foreach($news_row as $row)
			{
				$headline = $row -> nodeValue;
				$href = $row->getAttribute('href');

				if (strpos($href,"pubads"))
				{
					//ignore ads
				}
				else if(strlen($href) < 1)
				{
					//ignore blanks
				}
				else if(strpos($href,"://"))
				{
					list($date, $articlebody) = GetArticleBody($href);
					$article = new Article(array("headline"=>$headline, "date"=>$date, "articlebody"=>$articlebody, "href"=>$href, "category"=>$category));
					$articles[] = $article;
				}
				else
				{
					$href = "http://www.straitstimes.com" . $href;
					list($date, $articlebody) = GetArticleBody($href);
					$article = new Article(array("headline"=>$headline, "date"=>$date, "articlebody"=>$articlebody, "href"=>$href,  "category"=>$category));
					$articles[] = $article;
				}
			}
			foreach ($articles as $article)
			{
				CurlToDB($article);
			}
		}
	}
}
