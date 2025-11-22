<?php

namespace Nebatech\Controllers;

use Nebatech\Core\Controller;
use Nebatech\Core\Database;

class EventController extends Controller
{
    /**
     * List all events
     */
    public function index()
    {
        $filter = $_GET['filter'] ?? 'upcoming';
        
        $conditions = [];
        $params = [];

        if ($filter === 'upcoming') {
            $conditions[] = "status = 'upcoming' AND start_time > NOW()";
        } elseif ($filter === 'past') {
            $conditions[] = "status = 'completed' OR end_time < NOW()";
        } elseif ($filter === 'my-events' && isset($_SESSION['user_id'])) {
            $conditions[] = "EXISTS (SELECT 1 FROM event_rsvps WHERE event_id = ce.id AND user_id = ?)";
            $params[] = $_SESSION['user_id'];
        }

        $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

        $events = Database::fetchAll(
            "SELECT ce.*, 
                    u.first_name as organizer_first_name, u.last_name as organizer_last_name,
                    (SELECT COUNT(*) FROM event_rsvps WHERE event_id = ce.id AND status = 'going') as attendees_count
             FROM community_events ce
             INNER JOIN users u ON ce.organizer_id = u.id
             $whereClause
             ORDER BY ce.start_time ASC",
            $params
        );

        $this->view('community/events', compact('events'));
    }

    /**
     * Show single event
     */
    public function show($uuid)
    {
        $userId = $_SESSION['user_id'] ?? null;

        $event = Database::fetch(
            "SELECT ce.*, 
                    u.first_name as organizer_first_name, u.last_name as organizer_last_name, u.avatar as organizer_avatar,
                    (SELECT COUNT(*) FROM event_rsvps WHERE event_id = ce.id AND status = 'going') as attendees_count,
                    " . ($userId ? "(SELECT status FROM event_rsvps WHERE event_id = ce.id AND user_id = ?) as user_rsvp" : "NULL as user_rsvp") . "
             FROM community_events ce
             INNER JOIN users u ON ce.organizer_id = u.id
             WHERE ce.uuid = ?",
            $userId ? [$userId, $uuid] : [$uuid]
        );

        if (!$event) {
            $this->redirect('/community/events');
            return;
        }

        // Get attendees
        $attendees = Database::fetchAll(
            "SELECT u.id, u.first_name, u.last_name, u.avatar, er.status
             FROM event_rsvps er
             INNER JOIN users u ON er.user_id = u.id
             WHERE er.event_id = ? AND er.status = 'going'
             ORDER BY er.created_at ASC",
            [$event['id']]
        );

        return $this->view('community/event-detail', compact('event', 'attendees'));
    }

    /**
     * Create event form
     */
    public function create()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
            return;
        }

        return $this->view('community/event-create');
    }

    /**
     * Store new event
     */
    public function store()
    {
        if (!$this->isAuthenticated()) {
            $this->jsonResponse(['success' => false, 'message' => 'Please sign in']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        // Generate UUID
        $uuid = $this->generateUUID();

        // Handle tags
        $tags = isset($input['tags']) && is_array($input['tags']) 
            ? json_encode($input['tags']) 
            : null;

        // Insert event
        Database::query(
            "INSERT INTO community_events (uuid, organizer_id, title, description, type, 
             start_time, end_time, timezone, location, meeting_url, max_attendees, tags, is_featured, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $uuid,
                $_SESSION['user_id'],
                $input['title'],
                $input['description'],
                $input['type'],
                $input['start_time'],
                $input['end_time'],
                $input['timezone'] ?? 'Africa/Accra',
                $input['location'] ?? null,
                $input['meeting_url'] ?? null,
                $input['max_attendees'] ?? null,
                $tags,
                0,
                'upcoming'
            ]
        );

        $this->jsonResponse([
            'success' => true,
            'redirect' => '/community/events/' . $uuid
        ]);
    }

    /**
     * RSVP to event
     */
    public function rsvp($uuid)
    {
        if (!$this->isAuthenticated()) {
            $this->jsonResponse(['success' => false, 'message' => 'Please sign in']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $status = $input['status'] ?? 'going';

        // Get event
        $event = Database::fetch(
            "SELECT * FROM community_events WHERE uuid = ?",
            [$uuid]
        );

        if (!$event) {
            $this->jsonResponse(['success' => false, 'message' => 'Event not found']);
            return;
        }

        // Check if already RSVPed
        $existing = Database::fetch(
            "SELECT * FROM event_rsvps WHERE event_id = ? AND user_id = ?",
            [$event['id'], $_SESSION['user_id']]
        );

        if ($existing) {
            // Update RSVP
            Database::query(
                "UPDATE event_rsvps SET status = ? WHERE id = ?",
                [$status, $existing['id']]
            );
        } else {
            // Create RSVP
            Database::query(
                "INSERT INTO event_rsvps (event_id, user_id, status) VALUES (?, ?, ?)",
                [$event['id'], $_SESSION['user_id'], $status]
            );
        }

        $this->jsonResponse(['success' => true]);
    }

    /**
     * Generate UUID
     */
    private function generateUUID()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}
