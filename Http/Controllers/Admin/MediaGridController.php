<?php namespace Modules\Media\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Media\Repositories\FileRepository;

class MediaGridController extends AdminBaseController
{
    /**
     * @var FileRepository
     */
    private $file;

    public function __construct(FileRepository $file)
    {
        parent::__construct();

        $this->file = $file;
    }

    public function index()
    {
        $files = $this->file->all();

        return view('media::admin.grid', compact('files'));
    }
}
