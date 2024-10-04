<?php

namespace App\Data;

use App\Enums\ProjectStatus;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

/** @typescript **/
class TaskData extends Data
{
  public function __construct(

    public string|Optional $tid,

    public string|Optional $id,

    public string $name,

    public string $priority,

    public string|Optional $created_at,

    public string|Optional $description,

    public string|Optional $status,

    public UserData|Optional $user,

    public UserData|Optional $assignee,

    public int|Optional $comments_count,

    public int|Optional $files_count,

    public int $board_id,

    /** @var Collection<CommentData> */
    public Collection|Optional $comments,

    public int|Optional $position,

    public int $assigned_to,

    public int|Optional $assigned_by

  ) {}

  public static function rules(): array
  {
    return [
      'name' => [
        'required',
        'min:5'
      ],

      'status' => ['sometimes', Rule::in(ProjectStatus::cases())],

      'description' => 'sometimes|min:20',

      'assigned_to' => ['required', 'exists:users,id'],

      'priority' => [
        'sometimes',
        Rule::in(['normal', 'medium', 'high'])
      ],
    ];
  }

  public static function messages()
  {
    return [
      'name.required' => 'Provide context for the task',
      'name.min' => 'The name should at least be :min characters long',

      'description.min' => 'Be a bit verbose. Describe the task better',

      'assigned_to.required' => 'Pick a person to work on the task',
      'assigned_to.exists' => 'The assigned person cannot be found',

      'priority.in' => 'The priority value must be one of :values',
    ];
  }
}
