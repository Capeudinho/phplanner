@if (!empty($content) && count($content) > 0)
    <table id="dataTable" class="min-w-full shadow-lg border rounded-lg overflow-hidden">
        <thead class="text-left text-bold" style="background: var(--Container, #F2F6F7);">
            <tr class="border border-gray-300">
                @foreach ($header as $item)
                    <th class="px-6 py-3 font-medium tracking-wider">
                        {{ $item }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($content as $index => $row)
                <tr class="text-left hover:bg-gray-200 border border-gray-300 @if($index % 2 != 0) bg-gray-100 hover:bg-gray-200 @endif">
                    @foreach ($row as $cell)
                        @if(is_array($cell) && array_key_exists('color', $cell) && array_key_exists('name', $cell))
                            <td class="px-6 py-4" style="color: {{ $cell['color'] }}">
                                {{ $cell['name'] }}
                            </td>
                        @else
                            <td class="px-6 py-4">{{ $cell }}</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h5 class="text-center text-gray-500">Nenhum resultado encontrado.</h5>
@endif
