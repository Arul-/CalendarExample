<?php

namespace App;

use DateTimeImmutable;
use Eluceo\iCal\Domain\Entity\Calendar as Cal;
use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Domain\ValueObject\SingleDay;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;
use GuzzleHttp\Psr7\Response;

class Calendar
{
    /**
     * Create an event and export it as iCal file
     * @param string $date
     * @param string $name
     * @param string $description
     * @return Response iCal file download
     */
    public function event(
        string $date = '2030-12-24',
        string $name = 'Christmas Eve',
        string $description = 'Lorem Ipsum Dolor...'
    ): Response
    {
        // 1. Create Event domain entity
        $event = (new Event())
            ->setSummary($name)
            ->setDescription($description)
            ->setOccurrence(
                new SingleDay(
                    new Date(
                        DateTimeImmutable::createFromFormat('Y-m-d', $date)
                    )
                )
            );

        // 2. Create Calendar domain entity
        $calendar = new Cal([$event]);

        // 3. Transform domain entity into an iCalendar component
        $componentFactory = new CalendarFactory();
        return new Response(
            200,
            [
                'Content-Type' => 'text/calendar; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="event.ics"',
            ],
            (string)$componentFactory->createCalendar($calendar)
        );
    }
}
