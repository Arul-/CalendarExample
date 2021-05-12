<?php

namespace App;

use DateTime;
use GuzzleHttp\Psr7\Response;
use Spatie\IcalendarGenerator\Components\Event;
use Spatie\IcalendarGenerator\Enums\ParticipationStatus;
use Spatie\IcalendarGenerator\Components\Calendar as iCal;

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
    ): Response {
        $event = Event::create($name)
            ->description($description)
            ->startsAt(new DateTime($date))
            ->fullDay()
            ->attendee('me@example.com') // only an email address is required
            ->attendee('arul@luracast.com', 'Arul Kumaran', ParticipationStatus::accepted());

        return new Response(
            200,
            [
                'Content-Type' => 'text/calendar; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="event.ics"',
            ],
            (new iCal)->event($event)->get()
        );
    }
}
