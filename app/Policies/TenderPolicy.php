<?php 
namespace App\Policies;

use App\Models\User;
use App\Models\Customer;
use App\Models\Tender;
use Illuminate\Auth\Access\HandlesAuthorization;

class TenderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tenders.
     * Both admins and customers can view
     */
    public function viewAny($actor): bool
    {
        return true;
    }

    public function view($actor, Tender $tender): bool
    {
        return true;
    }

    /**
     * Both admin and customer can create tender
     */
    public function create($actor): bool
    {
        return true;
    }

    /**
     * Update tender
     * - Admin (User) can update any tender
     * - Customer can update only their own pending tender
     */
    public function update($actor, Tender $tender): bool
    {
        if ($actor instanceof User) {
            return true; // admin full access
        }

        if ($actor instanceof Customer) {
            return $actor->id === $tender->customer_id && $tender->status === 'pending';
        }

        return false;
    }

    public function delete($actor, Tender $tender): bool
    {
        if ($actor instanceof User) {
            return true; // admin full access
        }

        if ($actor instanceof Customer) {
            return $actor->id === $tender->customer_id && $tender->status === 'pending';
        }

        return false;
    }

    /**
     * Only admin can approve
     */
    public function approve($actor, Tender $tender): bool
    {
        return $actor instanceof User && $tender->status === 'pending';
    }

    /**
     * Only admin can reject
     */
    public function reject($actor, Tender $tender): bool
    {
        return $actor instanceof User && $tender->status === 'pending';
    }

    /**
     * Only admin can close
     */
    public function close($actor, Tender $tender): bool
    {
        return $actor instanceof User && $tender->status === 'approved';
    }
}
