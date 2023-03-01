<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if ($datos['modo'] == 'Cerrar')
                {{ __('Cerrar Asignatura') }}
            @else
                {{ __('Invitar Estudiantes') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (!$datos['listado_estudiantes']->isEmpty())
                        <h2 class='font-semibold text-l mb-4'>Listado de Estudiantes</h2>
                        <form method="POST" action="{{ route('asignatura.update', ['id' => $datos['id'], 'modo' => 'Invitar']) }}">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-4 gap-4">
                                @foreach($datos['listado_estudiantes'] as $estudiante)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="estudiantes_invitados[]" value="{{ $estudiante->id }}" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                        <span class="ml-2">{{ $estudiante->nombre }} {{ $estudiante->apellido }} - {{ $estudiante->cedula }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 disabled:opacity-50" :disabled="!estudiantes_invitados.length">{{ __('Enviar Invitaciones') }}</button>
                            </div>
                        </form>
                    @else
                        <h2 class='font-semibold text-l mb-4'>No hay mas estudiantes, comuniquese con sus cursantes para que se unan a la aplicacion.</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
