<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>
        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('asignatura.store') }}">
            @csrf

            <div>
                <x-label for="nombre" value="Nombre de Asignatura" />
                <x-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" placeholder="Desarrollo Web" required autofocus />
            </div>

            <div class="mt-4">
                <x-label for="descripcion" value="Descripción" />
                <x-input id="descripcion" class="block mt-1 w-full" type="text" name="descripcion" :value="old('descripcion')" placeholder="Descripción" required />
            </div>

            <div class="mt-4">
                <x-label for="carrera" value="Carrera" />
                <select id="carrera" name="carrera" class="form-select w-full" required>
                    <option value="Ingenieria en Informatica">Ingeniería en Informática</option>
                </select>
            </div>

            <input type="hidden" name="docente_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="carrera_id" value=1>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    Crear
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>