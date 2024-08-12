<?php

namespace Domain\Profiles\Actions;

use Domain\Profiles\Models\Photo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;
use Spatie\QueueableAction\QueueableAction;

class AnalysePhoto
{
    use QueueableAction;

    public function execute(Photo $photo)
    {
        $prompt = match($photo->folder) {
            Photo::FOLDER_PIERCINGS => "Describe this piercing. Use these json keys: 'location', 'type', 'material'.",
            Photo::FOLDER_TATTOOS => "Describe this tattoo. Use these json keys: 'location', 'type', 'style', 'color'.",
            Photo::FOLDER_ACTIVITIES => "Describe activity (if any, describe 3 commonly used words), location, sports (if any, describe 3 commonly used words), attributes (if any). ",
            default => "Describe the following json:

            {
                'descent': 'chinese, black, caucasian, hispanic, middle eastern, native american, pacific islander, south asian, other',
                'skin color': 'light, mediterranian, medium, dark',
                'activity': 'if any',
                'sports': 'if any',
                'jewelry': 'if any',
                'clothing': '',
                'hair': 'Describe color, broad description of style, and if the person has a beard or moustache, describe it. If no facial hair, do not mention it.'
            }
           "
        };

        $prompt = $prompt . " Do not mention posing, smiling. Be super brief, just use keywords. Return JSON format with only root level keys with corresponding values. All values should be plain strings. If any of the values is 'ambiguous', 'none', or other non descriptive value, remove the key from the json response.";

        $path = $photo->cdn_path."?w=1200&fm=jpg&q=80";

        try {
            ray($path, $prompt);
            $result = OpenAI::chat()->create([
                'model' => 'gpt-4-turbo',
                'messages' => [
                    ['role' => 'user', 'content' =>
                        [
                            ['type' => "text", "text" => $prompt],
                            ['type' => "image_url", "image_url" => ["url" => $path]],
                        ]
                    ]
                ],
            ]);

            $json = $result->choices[0]->message->content;
            $json = str_replace("```json\n", "", $json);
            $json = str_replace("\n```", "", $json);

            $photo->analysis = json_decode($json);
            $photo->save();

            if ($photo->photoable instanceof \Domain\Profiles\Models\Model) {
                $photo->photoable->searchable();
            }
        } catch (\Exception $e) {
            Log::error("Analyse photo {$photo->id}: {$e->getMessage()}");
        }
    }
}
