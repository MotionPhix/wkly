<?php

namespace App\Http\Controllers\Projects;

use App\Data\ProjectData;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Index extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $projects = ProjectData::collect(Project::where('created_by', auth()->id())->with('author', 'contact.firm')->paginate(20));

        if ($request->wantsJson()) {

          return $projects;

        }

        return Inertia::render('Projects/Index'/*, [
            'projects' => $projects,
        ]*/);
    }
}
