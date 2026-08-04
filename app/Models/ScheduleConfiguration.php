<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class ScheduleConfiguration extends Model
{
    protected $fillable = ['clinic_id', 'day_of_week', 'start_time', 'end_time', 'slot_duration_minutes', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public static function daysOfWeek(): array
    {
        return [
            0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday',
            4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday',
        ];
    }

    public static function getAvailableSlots(int $clinicId, string $date, ?int $excludeAppointmentId = null): array
    {
        $carbonDate = Carbon::parse($date);

        $config = static::where('clinic_id', $clinicId)
            ->where('day_of_week', $carbonDate->dayOfWeek)
            ->where('is_active', true)
            ->first();

        if (! $config) {
            return [];
        }

        $start = Carbon::parse($date . ' ' . $config->start_time);
        $end = Carbon::parse($date . ' ' . $config->end_time);

        $slots = [];
        while ($start->lt($end)) {
            $slots[] = $start->format('H:i');
            $start->addMinutes($config->slot_duration_minutes);
        }

        $booked = Appointment::where('clinic_id', $clinicId)
            ->whereDate('appointment_date', $date)
            ->when($excludeAppointmentId, fn ($q) => $q->where('id', '!=', $excludeAppointmentId))
            ->pluck('appointment_time')
            ->map(fn ($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();

        return array_values(array_diff($slots, $booked));
    }

    public static function activeDaysForClinic(int $clinicId): array
    {
        return static::where('clinic_id', $clinicId)
            ->where('is_active', true)
            ->pluck('day_of_week')
            ->toArray();
    }
}