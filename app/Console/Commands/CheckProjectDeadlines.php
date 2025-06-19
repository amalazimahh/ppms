<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckProjectDeadlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-project-deadlines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Log::info('CheckProjectDeadlines command started');

        $now = \Carbon\Carbon::now();
        // Eager load the rkn relationship
        $projects = \App\Models\Project::with(['projectTeam', 'rkn'])->get();

        foreach ($projects as $project) {
            $deadline = $project->rkn ? $project->rkn->endDate : null;

            \Log::info('Project deadline value', [
                'id' => $project->id,
                'title' => $project->title,
                'deadline' => $deadline
            ]);

            if (!$deadline) continue;

            $deadlineCarbon = \Carbon\Carbon::parse($deadline);
            $diffInMonths = (int) $now->diffInMonths($deadlineCarbon, false);
            $diffInWeeks = (int) $now->diffInWeeks($deadlineCarbon, false);
            $diffInDays = (int) $now->diffInDays($deadlineCarbon, false);

            if ($diffInMonths >= 1) {
                $timeLeft = $diffInMonths . ' month' . ($diffInMonths > 1 ? 's' : '');
            } elseif ($diffInWeeks >= 1) {
                $timeLeft = $diffInWeeks . ' week' . ($diffInWeeks > 1 ? 's' : '');
            } else {
                $timeLeft = $diffInDays . ' day' . ($diffInDays > 1 ? 's' : '');
            }

            // Overdue
            if ($now->greaterThan($deadlineCarbon)) {
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

                \Log::info("Matched overdue", [
                    'project' => $project->title,
                    'now' => $now->toDateTimeString(),
                    'deadline' => $deadlineCarbon->toDateTimeString(),
                    'overdueText' => $overdueText
                ]);
                sendNotification(
                    'overdue',
                    "Project '{$project->title}' is overdue by {$overdueText}.",
                    ['Admin', 'Project Manager', 'Executive'],
                    $project->projectTeam->pluck('officer_in_charge')->toArray()
                );
            }
            // Upcoming
            elseif ($diffInMonths > 0 && $diffInMonths <= 2) {
                \Log::info("Matched upcoming", ['project' => $project->title, 'months' => $diffInMonths]);
                sendNotification(
                    'upcoming_deadline',
                    "Project '{$project->title}' is approaching its deadline in {$timeLeft}.",
                    ['Admin', 'Project Manager', 'Executive'],
                    $project->projectTeam->pluck('officer_in_charge')->toArray()
                );
            }
        }
    }
}
