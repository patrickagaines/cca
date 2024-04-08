@props(['service' => null])

<form
    id="services_form"
    action="{{
        isset($service) ?
        route('dashboard.services.update', ['service' => $service]) :
        route('dashboard.services.store')
    }}"
    method="POST"
    enctype="multipart/form-data"
>
    @csrf
    @isset($service)
        @method('PUT')
    @endisset
    <div class="mb-4 flex justify-end">
        <x-primary-button>
            Save
        </x-primary-button>
    </div>
    <div class="mb-6">
        <x-input-label for="name">
            Name
            <span class="text-red-600">*</span>
        </x-input-label>
        <x-text-input
            id="name"
            name="name"
            class="w-full"
            required
            maxlength="60"
            value="{{ $service->name ?? old('name') }}"
        />
        <x-input-error :messages="$errors->get('title')"/>
    </div>
    <div class="mb-6">
        <x-input-label for="description">
            Description
            <span class="text-red-600">*</span>
        </x-input-label>
        <textarea
            id="description"
            name="description"
            class="box-border w-full rounded-md border-gray-300 shadow-sm min-h-[920px] focus:border-indigo-500 focus:ring-indigo-500 sm:min-h-[560px] md:min-h-[460px] lg:min-h-[320px]"
            required
            maxlength="1500"
        >{{ $service->description ?? old('description') }}</textarea>
    </div>
</form>
