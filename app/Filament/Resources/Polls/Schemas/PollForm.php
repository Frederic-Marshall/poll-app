<?php

namespace App\Filament\Resources\Polls\Schemas;

use App\Enums\PollStatus;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PollForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(PollStatus::class)
                    ->default('draft')
                    ->required(),

                Repeater::make('options')
                    ->relationship()
                    ->schema([
                        TextInput::make('text')->required(),
                        SpatieMediaLibraryFileUpload::make('image')
                            ->collection('images'),
                    ])
                ->columnSpanFull()
                ->minItems(2)
                ->maxItems(10)
                ->columns(1),

                Hidden::make('user_id')
                    ->default(auth()->id()),
            ]);
    }
}
