<?php

namespace App\Console\Commands;

use App\Models\Car;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Moves car photos that predate the media library (the legacy `image` column)
 * into Spatie Media Library so they get thumbnails.
 */
class ImportCarPhotos extends Command
{
    protected $signature = 'cars:import-photos {--regenerate : Rebuild the conversions of cars that already have a photo}';

    protected $description = 'Import legacy car photos into the media library and build their thumbnails';

    public function handle(): int
    {
        $imported = 0;

        Car::query()->with('media')->each(function (Car $car) use (&$imported) {
            if ($car->hasMedia(Car::PHOTO)) {
                if ($this->option('regenerate')) {
                    $this->call('media-library:regenerate', ['--ids' => $car->getFirstMedia(Car::PHOTO)->id, '--force' => true]);
                }

                return;
            }

            $legacy = (string) $car->image;

            if ($legacy === '' || Str::startsWith($legacy, ['http://', 'https://'])) {
                return;
            }

            if (Str::startsWith($legacy, Car::IMAGE_DIRECTORY.'/')) {
                $disk = Storage::disk(Car::IMAGE_DISK);

                if (! $disk->exists($legacy)) {
                    $this->warn("  {$car->title}: file {$legacy} not found, skipped");

                    return;
                }

                $car->addMedia($disk->path($legacy))->preservingOriginal()->toMediaCollection(Car::PHOTO);
                $car->deleteImageFile();     // the media library now owns the file
                $car->update(['image' => null]);
            } else {
                $file = public_path(ltrim($legacy, '/'));

                if (! is_file($file)) {
                    $this->warn("  {$car->title}: file {$legacy} not found, skipped");

                    return;
                }

                // bundled demo images stay where they are
                $car->addMedia($file)->preservingOriginal()->toMediaCollection(Car::PHOTO);
                $car->update(['image' => null]);
            }

            $imported++;
            $this->line("  {$car->title}: imported");
        });

        $this->info("Done: {$imported} photo(s) imported.");

        return self::SUCCESS;
    }
}
