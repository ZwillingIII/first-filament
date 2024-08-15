<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoleResource extends BaseResource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';
    protected static ?string $navigationLabel = 'Роли';
    protected static ?string $modelLabel = 'Роль';
    protected static ?string $pluralModelLabel = 'Роль';
    protected static ?string $navigationGroup = 'Права доступа';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('fields.code'))
                    ->unique(ignoreRecord: true)
                    ->maxLength(250)
                    ->required(),
                Select::make('guard_name')
                ->label(__('fields.guard'))
                ->options([
                    'web' => 'web',
                    'api' => 'api',
                ]),
                Forms\Components\Select::make('permissions')
                    ->searchable()
                    ->relationship('permissions', 'name')
                    ->getOptionLabelFromRecordUsing(fn(Permission $record) => str_replace('filament.permissions.', '', trans('filament.permissions.' . $record->name)))
                    ->label(__('fields.permissions'))
                    ->multiple()
                    ->searchDebounce(500),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label(__('fields.id')),
                TextColumn::make('name')
                    ->sortable()
                    ->label(__('fields.code')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }

    public static function getResourceCode(): string
    {
        return 'role';
    }
}
