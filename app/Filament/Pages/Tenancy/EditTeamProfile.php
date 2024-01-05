<?php
namespace App\Filament\Pages\Tenancy;

use App\Models\Team;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;
use Illuminate\Database\Eloquent\Model;

class EditTeamProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return '團隊資料';
    }

    public function form(Form $form): Form
    {
        // $isAdmin = auth()->user()->is_admin;
        // dd($isAdmin);

        return $form
            ->schema([
                TextInput::make('name')->label('團隊名稱'),
                Checkbox::make('is_admin')
                    ->label('設為管理員')
                    ->visible(fn (): bool => auth()->user()->canManageTenants()),
            ]);
    }
}
