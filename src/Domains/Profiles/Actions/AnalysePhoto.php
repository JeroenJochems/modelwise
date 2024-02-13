<?php

namespace Domain\Profiles\Actions;

use Domain\Profiles\Models\Photo;
use Illuminate\Support\Facades\Http;
use Spatie\QueueableAction\QueueableAction;

class AnalysePhoto
{
    use QueueableAction;

    public function execute(Photo $photo)
    {
        $prompt = match($photo->folder) {
            Photo::FOLDER_PIERCINGS => "Describe this piercing. Be super brief, just use keywords. Return comma separated.",
            Photo::FOLDER_TATTOOS => "Describe this tattoo. Be super brief, just use keywords. Return comma separated.",
            Photo::FOLDER_ACTIVITIES => "Describe activity (if any, describe 3 commonly used words), sports (if any, describe 3 commonly used words), attributes (if any). Be super brief, just use keywords. Return comma separated.",
            default => "Describe probable descent (name only the continent/country), activity, sports (skip this if not clearly sporting), attributes (if any), clothing, hair. Be super brief, just use keywords. Return comma separated."
        };

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

        ray($result->json());

        $result = $result->json("output.answer");
        $result = str_replace("```json", "", $result);
        $result = str_replace("```", "", $result);


        $photo->analysis = trim($result);
        $photo->save();

        if ($photo->photoable instanceof \Domain\Profiles\Models\Model) {
            $photo->photoable->searchable();
        }

    }
}
