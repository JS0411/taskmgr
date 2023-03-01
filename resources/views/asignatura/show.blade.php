<x-app-layout>
    <x-slot name="header">
        <h2 style="display: flex; justify-content: space-between; align-items: center" class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $datos['nombre'] }}

            @if (Auth::user()->tipo == 'docente')
                <a href="{{ route('asignatura.edit', ['id' => $datos['id'], 'modo' => 'Cerrar']) }}" class="inline-block bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Cerrar Asignatura</a>
            @endif
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="">
                <h2 class="text-xl font-bold">Asignaciones Pendientes</h2>
                <div class="mb-4">
                    @if ($datos['actividades'] == null)
                        @if (Auth::user()->tipo == 'estudiante')
                            <p>No tienes actividades que entregar para esta semana.</p>
                        @else
                            <p class="my-4">No hay ninguna actividad, presione el boton para crear una.</p>
                        @endif
                    @else
                        <ul>
                            @foreach ($datos['actividades'] as $actividad)
                                @php $count = $loop->iteration @endphp
                                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mt-4">
                                    <a class="" href="/actividad/{{$actividad->id}}">
                                        <li style="display: flex; gap: 24px; margin-top: 4px">
                                            Tema {{$count}}. {{ $actividad->nombre}} - {{$actividad->modalidad}}
                                            <div>
                                                @if ($actividad->estado != 'Pendiente')
                                                    <p style="color: #666666">Finalizada</p>
                                                @else
                                                    <p style="color: #ff0000">Para entregar en {{$actividad->entrega()}}</p>
                                                @endif
                                            </div>
                                        </li>                                            
                                    </a>
                                </div>
                            @endforeach
                        </ul>
                    @endif
                </div>
                @if (Auth::user()->tipo == 'docente')
                    <a href="{{ route('actividad.create', ['id' => $datos['id']]) }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Crear Actividad</a>
                @endif
            </div>

            <div class="my-8">
                <h2 class="text-xl font-bold">Listado de Estudiantes</h2>
                <div>
                    @if ($datos['estudiantes']->isEmpty())
                        @if (Auth::user()->tipo == 'docente')
                            <p class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 my-4">No hay ningun estudiante, presione el boton para agregarlos</p>
                        @endif
                    @else
                        <ul>
                            @foreach ($datos['estudiantes'] as $estudiante)
                                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 mt-4">
                                    <li style="display: flex; gap: 24px; margin-top: 4px">
                                        {{ $estudiante->nombre }}, {{ $estudiante->apellido }} - V{{ $estudiante->cedula }}  
                                    </li>                                            
                                </div>
                            @endforeach
                        </ul>
                    @endif
                </div>
                @if (Auth::user()->tipo == 'docente')
                    <a href="{{ route('asignatura.edit', ['id' => $datos['id'], 'modo' => 'Invitar']) }}" class="inline-block bg-blue-500 text-white px-4 py-2 mt-4 rounded hover:bg-blue-600">Invitar Estudiantes</a>
                @endif
            </div>
        
    </div>

</x-app-layout>




