<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_admin_hidden_until_an_admin_user_exists(): void
    {
        $this->get('/admin/booking/login')->assertNotFound();
        $this->followingRedirects()->get('/admin/booking')->assertNotFound();
    }

    public function test_admin_dashboard_redirects_to_login_when_not_authenticated(): void
    {
        User::factory()->admin()->create();

        $this->get('/admin/booking')->assertRedirect(route('admin.bookings.login'));
    }

    public function test_admin_login_page_loads_when_admin_user_exists(): void
    {
        User::factory()->admin()->create();

        $this->get('/admin/booking/login')->assertOk();
    }

    public function test_non_admin_user_cannot_access_booking_dashboard(): void
    {
        User::factory()->admin()->create();
        $regular = User::factory()->create(['is_admin' => false]);

        $this->actingAs($regular);

        $this->get('/admin/booking')->assertForbidden();
    }

    public function test_non_admin_cannot_sign_in_to_booking_admin(): void
    {
        User::factory()->admin()->create();
        $regular = User::factory()->create([
            'email' => 'member@example.com',
            'is_admin' => false,
        ]);

        $this->post('/admin/booking/login', [
            'email' => $regular->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');
    }

    public function test_admin_can_sign_in_and_confirm_and_cancel(): void
    {
        $admin = User::factory()->admin()->create([
            'email' => 'admin@example.com',
        ]);

        $this->post('/admin/booking/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ])->assertRedirect(route('admin.bookings.index'));

        $this->assertAuthenticatedAs($admin);

        $booking = Booking::query()->create([
            'name' => 'Pat',
            'email' => 'pat@example.com',
            'message' => null,
            'starts_at' => Carbon::parse('2025-04-01 17:00:00', 'UTC'),
            'ends_at' => Carbon::parse('2025-04-01 17:30:00', 'UTC'),
            'timezone' => 'UTC',
            'status' => 'pending',
        ]);

        $this->post(route('admin.bookings.confirm', $booking))->assertRedirect();
        $this->assertSame('confirmed', $booking->fresh()->status);

        $this->post(route('admin.bookings.cancel', $booking))->assertRedirect();
        $this->assertSame('cancelled', $booking->fresh()->status);
    }
}
