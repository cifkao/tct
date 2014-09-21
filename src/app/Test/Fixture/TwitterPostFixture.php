<?php
/**
 * TwitterPostFixture
 *
 */
class TwitterPostFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'posts_twitter';

/**
 * Import
 *
 * @var array
 */
	public $import = array('model' => 'TwitterPost', 'records' => true);

}
