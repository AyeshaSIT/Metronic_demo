<div class="flex">
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <x-nav-link :href="route('f-audiocalls.create')" :active="request()->routeIs('f-audiocalls.create')">
            {{ __('Insert Record') }}
        </x-nav-link>
    </div>
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <x-nav-link :href="route('f-audiocalls.index')" :active="request()->routeIs('f-audiocalls.index')">
            {{ __('View Record') }}
        </x-nav-link>
    </div>
</div>