<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Companion;
use App\Models\EscrowTransaction;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoBookingSeeder extends Seeder
{
    public function run(): void
    {
        $client  = User::where('email', 'client.male@velvet.demo')->first();
        $companions = Companion::take(4)->get();

        foreach ($companions as $index => $companion) {
            $startsAt = Carbon::now()->subDays(rand(5, 30))->setHour(19)->setMinute(0);
            $hours    = rand(3, 8);
            $endsAt   = $startsAt->copy()->addHours($hours);
            $base     = $companion->hourly_rate * $hours;
            $fee      = round($base * 0.10, 2);
            $tax      = round($base * 0.12, 2);
            $total    = round($base + $fee + $tax, 2);

            $status = match ($index) {
                0 => 'completed',
                1 => 'confirmed',
                2 => 'completed',
                default => 'cancelled_client',
            };

            $booking = Booking::create([
                'reference'      => 'VH-' . strtoupper(Str::random(6)),
                'client_id'      => $client->id,
                'booking_type'   => 'companion',
                'bookable_type'  => Companion::class,
                'bookable_id'    => $companion->id,
                'starts_at'      => $startsAt,
                'ends_at'        => $endsAt,
                'duration_hours' => $hours,
                'base_amount'    => $base,
                'addons_amount'  => 0,
                'service_fee'    => $fee,
                'tax_amount'     => $tax,
                'total_amount'   => $total,
                'currency'       => 'USD',
                'status'         => $status,
                'event_details'  => ['event_type' => 'corporate', 'guest_count' => 1, 'dress_code' => 'Black Tie'],
            ]);

            // Seed payment + escrow for completed/confirmed bookings
            if (in_array($status, ['completed', 'confirmed'])) {
                $payment = Payment::create([
                    'booking_id'         => $booking->id,
                    'payer_id'           => $client->id,
                    'amount'             => $total,
                    'currency'           => 'USD',
                    'status'             => 'captured',
                    'payment_method'     => 'stripe',
                    'gateway_payment_id' => 'pi_demo_' . Str::random(20),
                    'captured_at'        => $startsAt->copy()->subDays(2),
                ]);

                $platformFee = round($total * 0.15, 2);

                EscrowTransaction::create([
                    'payment_id'           => $payment->id,
                    'booking_id'           => $booking->id,
                    'provider_id'          => $companion->user_id,
                    'held_amount'          => $total,
                    'platform_fee'         => $platformFee,
                    'provider_payout'      => round($total - $platformFee, 2),
                    'state'                => $status === 'completed' ? 'released' : 'holding',
                    'held_at'              => $startsAt->copy()->subDays(2),
                    'release_scheduled_at' => $endsAt->copy()->addHours(48),
                    'released_at'          => $status === 'completed' ? $endsAt->copy()->addDays(2) : null,
                    'stripe_transfer_id'   => $status === 'completed' ? 'tr_demo_' . Str::random(20) : null,
                ]);
            }
        }

        $this->command->info('✓ Seeded demo bookings, payments & escrow transactions');
    }
}
