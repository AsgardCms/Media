<?php namespace Modules\Media\Validators;

use Illuminate\Validation\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MaxFolderSizeValidator extends Validator
{
    public function validateMaxSize($attribute, UploadedFile $value, $parameters)
    {
        $mediaPath = public_path(config('asgard.media.config.files-path'));
        $folderSize = `du -s $mediaPath`;
        preg_match('/([0-9]+)/', $folderSize, $match);

        return ($match[0] + $value->getSize()) < config('asgard.media.config.max-total-size');
    }
}
