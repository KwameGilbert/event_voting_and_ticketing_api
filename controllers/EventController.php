<?php
require_once '../models/Event.php';


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
            return json_encode([
                "message" => "Event created successfully.",
                "data" => $data
            ], 201);
        } else {
            return json_encode([
                "message" => "Failed to create event."
            ], 500);
        }
    }

    public function getAllEvents()
    {
        $events = $this->event->getAllEvents();
        if ($events >= 0) {
            return json_encode([
                "events" => $events
            ], 200);
        } else {
            return json_encode([
                "message" => "Failed to get events."
            ], 500);
        }
    }

    public function getEventById($id)
    {
        $event = $this->event->getEventById($id);
        if ($event) {
            return json_encode([
                "event" => $event
            ], 200);
        } else {
            return json_encode([
                "message" => "Event by Id not found."
            ], 404);
        }
    }

    public function updateEvent($id, $data)
    {
        if ($this->event->updateEvent($id, $data)) {
            return json_encode([
                "message" => "Event updated successfully.",
                "data" => $data
            ], 200);
        } else {
            return json_encode([
                "message" => "Failed to update event."
            ], 500);
        }
    }

    public function deleteEvent($id)
    {
        if ($this->event->deleteEvent($id)) {
            return json_encode([
                "message" => "Event deleted successfully."
            ], 200);
        } else {
            return json_encode([
                "message" => "Failed to delete event."
            ], 500);
        }
    }
}
