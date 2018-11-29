
CREATE TABLE `seo_backend` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(200) NOT NULL DEFAULT '',
  `symbol` varchar(50) NOT NULL DEFAULT '',
  `enable` tinyint(1) NOT NULL DEFAULT 1,
  `home` varchar(100) NOT NULL DEFAULT '',
  `meta` varchar(10240) NOT NULL DEFAULT '',
  `engine` varchar(50) NOT NULL DEFAULT '',
  `priority` int(11) NOT NULL DEFAULT 10,
  `creation_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modif_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tenant` mediumint(9) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `tenant_foreignkey_idx` (`tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `seo_contents` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(2000) NOT NULL DEFAULT '',
  `url_id` varchar(150) NOT NULL DEFAULT '',
  `title` varchar(250) NOT NULL DEFAULT 'no title',
  `description` varchar(2048) NOT NULL DEFAULT 'auto created content',
  `mime_type` varchar(64) NOT NULL DEFAULT 'application/octet-stream',
  `media_type` varchar(64) NOT NULL DEFAULT 'application/octet-stream',
  `file_path` varchar(250) NOT NULL DEFAULT '',
  `file_name` varchar(250) NOT NULL DEFAULT 'unknown',
  `file_size` int(11) NOT NULL DEFAULT 0,
  `downloads` int(11) NOT NULL DEFAULT 0,
  `creation_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modif_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expire_dtime` datetime DEFAULT '0000-00-00 00:00:00',
  `tenant` mediumint(9) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url_id_unique_idx` (`tenant`,`url_id`),
  KEY `tenant_foreignkey_idx` (`tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `seo_sitemap_link` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(200) NOT NULL DEFAULT '',
  `loc` varchar(2048) NOT NULL DEFAULT '',
  `lastmod` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changefreq` varchar(16) NOT NULL DEFAULT '',
  `priority` decimal(32,8) NOT NULL DEFAULT 0.00000000,
  `tenant` mediumint(9) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `tenant_foreignkey_idx` (`tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
