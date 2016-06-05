<?php namespace Modules\Media\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Image\Facade\Imagy;
use Modules\Media\ValueObjects\MediaPath;

/**
 * Class File
 * @package Modules\Media\Entities
 * @property \Modules\Media\ValueObjects\MediaPath path
 */
class File extends Model
{
    use Translatable;
    /**
     * All the different images types where thumbnails should be created
     * @var array
     */
    private $imageExtensions = ['jpg', 'png', 'jpeg', 'gif'];

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
    protected $appends = ['path_string'];

    public function getPathAttribute($value)
    {
        return new MediaPath($value);
    }

    public function getPathStringAttribute()
    {
        return (string) $this->path;
    }

    public function isImage()
    {
        return in_array(pathinfo($this->path, PATHINFO_EXTENSION), $this->imageExtensions);
    }

    public function getThumbnail($type)
    {
        if ($this->isImage() && $this->getKey()) {
            return Imagy::getThumbnail($this->path, $type);
        }

        return false;
    }
}
