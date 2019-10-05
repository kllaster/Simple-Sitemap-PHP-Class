<?

require_once 'cSitemap.php';

//Start
$sDomain = 'https://example.com';    // Domain of this site

$Sitemap = new Sitemap($sDomain);
$Sitemap->NewSitemap();

//Add items
$Sitemap->AddItem( '/', 'daily', '1.0' );

$Sitemap->AddItem( '/about', 'weekly', '0.8' );
$Sitemap->AddItem( '/shop', 'weekly', '0.8' );

$DB_news = new DB_News;                                                     //Example DB class
$news = $DB_news->News('Select_all_posts');  
for($i = 1; $i <= count($news); $i++){
    $Sitemap->AddItem( '/news/'.$news[$i]['url_title'], 'never', '0.9' );   // Add all news posts
}


//End
$Sitemap->CloseSitemapIndex();