<?php

namespace Nails\Analytics\Driver\Google\Settings;

use Nails\Analytics\Driver\Google\Admin\Permission;
use Nails\Common\Helper\Form;
use Nails\Common\Interfaces;
use Nails\Components\Setting;
use Nails\Environment;
use Nails\Factory;

class Google implements Interfaces\Component\Settings
{
    const KEY_PROFILE_ID   = 'profile_id';
    const KEY_AD_WORDS_ID  = 'ad_words_id';
    const KEY_ENVIRONMENTS = 'environments';

    // --------------------------------------------------------------------------

    /**
     * @inheritDoc
     */
    public function getLabel(): string
    {
        return 'Google Analytics';
    }

    // --------------------------------------------------------------------------

    /**
     * @inheritDoc
     */
    public function getPermission(): string
    {
        return Permission\Settings\Google::class;
    }

    // --------------------------------------------------------------------------

    /**
     * @inheritDoc
     */
    public function get(): array
    {
        /** @var Setting $oProfileId */
        $oProfileId = Factory::factory('ComponentSetting');
        $oProfileId
            ->setKey(static::KEY_PROFILE_ID)
            ->setLabel('Profile ID')
            ->setPlaceholder('UA-XXXXXXXX-Y')
            ->setInfo('If left blank, Google Analytics will be disabled.')
            ->setInfoClass('alert alert-warning');

        /** @var Setting $oAdWordsId */
        $oAdWordsId = Factory::factory('ComponentSetting');
        $oAdWordsId
            ->setKey(static::KEY_AD_WORDS_ID)
            ->setLabel('AdWords ID')
            ->setPlaceholder('AW-XXXXXXXXX');

        /** @var Setting $oEnvironments */
        $oEnvironments = Factory::factory('ComponentSetting');
        $oEnvironments
            ->setKey(static::KEY_ENVIRONMENTS . '[]')
            ->setLabel('Enabled On')
            ->setType(Form::FIELD_DROPDOWN_MULTIPLE)
            ->setClass('select2')
            ->setDefault([Environment::ENV_PROD])
            ->setOptions(array_combine(
                Environment::available(),
                Environment::available()
            ));

        return [
            $oProfileId,
            $oAdWordsId,
            $oEnvironments,
        ];
    }
}
