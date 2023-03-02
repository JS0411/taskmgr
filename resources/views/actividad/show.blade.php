<x-app-layout>
    <x-slot name="header">
        <h2 style="display: flex; justify-content: space-between; align-items: center" class="font-semibold text-xl text-gray-800 leading-tight">
            Actividad - {{ $datos['modalidad'] }}

            @if (Auth::user()->tipo == 'docente' && $datos['estado'] == 'Pendiente')
                <a href="{{ route('actividad.edit', ['id' => $datos['id']]) }}" class="inline-block bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Evaluar Actividad</a>
            @endif
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="">
                <h2 class="text-xl font-bold">Detalles de la Actividad</h2>
                <div class="mb-4">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mt-4">
                            <li style="display: flex; gap: 24px; margin-top: 4px">
                                {{ $datos['descripcion'] }} - {{ $datos['modalidad'] }} - Ponderacion: {{$datos['puntuacionMaxima']}}, @if(Auth::user()->tipo=='estudiante' && $datos['estado'] == 'Finalizado') Puntuacion Adquirida: {{$datos['puntuacion']}}@endif
                                <div>
                                    @if ($datos['estado'] != 'Pendiente')
                                        <p style="color: #666666">Finalizada</p>
                                    @else
                                        <p style="color: #ff0000">{{$datos['fecha_entrega']}}</p>
                                    @endif
                                </div>
                            </li>      
                            @if (Auth::user()->tipo == 'estudiante' && $datos['estado'] == 'Pendiente' && $datos['fecha_entrega'] != 'Pendiente por evaluar')
                                <form action="{{ route('actividad.update', ['id' => $datos['id']]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type=submit class="inline-block bg-blue-500 text-white px-4 py-2 mt-3 rounded hover:bg-blue-600">Entregar Actividad</button>
                                </form>
                            @endif                                      
                        </div>
                </div>
            </div>
        
    </div>

</x-app-layout>




