<?php
namespace App\Filament\Pages\Tenancy;

use App\Models\Team;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;
use Carbon\Carbon;

class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return '註冊新團隊';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('團隊名稱'),
                Checkbox::make('is_admin')
                    ->label('設為管理員'),
            ]);
    }

    protected function handleRegistration(array $data): Team
    {
        $team = Team::create($data);

        $team->members()->attach(auth()->user(), ['created_at' => now(), 'updated_at' => now()]);

        return $team;
    }
}
