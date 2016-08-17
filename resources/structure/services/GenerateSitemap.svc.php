<?php
/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GenerateSitemap
{
    public static function generate()
    {
        $ConfigCore = ConfigCore::getInstance();
        $urlBase = $ConfigCore->getAppBaseUrl();

        $sitemap = new Sitemap($urlBase);
        $sitemap->setPath(SYSROOT . 'public/sitemaps/');
        //$sitemap->setFilename( 'sitemap');

        //$sitemap->addItem( UrlMaker::toRoute('index') , '1.0', 'daily', 'Today');

        $sitemap->createSitemapIndex($urlBase . 'sitemaps/', 'Today');
    }
}