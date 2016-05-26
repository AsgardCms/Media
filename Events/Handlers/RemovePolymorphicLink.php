<?php namespace Modules\Media\Events\Handlers;

use Illuminate\Support\Facades\DB;
use Modules\Media\Contracts\DeletingMedia;

class RemovePolymorphicLink
{
    public function handle(DeletingMedia $event)
    {
        DB::table('media__imageables')->where('imageable_id', $event->getEntityId())
            ->where('imageable_type', $event->getClassName())->delete();
    }
}
