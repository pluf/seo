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
class Seo_Engine_Global extends Seo_Engine
{

    /**
     *
     * {@inheritdoc}
     *
     * @see Seo_Engine::getTitle()
     */
    public function getTitle()
    {
        return 'Global';
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see Seo_Engine::getDescription()
     */
    public function getDescription()
    {
        return 'The Global Engine is an embedded gloabal Prerender.io to use in all tenants.';
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see Seo_Engine::getExtraParam()
     */
    public function getExtraParam()
    {
        return array(
            array(
                'name' => 'period',
                'type' => 'String',
                'unit' => 'none',
                'title' => 'Relative date',
                'description' => 'When the cached page is expired for example +2 days.',
                'editable' => true,
                'visible' => true,
                'priority' => 5,
                'symbol' => 'key',
                'defaultValue' => '+1 day',
                'validators' => [
                    'NotNull'
                ]
            ),
            array(
                'name' => 'pattern',
                'type' => 'String',
                'unit' => 'none',
                'title' => 'Pattern',
                'description' => 'Pattern of URLs which must be managed',
                'editable' => true,
                'visible' => true,
                'priority' => 10,
                'symbol' => 'pattern',
                'defaultValue' => '.*',
                'validators' => [
                    'NotNull',
                    'NotEmpty'
                ]
            )
        );
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see Seo_Engine::render()
     */
    public function render($request)
    {
        // Check the url exist and match with pattern
        $url = $request->get_base();
        Pluf_Assert::assertNotNull($url, 'URL is not defined');
        if (! preg_match('/'.$request->get_meta('pattern', '.*').'/', $url)) {
            return false;
        }

        // Check content
        $content = $this->checkRegister($url);
        return $this->fetchContentBinary($request, $content);
    }

    /*
     * Fetch binary model and add the counter
     */
    public function fetchContentBinary($request, $content)
    {

        // if content is expired then we render it
        if ($content->isExpired()) {
            // maso, 2017: fetch data from server
            $client = new \GuzzleHttp\Client(array(
                'base_uri' => Pluf::f('seo_prerender_global_url', 'localhost')
            ));
            if (! defined('IN_UNIT_TESTS')) {
                $res = $client->request('GET', '/' . $content->url, array(
                    'stream' => false,
                    'debug' => false,
                    'query' => $request->get_parameters()
                ));
                if ($res->getStatusCode() != 200) {
                    // TODO: maso, 2019: add a log
                    return false;
                }
                $entityBody = $res->getBody();
            } else {
                $entityBody = 'IN_UNIT_TESTS';
            }
            $content->writeValue($entityBody);
            $content->expire_dtime = gmdate('Y-m-d H:i:s', strtotime($request->get_meta('period', '+1 day')));
        }

        // return the response
        $content->downloads += 1;
        $content->update();
        $response = new Pluf_HTTP_Response_File($content->getAbsloutPath(), $content->mime_type);
        return $response;
    }

    /*
     * Check and register the url if required
     */
    private function checkRegister($url)
    {
        $content = Seo_Content::getContent($url);
        if ($content == null) {
            $content = new Seo_Content();
            $content->url = $url;
            $content->downloads = 0;
            $content->expire_dtime = gmdate('Y-m-d H:i:s', strtotime('-1 day'));
            $content->create();
        }
        return $content;
    }
}
