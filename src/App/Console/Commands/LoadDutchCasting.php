<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Domain\Profiles\Enums\Ethnicity;
use Domain\Profiles\Enums\Gender;
use Domain\Profiles\Enums\HairColor;
use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Photo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Support\PHash;

class LoadDutchCasting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-dutch-casting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $json = \Illuminate\Support\Facades\File::json(storage_path('app/dutch-casting-alles.json'));

        $scrape = false;

        foreach ($json as $profile) {

            if ($profile['ID_Model'] === "aaaaa73016") {
                $scrape = true;
            }

            if (!$scrape) continue;

            $lastChange = Carbon::createFromFormat('d-m-Y', $profile['last_changed_foto']);

            if ($lastChange->isBefore(Carbon::now()->subYear(2))) {
                continue;
            }

            $model = Model::firstOrNew(['external_id' => 'https://talents.dutchcasting.nl/model/'.$profile['ID_Model']]);

            if ($model->photos()->count() > 0) {
                print "Model already exists\n";
                continue;
            }

            $profilePhoto = optional($profile['fotos'][0])['FotoURL'];

            if ($profilePhoto) {

                if ($profilePhoto==="http://foto.dutchcasting.nl/foto/wwwfotonl/172/240/web/DCA-172240-2.jpg") continue;
                if ($profilePhoto==="http://foto.dutchcasting.nl/foto/wwwfotonl/106/228/web/DCA-106228-87.jpg") continue;
                $phash = (new PHash())->getHash(
                        $profilePhoto
                );

                $photo = Photo::where('hash', $phash)->get();

                if ($photo->count() > 0) {
                    $model = $photo->first()->photoable;
                    print $profile['ID_Model']." - photo exists, belongs to ".$model->id."\n";
                    continue;
                }
            }


            $model->first_name = $profile['Voornaam'];
            $model->last_name = $profile['Achternaam_letter'];
            $model->date_of_birth = $profile['Geboortedatum'];
            $model->height = $this->emtpyToNull($profile['Lengte']);
            $model->gender = $this->mapGender($profile['Geslacht']);
            $model->clothing_size_top = $this->mapSizes($profile['Confectie']);
            $model->cup_size = $this->emtpyToNull($profile['BH']);
            $model->waist = $this->emtpyToNull($profile['Taille']);
            $model->hips = $this->emtpyToNull($profile['Heup']);
            $model->shoe_size = $this->mapShoesize($profile['Schoen']);
            $model->ethnicity = $this->mapEthnicity($profile['Look']);
            $model->hair_color = $this->mapHairColor($profile['Haarkleur']);
            $model->save();

            foreach ($profile['fotos'] as $p) {

                if ($p['FotoURL']==="http://foto.dutchcasting.nl/foto/wwwfotonl/172/240/web/DCA-172240-2.jpg") continue;
                if ($p['FotoURL']==="http://foto.dutchcasting.nl/foto/wwwfotonl/106/228/web/DCA-106228-87.jpg") continue;

                $photo = new Photo();
                $photo->photoable()->associate($model);
                $photo->folder = Photo::FOLDER_WORK_EXPERIENCE;
                $photo->path = "photos/".Str::random(40);
                Storage::put($photo->path, file_get_contents($p['FotoURL']));
                $photo->hash = (new PHash())->getHash(
                    $p['FotoURL']
                );
                $photo->save();

            }

            print "Saved model ".$model->id." - ".$profile['ID_Model'] . PHP_EOL;
        }
    }

    function mapEthnicity(string $value): Ethnicity {
        $value = strtolower($value);

        return match ($value) {
            'europees', 'zuid-europees', 'oost-europees',  => Ethnicity::White,
            'latino' => Ethnicity::Hispanic,
            'indiaas' => Ethnicity::Indian,
            'antilliaans', 'surinaams' => Ethnicity::Caribbean,
            'arabisch' => Ethnicity::MiddleEastern,
            'afrikaans' => Ethnicity::Black,
            'aziatisch' => Ethnicity::Asian,
            default => Ethnicity::Other,
        };
    }

    protected function emtpyToNull($value)
    {
        if ($value === "") return null;

        return $value;
    }

    protected function mapHairColor($color) {
        $color = strtolower(trim($color));

        if (!$color) return null;

        return match ($color) {
            'zwart', 'zwart ' => HairColor::Black,
            'bruin', 'l. bruin', 'l_bruin', 'l bruin', 'l. bruin ', 'd. bruin', 'd bruin', 'd_bruin', 'd.bruin', 'bruin-zwart' => HairColor::Brown,
            'blond', 'l blond', 'l. blond', 'l. blond ', 'blond-grijs' => HairColor::Blond,
            'd_blond', 'd blond', 'd. blond', 'd. blond ' => HairColor::DarkBlond,
            'grijs', 'grijs ', 'zwart-grijs', 'zwart-grijs ', 'grijs-wit', 'bruin-grijs', 'bruin-grijs ' => HairColor::Gray,
            'rood', 'rood ', 'rood-blond', 'rood-blond ', 'rood-bruin', 'rood-bruin ', 'rood-grijs', 'bruin-rood', 'rossig' => HairColor::Red,
            default => HairColor::Other
        };
    }


    protected function mapSizes($value)
    {
        if (!$value) return null;

        $intValue = substr($value, 0, 2);

        if (!is_numeric($intValue)) return null;


        $sizeRanges = [
            "XS"    => [32, 36],
            "S"     => [37, 40],
            "M"     => [41, 44],
            "L"     => [45, 48],
            "XL"    => [49, 52],
            "XXL"   => [53, 56],
            "XXXL"  => [57, 60]
        ];

        // Define children's sizes
        $childRanges = [
            "Child XS" => [104, 116],
            "Child S"  => [117, 128],
            "Child M"  => [129, 140],
            "Child L"  => [141, 152],
            "Child XL" => [153, 164]
        ];

        // Check for T-shirt sizes based on range
        foreach ($sizeRanges as $size => $range) {
            if ($intValue >= $range[0] && $intValue <= $range[1]) {
                return $size;
            }
        }

        // Check for children's sizes based on range
        foreach ($childRanges as $childSize => $range) {
            if ($intValue >= $range[0] && $intValue <= $range[1]) {
                return $childSize;
            }
        }

        return null;
    }

    protected function mapGender($value)
    {
        if ($value==="vrouw") return Gender::Female;
        if ($value==="man") return Gender::Male;

        return null;
    }

    protected function mapShoesize($value)
    {
        if (!$value) return null;

        return substr($value, 0, 2);
    }

    protected function mapHair($value)
    {
        return match($value) {
            'Blond' => HairColor::Blond,
        };
    }
}
