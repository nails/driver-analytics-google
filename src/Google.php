<?php

namespace Nails\Analytics\Driver;

use Nails\Analytics\Driver\Google\Settings;
use Nails\Analytics\Interfaces;
use Nails\Common\Driver\Base;
use Nails\Common\Service\Asset;
use Nails\Environment;
use Nails\Factory;

class Google extends Base implements Interfaces\Driver
{
    /**
     * @return \Nails\Analytics\Interfaces\Driver
     * @throws \Nails\Common\Exception\AssetException
     * @throws \Nails\Common\Exception\FactoryException
     */
    public function boot(): Interfaces\Driver
    {
        $aEnvironment = $this->getSetting(Settings\Google::KEY_ENVIRONMENTS);
        if (!in_array(Environment::get(), $aEnvironment)) {
            return $this;
        }

        /** @var Asset $oAsset */
        $oAsset = Factory::service('Asset');

        $sProfileId = trim($this->getSetting(Settings\Google::KEY_PROFILE_ID));
        $sAdWordsId = trim($this->getSetting(Settings\Google::KEY_AD_WORDS_ID));

        if (!empty($sProfileId)) {
            $oAsset
                //  Google Tag Manager
                ->load(
                    'https://www.googletagmanager.com/gtag/js?id=' . $sProfileId,
                    null,
                    $oAsset::TYPE_JS_HEADER,
                    true
                )
                ->inline(
                    "window.dataLayer = window.dataLayer || [];
                    function gtag() {dataLayer.push(arguments);}
                    gtag('js', new Date());
                    gtag('config', '" . $sProfileId . "');",
                    $oAsset::TYPE_JS_INLINE_HEADER
                );
        }

        if (!empty($sProfileId) && !empty($sAdWordsId)) {
            $oAsset
                ->inline(
                    "gtag('config', '" . $sAdWordsId . "');",
                    $oAsset::TYPE_JS_INLINE_HEADER
                );
        }

        return $this;
    }
}
