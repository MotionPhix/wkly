<?php

namespace App\Http\Controllers\Reports;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Carbon\Carbon;
use Inertia\Inertia;

class Index extends Controller
{
  public function __invoke()
  {
    $startOfWeek = Carbon::now()->startOfWeek()->startOfDay(); // Start of Monday
    $endOfWeek = Carbon::now()->startOfWeek()->addDays(4)->setHour(16)->setMinute(30)->setSecond(0); // Friday, 4:30 PM

    // Get projects with associated tasks within the weekly range
    $projects = Project::with(['contact.firm', 'boards.tasks' => function ($query) use ($startOfWeek, $endOfWeek) {
      $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
    }])
      ->whereHas('boards.tasks', function ($query) use ($startOfWeek, $endOfWeek) {
        $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
      })
      ->get();

    $reportData = $projects->map(function ($project) {

      $tasks = $project->boards->flatMap->tasks->filter(function ($task) {
        return $task->assigned_to === auth()->id();
      });

      $projectData = [
        'project_id' => $project->pid,
        'project_name' => $project->name,
        'project_contact' => $project->contact,
        'project_week' => Carbon::create($project->created_at)->week,
        'tasks' => $tasks->map(function ($task) {
          return [
            'task_id' => $task->tid,
            'task_name' => $task->name,
            'task_info' => $task->description,
            'assigned_by' => $task->assignee?->name,
            'assigned_at' => $task->created_at,
            'actual_date' => Carbon::createFromDate($task->created_at)->format('d M, Y'),
            'status' => ProjectStatus::tryFrom($task->status)?->getLabel(),
          ];
        })->values(),

        'status' => $this->getProjectStatus($tasks),
      ];

      return $projectData;

    })->values();

    return Inertia::render('Reports/Index', [
      'reportData' => $reportData,
      'weekNumber' => date('W', strtotime($startOfWeek)),
    ]);
  }

  private function getProjectStatus($tasks)
  {
    $totalTasks = $tasks->count();

    $completedTasks = $tasks->where('status', 'done')->count();
    $canceledTasks = $tasks->where('status', 'cancelled')->count();

    if ($totalTasks > 0) {
      if ($completedTasks === $totalTasks) {
        return 'completed';
      } elseif ($completedTasks > 0 || $canceledTasks > 0) {
        return 'in progress';
      } else {
        return 'cancelled';
      }
    }

    return 'not started';
  }
}
