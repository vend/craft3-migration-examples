<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;

/**
 * m180717_205156_section_questions migration.
 */
class m180717_205156_section_questions extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Initialize the section
        $exampleSection = new \craft\models\Section([
            "name" => "Example FAQ",
            "handle" => "exampleFAQ",
            "type" => \craft\models\Section::TYPE_CHANNEL,
            "enableVersioning" => true,
            "propagateEntries" => true,
            "siteSettings" => [
                new \craft\models\Section_SiteSettings([
                    "siteId" => Craft::$app->sites->getPrimarySite()->id,
                    "enabledByDefault" => true,
                    "hasUrls" => true,
                    "uriFormat" => "examples/{slug}",
                    "template" => "examples/_entry",
                ]),
                new \craft\models\Section_SiteSettings([
                    "siteId" => Craft::$app->sites->getSiteByHandle("us")->id,
                    "enabledByDefault" => true,
                    "hasUrls" => true,
                    "uriFormat" => "us/examples/{slug}",
                    "template" => "examples/_entry",
                ]),
                new \craft\models\Section_SiteSettings([
                    "siteId" => Craft::$app->sites->getSiteByHandle("au")->id,
                    "enabledByDefault" => true,
                    "hasUrls" => true,
                    "uriFormat" => "au/examples/{slug}",
                    "template" => "examples/_entry",
                ]),
                new \craft\models\Section_SiteSettings([
                    "siteId" => Craft::$app->sites->getSiteByHandle("nz")->id,
                    "enabledByDefault" => true,
                    "hasUrls" => true,
                    "uriFormat" => "nz/examples/{slug}",
                    "template" => "examples/_entry",
                ]),
                new \craft\models\Section_SiteSettings([
                    "siteId" => Craft::$app->sites->getSiteByHandle("uk")->id,
                    "enabledByDefault" => true,
                    "hasUrls" => true,
                    "uriFormat" => "uk/examples/{slug}",
                    "template" => "examples/_entry",
                ]),
            ],
        ]);

        // Save the section
        return (Craft::$app->sections->saveSection($exampleSection));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $section = Craft::$app->sections->getSectionByHandle("exampleFAQ");
        return (Craft::$app->sections->deleteSectionById($section->id));
    }
}
