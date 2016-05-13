<?php namespace Modules\Media\Events\Handlers;

use Modules\Media\Contracts\StoringMedia;
use Modules\Media\Image\Imagy;
use Modules\Media\Repositories\FileRepository;
use Modules\Media\Services\FileService;

class HandleMediaStorage
{
    /**
     * @var FileService
     */
    private $fileService;
    /**
     * @var FileRepository
     */
    private $file;
    /**
     * @var Imagy
     */
    private $imagy;

    public function __construct(FileService $fileService, FileRepository $file, Imagy $imagy)
    {
        $this->fileService = $fileService;
        $this->file = $file;
        $this->imagy = $imagy;
    }

    public function handle(StoringMedia $event)
    {
        $entity = $event->getEntity();
        $zone = $this->getZoneFrom($event->getSubmissionData());
        $postMedias = $this->getPostedMediasFrom($event->getSubmissionData());
        $orders = $this->getOrdersFrom($event->getSubmissionData());

        foreach ($postMedias as $key => $fileId) {
            $order = array_search($fileId, $orders);
            $entity->files()->attach($fileId, ['imageable_type' => get_class($entity), 'zone' => $zone, 'order' => $order]);
        }
    }

    private function getZoneFrom(array $submissionData)
    {
        return array_get($submissionData, 'zone');
    }

    private function getPostedMediasFrom(array $submissionData)
    {
        return array_get($submissionData, 'medias', []);
    }

    private function getOrdersFrom(array $submissionData)
    {
        $orderString = array_get($submissionData, 'orders');

        return explode(',', $orderString);
    }
}
