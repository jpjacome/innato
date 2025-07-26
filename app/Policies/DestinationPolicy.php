<?php
namespace App\Policies;

use App\Models\Destination;
use App\Models\User;

class DestinationPolicy
{
    /**
     * Determine if the user can update the destination.
     */
    public function update(User $user, Destination $destination)
    {
        // Allow if user is admin
        if ($user->role === 'admin') {
            return true;
        }
        // Allow if user is editor and assigned to this destination
        if ($user->role === 'editor' && $user->destination_id === $destination->id) {
            return true;
        }
        return false;
    }
}
