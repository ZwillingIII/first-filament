<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use function Filament\Support\locale_has_pluralization;

abstract class BaseResource extends Resource
{
    const SYSTEM_SETTINGS_NAV_GROUP = 'Системные настройки';
    const CLIENTS_NAV_GROUP = 'Клиенты';
    const USERS_NAV_GROUP = 'Сотрудники';
    const PRODUCTS_NAV_GROUP = 'Товары';
    const SHOPS_NAV_GROUP = 'Магазины';
    const ORDERS_NAV_GROUP = 'Заказы';
    const MARKETING_NAV_GROUP = 'Маркетинг';
    const INFORMATION_NAV_GROUP = 'Маркетинг';


    const CLIENTS_NAV_SORT = 100;
    const ORDERS_NAV_SORT = 150;
    const USERS_NAV_SORT = 200;
    const ROLES_NAV_SORT = 250;
    const FEEDBACK_NAV_SORT = 300;
    const DOCUMENTS_NAV_SORT = 900;
    const CITIES_NAV_SORT = 550;
    const SHOPS_NAV_SORT = 600;
    const CATALOGS_NAV_SORT = 650;
    const PRODUCTS_NAV_SORT = 700;
    const PROMOTIONS_NAV_SORT = 750;
    const SPECIAL_OFFERS_NAV_SORT = 800;

//    public static function getNavigationLabel(): string
//    {
//        return __('resources.' . static::getResourceCode() . '.plural_label');
//    }

    public abstract static function getResourceCode();

    protected static bool $hasTitleCaseModelLabel = false;

//    public static function getPluralModelLabel(): string
//    {
//        return __('resources.' . static::getResourceCode() . '.plural_label');
//    }

//    public static function getModelLabel(): string
//    {
//        return __('resources.' . static::getResourceCode() . '.label');
//    }

    public static function canCreate(): bool
    {
        return auth()->user()->can(static::getResourceCode() . '_edit');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can(static::getResourceCode() . '_edit');
    }

    public static function canView(Model $record): bool
    {
        return auth()->user()->can(static::getResourceCode() . '_view');
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->can(static::getResourceCode() . '_view');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can(static::getResourceCode() . '_delete');
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->can(static::getResourceCode() . '_delete');
    }
}
