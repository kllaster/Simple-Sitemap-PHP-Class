# Simple-Sitemap-PHP-Class
Simple PHP Class to create sitemap.xml

1. Create class and sitemap-index

```
require_once 'cSitemap.php';

$sDomain = 'https://example.com';    // Domain of this site

$Sitemap = new Sitemap($sDomain);
$Sitemap->NewSitemap();

```

2. Add items (URLs)

```
// AddItem( $url, $changefreq, $priority );
// $url - URL to add
// $changefreq - The frequency of page changes (always, hourly, daily, weekly, monthly, yearly, never)
// $priority - Priority of indexing over other pages (0.0 - 1.0). Default value 0.5

$Sitemap->AddItem( '/', 'daily', '1.0' );
$Sitemap->AddItem( '/about', 'weekly', '0.8' );
$Sitemap->AddItem( '/shop', 'weekly', '0.8' );
$Sitemap->AddItem( '/news', 'weekly' );

$DB_news = new DB_News;                                                     // Example DB class
$news = $DB_news->News('Select_all_posts');     
for($i = 1; $i <= count($news); $i++){
    $Sitemap->AddItem( '/news/'.$news[$i]['url_title'], 'never', '0.9' );   // Add all news posts
}

```

2. End, close sitemap-index

```
$Sitemap->CloseSitemapIndex();

```
