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
	    $title = $this->pluginSettings->tabTitle ? Craft::$app->view->renderObjectTemplate($this->pluginSettings->tabTitle, ['section' => $section])  : Craft::t('app', 'Content');
		$tabTitle =  $title;

		$entryTypes = Craft::$app->sections->getEntryTypesBySectionId( $section->id );
		foreach ( $entryTypes as $entryType ) {

			$postedFieldLayout = array( $tabTitle => array() );

			if ( is_array( $this->pluginSettings->defaultGroups ) ) {
				foreach ( $this->pluginSettings->defaultGroups as $groupId ) {
					$fieldGroup        = Craft::$app->fields->getGroupById( $groupId );
					$fieldGroupFields  = Craft::$app->fields->getFieldsByGroupId( $groupId );
					$fieldGroupFields  = array_map( function ( $field ) {
						return $field->id;
					}, $fieldGroupFields );
					$postedFieldLayout = array_merge( $postedFieldLayout, [ $fieldGroup->name => $fieldGroupFields ] );
				}
			}

			$fieldLayout       = Craft::$app->fields->assembleLayout( $postedFieldLayout );
			$fieldLayout->type = Entry::class;
			$entryType->setFieldLayout( $fieldLayout );
			if($this->pluginSettings->hasTitleField) {
				$entryType->hasTitleField = true;
			}

			if ( Craft::$app->sections->saveEntryType( $entryType ) ) {

			} else {

			}

		}

	}
}