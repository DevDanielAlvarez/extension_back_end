<?php

namespace App\Observers;

use App\Models\User;
use DB;

class UserObserver
{
    /**
     * Handle the User "creating" event.
     */
    public function creating(User $user): void
    {
        //check if registration_number is empty, because it might be set manually
        if (empty($user->registration_number)) {
            //set the registration number using generateUniqueRegistration method
            $user->registration_number = $this->generateUniqueRegistration();
        }
    }
    public function generateUniqueRegistration(): string
    {
        return DB::transaction(function () {

            // get current letter and number with lock
            $sequence = DB::table('registration_sequences')
                ->orderBy('letter', 'desc')
                ->lockForUpdate()
                ->first();

            //if not found, something is wrong
            if (!$sequence) {
                throw new \RuntimeException('No registration sequence found');
            }
            // increment sequence number
            $nextNumber = $sequence->current_number + 1;

            // verify if within limit
            if ($nextNumber <= 99999) {
                DB::table('registration_sequences')
                    ->where('id', $sequence->id)
                    ->update([
                        'current_number' => $nextNumber,
                        'updated_at' => now(),
                    ]);
                // return formatted registration number
                return sprintf('%s-%05d', $sequence->letter, $nextNumber);
            }

            // if exceeded, move to next letter
            if ($sequence->letter === 'Z') {
                throw new \RuntimeException('All registration numbers exhausted');
            }
            // calculate next letter
            $nextLetter = chr(ord($sequence->letter) + 1);

            // Create new sequence entry for next letter
            DB::table('registration_sequences')->insert([
                'letter' => $nextLetter,
                'current_number' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            // return formatted registration number
            return sprintf('%s-%05d', $nextLetter, 1);
        });
    }
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
