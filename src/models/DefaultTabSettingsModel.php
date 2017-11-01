<?php

namespace studioespresso\defaulttab\models;

use craft\base\model;

/**
 * Class DefaultTabSettingsModel
 *
 * @package \studioespresso\defaulttab\models
 */
class DefaultTabSettingsModel extends Model {

	/**
	 * @var string
	 */
	public $tabTitle;

	/**
	 * @var bool
	 */
	public $hasTitleField = true;
	
}