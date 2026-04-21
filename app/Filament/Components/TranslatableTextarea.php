<?php

namespace App\Filament\Components;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Group;

class TranslatableTextarea
{
    public static function make(string $field, array $locales, int $rows = 5): array
    {
        $defaultLocale = array_key_first($locales);

        return [
            Group::make()->schema([
                Hidden::make($field)
                    ->default([]),

                Select::make("{$field}_active_locale")
                    ->label('Editing language')
                    ->options($locales)
                    ->default($defaultLocale)
                    ->live()
                    ->afterStateUpdated(function ($state, $set, $get) use ($field) {
                        $values = $get($field) ?? [];

                        if (! is_array($values)) {
                            $values = [];
                        }

                        $set("{$field}_input", $values[$state] ?? '');
                    }),

                Textarea::make("{$field}_input")
                    ->label(function ($get) use ($field, $locales, $defaultLocale) {
                        $locale = $get("{$field}_active_locale") ?? $defaultLocale;

                        return ucfirst($field) . ' (' . ($locales[$locale] ?? $locale) . ')';
                    })
                    ->rows($rows)
                    ->live()
                    ->afterStateHydrated(function ($set, $get) use ($field, $defaultLocale) {
                        $locale = $get("{$field}_active_locale") ?? $defaultLocale;
                        $values = $get($field) ?? [];

                        if (! is_array($values)) {
                            $values = [];
                        }

                        $set("{$field}_input", $values[$locale] ?? '');
                    })
                    ->afterStateUpdated(function ($state, $set, $get) use ($field, $defaultLocale) {
                        $locale = $get("{$field}_active_locale") ?? $defaultLocale;
                        $values = $get($field) ?? [];

                        if (! is_array($values)) {
                            $values = [];
                        }

                        $values[$locale] = $state;

                        $set($field, $values);
                    }),
            ])->columnSpanFull(),
        ];
    }
}
