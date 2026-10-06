<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Deux filtres Twig maison :
 *  - time_ago : « il y a 3 jours »
 *  - excerpt  : coupe un texte à N caractères et ajoute « … »
 */
class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('time_ago', [$this, 'timeAgo']),
            new TwigFilter('excerpt', [$this, 'excerpt']),
        ];
    }

    public function timeAgo(\DateTimeInterface $date): string
    {
        $seconds = (new \DateTimeImmutable())->getTimestamp() - $date->getTimestamp();

        if ($seconds < 60) {
            return "à l'instant";
        }

        $units = [
            [31536000, 'an', 'ans'],
            [2592000, 'mois', 'mois'],
            [86400, 'jour', 'jours'],
            [3600, 'heure', 'heures'],
            [60, 'minute', 'minutes'],
        ];

        foreach ($units as [$unitSeconds, $singular, $plural]) {
            if ($seconds >= $unitSeconds) {
                $count = intdiv($seconds, $unitSeconds);

                return sprintf('il y a %d %s', $count, $count > 1 ? $plural : $singular);
            }
        }

        return "à l'instant";
    }

    public function excerpt(?string $text, int $length = 30): string
    {
        $text = (string) $text;

        return mb_strlen($text) > $length ? mb_substr($text, 0, $length).'…' : $text;
    }
}
