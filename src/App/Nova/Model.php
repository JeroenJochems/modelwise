<?php

namespace App\Nova;

use App\Nova\Actions\ApplyForRole;
use App\Nova\Actions\CreateApplication;
use App\Nova\Actions\InviteForRole;
use App\Nova\Filters\AgeFilter;
use Datomatic\Nova\Fields\Enum\Enum;
use Domain\Profiles\Enums\Ethnicity;
use Domain\Profiles\Enums\EyeColor;
use Domain\Profiles\Enums\Gender;
use Domain\Profiles\Enums\HairColor;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Email;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\VaporImage;
use Laravel\Nova\Http\Requests\NovaRequest;
use Domain\Profiles\Models\Model as ModelClass;
use Laravel\Nova\Panel;
use Spatie\TagsField\Tags;

class Model extends Resource
{
    public static $model = ModelClass::class;

    public function title()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public static $search = [
        'first_name',
        'last_name',
    ];


    public static function perPageOptions()
    {
        return [200];
    }

    public function fields(NovaRequest $request)
    {
        return [
            Avatar::make('Profile picture', 'profile_picture_cdn')
                ->thumbnail(function ($value, $disk) {
                    // @phpstan-ignore-next-line
                    return $value ? $this->profile_picture_cdn : null;
                })
                ->path("profile_pictures")
                ->preview(function ($value, $disk) {
                    // @phpstan-ignore-next-line
                    return $value ? $this->profile_picture_cdn : null;
                })
                ->hideFromIndex()->hideFromDetail()->readonly(true)->showOnUpdating(false),
            Stack::make("Name", [
                Line::make("Name", function () {
                    return $this->first_name . " " . $this->last_name;
                })->asHeading(),
                Line::make("Location", function () {
                    return $this->city . ", " . $this->country;
                })->asSmall(),
                Line::make("Phone number", function () {
                    return $this->phone_number;
                })->asSmall(),
                Line::make("Whatsapp number", function () {
                    return $this->whatsapp_number;
                })->asSmall(),
            ])->onlyOnIndex(),

            Text::make('First Name')->sortable()->rules('required', 'max:255')->hideFromIndex(),
            Text::make('Last Name')->sortable()->rules('required', 'max:255')->hideFromIndex(),
            Text::make('Phone number')->rules('required', 'max:255')->hideFromIndex(),
            Text::make('WhatsApp number')->rules('max:255')->hideFromIndex(),
            Email::make('Email')->sortable()->required()->rules('required', 'email')->hideFromIndex(),
            Enum::make('Gender')->displayUsingLabels()->attach(Gender::class)->filterable()->rules('required', 'max:255')->hideFromIndex(),
            Select::make('Preferred language')->options(['en' => 'English', 'nl' => 'Nederlands'])->rules('required')->hideFromIndex(),
            Date::make('Date of birth')->hideFromIndex(),
            Boolean::make('Completed onboarding', 'has_completed_onboarding')->readonly(),
            Boolean::make('Newsletter', 'is_subscribed_to_newsletter')->hideFromIndex(),
            Boolean::make('Is accepted'),
            Textarea::make("Bio")->alwaysShow()->hideFromIndex(),
            Textarea::make("Admin notes")->alwaysShow()->hideFromIndex(),
            Tags::make('Modeling experience')->type(ModelClass::TAG_TYPE_MODEL_EXPERIENCE)->withLinkToTagResource()->hideFromIndex(),
            Tags::make('Other professions')->type(ModelClass::TAG_TYPE_PROFESSIONS)->withLinkToTagResource()->hideFromIndex(),
            VaporImage::make("Profile picture", "profile_picture")
                ->path(
                    "profile_pictures")
                ->preview(fn() => $this->profile_picture_cdn)
                ->hideFromIndex()
                ->hideFromDetail()
                ->detailWidth(300)
                ->disableDownload(),
            Text::make('Photos', function () {
                return '<div style="display: flex; width: 600px; height: 120px; overflow-x: scroll; overflow-y: hidden">
                        <img src="' . $this->profile_picture_cdn . '" height="120" />
                        ' . implode("", $this->photos->map(function ($photo) {
                        return '<img src="' . $photo->cdn_path_thumb . '" height="120" />';
                    })->toArray())
                    . '</div>';
            })->asHtml()->onlyOnIndex(),
            Text::make('Photo preview', function () {
                return '<div style="display: flex; height: 400px; overflow-x: scroll; overflow-y: hidden">
                        <img src="' . $this->profile_picture_cdn_thumb . '" height="120" />
                        ' . implode("", $this->photos->map(function ($photo) {
                        return '<img src="' . $photo->cdn_path_thumb . '" height="120" />';
                    })->toArray())
                    . '</div>';
            })->asHtml()->hideFromIndex(),
            Text::make('Instagram')->rules( 'max:255')->hideFromIndex()->copyable(),
            Text::make('Tiktok')->rules( 'max:255')->hideFromIndex()->copyable(),
            Text::make('Website')->rules('max:255')->hideFromIndex()->copyable(),
            new Panel('Body Characteristics', $this->bodyFields()),
            HasMany::make("Applications")->showOnIndex(false),
            HasMany::make("Invites")->showOnIndex(false),
            HasMany::make("Exclusive countries")->showOnIndex(false),
            MorphMany::make("Photos", "photos", Photo::class)->showOnIndex(true),
        ];
    }

    public function bodyFields()
    {
        return [
            Enum::make('Ethnicity')->attach(Ethnicity::class)->nullable()->filterable()->hideFromIndex(),
            Enum::make('Eye color')->attach(EyeColor::class)->nullable()->filterable()->hideFromIndex(),
            Enum::make('Hair color')->attach(HairColor::class)->nullable()->filterable()->hideFromIndex(),
            Number::make("Shoe size")->help("EU format")->nullable()->filterable()->hideFromIndex(),
            Number::make("Chest")->help("in cm")->filterable()->hideFromIndex(),
            Number::make("Waist")->help("in cm")->filterable()->hideFromIndex(),
            Number::make("Hips")->help("in cm")->filterable()->hideFromIndex(),
            Number::make("Height")->help("in cm")->filterable()->hideFromIndex(),
            Text::make("Cup size")->hideFromIndex()->filterable(),
        ];
    }

    public function cards(NovaRequest $request)
    {
        return [
        ];
    }

    public function filters(NovaRequest $request)
    {
        return [
            AgeFilter::make()->range(0,75),
        ];
    }

    public function lenses(NovaRequest $request)
    {
        return [];
    }

    public function actions(NovaRequest $request)
    {
        return [
            new InviteForRole(),
            new ApplyForRole(),
        ];
    }
}
