<?php

namespace App\ViewModels;

use Domain\Profiles\Models\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Tags\Tag as TagModel;

/** @typescript */
class ModelTagsViewModel
{
    /** @var array<Tag> */
    public Collection|array $allCategories;

    /** @var array<Tag> */
    public Collection|array $allLooks;

    /** @var array<Tag> */
    public Collection|array $allProfessions;

    /** @var array<string> */
    public Collection|array $selectedCategories;

    /** @var array<string> */
    public Collection|array $selectedLooks;

    /** @var array<string> */
    public Collection|array $selectedProfessions;

    public ?string $otherCategories;

    public function __construct(Model|Authenticatable $model)
    {
        $this->allLooks = TagModel::query()
            ->where('type', Model::TAG_TYPE_LOOKS)
            ->get()
            ->map(fn(TagModel $tag) => Tag::fromMode($tag))
            ->toArray();

        $this->allCategories = TagModel::query()
            ->where('type', Model::TAG_TYPE_MODEL_EXPERIENCE)
            ->get()
            ->map(fn(TagModel $tag) => Tag::fromMode($tag))
            ->toArray();

        $this->allProfessions = TagModel::query()
            ->where('type', Model::TAG_TYPE_PROFESSIONS)
            ->get()
            ->map(fn(TagModel $tag) => Tag::fromMode($tag))
            ->toArray();

        $this->selectedCategories = $model->tagsWithType(Model::TAG_TYPE_MODEL_EXPERIENCE)
            ->map(fn(TagModel $tag) => $tag->slug)
            ->flatten()
            ->toArray();

        $this->selectedLooks = $model->tagsWithType(Model::TAG_TYPE_LOOKS)
            ->map(fn(TagModel $tag) => $tag->slug)
            ->flatten()
            ->toArray();

        $this->selectedProfessions = $model->tagsWithType(Model::TAG_TYPE_PROFESSIONS)
            ->map(fn(TagModel $tag) => $tag->slug)
            ->flatten()
            ->toArray();

        $this->otherCategories = $model->other_categories;

    }
}
