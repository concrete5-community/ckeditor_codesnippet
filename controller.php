<?php

namespace Concrete\Package\CkeditorCodesnippet;

use A3020\CkeditorCodesnippet\Installer;
use A3020\CkeditorCodesnippet\Provider;
use Concrete\Core\Package\Package;

final class Controller extends Package
{
    protected $pkgHandle = 'ckeditor_codesnippet';
    protected $appVersionRequired = '8.2.1';
    protected $pkgVersion = '1.0.1';
    protected $pkgAutoloaderRegistries = [
        'src/CkeditorCodesnippet' => '\A3020\CkeditorCodesnippet',
    ];

    public function getPackageName()
    {
        return t('Code for CKEditor');
    }

    public function getPackageDescription()
    {
        return t('Adds the Codesnippet plugin to CKEditor.');
    }

    public function on_start()
    {
         /** @var Provider $provider */
        $provider = $this->app->make(Provider::class);
        $provider->register();
    }

    public function install()
    {
        $pkg = parent::install();

        /** @var Installer $installer */
        $installer = $this->app->make(Installer::class);
        $installer->install($pkg);
    }
}
