@php
    $main = [
        ['route' => 'home', 'label' => 'Home', 'params' => []],
        ['route' => 'projects.index', 'label' => 'Projects', 'params' => []],
        ['route' => 'writing.index', 'label' => 'Writing', 'params' => []],
        ['route' => 'now', 'label' => 'Now', 'params' => []],
        ['route' => 'music', 'label' => 'Music', 'params' => []],
        ['route' => 'contact', 'label' => 'Contact', 'params' => []],
    ];
    $more = [
        ['route' => 'uses', 'label' => 'Uses'],
        // ['route' => 'speaking', 'label' => 'Speaking'], // uncomment + restore /speaking route
        ['route' => 'booking', 'label' => 'Book'],
        ['route' => 'resume', 'label' => 'Résumé'],
        ['route' => 'colophon', 'label' => 'Colophon'],
    ];
@endphp

<div class="flex items-center gap-3 lg:gap-5 shrink-0">
    <div class="hidden lg:flex flex-wrap items-center justify-end gap-x-5 gap-y-1">
        @foreach ($main as $item)
            @php
                $active = $item['route'] === 'writing.index'
                    ? request()->routeIs('writing.index', 'writing.show')
                    : request()->routeIs($item['route']);
            @endphp
            <a href="{{ route($item['route'], $item['params']) }}"
               class="text-sm font-medium transition-colors {{ $active ? 'text-warm' : 'text-muted hover:text-warm' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
        <span class="text-muted/40 select-none" aria-hidden="true">|</span>
        @foreach ($more as $item)
            <a href="{{ route($item['route']) }}"
               class="text-xs font-medium uppercase tracking-wider transition-colors {{ request()->routeIs($item['route']) ? 'text-copper' : 'text-muted hover:text-copper' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
        <a href="{{ route('feed') }}" class="text-xs font-mono text-muted hover:text-warm transition-colors" title="RSS">RSS</a>
    </div>

    <details class="lg:hidden relative group">
        <summary class="cursor-pointer list-none rounded-sm border border-white/15 px-3 py-2 text-sm text-warm hover:border-copper/40 transition-colors">
            <span class="font-medium">Menu</span>
        </summary>
        <div class="absolute right-0 top-full z-50 mt-2 min-w-[14rem] rounded-sm border border-white/10 bg-panel py-3 shadow-xl">
            @foreach ($main as $item)
                @php
                    $mActive = $item['route'] === 'writing.index'
                        ? request()->routeIs('writing.index', 'writing.show')
                        : request()->routeIs($item['route']);
                @endphp
                <a href="{{ route($item['route'], $item['params']) }}"
                   class="block px-4 py-2 text-sm {{ $mActive ? 'bg-panel-2 text-warm' : 'text-muted hover:bg-panel-2 hover:text-warm' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
            <div class="my-2 border-t border-white/10"></div>
            @foreach ($more as $item)
                <a href="{{ route($item['route']) }}"
                   class="block px-4 py-2 text-xs uppercase tracking-wider {{ request()->routeIs($item['route']) ? 'text-copper bg-panel-2' : 'text-muted hover:bg-panel-2 hover:text-copper' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
            <a href="{{ route('feed') }}" class="block px-4 py-2 text-xs font-mono text-muted hover:text-warm">RSS feed</a>
        </div>
    </details>
</div>
