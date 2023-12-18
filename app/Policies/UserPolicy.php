<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
	/**
		* Determine whether the user can view any models.
		*/
	public function viewAny(User $user): bool
	{
		//
	}

	/**
		* Determine whether the user can view the model.
		*/
	public function view(User $user, User $model): bool
	{
		//
	}

	/**
		* Determine whether the user can create a user.
		*/
	public function create(User $user): bool
	{
		//
		return $user->isAdmin;
	}

	/**
		* Determine whether the user can update the model.
		*/
	public function update(User $user, User $model): bool
	{
		//
	}

	/**
		* Determine whether the user can delete the model.
		*/
	public function delete(User $user, User $model): bool
	{
		//
	}

	/**
		* Determine whether the user can restore the model.
		*/
	public function restore(User $user, User $model): bool
	{
		//
	}

	/**
		* Determine whether the user can permanently delete the model.
		*/
	public function forceDelete(User $user, User $model): bool
	{
		//
	}

	/**
		* Determine whether the user can update the isAdmin column.
		*/

	public function updateIsAdmin(User $user)
	{
		return $user->isAdmin;
	}


}
