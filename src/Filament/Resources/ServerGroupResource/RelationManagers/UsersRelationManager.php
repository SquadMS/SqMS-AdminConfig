<?php

namespace SquadMS\AdminConfig\Filament\Resources\ServerGroupResource\RelationManagers;

use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyThroughRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class UsersRelationManager extends HasManyThroughRelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * We do only want to manage permissions, not create them
     */
    protected function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            //
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')->sortable(),
                Tables\Columns\TextColumn::make('name')->sortable(),
                Tables\Columns\TextColumn::make('steam_id_64')->sortable(),
            ])
            ->filters([
                //
            ]);
    }
}
