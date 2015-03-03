<?php namespace Modules\Media\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Modules\Media\Http\Requests\UploadMediaRequest;
use Modules\Media\Services\FileService;

class MediaController extends Controller
{
    /**
     * @var FileService
     */
    private $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UploadMediaRequest $request
     * @return Response
     */
    public function store(UploadMediaRequest $request)
    {
        $savedFile = $this->fileService->store($request->file('file'));

        if (is_string($savedFile)) {
            return Response::json(['error' => $savedFile], 409);
        }

        return Response::json($savedFile->toArray());
    }

    /**
     * Link the given entity with a media file
     * @param Request $request
     */
    public function linkMedia(Request $request)
    {
        $mediaId = $request->get('mediaId');
        $entityClass = $request->get('entityClass');
        $entityId = $request->get('entityId');

        $entity = $entityClass::find($entityId);
        $entity->files()->attach($mediaId, ['imageable_type' => $entityClass, 'zone' => $request->get('zone')]);
    }

    public function unlinkMedia(Request $request)
    {
        $mediaId = $request->get('mediaId');

    }
}
