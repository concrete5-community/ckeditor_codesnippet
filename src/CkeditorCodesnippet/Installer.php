<?php

namespace A3020\CkeditorCodesnippet;

use Concrete\Core\Application\ApplicationAwareInterface;
use Concrete\Core\Application\ApplicationAwareTrait;
use Concrete\Core\Page\Page;
use Concrete\Core\Page\Single;

final class Installer implements ApplicationAwareInterface
{
    use ApplicationAwareTrait;

    /**
     * @param \Concrete\Core\Package\Package $pkg
     */
    public function install($pkg)
    {
        $this->registerEditorPlugin();
        $this->dashboardPages($pkg);
    }

    /**
     * Add the plugin to the list of enabled CKEditor plugins.
     */
    private function registerEditorPlugin()
    {
        /** @var \Concrete\Core\Editor\PluginManager $pluginManager */
        $pluginManager = $this->app->make('editor')
            ->getPluginManager();

        /** @var \Concrete\Core\Site\Config\Liaison $config */
        $config = $this->app->make('site')->getSite()->getConfigRepository();
        $selected = $pluginManager->getSelectedPlugins();
        $selected[] = 'codesnippet';

        $config->save('editor.ckeditor4.plugins.selected', array_values($selected));
    }

     private function dashboardPages($pkg)
    {
        $pages = [
            '/dashboard/system/basics/editor/ckeditor_codesnippet' => t('CKEditor Codesnippet'),
            '/dashboard/system/basics/editor/ckeditor_codesnippet/settings' => t('Settings'),
        ];

        foreach ($pages as $path => $name) {
            /** @var Page $page */
            $page = Page::getByPath($path);
            if ($page && !$page->isError()) {
                continue;
            }

            $singlePage = Single::add($path, $pkg);
            $singlePage->update([
                'cName' => $name,
            ]);
        }
    }
}
