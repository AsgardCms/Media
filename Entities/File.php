<?php namespace Modules\Media\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use Translatable;

    protected $table = 'media__files';
    public $translatedAttributes = ['description', 'alt_attribute', 'keywords'];
    protected $fillable = [
        'description',
        'alt_attribute',
        'keywords',
        'filename',
        'path',
        'extension',
        'mimetype',
        'width',
        'height',
        'filesize',
        'folder_id',
    ];
    function albums()
    {
        return $this->belongsToMany('Modules\Gallery\Entities\Album',  'gallery__album_file');
    }
    function item()
    {
        return $this->hasOne('Modules\Gallery\Entities\item');
    }
}
