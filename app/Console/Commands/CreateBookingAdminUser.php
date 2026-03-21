<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateBookingAdminUser extends Command
{
    protected $signature = 'booking:create-admin {email : Admin email address} {name? : Display name}';

    protected $description = 'Create a user (or promote an existing one) for booking admin at /admin/booking';

    public function handle(): int
    {
        $email = strtolower(trim($this->argument('email')));
        $name = trim((string) ($this->argument('name') ?: Str::before($email, '@')));

        if ($name === '') {
            $this->error('Name is required if the email has no local part.');

            return self::FAILURE;
        }

        $existing = User::query()->where('email', $email)->first();

        if ($existing) {
            $existing->forceFill([
                'name' => $name,
                'is_admin' => true,
            ])->save();
            $this->info("{$email} is now a booking admin.");

            if ($this->confirm('Set a new password for this user?', false)) {
                $password = $this->secret('New password');
                $confirm = $this->secret('Confirm password');
                if ($password !== $confirm) {
                    $this->error('Passwords do not match.');

                    return self::FAILURE;
                }
                if (strlen($password) < 8) {
                    $this->error('Use at least 8 characters.');

                    return self::FAILURE;
                }
                $existing->update(['password' => $password]);
                $this->info('Password updated.');
            }

            return self::SUCCESS;
        }

        $password = $this->secret('Password');
        $confirm = $this->secret('Confirm password');
        if ($password !== $confirm) {
            $this->error('Passwords do not match.');

            return self::FAILURE;
        }
        if (strlen($password) < 8) {
            $this->error('Use at least 8 characters.');

            return self::FAILURE;
        }

        User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'is_admin' => true,
        ]);

        $this->info("Created booking admin: {$email}");

        return self::SUCCESS;
    }
}
