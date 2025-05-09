<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HandlesMedia
{
    public array $fileTypes = ['image', 'video', 'file', 'audio'];
    public array $multipleFileTypes = ['images', 'videos', 'files', 'audios'];

    /**
     * Handle media upload for single or multiple files
     *
     * @param Request $request The incoming request containing files
     * @param Model $model The model to associate the media with
     * @param string|null $collection The media collection name (default: null)
     * @return void
     */
    public function handleMediaUpload(Request $request, Model $model, ?string $collection = null): void
    {
        $this->processFiles($request, $model, $collection, false);
        $this->processFiles($request, $model, $collection, true);
    }

    /**
     * Update media by clearing existing collection and uploading new files
     *
     * @param Request $request The incoming request containing files
     * @param Model $model The model to associate the media with
     * @param string $collection The media collection name (default: 'default')
     * @return void
     */
    public function handleMediaUpdate(Request $request, Model $model, ?string $collection = null): void
    {
        if ($request->hasAny(array_merge($this->fileTypes, $this->multipleFileTypes))) {
            $this->clearCollections($request, $model, $collection);
            $this->handleMediaUpload($request, $model, $collection);
        }
    }

    /**
     * Delete all media in a collection
     *
     * @param Model $model The model containing the media collection
     * @param string $collection The media collection name (default: 'default')
     * @return void
     */
    public function handleMediaDeletion(Model $model, string $collection = 'default'): void
    {
        $model->clearMediaCollection($collection);
    }

    /**
     * Process file uploads for single or multiple files
     *
     * @param Request $request The incoming request containing files
     * @param Model $model The model to associate the media with
     * @param string|null $collection The media collection name
     * @param bool $isMultiple Whether to process multiple files or single file
     * @return void
     */
    private function processFiles(Request $request, Model $model, ?string $collection, bool $isMultiple): void
    {
        $types = $isMultiple ? $this->multipleFileTypes : $this->fileTypes;

        foreach ($types as $type) {
            if ($request->hasFile($type)) {
                $collectionName = $collection ?? $model->getTable() . '-' . ($isMultiple ? $type : $type . 's');
                $files = $isMultiple ? $request->file($type) : [$request->file($type)];

                foreach ($files as $file) {
                    $model->addMedia($file)->toMediaCollection($collectionName);
                }
            }
        }
    }

    /**
     * Clear media collections based on request files
     *
     * @param Request $request The incoming request containing files
     * @param Model $model The model containing the media collections
     * @param string|null $collection The specific collection to clear (null clears all relevant collections)
     * @return void
     */
    private function clearCollections(Request $request, Model $model, ?string $collection): void
    {
        if ($collection) {
            $model->clearMediaCollection($collection);
            return;
        }

        $types = array_merge($this->fileTypes, $this->multipleFileTypes);

        foreach ($types as $type) {
            if ($request->hasFile($type)) {
                $collectionName = $model->getTable() . '-' . (in_array($type, $this->fileTypes) ? $type . 's' : $type);
                $model->clearMediaCollection($collectionName);
            }
        }
    }

    /**
     * Link existing media to another model
     *
     * @param Media $media of the media to link
     * @param HasMedia $targetModel Model to receive the media
     * @param string $collection Target collection name
     * @return void
     */
    public function linkExistingMedia(Media $media, HasMedia $targetModel, string $collection = 'default'): void
    {
        $media->copy($targetModel, $collection);
    }
}
