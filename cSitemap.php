<?

class Sitemap{

    public function __construct( $domain ){

        $this->domain = $domain;
        $this->date = date('Y-m-d');
        $this->sitemap_others = array();
        $this->sitemap_url;

        if(!file_exists(__DIR__.'/../../sitemap.xml')){
            file_put_contents(__DIR__.'/../../sitemap.xml', '');
        }

    }

    public function NewSitemap(){

        $this->items = 0;

        if(!empty($this->sitemap_others) && count($this->sitemap_others)){
            $loc = 'sitemap/sitemap_'.(count($this->sitemap_others)+1).'.xml';
        }else{
            $loc = 'sitemap/sitemap_1.xml';
        }

        $this->sitemap_others[] = $loc;

        if(!file_exists($loc)){
            file_put_contents($loc, '');
        }

        $fp_clear = fopen($loc, "w");
        fclose($fp_clear);

        $this->$fp = fopen($loc, "a+");
        $xml_header = '<?xml version="1.0" encoding="UTF-8"?>'."\r\n".
                      '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\r\n";
        fwrite($this->$fp, $xml_header); 

        $this->sitemap_url = __DIR__ .'/../../'. $loc;

    }

    private function NewSitemapClose(){

        $xml_end = "</urlset>\r\n";

        fwrite($this->$fp, $xml_end); 
        fclose($this->$fp);
        
    }

    public function AddItem( $url, $changefreq, $priority = 0.5 ){

        //$changefreq   = always, hourly, daily, weekly, monthly, yearly, never
        //$priority     = 0.0 - 1.0

        if($this->items == 50000 || filesize($this->sitemap_url) >= 52000000){
            $this->NewSitemapClose();
            $this->NewSitemap();
        }
        
        $xml_url = "<url>\r\n".
                        "\t<loc>".$this->domain.$url."</loc>\r\n".
                        "\t<lastmod>".$this->date."</lastmod>\r\n".
                        "\t<changefreq>".$changefreq."</changefreq>\r\n".
                        "\t<priority>".$priority."</priority>\r\n". 
                    "</url>\r\n";

        fwrite($this->$fp, $xml_url); 

        $this->items++;
        
    }

    public function CloseSitemapIndex(){

        $this->NewSitemapClose();

        $fp_clear = fopen(__DIR__.'/../../sitemap.xml', "w");
        fclose($fp_clear);

        $fp_index = fopen(__DIR__.'/../../sitemap.xml', "a+");
        $xml_index_header = '<?xml version="1.0" encoding="UTF-8"?>'."\r\n".
                                "\t".'<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\r\n";
        fwrite($fp_index, $xml_index_header); 

        $sitemap_tag = '';

        for($i = 0; $i < count($this->sitemap_others); $i++){
            $sitemap_tag .= "\t<sitemap>\r\n".
                                "\t\t<loc>".$this->domain.$this->sitemap_others[$i]."</loc>\r\n".
                                "\t\t<lastmod>".$this->date."</lastmod>\r\n".
                            "\t</sitemap>\r\n";
        }

        fwrite($fp_index, $sitemap_tag); 

        $xml_end = "</sitemapindex>\r\n";

        fwrite($fp_index, $xml_end); 
        fclose($fp_index);
    }

}



/* 

//SITEMAP INDEX

<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <sitemap>
        <loc>http://www.example.com/sitemap1.xml.gz</loc>
        <lastmod>2004-10-01T18:23:17+00:00</lastmod>
    </sitemap>

    <sitemap>
        <loc>http://www.example.com/sitemap2.xml.gz</loc>
        <lastmod>2005-01-01</lastmod>
    </sitemap>

</sitemapindex>

*/



/*

//SITEMAP

<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

   <url>
      <loc>http://www.example.com/</loc>
      <lastmod>2005-01-01</lastmod>
      <changefreq>daily</changefreq>
      <priority>0.8</priority>
   </url>

</urlset>  

*/