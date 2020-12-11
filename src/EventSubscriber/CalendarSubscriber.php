<?php

namespace App\EventSubscriber;

use App\Repository\InteractionRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    private $interactionRepository;
    private $route;

    public function __construct(InteractionRepository $interactionRepository, UrlGeneratorInterface $route)
    {
        $this->interactionRepository = $interactionRepository;
        $this->route = $route;
    }

    public function onCalendarEvents(CalendarEvent $calendarEvent)
    {
        $start = $calendarEvent->getStart();
        $end = $calendarEvent->getEnd();
        $filters = $calendarEvent->getFilters();

        $interactions = $this->interactionRepository->getInteractionForCalendar($start,$end);

        foreach ($interactions as $interaction)
        {
            $interactionEvent = new Event(
                $interaction->getType(),
                $interaction->getCreatedDate(),
                $interaction->getDateDue()
            );

            if($interaction->getType() == 'Phone') {
                $color = '#175826';
            }elseif ($interaction->getType() == 'Email') {
                $color = '#004085';
            }elseif ($interaction->getType() == 'Meeting'){
                $color = '#856404';
            }else {
                $color = '#17d8bb';
            }

            $interactionEvent->setOptions([
                'backgroundColor' => $color,
                'color' => $color,
            ]);

            $interactionEvent->addOption(
                'url',
                $this->route->generate('calendar',[
                    'id' => $interaction->getId()
                ])
            );
            $calendarEvent->addEvent($interactionEvent);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarEvents'
        ];
    }
}
