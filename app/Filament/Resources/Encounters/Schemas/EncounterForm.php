<?php

namespace App\Filament\Resources\Encounters\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use App\Models\ScheduleConfiguration;


class EncounterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
				Select::make('patient_id')
					->relationship(name: 'patient', titleAttribute: 'patientcode')
					->searchable() 
					->preload()
					->live()
					->afterStateUpdated(function(Set $set, $state) {
						$set('appointment.patient_id', $state);
						$set('appointment.appointment_date', null);
                        $set('appointment.appointment_time', null);
					}),
			Select::make('clinic_id')
						->relationship(name: 'clinic', titleAttribute: 'name', modifyQueryUsing: fn ($query) => $query->where('hospital_id', Auth::user()->hospital_id)->orderBy('name'))
						->searchable() 
						->preload()
						->live()
					->afterStateUpdated(fn (Set $set, $state) => $set('appointment.clinic_id', $state)),
				Section::make('Encounter information')
				->relationship('hospital')
				->schema([
					Select::make('visit_type')
					->label('Patient type')
                    ->options([
						'Outpatient' => 'Outpatient',
						'Emergency' => 'Emergency',
						'Inpatient' => 'Inpatient',
						'Referal' => 'Referal',
						'Telemedicine' => 'Telemedicine',
					])->required(),
					
										
					TextInput::make('referred_by'),
				]),
				Section::make('Appointment Information')
					->relationship('appointment') 
					->schema([
						Hidden::make('patient_id'),
						Hidden::make('clinic_id'),
						DatePicker::make('appointment_date')
						->required()
						->live()
						->minDate(now())
						->disabled(fn (Get $get) => ! $get('../clinic_id'))
						->disabledDates(function (Get $get) {
							$clinicId = $get('../clinic_id');

							if (! $clinicId) {
								return [];
							}

							$activeDays = ScheduleConfiguration::activeDaysForClinic($clinicId);

							return collect(range(0, 60))
								->map(fn ($i) => now()->addDays($i))
								->filter(fn ($date) => ! in_array($date->dayOfWeek, $activeDays))
								->map(fn ($date) => $date->format('Y-m-d'))
								->toArray();
						})
						->afterStateUpdated(fn (Set $set) => $set('appointment_time', null)),
						Select::make('appointment_time')
							->label('Time Slot')
							->options(function (Get $get) {
								$clinicId = $get('../clinic_id');
								$date = $get('appointment_date');

								if (! $clinicId || ! $date) {
									return [];
								}

								return collect(ScheduleConfiguration::getAvailableSlots($clinicId, $date))
									->mapWithKeys(fn ($slot) => [$slot => $slot])
									->toArray();
							})
							->required()
							->disabled(fn (Get $get) => ! $get('appointment_date'))
							->live(),
						
						Select::make('visit_type')
							->options([
								'New' => 'New',
								'Follow-up' => 'Follow-up',
								'Review' => 'Review',
								'Telemedicine' => 'Telemedicine',
						]),
						 Select::make('status')
                    ->options([
						'Waiting' => 'Waiting',
						'In Progress' => 'In progress',
						'Completed' => 'Completed',
						'Cancelled' => 'Cancelled',
					])
                    ->default('Waiting')
                    ->required(),
				]) ,
                
               
               
               
                
               
          
				Textarea::make('chief_complaint'),
                Textarea::make('notes'),
				 
            ]);
    }
}
