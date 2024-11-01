<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Domain\Profiles\Actions\AnalysePhoto;
use Domain\Profiles\Enums\Ethnicity;
use Domain\Profiles\Enums\Gender;
use Domain\Profiles\Enums\HairColor;
use Domain\Profiles\Enums\ModelClass;
use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Photo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spekulatius\PHPScraper\PHPScraper;
use Support\PHash;

class LoadFrisseKoppen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "app:load-frisse-koppen";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Command description";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $json = \Illuminate\Support\Facades\File::json(
            storage_path("app/frisse-koppen.json")
        );

        $progressBar = $this->output->createProgressBar(count($json['data']));
        $progressBar->start();

        foreach ($json['data'] as $profile) {

            $progressBar->advance();
            if (!isset($profile['Origin URL'])) continue;

            $model = Model::firstOrNew([
                "external_id" => $profile["Origin URL"],
            ]);

            if (!!$model->id) {
                continue;
            }

            $data = $this->extractData($profile["description"]);

            $name = explode(" ", $profile["name"]);
            $model->first_name = ucwords(strtolower($name[0]), " -");

            $model->last_name = $name[1] ?? "";
            $model->ethnicity = $this->mapEthnicity($data["AFKOMST"] ?? "");
            $model->height = $data["LENGTE (CM)"] ?? null;
            $model->gender = $this->extractGender($data["GESLACHT"] ?? "");
            $model->model_class = ModelClass::Talent;
            $model->hair_color = $this->extractHairColor($data["HAARKLEUR"] ?? "");

            if (isset($data["LEEFTIJD"])) {
                $model->date_of_birth = Carbon::now()
                    ->subYears($data["LEEFTIJD"])
                    ->firstOfYear();
            }

            if (isset($data["CUPMAAT"])) {
                $model->cup_size = $data['CUPMAAT'];
            }

            if (isset($data["SCHOENMAAT"])) {
                $model->shoe_size = intval($data['SCHOENMAAT']);
            }

            if ($profile['profile_photo']) {
                $model->profile_picture = "profile_pictures/" . Str::random(40);
                Storage::put($model->profile_picture, file_get_contents($profile['profile_photo']));
            }

            $model->save();

            $this->extractPhotos($profile['Model Photos'], $model);



        }

        $progressBar->finish();
    }

    public function extractGender($input)
    {
        if ($input==="Man") return Gender::Male;
        if ($input==="Vrouw") return Gender::Female;

        return null;
    }

    public function extractData($description)
    {
        $rows = explode("\t\n", $description);

        $data = [];
        foreach ($rows as $row) {
            $parts = explode("\t", trim($row));

            if (count($parts) !== 2) {
                continue;
            }

            $data[$parts[0]] = $parts[1];
        }

        return $data;
    }

    function extractHairColor(string $input): HairColor {

        $mapping = [
            'Bruin' => HairColor::Brown,
            'Donkerbruin' => HairColor::Brown,
            'Donkerblond' => HairColor::DarkBlond,
            'Blond' => HairColor::Blond,
            'Zwart' => HairColor::Black,
            'Lichtbruin' => HairColor::Brown,
            'Grijs' => HairColor::Gray,
            'Rood' => HairColor::Red,
            'Bruin/Grijs' => HairColor::Brown,
            'Blond/Grijs' => HairColor::Blond,
            'Lichtblond' => HairColor::Blond,
            'Rossig' => HairColor::Red,
            'Roodbruin' => HairColor::Red,
            'Blond/Bruin' => HairColor::Blond,
            'Zwart/Grijs' => HairColor::Gray,
            'Blond/Rossig' => HairColor::Blond,
            'Wit' => HairColor::White,
            'Diepzwart' => HairColor::Black,
            'Blond, Rossig' => HairColor::Blond,
            'Donkerblond/Grijs' => HairColor::DarkBlond,
            'Donkerblond, Rossig' => HairColor::DarkBlond,
            'Grijs, Wit' => HairColor::Gray,
            'Rood, Rossig' => HairColor::Red,
            'Bruin, Zwart' => HairColor::Brown,
            'Roze' => HairColor::Colored,
            'Rood, Roodbruin' => HairColor::Red,
            'Blond, Blond/Bruin, Blond/Grijs' => HairColor::Blond,
        ];

        return $mapping[$input] ?? HairColor::Other;
    }

    function mapEthnicity(string $input): Ethnicity
    {
        $mapping = [
            "Westers" => Ethnicity::White,
            "Surinaams" => Ethnicity::Caribbean,
            "onbekend" => Ethnicity::Other,
            "Indisch" => Ethnicity::Asian,
            "Aziatisch" => Ethnicity::Asian,
            "Mediterraans" => Ethnicity::Mediterranean,
            "Afrikaans" => Ethnicity::Black,
            "Antilliaans" => Ethnicity::Caribbean,
            "Arabisch" => Ethnicity::MiddleEastern,
            "Indiaas" => Ethnicity::Indian,
            "Oost-Europees" => Ethnicity::White,
            "Latino" => Ethnicity::Hispanic,
            "Latina" => Ethnicity::Hispanic,
            "Moluks" => Ethnicity::Pacific,
            "Zuid-Amerikaans" => Ethnicity::Hispanic,
            "Westers/Afrikaans" => Ethnicity::White,
            "Caribisch" => Ethnicity::Caribbean,
            "Surinaams, Westers" => Ethnicity::Caribbean,
            "Indisch, Westers" => Ethnicity::Indian,
            "Afrikaans, Westers" => Ethnicity::Black,
            "Antilliaans, Westers" => Ethnicity::Caribbean,
            "Arabisch, Mediterraans" => Ethnicity::MiddleEastern,
            "Mediterraans, Oost-Europees" => Ethnicity::MiddleEastern,
            "Arabisch, Westers" => Ethnicity::MiddleEastern,
            "Indiaas, Westers" => Ethnicity::Indian,
            "Aziatisch, Indisch" => Ethnicity::Asian,
            "Antilliaans, Mediterraans" => Ethnicity::Caribbean,
            "Caribisch, Westers" => Ethnicity::Caribbean,
        ];

        return $mapping[$input] ?? Ethnicity::Other;
    }

    /**
     * @param $modelPhotos
     * @param $model
     * @return void
     */
    private function extractPhotos($modelPhotos, $model): void
    {
        $photos = [];

        foreach ($modelPhotos as $p) {
            $photos[] = $p['Photo'];
        }

        foreach ($photos as $sourcePhoto) {
            $photo = new Photo();
            $photo->photoable()->associate($model);
            $photo->folder = Photo::FOLDER_WORK_EXPERIENCE;
            $photo->path = "photos/" . Str::random(40);
            Storage::put($photo->path, file_get_contents($sourcePhoto));

            try {
                $photo->hash = (new PHash())->getHash(
                    $sourcePhoto
                );
            } catch (\Exception $e) {
                //
            }
            $photo->save();

            app(AnalysePhoto::class)->onQueue()->execute($photo);
        }
    }
}
