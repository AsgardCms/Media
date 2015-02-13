<?php namespace Modules\Media\Composers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;
use Modules\Core\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group('Medias', function (SidebarGroup $group) {
            $group->enabled = false;

            $group->addItem('Medias', function (SidebarItem $item) {
                $item->route('admin.media.media.index');
                $item->icon = 'fa fa-camera';
                $item->name = 'Medias';
                $item->authorize(
                    $this->auth->hasAccess('media.media.index')
                );
            });

        });
    }
}
