<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use Carbon\Carbon;

class CheckProjectStatuses extends Command
{
    protected $signature = 'projects:check-statuses';
    protected $description = 'Check project statuses and send notifications for upcoming deadlines, overbudget, and overdue projects';

    public function handle()
    {
        $projects = Project::with(['rkn', 'financial_status'])->get();

        foreach ($projects as $project) {
            // check deadline status
            if ($project->rkn && $project->rkn->endDate) {
                $deadline = Carbon::parse($project->rkn->endDate);
            } else {
                $handover = Carbon::parse($project->handoverDate);
                $fyStartYear = $handover->month < 4 ? $handover->year : $handover->year + 1;
                $fyStart = Carbon::create($fyStartYear, 4, 1);
                $deadline = $fyStart->copy()->addYears(5)->subDay();
            }

            $now = Carbon::now();
            $diffInMonths = floor($now->diffInMonths($deadline, false));

            // send upcoming deadline notification if deadline is 2 months away
            if ($diffInMonths == 2) {
                $message = "Project {$project->title} has an upcoming deadline in 2 months ({$deadline->format('d-m-Y')}).";
                sendNotification('upcoming_deadline', $message);
            }

            // send overdue notification if project is past deadline
            if ($diffInMonths < 0) {
                $message = "Project {$project->title} is overdue. Deadline was {$deadline->format('d-m-Y')}.";
                sendNotification('overdue', $message);
            }

            // check budget status if financial status exists
            if ($project->financial_status) {
                $actual = $project->financial_status->actual;
                $planned = $project->financial_status->planned;

                if ($actual > $planned) {
                    $overBudgetAmount = $actual - $planned;
                    $message = "Project {$project->title} is over budget by {$overBudgetAmount}.";
                    sendNotification('overbudget', $message);
                }
            }
        }

        $this->info('Project statuses checked successfully.');
    }
}
