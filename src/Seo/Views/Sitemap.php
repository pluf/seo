<?php

/*
 * This file is part of Pluf Framework, a simple PHP Application Framework.
 * Copyright (C) 2010-2020 Phoinex Scholars Co. (http://dpq.co.ir)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Generate site map
 *
 * @author Mostafa Barmshory<mostafa.barmshory@dqp.co.ir>
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
    public static function get($request, $match)
    {
        // Links
        $link = new Seo_SitemapLink();
        $links = $link->getList();
        
        $list = array();
        foreach ($links as $lnk){
            if($lnk->lastmod){
                $dt = new DateTime($lnk->lastmod, new DateTimeZone('UTC'));
                $lnk->lastmod = $dt->format(DateTime::ATOM); // Updated ISO8601
            }
        }

        
        // Add link to SPAs of tenant
        $tmpl = new Pluf_Template('/sitemap.template');
        $context = new Pluf_Template_Context(array(
            'tenant' => $request->tenant,
            'links' => $links
        ));
        $mimetype = Pluf::f('mimetype', 'text/xml') . '; charset=utf-8';
        return new Pluf_HTTP_Response($tmpl->render($context), $mimetype);
    }
}
