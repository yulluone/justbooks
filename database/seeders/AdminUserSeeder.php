<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;


class AdminUserSeeder extends Seeder
{
	/**
		* Run the database seeds.
		*/
	public function run(): void
	{
		User::create([
			'name' => 'Admin',
			'email' => 'admin@justbooks.com',
			'password' => Hash::make('Seol11@3'),
			'isAdmin' => true,
		]);
	}
}
