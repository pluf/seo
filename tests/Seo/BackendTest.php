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
use Pluf\Test\TestCase;

class BackendTest extends TestCase
{

    /**
     *
     * @before
     */
    public function setUpTest()
    {
        Pluf::start(__DIR__ . '/../conf/config.php');
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
    public function testClass()
    {
        $backend = new Seo_Backend();
        $this->assertNotNull($backend);
    }

    /**
     * Create new and store
     *
     * @test
     */
    public function createBackendTest()
    {
        $backend = new Seo_Backend();
        // fill
        $backend->title = 'title';
        $backend->description = 'description';
        $backend->symbol = 'symbol';
        $backend->enable = true;
        $backend->home = 'home';
        $backend->engine = 'prerender';

        $this->assertTrue($backend->create());
        $this->assertNotNull($backend);
    }

    /**
     * Create new and delete
     *
     * @test
     */
    public function createDeleteBackendTest()
    {
        $backend = new Seo_Backend();
        // fill
        $backend->title = 'title';
        $backend->description = 'description';
        $backend->symbol = 'symbol';
        $backend->enable = true;
        $backend->home = 'home';
        $backend->engine = 'prerender';

        $this->assertTrue($backend->create());
        $this->assertNotNull($backend);
        $this->assertTrue($backend->delete());
    }

    /**
     * Meta data test
     *
     * @test
     */
    public function metaDataBackendTest()
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
        $backend->setMeta('example', 'example');
        $this->assertTrue($backend->create());
        $this->assertNotNull($backend);

        $newBackend = new Seo_Backend($backend->id);
        $this->assertNotNull($newBackend);
        $this->assertEquals($backend->getMeta('example'), $newBackend->getMeta('example'));
    }

    /**
     * Get engine test
     *
     * @test
     */
    public function getEngineTest()
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
        $backend->setMeta('example', 'example');
        $this->assertTrue($backend->create());
        $this->assertNotNull($backend);

        $engine = $backend->get_engine();
        $this->assertNotNull($engine);
    }
}

