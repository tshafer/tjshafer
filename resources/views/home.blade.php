@extends('layouts.site')

@section('content')
    <section class="max-w-6xl mx-auto px-5 sm:px-8 py-14 lg:py-20">
        <div class="max-w-3xl rounded-sm border border-white/10 bg-panel p-6 sm:p-8 text-sm sm:text-base leading-relaxed">
            <p><span class="text-copper">tj@shafer.llc</span><span class="text-muted">:~$</span> whoami</p>
            <h1 class="text-warm mb-4">Tom Shafer. Software under Shafer LLC. Arizona.</h1>

            <p><span class="text-copper">tj@shafer.llc</span><span class="text-muted">:~$</span> cat about</p>
            <p class="text-muted mb-4">
                Works at <a href="https://fiscalnote.com" rel="noopener" class="text-warm hover:text-copper">FiscalNote</a>.
                Maintains <a href="https://www.washingtonian.com" rel="noopener" class="text-warm hover:text-copper">Washingtonian</a>.
            </p>

            <p><span class="text-copper">tj@shafer.llc</span><span class="text-muted">:~$</span> ls</p>
            <nav class="flex flex-wrap gap-x-6 gap-y-1 mb-4" aria-label="Sections">
                <a href="{{ route('projects.index') }}" class="text-[#8fbf8f] hover:text-copper">projects/</a>
                <a href="{{ route('writing.index') }}" class="text-[#8fbf8f] hover:text-copper">writing/</a>
                <a href="mailto:tj@tjshafer.com" class="hover:text-copper">tj@tjshafer.com</a>
            </nav>

            <p><span class="text-copper">tj@shafer.llc</span><span class="text-muted">:~$</span> <span class="inline-block w-2.5 h-5 align-middle bg-copper motion-safe:animate-[cursor-blink_1.1s_steps(1)_infinite]" aria-hidden="true"></span></p>
        </div>
    </section>
@endsection
