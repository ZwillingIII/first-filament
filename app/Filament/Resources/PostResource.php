<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use PHPUnit\Util\Filter;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Новости';
    protected static ?string $modelLabel = 'Новость';
    protected static ?string $pluralModelLabel = 'Новости';
    protected static ?string $navigationGroup = 'Контент';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Основное')
                    ->description('Основные данные')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(100)
                            ->label('Заголовок')
                            ->live(true)
                            ->afterStateUpdated(function (Set $set, $state) {
                                $set('slug', Str::slug($state));
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->label('Символьный код'),
                    ])
                        ->columns(2),
                Forms\Components\TextInput::make('text')
                    ->maxLength(255)
                    ->label('Текст'),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->preload()
                    ->label('Создатель')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('Имя')
                            ->required(),
                        Forms\Components\TextInput::make('Email')
                            ->required(),
                        Forms\Components\TextInput::make('Пароль')
                            ->required()
                            ->password(),
                    ]),
                Forms\Components\DatePicker::make('created_at')
                    ->label('Создан от')
                    ->maxDate(now())
                    ->default(now()),
                Forms\Components\DatePicker::make('updated_at')
                    ->label('Обновлен')
                    ->maxDate(now())
                    ->default(now()),
                Forms\Components\Toggle::make('active')
                    ->label('Активность')
                    ->default(true)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label('ID'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Наименование')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date('d.m.Y')
                    ->searchable()
                    ->label('Создан')
                    ->sortable(),
                Tables\Columns\IconColumn::make('active')
                    ->label('Активность')
                    ->boolean()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('created_at')
                    ->label('по дате создания')
                    ->options(self::getDates())
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getDates()
    {
        return Post::query()->pluck('created_at');
    }
}
