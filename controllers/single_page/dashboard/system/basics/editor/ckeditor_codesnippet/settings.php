<?php

namespace Concrete\Package\CkeditorCodesnippet\Controller\SinglePage\Dashboard\System\Basics\Editor\CkeditorCodesnippet;

use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Routing\Redirect;

final class Settings extends DashboardPageController
{
    public function view()
    {
        /** @var Repository $config */
        $config = $this->app->make(Repository::class);

        $this->set('selectedTheme', $config->get('ckeditor_codesnippet::settings.theme', 'default'));
        $this->set('initializeHighlight', (bool) $config->get('ckeditor_codesnippet::settings.initialize_highlight', true));
        $this->set('themeOptions', $this->getThemeOptions());
    }

    public function save()
    {
        if (!$this->token->validate('a3020.ckeditor_codesnippet.settings')) {
            $this->flash('error', $this->token->getErrorMessage());

            return Redirect::to('/dashboard/system/event_tracking/settings');
        }

        /** @var Repository $config */
        $config = $this->app->make(Repository::class);
        $config->save('ckeditor_codesnippet::settings.theme', $this->post('theme'));
        $config->save('ckeditor_codesnippet::settings.initialize_highlight', (bool) $this->post('initializeHighlight'));

        $this->flash('success', t('Your settings have been saved.'));

        return Redirect::to('/dashboard/system/basics/editor/ckeditor_codesnippet/settings');
    }

    /**
     * @return array
     */
    private function getThemeOptions()
    {
        $themes = [
            'arta',
            'ascetic',
            'atelier-dune.dark',
            'atelier-dune.light',
            'atelier-forest.dark',
            'atelier-forest.light',
            'atelier-heath.dark',
            'atelier-heath.light',
            'atelier-lakeside.dark',
            'atelier-lakeside.light',
            'atelier-seaside.dark',
            'atelier-seaside.light',
            'brown_paper',
            'dark',
            'default',
            'docco',
            'far',
            'foundation',
            'github',
            'googlecode',
            'idea',
            'ir_black',
            'magula',
            'mono-blue',
            'monokai',
            'monokai_sublime',
            'obsidian',
            'paraiso.dark',
            'paraiso.light',
            'pojoaque',
            'railscasts',
            'rainbow',
            'school_book',
            'solarized_dark',
            'solarized_light',
            'sunburst',
            'tomorrow',
            'tomorrow-night',
            'tomorrow-night-blue',
            'tomorrow-night-bright',
            'tomorrow-night-eighties',
            'vs',
            'xcode',
            'zenburn',
        ];

        return array_combine($themes, $themes);
    }
}
