<?php namespace Modules\Media\Http\Controllers\Admin;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Laracasts\Flash\Flash;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Media\Entities\File;
use Modules\Media\Http\Requests\UpdateMediaRequest;
use Modules\Media\Image\Imagy;
use Modules\Media\Repositories\FileRepository;

class MediaController extends AdminBaseController
{
    /**
     * @var FileRepository
     */
    private $file;
    /**
     * @var Repository
     */
    private $config;
    /**
     * @var Imagy
     */
    private $imagy;

    public function __construct(FileRepository $file, Repository $config, Imagy $imagy)
    {
        $this->file = $file;
        $this->config = $config;
        $this->imagy = $imagy;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $files = $this->file->all();

        $config = $this->config->get('media::config');

        return View::make('media::admin.index', compact('files', 'config'));
    }

    public function gridFiles()
    {
        $files = $this->file->all();

        return View::make('media::admin.grid', compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return \View::make('media.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  File     $file
     * @return Response
     */
    public function edit(File $file)
    {
        return View::make('media::admin.edit', compact('file'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  File               $file
     * @param  UpdateMediaRequest $request
     * @return Response
     */
    public function update(File $file, UpdateMediaRequest $request)
    {
        $this->file->update($file, $request->all());

        Flash::success(trans('media::messages.file updated'));

        return Redirect::route('dashboard.media.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  File     $file
     * @internal param int $id
     * @return Response
     */
    public function destroy(File $file)
    {
        $this->imagy->deleteAllFor($file);
        $this->file->destroy($file);

        Flash::success(trans('media::messages.file deleted'));

        return Redirect::route('dashboard.media.index');
    }
}
