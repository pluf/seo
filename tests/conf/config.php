<?php

// -------------------------------------------------------------------------
// Database Configurations
// -------------------------------------------------------------------------
$cfg = include 'sqlite.conf.php';

$cfg['test'] = true;
$cfg['debug'] = true;
$cfg['timezone'] = 'Europe/Berlin';
$cfg['installed_apps'] = array(
    'Pluf',
    'User',
    'Seo'
);
$cfg['mimetype'] = 'text/html';
$cfg['app_base'] = '/testapp';
$cfg['url_format'] = 'simple';
$cfg['upload_path'] = '/tmp';
$cfg['tmp_folder'] = '/tmp';
$cfg['middleware_classes'] = array(
    '\Pluf\Seo\Middleware\Render',
    '\Pluf\Middleware\Session',
    'User_Middleware_Session'
);
$cfg['secret_key'] = '5a8d7e0f2aad8bdab8f6eef725412850';

// -------------------------------------------------------------------------
// Template manager and compiler
// -------------------------------------------------------------------------
$cfg['template_folders'] = array(
    __DIR__ . '/../../templates', // /vendor/pluf/seo/templates
    __DIR__ . '/../templates'
);
$cfg['template_tags'] = array(
    'mytag' => 'Pluf_Template_Tag_Mytag'
);
$cfg['template_modifiers'] = array();

// -------------------------------------------------------------------------
// Logger
// -------------------------------------------------------------------------
$cfg['log_level'] = 'error';
$cfg['log_delayed'] = false;
$cfg['log_formater'] = '\Pluf\LoggerFormatter\Plain';
$cfg['log_appender'] = '\Pluf\LoggerAppender\Console';

// -------------------------------------------------------------------------
// Tenants
// -------------------------------------------------------------------------
// $cfg['tenant_notfound_url'] = 'https://pluf.ir/wb/blog/page/how-config-notfound-tenant';
// $cfg['multitenant'] = false;

// -------------------------------------------------------------------------
// user
// -------------------------------------------------------------------------

$cfg['user_account_auto_activate'] = true;
$cfg['user_avatar_default'] = __DIR__ . '/avatar.svg';

// -------------------------------------------------------------------------
// SEO
// -------------------------------------------------------------------------
//
// Enable default prerender engine
//
// A prerender to use with all tenants if there is not render configuration.
//
// $cfg['seo_prerender_default_enable'] = false;

// $cfg['seo_prerender_default_engine'] = 'global';

// $cfg['seo_prerender_default_period'] = '+7 days';

// $cfg['seo_prerender_default_pattern'] = '.*';

// $cfg['seo_prerender_global_url'] = 'localhost';

return $cfg;
