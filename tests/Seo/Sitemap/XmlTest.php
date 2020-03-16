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
namespace Pluf\Test\Seo\Sitemap;

use Pluf\Test\Client;
use Pluf\Test\TestCase;
use Pluf;
use Pluf_Migration;
use Seo_SitemapLink;

/**
 *
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class Seo_SiteMap_REST_XmlTest extends TestCase
{

    /**
     *
     * @before
     */
    public function setUpTest()
    {
        Pluf::start(__DIR__ . '/../../conf/config.php');
        $m = new Pluf_Migration();
        $m->install();
        $m->init();
    }

    /**
     * Delete all tables
     *
     * @after
     */
    protected function tearDownTest()
    {
        $m = new Pluf_Migration();
        $m->uninstall();
    }

    /**
     *
     * @test
     */
    public function listSapsRestTest()
    {
        // Add a link
        $link = new Seo_SitemapLink();
        $link->title = 'title';
        $link->description = 'description';
        $link->loc = 'http://www.example.com';
        $link->lastmod = gmdate('Y-m-d H:i:s');
        $link->changefreq = 'weekly';
        $link->priority = 0.6;
        $link->create();

        // get list
        $client = new Client();
        $response = $client->get('/seo/sitemap/sitemap.xml');
        $this->assertResponseNotNull($response, 'Find result is empty');
        $this->assertResponseStatusCode($response, 200, 'Find status code is not 200');
        $this->assertTrue(preg_match('/http:\/\/www\.example\.com/', $response->content) === 1, 'Link must exist in the generated site map');
    }
}



