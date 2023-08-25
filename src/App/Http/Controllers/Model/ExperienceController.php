<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ExperienceController extends Controller
{
    public function index()
    {
        return Inertia::render("Model/Onboarding/ProfessionalExperience");
    }
}
