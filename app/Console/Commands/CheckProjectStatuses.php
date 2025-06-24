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

            $now = \Carbon\Carbon::now();
            $deadlineCarbon = $deadline;

            if ($now->lessThanOrEqualTo($deadlineCarbon)) {
                // Upcoming deadline
                $diffInMonths = (int) ceil($now->floatDiffInMonths($deadlineCarbon));
                if ($diffInMonths >= 1 && $diffInMonths <= 2) {
                    $diffInWeeks = (int) $now->diffInWeeks($deadlineCarbon);
                    $diffInDays = (int) $now->diffInDays($deadlineCarbon);

                    if ($diffInMonths >= 1) {
                        $timeLeft = $diffInMonths . ' month' . ($diffInMonths > 1 ? 's' : '');
                    } elseif ($diffInWeeks >= 1) {
                        $timeLeft = $diffInWeeks . ' week' . ($diffInWeeks > 1 ? 's' : '');
                    } else {
                        $timeLeft = $diffInDays . ' day' . ($diffInDays > 1 ? 's' : '');
                    }

                    $title = $project->parentProject
                        ? $project->parentProject->title . ' - ' . $project->title
                        : $project->title;

                    $message = "Project {$title} is approaching its deadline in {$timeLeft} ({$deadlineCarbon->format('d-m-Y')}).";

                    sendNotification('upcoming_deadline', $message);
                }

            } elseif ($now->greaterThan($deadlineCarbon)) {
                // overdue deadline
                $overdueMonths = (int) $deadlineCarbon->diffInMonths($now);
                $overdueWeeks = (int) $deadlineCarbon->diffInWeeks($now);
                $overdueDays = (int) $deadlineCarbon->diffInDays($now);

                if ($overdueMonths >= 1) {
                    $overdueText = $overdueMonths . ' month' . ($overdueMonths > 1 ? 's' : '');
                } elseif ($overdueWeeks >= 1) {
                    $overdueText = $overdueWeeks . ' week' . ($overdueWeeks > 1 ? 's' : '');
                } else {
                    $overdueText = $overdueDays . ' day' . ($overdueDays > 1 ? 's' : '');
                }

                $title = $project->parentProject
                    ? $project->parentProject->title . ' - ' . $project->title
                    : $project->title;

                $message = "Project {$title} is overdue by {$overdueText} (Deadline was {$deadlineCarbon->format('d-m-Y')}).";

                sendNotification('overdue', $message);
            }


            // check budget status if financial status exists
            if ($project->financial_status) {
                $actual = $project->financial_status->actual;
                $planned = $project->financial_status->scheduled;
                $title = $project->parentProject ? $project->parentProject->title . ' - ' . $project->title : $project->title;

                if ($actual > $planned) {
                    $overBudgetAmount = $actual - $planned;
                    $message = "Project {$title} is over budget by {$overBudgetAmount}%.";
                    sendNotification('overbudget', $message);
                }
            }
        }

        $this->info('Project statuses checked successfully.');
    }
}
