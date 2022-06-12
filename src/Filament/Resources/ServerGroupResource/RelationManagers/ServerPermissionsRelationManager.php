<?php

namespace SquadMS\AdminConfig\Filament\Resources\ServerGroupResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class ServerPermissionsRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'permissions';

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
                Tables\Columns\TextColumn::make('name')->sortable()
            ])
            ->filters([
                //
            ]);
    }
}
