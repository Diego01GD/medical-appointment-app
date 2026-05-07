<x-admin-layout title="Calendario" :breadcrumbs="[
  [
    'name' => 'Dashboard',
    'href' => route('admin.dashboard'),
  ],
  [
    'name' => 'Calendario',
  ],
]">

<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

<div class="bg-white shadow-md sm:rounded-lg overflow-hidden border border-gray-100 p-6">
    <div id='calendar' class="bg-white"></div>
</div>

<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js'></script>

<style>
    /* Personalización de FullCalendar para Flowbite/Tailwind */
    .fc .fc-button-primary {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }
    .fc .fc-button-primary:not(:disabled):active,
    .fc .fc-button-primary:not(:disabled).fc-button-active {
        background-color: #1d4ed8;
        border-color: #1e3a8a;
    }
    .fc-event {
        cursor: pointer;
        border: none;
        border-radius: 4px;
        padding: 2px 4px;
        font-size: 0.75rem;
    }
    .fc-event-title {
        font-weight: 600;
    }
    .fc-daygrid-event-dot {
        border-width: 4px;
    }
    .fc .fc-toolbar-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #1f2937;
    }
    /* Para que el header parezca Flowbite */
    .fc .fc-button {
        border-radius: 0.375rem;
        text-transform: capitalize;
    }
    .fc .fc-button-group > .fc-button {
        border-radius: 0;
    }
    .fc .fc-button-group > .fc-button:first-child {
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
    }
    .fc .fc-button-group > .fc-button:last-child {
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }
    .fc-theme-standard td, .fc-theme-standard th {
        border-color: #f3f4f6;
    }
    .fc-col-header-cell-cushion {
        color: #6b7280;
        text-transform: lowercase;
        padding: 8px !important;
    }
    .fc-daygrid-day-number {
        color: #374151;
        font-size: 0.875rem;
        padding: 8px !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var eventsData = @json($events);

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día',
                list: 'Lista'
            },
            events: eventsData,
            eventClick: function(info) {
                if(info.event.url) {
                    info.jsEvent.preventDefault(); // don't let the browser navigate
                    window.open(info.event.url, '_blank');
                }
            },
            // Estilo de eventos
            eventContent: function(arg) {
                let dotEl = document.createElement('div');
                dotEl.style.width = '6px';
                dotEl.style.height = '6px';
                dotEl.style.borderRadius = '50%';
                dotEl.style.backgroundColor = arg.event.backgroundColor;
                dotEl.style.display = 'inline-block';
                dotEl.style.marginRight = '4px';

                let timeEl = document.createElement('span');
                timeEl.innerHTML = arg.timeText;
                timeEl.style.fontWeight = 'bold';
                timeEl.style.marginRight = '4px';

                let titleEl = document.createElement('span');
                titleEl.innerHTML = arg.event.title.substring(arg.event.title.indexOf(' ') + 1); // Remove time from title if present

                let arrayOfDomNodes = [ dotEl, timeEl, titleEl ]
                return { domNodes: arrayOfDomNodes }
            },
            displayEventTime: true,
            dayMaxEvents: true, // allow "more" link when too many events
        });

        calendar.render();
    });
</script>

</x-admin-layout>
