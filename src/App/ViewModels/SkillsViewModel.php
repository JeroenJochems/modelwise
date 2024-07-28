<?php

namespace App\ViewModels;

use Domain\Profiles\Models\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Tags\Tag as TagModel;

/** @typescript */
class SkillsViewModel
{
    /** @var array<Tag> */
    public Collection|array $allSkills;

    /** @var array<string> */
    public Collection|array $selectedSkills;

    public function __construct(Model|Authenticatable $model)
    {
        $this->allSkills = TagModel::query()
            ->where('type', Model::TAG_TYPE_SKILLS)
            ->orderBy('name->en')
            ->get()
            ->map(fn(TagModel $tag) => Tag::fromMode($tag))
            ->toArray();

        $this->selectedSkills = $model->tagsWithType(Model::TAG_TYPE_SKILLS)
            ->map(fn(TagModel $tag) => $tag->slug)
            ->flatten()
            ->toArray();

    }
}
