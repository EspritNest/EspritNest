<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Symfony\Component\Intl\DateFormatter\DateFormatter;

class TimeAgoExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('timeAgo', [$this, 'timeAgo']),
        ];
    }

    public function timeAgo(\DateTimeInterface $date)
    {
              // Calculer la différence entre la date actuelle et la date donnée
              $interval = $date->diff(new \DateTime());

              // Retourner le format approprié selon l'intervalle
              if ($interval->y > 0) {
                  return $interval->format('%y year(s) ago');
              } elseif ($interval->m > 0) {
                  return $interval->format('%m month(s) ago');
              } elseif ($interval->d > 0) {
                  return $interval->format('%d day(s) ago');
              } elseif ($interval->h > 0) {
                  return $interval->format('%h hour(s) ago');
              } elseif ($interval->i > 0) {
                  return $interval->format('%i minute(s) ago');
              } else {
                  return 'Just now';  // Si l'événement s'est produit récemment
              }
          }
      }