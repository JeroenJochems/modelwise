<?php

namespace App\Nova;

use Datomatic\Nova\Fields\Enum\Enum;
use Domain\Models\Enums\Ethnicity;
use Domain\Models\Enums\EyeColor;
use Domain\Models\Enums\HairColor;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\VaporImage;
use Laravel\Nova\Http\Requests\NovaRequest;
use Domain\Models\Models\Model as ModelClass;
use Laravel\Nova\Panel;
use Spatie\TagsField\Tags;

class Model extends Resource
{
    public static $model = ModelClass::class;

    public static $search = [
        'first_name',
        'last_name',
        'email',
    ];

    public function title() {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function fields(NovaRequest $request)
    {
        return [
            Avatar::make('Profile picture', 'profile_picture_cdn')
                ->thumbnail(function ($value, $disk) {
                    // @phpstan-ignore-next-line
                    return $value ? $this->profile_picture_cdn."?w=720&h=720&fit=crop&crop=faces" : null;
                })
                ->path("profile_pictures")
                ->preview(function ($value, $disk) {
                    // @phpstan-ignore-next-line
                    return $value ? $this->profile_picture_cdn : null;
                })
                ->hideFromIndex()->hideFromDetail()->readonly(true)->showOnUpdating(false),
            Stack::make("Name", [
                Line::make("Name", function() { return $this->first_name." ".$this->last_name; })->asHeading(),
                Line::make("Location", function() { return $this->city.", ".$this->country; })->asSmall(),
            ])->onlyOnIndex(),
            Text::make('First Name')->sortable()->rules('required', 'max:255')->hideFromIndex(),
            Text::make('Last Name')->sortable()->rules('required', 'max:255')->hideFromIndex(),
            Date::make('Date of birth')->hideFromIndex(),
            Boolean::make('Completed onboarding', 'has_completed_onboarding')->readonly(),
            Boolean::make('Newsletter', 'is_subscribed_to_newsletter')->hideFromIndex(),
            Boolean::make('Is accepted'),
            Textarea::make("Bio")->alwaysShow()->hideFromIndex(),
            Textarea::make("Admin notes")->alwaysShow()->hideFromIndex(),
            Tags::make('Sports')->type("Sports")->withLinkToTagResource()->hideFromIndex(),
            Tags::make('Creativity')->type("Creativity")->withLinkToTagResource()->hideFromIndex(),
            VaporImage::make("Profile picture", "profile_picture")
                ->path("profile_pictures")
                ->preview(function ($value, $disk) {
                    // @phpstan-ignore-next-line
                    return $value ? $this->profile_picture_cdn : null;
                })
                ->hideFromIndex()
                ->detailWidth(300)
                ->disableDownload(),
            Text::make('Photos', function() {
                return '<div style="display: flex; width: 600px; overflow-x: scroll">
                        <img src="'.$this->profile_picture_cdn.'?w=720&h=960&fit=crop&fm=auto&crop=faces" width="90" height="120" />
                        ' .implode("", $this->photos->map(function ($photo) {
                        return '<img src="'.$photo->cdn_path.'?w=720&h=960&fit=crop&fm=auto&crop=faces" width="90" height="120" />';
                    })->toArray())
                     . '</div>';
            })->asHtml()->onlyOnIndex(),
            Text::make('Instagram')->rules('required', 'max:255')->hideFromIndex(),
            Text::make('Tiktok')->rules('required', 'max:255')->hideFromIndex(),
            Text::make('Website')->rules('required', 'max:255')->hideFromIndex(),
            new Panel('Body Characteristics', $this->bodyFields()),
            HasMany::make("Longlisted jobs")->showOnIndex(false),
            HasMany::make("Exclusive countries")->showOnIndex(false),
            HasMany::make("Photos", "photos", Photo::class)->showOnIndex(true),
        ];
    }

    public function bodyFields()
    {
        return [
            Enum::make('Ethnicity')->attach(Ethnicity::class)->hideFromIndex(),
            Enum::make('Eye color')->attach(EyeColor::class)->hideFromIndex(),
            Enum::make('Hair color')->attach(HairColor::class)->hideFromIndex(),
            Text::make("Shoe size")->help("EU format")->hideFromIndex(),
            Text::make("Chest")->help("in cm")->hideFromIndex(),
            Text::make("Waist")->help("in cm")->hideFromIndex(),
            Text::make("Hips")->help("in cm")->hideFromIndex(),
            Text::make("Height")->help("in cm")->hideFromIndex(),
        ];
    }

    public function cards(NovaRequest $request)
    {
        return [];
    }

    public function filters(NovaRequest $request)
    {
        return [];
    }

    public function lenses(NovaRequest $request)
    {
        return [];
    }

    public function actions(NovaRequest $request)
    {
        return [];
    }
}
