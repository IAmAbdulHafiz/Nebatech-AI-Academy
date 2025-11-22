<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Calendar - Nebatech AI Academy</title>
    
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
    <link href="<?= asset('css/main.css') ?>" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="<?= asset('js/theme-toggle.js') ?>"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
<?php include __DIR__ . '/../partials/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-3">
                <svg class="w-8 h-8 text-primary/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Community Events
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Join workshops, webinars, and community gatherings
            </p>
        </div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/community/events/create" 
               class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors font-medium flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Create Event</span>
            </a>
        <?php endif; ?>
    </div>

    <!-- Filters -->
    <?php 
    // Sanitize and whitelist filter parameter
    $allowedFilters = ['upcoming', 'past', 'my-events'];
    $currentFilter = isset($_GET['filter']) ? htmlspecialchars($_GET['filter'], ENT_QUOTES, 'UTF-8') : 'upcoming';
    $currentFilter = in_array($currentFilter, $allowedFilters) ? $currentFilter : 'upcoming';
    ?>
    <div class="flex items-center space-x-4 mb-8">
        <button onclick="filterEvents('upcoming')" 
                class="filter-btn px-4 py-2 rounded-lg font-medium transition-colors <?= $currentFilter === 'upcoming' ? 'bg-primary text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' ?>">
            Upcoming
        </button>
        <button onclick="filterEvents('past')" 
                class="filter-btn px-4 py-2 rounded-lg font-medium transition-colors <?= $currentFilter === 'past' ? 'bg-primary text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' ?>">
            Past Events
        </button>
        <button onclick="filterEvents('my-events')" 
                class="filter-btn px-4 py-2 rounded-lg font-medium transition-colors <?= $currentFilter === 'my-events' ? 'bg-primary text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' ?>">
            My Events
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Events List -->
        <div class="lg:col-span-2 space-y-6">
            <?php if (empty($events)): ?>
                <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <p class="text-gray-500 dark:text-gray-400 text-lg mb-4">No events found</p>
                    <a href="/community/events/create" class="text-primary hover:underline">
                        Create the first event!
                    </a>
                </div>
            <?php else: ?>
                <?php foreach ($events as $event): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="md:flex">
                            <!-- Event Image -->
                            <div class="md:w-1/3 h-48 md:h-auto bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center relative">
                                <?php if ($event['cover_image']): ?>
                                    <img src="<?= htmlspecialchars($event['cover_image']) ?>" 
                                         alt="<?= htmlspecialchars($event['title']) ?>"
                                         class="w-full h-full object-cover">
                                <?php else: ?>
                                    <?php 
                                    $eventTypeIcons = [
                                        'webinar' => '<svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>',
                                        'workshop' => '<svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
                                        'hackathon' => '<svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>',
                                        'meetup' => '<svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>'
                                    ];
                                    echo $eventTypeIcons[$event['type']] ?? '<svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>';
                                    ?>
                                <?php endif; ?>
                                
                                <?php if ($event['is_featured']): ?>
                                    <span class="absolute top-3 left-3 px-2 py-1 bg-yellow-500 text-white rounded-full text-xs font-semibold flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        Featured
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Event Details -->
                            <div class="flex-1 p-6">
                                <!-- Type & Status -->
                                <div class="flex items-center space-x-2 mb-3">
                                    <span class="px-2 py-1 bg-primary/10 text-primary rounded-full text-xs font-medium">
                                        <?= ucfirst($event['type']) ?>
                                    </span>
                                    <span class="px-2 py-1 <?= $event['status'] === 'upcoming' ? 'bg-green-100 text-green-800' : 
                                                               ($event['status'] === 'ongoing' ? 'bg-blue-100 text-blue-800' : 
                                                               ($event['status'] === 'completed' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800')) ?> rounded-full text-xs font-medium">
                                        <?= ucfirst($event['status']) ?>
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                    <a href="/community/events/<?= $event['uuid'] ?>" class="hover:text-primary">
                                        <?= htmlspecialchars($event['title']) ?>
                                    </a>
                                </h3>

                                <!-- Description -->
                                <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                                    <?= htmlspecialchars($event['description']) ?>
                                </p>

                                <!-- Meta Info -->
                                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span><?= date('l, M j, Y', strtotime($event['start_time'])) ?></span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span><?= date('g:i A', strtotime($event['start_time'])) ?> - <?= date('g:i A', strtotime($event['end_time'])) ?></span>
                                    </div>
                                    <?php if ($event['location']): ?>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <span><?= htmlspecialchars($event['location']) ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($event['meeting_url']): ?>
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                            <a href="<?= htmlspecialchars($event['meeting_url']) ?>" 
                                               target="_blank" 
                                               class="text-primary hover:underline">
                                                Join online
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Footer -->
                                <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center space-x-4 text-sm">
                                        <span class="flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                            <span><?= $event['attendees_count'] ?? 0 ?> attending</span>
                                        </span>
                                        <?php if ($event['max_attendees']): ?>
                                            <span class="text-gray-400">/ <?= $event['max_attendees'] ?> max</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if (isset($_SESSION['user_id']) && $event['status'] === 'upcoming'): ?>
                                        <button onclick="rsvpEvent('<?= $event['uuid'] ?>', 'going')" 
                                                class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors text-sm font-medium">
                                            RSVP
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Stats
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Upcoming</span>
                        <span class="font-semibold text-green-600"><?= count(array_filter($events, fn($e) => $e['status'] === 'upcoming')) ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">This Month</span>
                        <span class="font-semibold text-gray-900 dark:text-white"><?= count(array_filter($events, fn($e) => date('Y-m', strtotime($e['start_time'])) === date('Y-m'))) ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Total Attendees</span>
                        <span class="font-semibold text-gray-900 dark:text-white"><?= array_sum(array_column($events, 'attendees_count')) ?></span>
                    </div>
                </div>
            </div>

            <!-- Event Types -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Event Types</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                        <span class="text-gray-700 dark:text-gray-300">Webinars</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="text-gray-700 dark:text-gray-300">Workshops</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                        <span class="text-gray-700 dark:text-gray-300">Hackathons</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span class="text-gray-700 dark:text-gray-300">Meetups</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <span class="text-gray-700 dark:text-gray-300">Live Sessions</span>
                    </div>
                </div>
            </div>

            <!-- Calendar Widget -->
            <div class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-lg p-6 border border-white/20 dark:border-primary/80">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    This Month
                </h3>
                <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">
                    Don't miss out on upcoming events. Add them to your calendar!
                </p>
                <button class="w-full px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors text-sm font-medium">
                    Export Calendar
                </button>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>

<script>
function filterEvents(filter) {
    window.location.href = '/community/events?filter=' + filter;
}

async function rsvpEvent(uuid, status) {
    try {
        const response = await fetch(`/community/events/${uuid}/rsvp`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ status })
        });
        
        const data = await response.json();
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Failed to RSVP');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to RSVP. Please try again.');
    }
}
</script>

