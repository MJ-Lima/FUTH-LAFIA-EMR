<?php

namespace App\Filament\Resources\ScheduleConfigurations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Components\Utilities\Set;
use App\Models\ScheduleConfiguration;

class ScheduleConfigurationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 Select::make('clinic_id')
					->label('Clinic')
					->relationship(
						name: 'clinic',
						titleAttribute: 'name',
						modifyQueryUsing: fn ($query) => $query->where('status', true)->orderBy('name'))
					->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} ({$record->code})")
					->searchable(['name', 'code'])
					->preload()
					->required(),

				Select::make('day_of_week')
					->options(ScheduleConfiguration::daysOfWeek())
					->required(),

				TimePicker::make('start_time')->required(),
				TimePicker::make('end_time')->required(),

				TextInput::make('slot_duration_minutes')
					->numeric()
					->default(30)
					->suffix('minutes')
					->required(),

				Toggle::make('is_active')->default(true),
            ]);
    }
}
