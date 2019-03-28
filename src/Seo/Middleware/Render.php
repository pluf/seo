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
use Jaybizzle\CrawlerDetect\CrawlerDetect;

/**
 * SEO middleware
 *
 *
 * @author maso <mostafa.barmshory@dpq.co.ir>
 *        
 */
class Seo_Middleware_Render
{

    /**
     * Check request to detect bot
     *
     * @param Pluf_HTTP_Request $request
     */
    function process_request(&$request)
    {
        if ($request->method !== 'GET') {
            return false;
        }

        // Do not render files
        if (preg_match('/^.*\.(.+)$/i', $request->query)) {
            return false;
        }

        // Do not render api
        if (preg_match('/^\/api\/.*$/i', $request->query)) {
            return false;
        }

        // Do not render for prerender.io
        if (preg_match('/Prerender/', $request->agent)) {
            return false;
        }

        $CrawlerDetect = new CrawlerDetect();
        if (array_key_exists('_escaped_fragment_', $request->REQUEST) || $CrawlerDetect->isCrawler($request->agent)) {
            return $this->prerenderResponse($request);
        }
        return false;
    }

    /**
     * بر اساس تقاضا یک نتیجه مناسب برای جستجوی گوگل ایجاد می‌کند.
     *
     * @param Pluf_HTTP_Request $request
     */
    function prerenderResponse($request)
    {
        $backend = new Seo_Backend();
        $backends = $backend->getList(array(
            'filter' => 'enable=1',
            'order' => 'priority ASC'
        ));
        $renderRequest = new Seo_Request($request);
        foreach ($backends as $backend) {
            try {
                $response = $backend->render($renderRequest);
                if ($response) {
                    if ($response instanceof Pluf_HTTP_Response) {
                        return $response;
                    }
                    return new Pluf_HTTP_Response($response);
                }
            } catch (Exception $error) {
                // TODO: maso, 2014: log the error
            }
        }
        // No prerender engine is set. So default prerender will be used.
        if (Pluf::f('seo.prerender.default.enable', false)) {
            $backend = new Seo_Backend();
            $backend->title = 'Default global prerenderer';
            $backend->symbol = 'global';
            $backend->engine = 'global';
            $backend->setMeta('period', Pluf::f('.prerender.default.period', '+7 days'));
            $backend->setMeta('pattern', Pluf::f('seo.prerender.default.pattern', '.*'));
            return $backend->render($renderRequest);
        }

        return false;
    }
}
