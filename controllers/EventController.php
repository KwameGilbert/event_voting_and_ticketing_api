<?php
require_once '../models/Event.php';
require_once '../helpers/Response.php';

class EventController
{
    private $event;

    public function __construct()
    {
        $this->event = new Event();
    }

    public function createEvent($data)
    {
        if ($this->event->createEvent($data)) {
            Response::send(
                201,
                [
                    "message" => "Event created successfully.",
                    "data" => $data
                ]
            );
        } else {
            Response::send(500, ["message" => "Failed to create event."]);
        }
    }

    public function getAllEvents()
    {
        $events = $this->event->getAllEvents();
        if ($events >=0) {
            Response::send(200, $events);
        } else {
            Response::send(500, ["message" => "Failed to get all events."]);
        }
    }

    public function getEventById($id)
    {
        $event = $this->event->getEventById($id);
        if ($event) {
            Response::send(200, [
                "event" => $event]);
        } else {
            Response::send(500, ["message" => "Failed to get events for user."]);
        }
    }

    public function updateEvent($id, $data)
    {
        if ($this->event->updateEvent($id, $data)) {
            Response::send(
                200,
                [
                    "message" => "Event updated successfully.",
                    "data" => $data
                ]
            );
        } else {
            Response::send(500, ["message" => "Failed to update event."]);
        }
    }

    public function deleteEvent($id)
    {
        if ($this->event->deleteEvent($id)) {
            Response::send(200, ["message" => "Event deleted successfully."]);
        } else {
            Response::send(500, ["message" => "Failed to delete event."]);
        }
    }
}
