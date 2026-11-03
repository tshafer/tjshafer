@extends('layouts.site')

@section('content')
    <section class="max-w-6xl mx-auto px-5 sm:px-8 py-14 lg:py-20">
        <div class="max-w-3xl rounded-sm border border-white/10 bg-panel p-6 sm:p-8 text-sm sm:text-base leading-relaxed">
            <p><span class="text-copper">tom@shafer.llc</span><span class="text-muted">:~$</span> whoami</p>
            <h1 class="text-warm mb-4">Tom Shafer. I run Shafer LLC: Laravel, WordPress, and PHP + Vue. Arizona.</h1>

            <p><span class="text-copper">tom@shafer.llc</span><span class="text-muted">:~$</span> cat about</p>
            <p class="text-muted mb-4">
                Maintains <a href="https://www.washingtonian.com" rel="noopener" class="text-warm hover:text-copper">Washingtonian</a>.
                Also at <a href="https://fiscalnote.com" rel="noopener" class="text-warm hover:text-copper">FiscalNote</a>.
            </p>

            <p><span class="text-copper">tom@shafer.llc</span><span class="text-muted">:~$</span> ls</p>
            <nav class="flex flex-wrap gap-x-6 gap-y-1 mb-4" aria-label="Sections">
                <a href="https://shafer.llc/services" rel="noopener" class="text-[#8fbf8f] hover:text-copper">services/</a>
                <a href="https://shafer.llc/portfolio" rel="noopener" class="text-[#8fbf8f] hover:text-copper">work/</a>
                <a href="{{ route('projects.index') }}" class="text-[#8fbf8f] hover:text-copper">projects/</a>
                <a href="mailto:tom@shafer.llc" class="hover:text-copper">tom@shafer.llc</a>
            </nav>

            <p><span class="text-copper">tom@shafer.llc</span><span class="text-muted">:~$</span> <a href="https://shafer.llc/contact" rel="noopener" class="text-warm underline underline-offset-4 hover:text-copper">./start-a-project</a></p>

            <p><span class="text-copper">tom@shafer.llc</span><span class="text-muted">:~$</span> <span class="inline-block w-2.5 h-5 align-middle bg-copper motion-safe:animate-[cursor-blink_1.1s_steps(1)_infinite]" aria-hidden="true"></span></p>
        </div>
    </section>
@endsection
