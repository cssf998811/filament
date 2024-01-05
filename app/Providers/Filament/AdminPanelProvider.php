<?php

namespace App\Providers\Filament;

use App\Filament\AvatarProviders\BoringAvatarsProvider;
use App\Filament\Pages\Tenancy\EditTeamProfile;
use App\Filament\Pages\Tenancy\RegisterTeam;
use App\Http\Middleware\ApplyTenantScopes;
use App\Models\Team;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->tenant(Team::class)
            ->tenantRegistration(RegisterTeam::class)
            ->tenantProfile(EditTeamProfile::class)
            ->tenantMenuItems([
                'profile' => MenuItem::make()->label('編輯團隊資料'),
                'register' => MenuItem::make()->label('新增團隊資料')
                    ->visible(fn (): bool => auth()->user()->canManageTenants()),
            ])
            ->defaultAvatarProvider(BoringAvatarsProvider::class)
            ->login()
            // 使用者可自行註冊帳號使用
            // ->registration()
            // ->passwordReset()
            // ->emailVerification()
            // 右上角的profile(改名、信箱、密碼等等)
            ->profile()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->authGuard('web')
            // ->spa()
            // ->darkMode(false)
            // ->brandName('Bossview')
            // ->brandLogo(asset('images/logo.svg'))
            // ->brandLogo(fn () => view('logo'))
            // ->favicon(asset('images/favicon.png'))
            // 預設是側邊選單
            // ->topNavigation()
            ->tenantMiddleware([
                // 租戶隔離 避免跨team存取label跟task
                ApplyTenantScopes::class,
            ], isPersistent: true);
    }
}
