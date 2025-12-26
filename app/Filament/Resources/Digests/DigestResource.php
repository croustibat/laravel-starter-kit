<?php

namespace App\Filament\Resources\Digests;

use App\Filament\Resources\Digests\Pages\CreateDigest;
use App\Filament\Resources\Digests\Pages\EditDigest;
use App\Filament\Resources\Digests\Pages\ListDigests;
use App\Filament\Resources\Digests\Schemas\DigestForm;
use App\Filament\Resources\Digests\Tables\DigestsTable;
use App\Models\Digest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DigestResource extends Resource
{
    protected static ?string $model = Digest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return DigestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DigestsTable::configure($table);
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
            'index' => ListDigests::route('/'),
            'create' => CreateDigest::route('/create'),
            'edit' => EditDigest::route('/{record}/edit'),
        ];
    }
}
