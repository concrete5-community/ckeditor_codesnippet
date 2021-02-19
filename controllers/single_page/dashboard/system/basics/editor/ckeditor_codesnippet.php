<?php

namespace Concrete\Package\CkeditorCodesnippet\Controller\SinglePage\Dashboard\System\Basics\Editor;

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Routing\Redirect;

final class CkeditorCodesnippet extends DashboardPageController
{
    public function view()
    {
        return Redirect::to('/dashboard/system/basics/editor/ckeditor_codesnippet/settings');
    }
}
