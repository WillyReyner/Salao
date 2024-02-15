<?php

namespace Database\Factories;

use App\Models\TickedNotification;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TickedNotificationFactory extends Factory
{
	protected $model = TickedNotification::class;

	public function definition(): array
	{
		return [
			'read' => $this->faker->boolean(),
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),

			'ticket_id' => Ticket::factory(),
			'user_id' => User::factory(),
		];
	}
}
