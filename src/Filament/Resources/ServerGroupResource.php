<?php

namespace SquadMS\AdminConfig\Filament\Resources;

use SquadMS\AdminConfig\Filament\Resources\ServerGroupResource\Pages;
use SquadMS\AdminConfig\Filament\Resources\ServerGroupResource\RelationManagers;
use SquadMS\AdminConfig\Models\ServerGroup;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;


class ServerGroupResource extends Resource
{
    protected static ?string $navigationGroup = 'AdmdminConfig Management';
    
    protected static ?string $model = ServerGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->rules('required|string|min:1|max:255')
                    ->required(),
                Forms\Components\ColorPicker::make('color')
                    ->rules('required|string|color')
                    ->required(),

                Forms\Components\Toggle::make('main')->required(),
                Forms\Components\TextInput::make('importance')->integer()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable(),
                Tables\Columns\BooleanColumn::make('main')->sortable(),
                Tables\Columns\TextColumn::make('importance')->sortable()
            ])
            ->filters([
                //
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\ServerPermissionsRelationManager::class,
            RelationManagers\UsersRelationManager::class,

        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServerGroup::route('/'),
            'create' => Pages\CreateServerGroup::route('/create'),
            'edit' => Pages\EditServerGroup::route('/{record}/edit'),
        ];
    }
}
