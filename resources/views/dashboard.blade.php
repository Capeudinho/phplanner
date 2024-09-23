@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/fullcalendar.css">
@endpush

@section('content')

<html lang='en'>

<head>
    <meta charset='utf-8' />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/locales/pt-br.global.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'pt-br',
            events: '/taskevents',
            eventClick: function (info) {
				const statusTranslations = {
        		"finished": "Concluída",
        		"ongoing": "Em progresso",
        		"delayed": "Pendente"
        		};
				const durationTranslations = {
				"half hour": "30 mintuos",
        		"hour": "1 hora",
        		"turn": "1 turno",
				"week": "1 semana",
        		"month": "1 mês",
        		"year": "1 ano"
        		};
				var start = info.event.start.toLocaleString().split(/[/,:]\s*/);
				start = start[0]+"/"+start[1]+"/"+start[2]+" "+start[3]+":"+start[4];
        		document.getElementById('eventTitle').innerText = info.event.title;
        		document.getElementById('eventid').value = info.event.id; 
        		document.getElementById('eventDescription').innerText = info.event.extendedProps.description;
        		document.getElementById('eventStart').innerText = start;
        		document.getElementById('eventStatus').innerText = statusTranslations[info.event.extendedProps.status] || info.event.extendedProps.status;
				document.getElementById('eventDuration').innerText = durationTranslations[info.event.extendedProps.duration_info] || info.event.extendedProps.duration_info;
				if (info.event.extendedProps.category_name == undefined)
				{
					document.getElementById('eventCategoryInfo').style.display = "none";
				}
				else
				{
					document.getElementById('eventCategoryInfo').style.display = "block";
					document.getElementById('eventCategory').innerText = info.event.extendedProps.category_name;
					document.getElementById('eventCategory').style.color = info.event.extendedProps.category_color;
				}
        		var editLink = document.getElementById('editLink');
        		editLink.href = "/task/" + info.event.id + "/edit"; 
        		var modal = document.getElementById("eventModal");
        		modal.style.display = "block";
			}
		});

        calendar.render();

        var span = document.getElementsByClassName("close")[0];
        span.onclick = function() {
            var modal = document.getElementById("eventModal");
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            var modal = document.getElementById("eventModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    });

    async function deleteEvent(eventId) {
        const confirmation = confirm('Tem certeza que deseja excluir esta tarefa?');
        if (!confirmation) {
            return;
        }
        try {
            const response = await fetch(`/task/${eventId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                alert('Evento excluído com sucesso.');
                window.location.href = '/dashboard'; 
            } else {
                console.error('Erro ao excluir o evento:', response.statusText);
                alert('Erro ao excluir o evento. Tente novamente mais tarde.');
            }
        } catch (error) {
            console.error('Erro ao excluir o evento:', error);
            alert('Erro ao excluir o evento. Tente novamente mais tarde.');
        }
    }



    </script>

</head>

<body>

<div class="p-6">
    <div class="flex">
        <h1 class="page-title">Seu Cronograma Mensal</h1>
    </div>
    <div class="flex justify-between">
        <div id='calendar' class="flex-1"></div>
        <div class="goals-board ml-60">
        <header class="flex justify-between items-center mb-4 border-b border-gray-300 pb-2">
            <h2 class="text-xl text-gray-700">Metas do mês</h2>
            <a href="{{ route('goal.create') }}" class="add-button bg-blue-500 text-white px-2 py-1 rounded flex items-center mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </a>
        </header>
    @if ($events->isEmpty())
        <p class="text-center text-gray-600">Nenhuma meta para este mês.</p>
    @else
        <ul class="list-disc pl-5">
            @foreach($events as $event)
                <li class="mb-2">
                    <strong>{{ $event['title'] }}</strong> 
                    <br>
                    <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($event['start'])->format('d/m/Y H:i') }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>



<!-- Modal -->
<div id="eventModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h1 id="eventTitle" class="text-2xl font-semibold text-gray-700 mb-2"></h1>
    <p><strong>Descrição:</strong> <span id="eventDescription"></span></p>
    <p><strong>Data de início:</strong> <span id="eventStart"></span></p>
	<p><strong>Duração:</strong> <span id="eventDuration"></span></p>
    <p><strong>Status:</strong> <span id="eventStatus"></span></p>
	<p id="eventCategoryInfo"><strong>Categoria:</strong> <span id="eventCategory"></span></p>
    <input type="hidden" id="eventid">
    <div class="flex justify-end mt-3">
    <a href="#" id="editLink" class="add-button mr-2" >Editar evento</a>
    <button onclick="deleteEvent(document.getElementById('eventid').value);" class="delete-button">
        Excluir evento
    </button>
    </div>
  </div>
</div>

</div>

</body>

</html>
@endsection
