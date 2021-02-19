<?php

namespace A3020\CkeditorCodesnippet;

use Concrete\Core\Asset\Asset;
use Concrete\Core\Asset\AssetList;
use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Http\ResponseAssetGroup;
use Concrete\Core\Logging\Logger;
use Exception;

final class PageView
{
    /**
     * @var Repository
     */
    private $config;

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Repository $config, Logger $logger)
    {
        $this->config = $config;
        $this->logger = $logger;
    }

    public function handle($event)
    {
        try {
            $this->loadAssets();
        } catch (Exception $e) {
            $this->logger->addDebug($e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    private function loadAssets()
    {
        $theme = $this->config->get('ckeditor_codesnippet::settings.theme', 'default');

        $al = AssetList::getInstance();

        $al->register(
            'css',
            'editor/ckeditor4/codesnippet',
            'js/plugins/codesnippet/lib/highlight/styles/'. $theme . '.css',
            [
                'position' => Asset::ASSET_POSITION_FOOTER,
            ],
            'ckeditor_codesnippet'
        );

        $al->register(
            'javascript',
            'editor/ckeditor4/codesnippet',
            'js/plugins/codesnippet/lib/highlight/highlight.pack.js',
            [
                'position' => Asset::ASSET_POSITION_FOOTER,
            ],
            'ckeditor_codesnippet'
        );

        // Load the CSS and JavaScript for Highlight.
        $assetGroup = ResponseAssetGroup::get();
        $assetGroup->requireAsset('css', 'editor/ckeditor4/codesnippet');
        $assetGroup->requireAsset('javascript', 'editor/ckeditor4/codesnippet');

        // Initialize Highlight.
        if ((bool) $this->config->get('ckeditor_codesnippet::settings.initialize_highlight', true)) {
            $assetGroup->addFooterAsset('<script>document.addEventListener("DOMContentLoaded", function(event) { hljs.initHighlightingOnLoad(); })</script>');
        }
    }
}
