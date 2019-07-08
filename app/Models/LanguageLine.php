<?php

namespace App\Models;

use App\Traits\Translatable;
use Spatie\TranslationLoader\LanguageLine as Model;

class LanguageLine extends Model
{
    use Translatable;

    public $translatable = ['text'];

    protected $casts = ['text' => 'string'];

    public static function getTranslationsForGroup(string $locale, string $group): array
    {
        return  static::withTranslations()
            ->where('group', $group)
            ->get()
            ->reduce(function ($lines, LanguageLine $languageLine) use ($locale) {
                $translation = $languageLine->getTranslation($locale);
                if ($translation !== null) {
                    array_set($lines, $languageLine->key, $translation);
                }
                return $lines;
            }) ?? [];
    }

    /**
     * @param string $locale
     *
     * @return string
     */
    public function getTranslation(string $locale): string
    {
        return $this->translate($locale)->text;
    }

    /**
     * @param string $locale
     * @param string $value
     *
     * @return $this
     */
    public function setTranslation(string $locale, string $value)
    {
        $translator = $this->translate($locale);
        $translator->text = $value;
        $translator->save();

        return $this;
    }

    protected function getTranslatedLocales(): array
    {
        return config('app.locales');
    }
}
