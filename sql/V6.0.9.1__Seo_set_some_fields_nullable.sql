
ALTER TABLE `seo_sitemap_link` CHANGE `title` `title` varchar(50) DEFAULT '';
ALTER TABLE `seo_sitemap_link` CHANGE `description` `description` varchar(200) DEFAULT '';
ALTER TABLE `seo_sitemap_link` CHANGE `lastmod` `lastmod` datetime DEFAULT '0000-00-00 00:00:00';
ALTER TABLE `seo_sitemap_link` CHANGE `changefreq` `changefreq` varchar(16) DEFAULT '';
ALTER TABLE `seo_sitemap_link` CHANGE `priority` `priority` decimal(32,8) DEFAULT '0.00000000';

