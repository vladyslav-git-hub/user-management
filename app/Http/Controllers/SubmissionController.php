<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubmissionRequest;
use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SubmissionController extends Controller
{

    public function store(StoreSubmissionRequest $request)
    {
        $submission = Submission::create($request->only([
            'name', 'email', 'phone', 'message', 'street', 'state', 'zip', 'country'
        ]));

        // Store images
        if ($request->hasFile('images')) {
            // helper function persent in app/Helpers/helper.php
            $submission->images = uploadFile($request->file('images'), 'Files', 'images', true);
        }

        // Store files
        if ($request->hasFile('files')) {
            // helper function persent in app/Helpers/helper.php
            $submission->files = uploadFile($request->file('files'), 'Files', 'pdfs');
        }

        $submission->save();

        return response()->json(['message' => 'Submission saved successfully!'], 200);
    }
}
