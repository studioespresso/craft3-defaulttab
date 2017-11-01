<?php

namespace studioespresso\defaulttab\services;

use Craft;
use craft\base\Component;
use craft\elements\Entry;
use craft\models\Section;
use GuzzleHttp\Client;
use studioespresso\defaulttab\DefaultTab;


class DefaultTabService extends Component {

	private $pluginSettings;

	public function __construct() {
		$this->pluginSettings = DefaultTab::getInstance()->getSettings();
	}

	/**
	 * @param Section $section
	 */
	public function addTab( Section $section ) {
		$tabTitle = $this->pluginSettings->tabTitle ? $this->pluginSettings->tabTitle : Craft::t('app', 'Content');

		$entryTypes = Craft::$app->sections->getEntryTypesBySectionId( $section->id );
		foreach ( $entryTypes as $entryType ) {

			$postedFieldLayout = array( $tabTitle => array() );

			$fieldLayout       = Craft::$app->fields->assembleLayout( $postedFieldLayout );
			$fieldLayout->type = Entry::class;
			$entryType->setFieldLayout( $fieldLayout );

			if ( Craft::$app->sections->saveEntryType( $entryType ) ) {

			} else {

			}

		}

	}
}