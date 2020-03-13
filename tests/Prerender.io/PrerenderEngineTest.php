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
use PHPUnit\Framework\TestCase;

require_once 'Pluf.php';

/**
 *
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class PrerenderEngineTest extends TestCase
{

    /**
     *
     * @before
     */
    public function setUpTest()
    {
        Pluf::start(dirname(__FILE__) . '/../conf/config.php');
        $m = new Pluf_Migration();
        $m->install();
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
    public function testClass()
    {
        $engine = new Seo_Engine_Prerender();
        $this->assertNotNull($engine);
    }

    /**
     *
     * @test
     */
    public function testRenderPage()
    {
        $backend = new Seo_Backend();
        // fill
        $backend->title = 'title';
        $backend->description = 'description';
        $backend->symbol = 'symbol';
        $backend->enable = true;
        $backend->home = 'home';
        $backend->engine = 'prerender';

        // Set meta
        $backend->setMeta('token', 'cf5U32kkvddysVwLjj2a');
        $backend->setMeta('url', 'http://service.prerender.io');
        $this->assertTrue($backend->create());
        $this->assertNotNull($backend);

        // http request
        $query = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REMOTE_ADDR'] = 'not set';
        $_SERVER['HTTP_HOST'] = 'localhost.com';
        $GLOBALS['_PX_uniqid'] = 'example';

        $request = new Pluf_HTTP_Request($query);
        $request->tenant = new Pluf_Tenant();
        $request->REQUEST['_escaped_fragment_'] = '/submit/2/11';

        // empty view
        $request->view = array(
            'ctrl' => array()
        );

        $seoRequest = new Seo_Request($request);
        $seoRequest->request = $request;
        $page = $backend->render($seoRequest);
        $this->assertNotNull($page);
    }
}

