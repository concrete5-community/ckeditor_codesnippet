<?php

namespace A3020\CkeditorCodesnippet;

use Concrete\Core\Application\ApplicationAwareInterface;
use Concrete\Core\Application\ApplicationAwareTrait;
use Concrete\Core\Asset\AssetList;
use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Editor\Plugin;
use Exception;
use Psr\Log\LoggerInterface;

final class Provider implements ApplicationAwareInterface
{
    use ApplicationAwareTrait;

    /**
     * @var \Concrete\Core\Config\Repository\Repository
     */
    protected $config;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger, Repository $config)
    {
        $this->logger = $logger;
        $this->config = $config;
    }

    public function register()
    {
        try {
            $this->listeners();
            $this->registerEditorPlugin();
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }

    private function listeners()
    {
        // This is to prevent issues with C5's Composer.
        $this->app['director']->addListener('on_page_view', function($event) {
            /** @var PageView $listener */
            $listener = $this->app->make(PageView::class);
            $listener->handle($event);
        });
    }

    /**
     * Registers the 'codesnippet' plugin in CKEditor.
     *
     * @throws \Exception
     */
    private function registerEditorPlugin()
    {
        $al = AssetList::getInstance();

        $al->register(
            'javascript',
            'editor/ckeditor4/codesnippet',
            'js/plugins/codesnippet/register.js',
            [],
            'ckeditor_codesnippet'
        );

        $plugin = $this->app->make(Plugin::class);
        $plugin->setKey('codesnippet');
        $plugin->setName('Codesnippet');
        $plugin->requireAsset('javascript', 'editor/ckeditor4/codesnippet');

        /** @var \Concrete\Core\Editor\PluginManager $pluginManager */
        $pluginManager = $this->app->make('editor')
            ->getPluginManager();

        $pluginManager->register($plugin);
    }
}
