<?php
/**
 * TwitterTranslationFixture
 *
 */
class TwitterTranslationFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'translations_twitter';

/**
 * Import
 *
 * @var array
 */
	public $import = array('model' => 'TwitterTranslation', 'records' => true);

}
