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
use PHPUnit\Framework\IncompleteTestError;

require_once 'Pluf.php';

/**
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class BackendTest extends TestCase
{
    
    /**
     * @before
     */
    public function setUpTest ()
    {
        Pluf::start(dirname(__FILE__) . '/config.php');
        $m = require dirname(__FILE__) . '/../../src/Seo/relations.php';
        $GLOBALS['_PX_models'] = array_merge($m, $GLOBALS['_PX_models']);
        $GLOBALS['_PX_config']['pluf_use_rowpermission'] = false;
        $db = Pluf::db();
        $schema = Pluf::factory('Pluf_DB_Schema', $db);
        $m1 = new Seo_Backend();
        $schema->model = $m1;
        $schema->dropTables();
        $schema->createTables();
    }
    
    /**
     * Delete all tables
     *
     * @after
     */
    protected function tearDownTest ()
    {
        $db = Pluf::db();
        $schema = Pluf::factory('Pluf_DB_Schema', $db);
        $m1 = new Seo_Backend();
        $schema->model = $m1;
        $schema->dropTables();
    }

    /**
     * @test
     */
    public function testClass ()
    {
        $backend = new Seo_Backend();
        $this->assertNotNull($backend);
    }

    /**
     * Create new and store
     *
     * @test
     */
    public function createBackendTest ()
    {
        $backend = new Seo_Backend();
        // fill
        $backend->title = 'title';
        $backend->description = 'description';
        $backend->symbol= 'symbol';
        $backend->enable= true;
        $backend->home= 'home';
        $backend->engine= 'prerender';
        
        $this->assertTrue($backend->create());
        $this->assertNotNull($backend);
    }
    
    /**
     * Create new and delete
     *
     * @test
     */
    public function createDeleteBackendTest ()
    {
        $backend = new Seo_Backend();
        // fill
        $backend->title = 'title';
        $backend->description = 'description';
        $backend->symbol= 'symbol';
        $backend->enable= true;
        $backend->home= 'home';
        $backend->engine= 'prerender';
        
        $this->assertTrue($backend->create());
        $this->assertNotNull($backend);
        $this->assertTrue($backend->delete());
    }
    
    /**
     * Meta data test
     *
     * @test
     */
    public function metaDataBackendTest ()
    {
        $backend = new Seo_Backend();
        // fill
        $backend->title = 'title';
        $backend->description = 'description';
        $backend->symbol= 'symbol';
        $backend->enable= true;
        $backend->home= 'home';
        $backend->engine= 'prerender';
        
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
    public function getEngineTest ()
    {
        $backend = new Seo_Backend();
        // fill
        $backend->title = 'title';
        $backend->description = 'description';
        $backend->symbol= 'symbol';
        $backend->enable= true;
        $backend->home= 'home';
        $backend->engine= 'prerender';
        
        // Set meta
        $backend->setMeta('example', 'example');
        $this->assertTrue($backend->create());
        $this->assertNotNull($backend);
        
        $engine = $backend->get_engine();
        $this->assertNotNull($engine);
    }
}

