<?php

namespace SMW\Tests;

use SMW\Tests\Util\PageCreator;
use SMW\Tests\Util\PageDeleter;

use SMW\Setup;

use Title;
use UnexpectedValueException;

/**
 * @ingroup Test
 *
 * @group SMW
 * @group SMWExtension
 * @group Database
 * @group medium
 *
 * @licence GNU GPL v2+
 * @since 1.9.0.1
 *
 * @author mwjames
 */
abstract class MwDBSQLStoreIntegrationTestCase extends MwDBaseUnitTestCase {

	/**
	 * In order for the test not being influenced by an exisiting setup
	 * registration we temporary remove from the GLOBALS configuration
	 * in order to enable hook and context assignment freely during testing
	 */
	private $wgHooks = array();

	protected function setUp() {
		parent::setUp();

		$this->wgHooks = $GLOBALS['wgHooks'];
		$GLOBALS['wgHooks'] = array();
	}

	protected function tearDown() {
		$GLOBALS['wgHooks'] = $this->wgHooks;

		parent::tearDown();
	}

	protected function runExtensionSetup( $context, $directory = 'Foo' ) {
		$setup = new Setup( $GLOBALS, $directory, $context );
		$setup->run();
	}

	protected function getStore() {

		$store = parent::getStore();

		if ( !( $store instanceof \SMWSQLStore3 ) ) {
			$this->markTestSkipped( 'Test only applicable for SMWSQLStore3' );
		}

		return $store;
	}

	protected function createPage( Title $title, $editContent = '' ) {
		$pageCreator = new PageCreator();
		$pageCreator->createPage( $title, $editContent );
	}

	protected function deletePage( Title $title ) {
		$pageCreator = new PageDeleter();
		$pageCreator->deletePage( $title );
	}

}