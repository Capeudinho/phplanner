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
            events: '/events',
            eventClick: function(info) {
                document.getElementById('eventTitle').innerText = info.event.title;
                document.getElementById('eventid').value = info.event.id; 
                document.getElementById('eventDescription').innerText = info.event.extendedProps.description;
                document.getElementById('eventStart').innerText = info.event.start.toLocaleString();
                document.getElementById('eventStatus').innerText = info.event.extendedProps.status;

                const statusTranslations = {
                "finished": "Concluído",
                "ongoing": "Em Progresso",
                "delayed": "Atrasada"
               
            };
                document.getElementById('eventStatus').innerText = statusTranslations[info.event.extendedProps.status] || info.event.extendedProps.status;

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
        <div class="goals-board ml-4">
            <h2 class="text-xl mb-4 text-center text-gray-700">Metas da Semana</h2>
        </div>
    </div>
</div>


<!-- Modal -->
<div id="eventModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h1 id="eventTitle" class="text-2xl font-semibold text-gray-700 mb-2"></h1>
    <p><strong>Descrição:</strong> <span id="eventDescription"></span></p>
    <p><strong>Data de Início:</strong> <span id="eventStart"></span></p>
    <p><strong>Status:</strong> <span id="eventStatus"></span></p>
    <input type="hidden" id="eventid">
    <div class="flex justify-end mt-3">
    <a href="#" id="editLink" class="add-button mr-2" >Editar tarefa</a>
    <button onclick="deleteEvent(document.getElementById('eventid').value);" class="delete-button">
        Excluir tarefa
    </button>
    </div>
  </div>
</div>

</div>

</body>

</html>
@endsection
