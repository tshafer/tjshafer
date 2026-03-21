<?php

namespace App\Services;

use App\Models\Booking;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

class BookingSlotService
{
    public function timezone(): string
    {
        return config('booking.timezone', 'America/Phoenix');
    }

    /**
     * @return Collection<int, array{startUtc: CarbonImmutable, endUtc: CarbonImmutable, label: string, dateKey: string}>
     */
    public function availableSlots(): Collection
    {
        $tz = $this->timezone();
        $slotMinutes = max(15, (int) config('booking.slot_minutes', 30));
        $horizonDays = max(1, (int) config('booking.horizon_days', 14));
        $minNoticeHours = max(0, (int) config('booking.min_notice_hours', 4));

        $nowLocal = CarbonImmutable::now($tz);
        $earliestStart = $this->roundUpToSlotBoundary(
            $nowLocal->addHours($minNoticeHours),
            $slotMinutes
        );

        $endHorizon = $nowLocal->addDays($horizonDays)->endOfDay();

        $windows = config('booking.windows', []);
        $slots = collect();

        for ($day = $nowLocal->startOfDay(); $day->lte($endHorizon); $day = $day->addDay()) {
            $isoDow = (int) $day->isoWeekday();

            foreach ($windows as $window) {
                $days = $window['days'] ?? [];
                if (! in_array($isoDow, $days, true)) {
                    continue;
                }

                $startStr = $window['start'] ?? '09:00';
                $endStr = $window['end'] ?? '17:00';

                $windowStart = CarbonImmutable::parse($day->format('Y-m-d').' '.$startStr, $tz);
                $windowEnd = CarbonImmutable::parse($day->format('Y-m-d').' '.$endStr, $tz);

                for ($t = $windowStart; $t->lt($windowEnd); $t = $t->addMinutes($slotMinutes)) {
                    $slotEnd = $t->addMinutes($slotMinutes);
                    if ($slotEnd->gt($windowEnd)) {
                        break;
                    }

                    if ($t->lt($earliestStart)) {
                        continue;
                    }

                    $startUtc = $t->utc();
                    $endUtc = $slotEnd->utc();

                    if ($this->slotIsBooked($startUtc, $endUtc)) {
                        continue;
                    }

                    $label = $t->format('g:i A').' – '.$slotEnd->format('g:i A').' '.$tz;
                    $dateKey = $t->format('Y-m-d');

                    $slots->push([
                        'startUtc' => $startUtc,
                        'endUtc' => $endUtc,
                        'label' => $label,
                        'dateKey' => $dateKey,
                    ]);
                }
            }
        }

        return $slots->values();
    }

    /**
     * @return Collection<string, Collection<int, array{startUtc: CarbonImmutable, endUtc: CarbonImmutable, label: string, dateKey: string}>>
     */
    public function slotsGroupedByDate(): Collection
    {
        return $this->availableSlots()->groupBy('dateKey');
    }

    public function slotIsBooked(CarbonImmutable $startUtc, CarbonImmutable $endUtc): bool
    {
        return Booking::query()
            ->blocking()
            ->where('starts_at', '<', $endUtc->toDateTimeString())
            ->where('ends_at', '>', $startUtc->toDateTimeString())
            ->exists();
    }

    public function isSlotBookable(Carbon $startUtc, Carbon $endUtc): bool
    {
        $start = CarbonImmutable::instance($startUtc)->utc();
        $end = CarbonImmutable::instance($endUtc)->utc();

        if ($end->lte($start)) {
            return false;
        }

        $expectedMinutes = (int) config('booking.slot_minutes', 30);
        if ((int) $start->diffInMinutes($end) !== $expectedMinutes) {
            return false;
        }

        if ($this->slotIsBooked($start, $end)) {
            return false;
        }

        $allowed = $this->availableSlots()->first(function (array $slot) use ($start, $end) {
            return $slot['startUtc']->equalTo($start) && $slot['endUtc']->equalTo($end);
        });

        return $allowed !== null;
    }

    private function roundUpToSlotBoundary(CarbonImmutable $t, int $slotMinutes): CarbonImmutable
    {
        $t = $t->setMicrosecond(0);
        if ((int) $t->format('s') > 0) {
            $t = $t->addMinute()->startOfMinute();
        }
        $m = (int) $t->format('i');
        $rem = $m % $slotMinutes;
        if ($rem !== 0) {
            $t = $t->addMinutes($slotMinutes - $rem);
        }

        return $t->startOfMinute();
    }
}
