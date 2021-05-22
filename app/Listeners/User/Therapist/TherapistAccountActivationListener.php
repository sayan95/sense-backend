<?php

namespace App\Listeners\User\Therapist;

use Exception;
use Throwable;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Interfaces\ITherapistService;

class TherapistAccountActivationListener
{
    private $therapistService;

    public function __construct(ITherapistService $therapistService)
    {
        $this->therapistService = $therapistService;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // set the is_active flag and verification time
        try{
            $this->therapistService->updateTherapistDetails($event->user->id, [
                'email_verified_at' => Carbon::now(),
                'is_active' => true
            ]);
        }catch(Throwable $e){
            throw $e;
        }
    }
}
