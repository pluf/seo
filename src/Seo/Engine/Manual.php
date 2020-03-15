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
 *
 * @author maso<mostafa.barmshory@dpq.co.ir>
 *        
 */
class Seo_Engine_Manual extends Seo_Engine
{

    /**
     *
     * {@inheritdoc}
     *
     * @see Seo_Engine::getTitle()
     */
    public function getTitle()
    {
        return 'Manual';
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see Seo_Engine::getDescription()
     */
    public function getDescription()
    {
        return 'Engine for manually registered cached pages.';
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see Seo_Engine::getExtraParam()
     */
    public function getExtraParam()
    {
        return array();
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see Seo_Engine::render()
     */
    public function render($request)
    {
        $url = $request->get_base();
        Pluf_Assert::assertNotNull($url, 'URL is not defined');
        $content = Seo_Content::getContent($url);
        if ($content == null) {
            $this->checkRegister($request);
            return false;
        } else if ($content->isExpired()) {
            return false;
        }
        return $this->_fetch_content_binary($content);
    }

    /*
     * Fetch binary model and add the counter
     */
    private function _fetch_content_binary($content)
    {
        $content->downloads += 1;
        $content->update();
        $response = new Pluf_HTTP_Response_File($content->getAbsloutPath(), $content->mime_type);
        $response->headers['Content-Disposition'] = sprintf('attachment; filename="%s"', $content->file_name);
        return $response;
    }

    /*
     * Check and register the url if required
     */
    private function checkRegister($request)
    {
        // TODO: maso, 2018: add registration as an option
        $content = new Seo_Content();
        $content->url = $request->get_base();
        $content->downloads = 0;
        $content->expire_dtime = gmdate('Y-m-d H:i:s', strtotime('-1 day'));
        $content->create();
    }
}
