<?php

namespace Domain\Profiles\Actions;

use Domain\Profiles\Models\Photo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Spatie\QueueableAction\QueueableAction;

class AnalysePhoto
{
    use QueueableAction;

    public function execute(Photo $photo)
    {

        $prompt = match($photo->folder) {
            Photo::FOLDER_PIERCINGS => "Describe this piercing.",
            Photo::FOLDER_TATTOOS => "Describe this tattoo.",
            Photo::FOLDER_ACTIVITIES => "Describe activity (if any, describe 3 commonly used words), location,s sports (if any, describe 3 commonly used words), attributes (if any). ",
            default => "Describe probable descent (name only the continent and if possible a country. the json key should be 'descent'), age (rounded to 5 years, as a number), gender, activity, sports (skip this if not clearly sporting), jewelry (if any), clothing, hair color (json key:  hair)."
        };

        $prompt = $prompt . " Do not mention posing, smiling. Be super brief, just use keywords. Return JSON format with only root level keys with corresponding values. All values should be plain strings. If any of the values is 'ambiguous', 'none', or other non descriptive value, remove the key from the json response";

        try {
            file_get_contents($photo->cdn_path);
        } catch (\Exception $e) {
            $photo->delete();
            return;
        }

        $data = [
            "params" => [
                "openai_api_key" => env("OPENAI_KEY"),
                "prompt" => $prompt,
                "file_url" => $photo->cdn_path_thumb,
                "max_tokens" => 200
            ],
            "project" => "9e7ff3d3a93f-4337-9bdd-8358efeff759"
        ];

        $result = Http::post('https://api-d7b62b.stack.tryrelevance.com/latest/studios/3c618207-7cb0-416d-aaf4-2593cffa30e8/trigger_limited', $data);

        $json = $result->json("output.answer");
        $json = str_replace('```json', '', $json);
        $json = trim(str_replace('```', '', $json));

        try {
            json_decode($json);
        } catch (\Exception $e) {
            Log::error("Invalid JSON response from Relevance", [$result, $data]);
            return;
        }

        $photo->analysis = json_decode($json);
        $photo->save();

        if ($photo->photoable instanceof \Domain\Profiles\Models\Model) {
            $photo->photoable->searchable();
        }

    }
}
