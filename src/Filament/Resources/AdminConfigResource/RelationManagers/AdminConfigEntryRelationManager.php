<?php

namespace SquadMS\AdminConfig\Filament\Resources\AdminConfigResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class AdminConfigEntryRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'entries';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\BelongsToSelect::make('user_id')
                ->relationship('user', 'name')
                ->nullable(),
            Forms\Components\BelongsToSelect::make('server_group_id')
                ->relationship('serverGroup', 'name')
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('user.avatar'),
                Tables\Columns\TextColumn::make('user.name')->sortable(),
                Tables\Columns\TextColumn::make('user.steam_id_64')->sortable(),
                Tables\Columns\TextColumn::make('serverGroup.name')->sortable(),
            ])
            ->filters([
                //
            ]);
    }
}
