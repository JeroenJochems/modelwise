<?php

namespace App\Http\Controllers;

use Domain\Leads\Models\Lead;
use Support\User;

class ContactController extends Controller
{
    public function store()
    {
        $lead = new Lead();
        $lead->phone = request()->get("phone");
        $lead->email = request()->get("email");
        $lead->first_name = request()->get("first_name");
        $lead->last_name = request()->get("last_name");
        $lead->save();

        foreach(User::get() as $user) {
            $user->notify(new \App\Notifications\Admin\LeadCreated($lead));
        }

        return redirect()->back();
    }
}
