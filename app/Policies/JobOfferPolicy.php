<?php

namespace App\Policies;

use App\Models\JobOffer;
use App\Models\User;

class JobOfferPolicy
{
    /**
     * Determine if the user can view any job offers.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view the job offer.
     */
    public function view(User $user, JobOffer $jobOffer): bool
    {
        // Owner can always view their own offers
        if ($user->id === $jobOffer->recruteur_user_id) {
            return true;
        }

        // Anyone can view open offers
        return $jobOffer->isOpen();
    }

    /**
     * Determine if the user can create job offers.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('recruteur');
    }

    /**
     * Determine if the user can update the job offer.
     */
    public function update(User $user, JobOffer $jobOffer): bool
    {
        return $user->id === $jobOffer->recruteur_user_id;
    }

    /**
     * Determine if the user can delete the job offer.
     */
    public function delete(User $user, JobOffer $jobOffer): bool
    {
        return $user->id === $jobOffer->recruteur_user_id;
    }
}
