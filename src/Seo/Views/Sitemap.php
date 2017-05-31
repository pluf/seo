<?php

/**
 * نمایش و اجرای spa
 * 
 * @author maso
 *
 */
class Seo_Views_Sitemap
{

    /**
     * Generate sitemap
     *
     * @param Pluf_HTTP_Request $request            
     * @param array $match            
     * @return Pluf_HTTP_Response
     */
    public static function get ($request, $match)
    {
        // Spas
        $sp = new Spa_SPA();
        $spaList = $sp->getList();
        
        // Links
        $link = new Seo_SitemapLink();
        $links = $link->getList();
        
        // Add link to SPAs of tenant
        $tmpl = new Pluf_Template('/sitemap.template');
        $context = new Pluf_Template_Context(
                array(
                        'tenant' => $request->tenant,
                        'spaList' => $spaList,
                        'links' => $links
                ));
        $mimetype = Pluf::f('mimetype', 'text/xml') . '; charset=utf-8';
        return new Pluf_HTTP_Response($tmpl->render($context), $mimetype);
    }
}