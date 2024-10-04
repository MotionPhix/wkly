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
    $endOfWeek = Carbon::now()->startOfWeek()->addWeek()->subDay()->setHour(16)->setMinute(30)->setSecond(0); // Friday, 4:30 PM

    // Get projects with associated tasks within the weekly range
    /*$projects = Project::with(['contact.firm', 'boards.tasks' => function ($query) use ($startOfWeek, $endOfWeek) {

      $sql = $query->toSql();

      dd($sql);

      $startOfWeekend = Carbon::now()->startOfWeek()->addDays(5)->startOfDay(); // Start of Saturday
      $endOfWeekend = Carbon::now()->startOfWeek()->addDays(6)->endOfDay(); // End of Sunday

      // $query->whereBetween('created_at', [$startOfWeek, $endOfWeek])
      // $query->whereBetween('created_at', [$startOfWeekend, $endOfWeekend])
      $query->whereBetween('created_at', [Carbon::THURSDAY, Carbon::yesterday()])
        ->selectRaw('DATE(created_at) as date, COUNT(*) as task_count')
        ->groupBy('date')
        ->orderBy('date', 'asc');

    }])->get();*/

    $projects = Project::with(['contact.firm', 'boards.tasks'])
      ->whereHas('boards.tasks', function ($query) use ($startOfWeek, $endOfWeek) {

        // $query->where('tasks.created_at', '=', Carbon::yesterday());
        $query->whereBetween('tasks.created_at', [$startOfWeek, $endOfWeek]);

      })
      ->get();

    $reportData = [];

    foreach ($projects as $project) {
      $projectData = [
        'project_id' => $project->pid,
        'project_name' => $project->name,
        'project_contact' => $project->contact,
        'project_week' => Carbon::create($project->created_at)->week,
        'tasks' => []
      ];

      foreach ($project->boards as $board) {
        foreach ($board->tasks as $task) {
          // Filter tasks assigned to the current user
          if ($task->assigned_to === auth()->id()) {
            $projectData['tasks'][] = [
              'task_id' => $task->tid,
              'task_name' => $task->name,
              'task_info' => $task->description,
              'assigned_by' => $task?->assignee?->name,
              'assigned_at' => $task->created_at,
              'actual_date' => Carbon::createFromDate($task->created_at)->format('d M, Y'),
              'status' => ProjectStatus::tryFrom($task->status)->getLabel(),
            ];
          }
        }
      }

      // Determin project status
      $projectData['status'] = $this->getProjectStatus($projectData['tasks']);

      $reportData[] = $projectData;
    }

    return Inertia::render('Reports/Index', [

      'reportData' => $reportData,
      'weekNumber' => date('W', strtotime($startOfWeek)),

    ]);
  }

  private function getProjectStatus($tasks)
  {
    $totalTasks = count($tasks);

    $completedTasks = collect($tasks)->where('status', 'done')->count();
    $canceledTasks = collect($tasks)->where('status', 'cancelled')->count();

    if (!!$totalTasks) {

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
