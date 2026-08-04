<?php

namespace App\Filament\Resources\Patients\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Facades\Auth;
use App\Models\State;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
					Step::make('Personal information')
						->schema([
							Grid::make()
							->columns(2)
							->schema([
								TextInput::make('firstname')
                    ->required()->columnOrder(2),
                TextInput::make('middlename')
                    ->required()->columnOrder(3),
                TextInput::make('lastname')
                    ->required()
					->columnOrder(1)->label('Surname'),
                DatePicker::make('dob')
                    ->required()->columnOrder(4),
				Select::make('gender')
					->label('Gender')
					->options([
						'male' => 'Male',
						'female' => 'Female',
					])
					->preload()
					->required()->columnOrder(5),
				Select::make('bloodgroup')
					->label('Blood Group')
					->options([
						'A+'  => 'A+',
						'A-'  => 'A-',
						'B+'  => 'B+',
						'B-'  => 'B-',
						'AB+' => 'AB+',
						'AB-' => 'AB-',
						'O+'  => 'O+',
						'O-'  => 'O-',
					])
					->preload()->columnOrder(6),
                Select::make('genotype')
					->label('Genotype')
					->options([
						'AA' => 'AA',
						'AS' => 'AS',
						'AC' => 'AC',
						'SS' => 'SS',
						'SC' => 'SC',
						'CC' => 'CC',
					])
					->preload()->columnOrder(7),
				Select::make('marital')
					->label('Marital status')
					->options([
						'single' => 'Single',
						'married' => 'Married',
						'divorced' => 'Divorced',
						'widowed' => 'Widowed',
					])
					->preload()
					->required()->columnOrder(8),
				Select::make('religion')
					->label('Religion')
					->options([
						'Christianity' => 'Christianity',
						'Islam' => 'Islam',
						'Traditional ' => 'Traditional ',
					])
					->preload()
					->required()->columnOrder(9),
							])
						]),
					Step::make('Contact information')
						->schema([
							
		Grid::make()
			->columns(2)
			->schema([
				TextInput::make('occupation'),
				TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('phonemain')
					->label('Phone no. (main)')
                    ->tel()
                    ->required(),
                TextInput::make('phonealt')
                    ->tel()
					->label('Phone no. (alternate)'),
                Textarea::make('address')
                    ->columnSpanFull(),
				 TextInput::make('country')
                    ->required(),
				Select::make('state')
					->label('State')
					->options(fn () => State::pluck('name', 'state_id')->toArray())
					->searchable(),
				TextInput::make('city')
                    ->required(),
                TextInput::make('postalcode'),
			])
							
						]),
					Step::make('Next of Kin information')
						->schema([
							Grid::make()
								->columns(2)
								->schema([
									TextInput::make('nokname')
										->required()
										->label('Next of Kin Full name'),
									TextInput::make('relationship')
										->required()
										->label('Next of Kin Relationship.'),
									TextInput::make('nokphone')
										->tel()
										->label('Next of Kin Phone no.')
										->required(),
									Textarea::make('nokaddress')
										->required()
										->label('Next of Kin Address'),
									TextInput::make('hereabout')->label('How did you hear about us?'),
									Textarea::make('notes')->label('Notes'),
									Toggle::make('status')
										->label('Active status')
										->visible(fn () => Auth::user()->can('Disable:Patient')),
								])
						]),
				])->columnSpanFull(),
            ]);
    }
}
