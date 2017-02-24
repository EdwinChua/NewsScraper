<?php
require_once("scraper.php");
$completion = 0;
$sites = array (
            'http://www.straitstimes.com/singapore/latest',
            'http://www.straitstimes.com/politics/latest',
            'http://www.straitstimes.com/asia/latest',
            'http://www.straitstimes.com/world/latest',
            'http://www.straitstimes.com/forum/latest',
            'http://www.straitstimes.com/opinion/latest',
            'http://www.straitstimes.com/business/latest',
            'http://www.straitstimes.com/tech/latest',
            'http://www.straitstimes.com/'
          );

$increment = 100 / count($sites);

foreach ($sites as $site)
{
  ScrapeThisSite($site,"Headlines");
  $completion = $completion + $increment;
  echo $completion . "% \n";
}
