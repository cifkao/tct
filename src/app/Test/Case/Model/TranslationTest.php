<?php
App::uses('Translation', 'Model');

/**
 * Translation Test Case
 *
 */
class TranslationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.translation',
		'app.translation_request',
		'app.post',
		'app.lang',
		'app.translator',
		'app.twitter_post',
		'app.twitter_translation',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Translation = ClassRegistry::init('Translation');
		$this->TranslationRequest = ClassRegistry::init('TranslationRequest');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Translation);
		unset($this->TranslationRequest);

		parent::tearDown();
	}

/**
 * testUrls method
 *
 * @return void
 */
  public function testUrls() {
    $url = "http://www.example.com/blah";
    $post = $this->Translation->Post->add("This is my post. " . $url, $this->Translation->Lang->toId('en'));
    $req = $this->TranslationRequest->add($post['Post']['id'], 'cs', false);

    $translation = $this->Translation->add("Toto je můj příspěvek.", $req['TranslationRequest']['id'], 0);
    $this->assertEquals($translation['Translation']['text'], "Toto je můj příspěvek. " . $url);

    $translation = $this->Translation->add("Toto je můj příspěvek." . $url, $req['TranslationRequest']['id'], 0);
    $this->assertEquals($translation['Translation']['text'], "Toto je můj příspěvek." . $url);
	}

}
