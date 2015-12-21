<?php namespace Modules\Media\Support\Traits;

trait MediaRelation
{
    /**
     * Make the Many To Many Morph To Relation
     * @return object
     */
    public function files()
    {
        return $this->morphToMany('Modules\Media\Entities\File', 'imageable', 'media__imageables')->withPivot('zone', 'id')->withTimestamps()->orderBy('order');
    }
}
