<?php 
class AppSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $admins = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'password' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

	public $auth_tokens = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'hash' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'key' => 'unique', 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'translator_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'unique'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'translator_id' => array('column' => 'translator_id', 'unique' => 1),
			'hash' => array('column' => 'hash', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

	public $browsers = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'hash' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'key' => 'unique', 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'user_agent' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'ip_address' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 16, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'hash' => array('column' => 'hash', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

	public $langs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 5, 'key' => 'index', 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8mb4_general_ci', 'comment' => 'English name of the language', 'charset' => 'utf8mb4'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'code' => array('column' => 'code', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

	public $posts = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'text' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'lang_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'created' => array('column' => 'created', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

	public $posts_twitter = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'Same as posts.id'),
		'tweet_id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index', 'comment' => 'Twitter status id'),
		'author_id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index', 'comment' => 'Twitter user id'),
		'author_screen_name' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => 'Twitter user screen_name', 'charset' => 'utf8mb4'),
		'retweet_id' => array('type' => 'biginteger', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'Twitter status id of retweet'),
		'my_retweet_id' => array('type' => 'biginteger', 'null' => true, 'default' => null, 'unsigned' => false, 'comment' => 'Twitter status id of TCT retweet'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'key' => 'index', 'comment' => 'Twitter created_at'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'created' => array('column' => 'created', 'unique' => 0),
			'author_id' => array('column' => 'author_id', 'unique' => 0),
			'tweet_id' => array('column' => 'tweet_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

	public $scorings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'translation_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'hash' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'key' => 'index', 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'user_hash' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'result' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'skipped' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'hash' => array('column' => 'hash', 'unique' => 0),
			'translation_id' => array('column' => 'translation_id', 'unique' => 0),
			'created' => array('column' => 'created', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

	public $settings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'key' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'value' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

	public $translation_requests = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'post_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'tgt_lang_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'hash' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'key' => 'index', 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'accepted_translation_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'hash' => array('column' => 'hash', 'unique' => 0),
			'created' => array('column' => 'created', 'unique' => 0),
			'post_id' => array('column' => 'post_id', 'unique' => 0),
			'tgt_lang_id' => array('column' => 'tgt_lang_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

	public $translations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'text' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'post_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'translator_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'lang_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'translation_request_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'browser_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'avg_score' => array('type' => 'float', 'null' => true, 'default' => null, 'unsigned' => false),
		'scoring_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'created' => array('column' => 'created', 'unique' => 0),
			'lang_id' => array('column' => 'lang_id', 'unique' => 0),
			'post_id' => array('column' => 'post_id', 'unique' => 0),
			'translator_id' => array('column' => 'translator_id', 'unique' => 0),
			'translation_request_id' => array('column' => 'translation_request_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

	public $translations_twitter = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary', 'comment' => 'Same as translations.id'),
		'tweet_id' => array('type' => 'biginteger', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => false, 'comment' => 'Twitter status id'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'created' => array('column' => 'created', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

	public $translators = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'activated' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'vacation' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'email' => array('column' => 'email', 'unique' => 1),
			'activated' => array('column' => 'activated', 'unique' => 0),
			'vacation' => array('column' => 'vacation', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

	public $translators_src_langs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'translator_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'lang_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'translator_id' => array('column' => 'translator_id', 'unique' => 0),
			'lang_id' => array('column' => 'lang_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

	public $translators_tgt_langs = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'translator_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'lang_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'translator_id' => array('column' => 'translator_id', 'unique' => 0),
			'lang_id' => array('column' => 'lang_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

}
