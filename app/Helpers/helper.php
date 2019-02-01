<?php

use App\Country;
use App\Note;

function getCountryIdsFromRequest(string $str = null)
{
    $temp = mb_convert_kana($str, 'as');
    $country_names = preg_split('/[\s,]+/', $temp, -1, PREG_SPLIT_NO_EMPTY);
    $country_ids = [];
    foreach ($country_names as $country_name) {
        $country = Country::firstOrCreate([
            'name' => $country_name,
        ]);
        $country_ids[] = $country->id;
    }
    return $country_ids;
}

function resizeAndSavePhotosToTempDir(array $photos, int $height)
{
    $paths = [];
    foreach ($photos as $photo)
    {
        $filename = uniqid('photo_').'.'.$photo->guessExtension();
        $path = \Image::make(file_get_contents($photo->getRealPath()));
        $path
            ->resize($height, null, function($constraint)
                {
                    $constraint->aspectRatio();
                })
            ->save(public_path().'/storage/img/tmp/'.$filename);
        $paths[] = '/img/tmp/'.$filename;
    }
    return $paths;
}

function movePhotosFromTempDirToNoteDir(array $paths, Note $note)
{
    foreach ($paths as $index => $path) 
    {
        $filename = 'photo_'.$note->id.'_'.$index.'_'.uniqid().'.'.pathinfo($path, PATHINFO_EXTENSION);
        Storage::disk('public')->move($path, '/img/note/'.$filename);
        $note->photos()->create(['path' => '/img/note/'.$filename]);
    }
}