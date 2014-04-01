
-- Create syntax for TABLE 'cachingframework_cache_smarty'
CREATE TABLE cachingframework_cache_smarty (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  identifier varchar(128) NOT NULL DEFAULT '',
  crdate int(11) unsigned NOT NULL DEFAULT '0',
  content mediumblob,
  lifetime int(11) unsigned NOT NULL DEFAULT '0',

  PRIMARY KEY (id),
  KEY cache_id (identifier)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE 'cachingframework_cache_smarty_tags'
CREATE TABLE cachingframework_cache_smarty_tags (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  identifier varchar(128) NOT NULL DEFAULT '',
  tag varchar(128) NOT NULL DEFAULT '',

  PRIMARY KEY (id),
  KEY cache_id (identifier),
  KEY cache_tag (tag)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;