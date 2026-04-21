<?php

namespace App\Filament\Components;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class TranslatableTextInput
{
    public static function make(string $field, array $locales): array
    {
        return [
            Hidden::make($field)
                ->default([]),

            Select::make("{$field}_active_locale")
                ->label('Editing language')
                ->options($locales)
                ->default(array_key_first($locales))
                ->live()
                ->afterStateUpdated(function ($state, $set, $get) use ($field) {
                    $values = $get($field) ?? [];
                    $set("{$field}_input", $values[$state] ?? '');
                }),

            TextInput::make("{$field}_input")
                ->label(function ($get) use ($field, $locales) {
                    $locale = $get("{$field}_active_locale") ?? array_key_first($locales);
                    return ucfirst($field) . ' (' . ($locales[$locale] ?? $locale) . ')';
                })
                ->live()
                ->afterStateHydrated(function ($set, $get) use ($field, $locales) {
                    $locale = $get("{$field}_active_locale") ?? array_key_first($locales);
                    $values = $get($field) ?? [];

                    $set("{$field}_input", $values[$locale] ?? '');
                })
                ->afterStateUpdated(function ($state, $set, $get) use ($field, $locales) {
                    $locale = $get("{$field}_active_locale") ?? array_key_first($locales);
                    $values = $get($field) ?? [];

                    $values[$locale] = $state;

                    $set($field, $values);
                }),
        ];
    }
}
