SHOW CREATE TABLE users;

| users | CREATE TABLE `users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `first_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `email_address` varchar(50) DEFAULT NULL,
  `joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `email_address` (`email_address`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 |

SHOW CREATE TABLE stories;

| stories | CREATE TABLE `stories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `link` varchar(100) NOT NULL,
  `posted_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `likes` int(11) NOT NULL,
  `img_url` varchar(100) NOT NULL,
  `validate` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=latin1 |

SHOW CREATE TABLE comments

| comments | CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `story_id` int(10) unsigned NOT NULL,
  `user_id` mediumint(8) unsigned NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `posted_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `story_id` (`story_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_comment_story_id` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_comment_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1 |

SHOW CREATE TABLE likes

| likes | CREATE TABLE `likes` (
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `story_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`story_id`),
  KEY `likes_ibfk_2` (`story_id`),
  CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 |

SHOW CREATE TABLE bookmarks

| bookmarks | CREATE TABLE `bookmarks` (
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `story_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`story_id`),
  KEY `bookmarks_ibfk_2` (`story_id`),
  CONSTRAINT `bookmarks_ibfk_2` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `bookmarks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 |

SHOW CREATE TABLE user_roles

| user_roles | CREATE TABLE `user_roles` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 |