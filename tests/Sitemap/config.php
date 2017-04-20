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

$cfg = array();

// Set the debug variable to true to force the recompilation of all
// the templates each time during development
$cfg['debug'] = true;

// If your models are using models from applications outside of the
// base objects of the framework, you need to list them here. 
// You need to include the name of the current application.
$cfg['installed_apps'] = array('Pluf', 'Seo');

// Base URL of the application. Note that it is not something like
// 'root_base' not to overwrite the base of another application when
// several application are running on the same host. 
// No / at the end.
$cfg['todo_base'] = '/~loa/todo/index';

// View file of the Todo application. They can be hardcoded in the 
// Dispatcher, but it is often better to have them in a separated file
// for readability.
$cfg['todo_urls'] = dirname(__FILE__).'/urls.php';

// Temporary folder where the script is writing the compiled templates,
// cached data and other temporary resources.
// It must be writeable by your webserver instance.
// It is mandatory if you are using the template system.
$cfg['tmp_folder'] = dirname(__FILE__).'/../tmp';

// The folder in which the templates of the application are located.
$cfg['template_folders'] = array(dirname(__FILE__).'/../templates');

// Default mimetype of the document your application is sending.
// It can be overwritten for a given response if needed.
$cfg['mimetype'] = 'text/html';

$cfg['template_tags'] = array();

// Default database configuration. The database defined here will be
// directly accessible from Pluf::db() of course it is still possible
// to open any other number of database connections through Pluf_DB
$cfg['db_login'] = '';
$cfg['db_password'] = '';
$cfg['db_server'] = '';
$cfg['db_database'] = $cfg['tmp_folder'].'/site-map.db';
$cfg['db_table_prefix'] = ''; 

// Starting version 4.1 of MySQL the utf-8 support is "correct".
// The reason of the db_version for MySQL is only for that.
$cfg['db_version'] = '';
$cfg['db_engine'] = 'SQLite';
return $cfg;
