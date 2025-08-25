<?php

namespace App\Jobs;

use App\User;
use App\Mail\AccountActivation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendActivationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 60;

    protected $user;
    protected $activationUrl;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param string $activationUrl
     * @return void
     */
    public function __construct(User $user, $activationUrl)
    {
        $this->user = $user;
        $this->activationUrl = $activationUrl;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Mail::to($this->user->email)->send(new AccountActivation($this->user, $this->activationUrl));
            \Log::info('Activation email sent to: ' . $this->user->email);
        } catch (\Exception $e) {
            \Log::error('Failed to send activation email to: ' . $this->user->email . ' Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(\Throwable $exception)
    {
        \Log::error('Failed to send activation email to: ' . $this->user->email . ' Error: ' . $exception->getMessage());
    }
}