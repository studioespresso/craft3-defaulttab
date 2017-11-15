<?php
/**
 * @copyright Copyright (c) 2017 Studio Espresso
 */

namespace studioespresso\defaulttab;

use craft;
use craft\events\FieldLayoutEvent;
use craft\events\SectionEvent;
use craft\models\EntryType;
use craft\services\Sections;
use studioespresso\defaulttab\models\DefaultTabSettingsModel;
use studioespresso\defaulttab\services\DefaultTabService;
use yii\base\Event;

/**
 * Plugin represents the Default Tab plugin.
 *
 * @author Studio Espresso <support@studioespresso.co>
 * @since  1.0
 */
class DefaultTab extends \craft\base\Plugin
{

    /**
     * @var \studioespresso\defaulttab\Plugin Plugin instance
     */
    public static $plugin;

    /**
     * @var bool
     */
    public $hasCpSettings = true;

    public function init()
    {
        self::$plugin = $this;
        Event::on(
            Sections::class,
            Sections::EVENT_AFTER_SAVE_SECTION,
            function (SectionEvent $section) {
                if ($section->isNew) {
                    $service = new DefaultTabService();
                    $service->addTab($section->section);
                }
            }
        );
    }

    /**
     * Creates and returns the model used to store the plugin’s settings.
     *
     * @return \craft\base\Model|null
     */
    protected function createSettingsModel()
    {
        return new DefaultTabSettingsModel();
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     * @throws \Twig_Error_Loader
     * @throws \RuntimeException
     */
    protected function settingsHtml(): string
    {
        Craft::$app->fields->getAllGroups();
        $fieldGroups = [];
        foreach (Craft::$app->fields->getAllGroups() as $group) {
            $fieldGroups[$group->id] = $group->name;
        }
        return Craft::$app->view->renderTemplate('defaulttab/settings', [
            'settings' => $this->getSettings(),
            'fieldGroups' => $fieldGroups,
        ]);
    }
}
