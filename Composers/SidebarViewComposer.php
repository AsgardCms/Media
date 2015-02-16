<?php namespace Modules\Media\Composers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;
use Modules\Core\Composers\BaseSidebarViewComposer;

class SidebarViewComposer extends BaseSidebarViewComposer
{
    public function compose(View $view)
    {
        $view->sidebar->group(trans('core::sidebar.content'), function (SidebarGroup $group) {

            $group->addItem(trans('media::media.title.media'), function (SidebarItem $item) {
                $item->weight = 2;
                $item->icon = 'fa fa-camera';
                $item->route('admin.media.media.index');
                $item->authorize(
                    $this->auth->hasAccess('media.media.index')
                );
            });

        });
    }
}
