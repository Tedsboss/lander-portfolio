<div class="project-visual {{ $project['theme'] }}" aria-hidden="true">
    <span class="visual-top">{{ strtoupper($project['label']) }}</span><span class="visual-grid"></span>
    @switch($project['id'])
        @case('direk')
            <div class="sheets"><i></i><i></i><i><b></b><b></b><b></b></i></div>
            @break
        @case('npmcs')
            <div class="monitor-mark"><i></i><i></i><i></i><i></i><span></span></div>
            @break
        @default
            <div class="innovation-mark"><i></i><i></i><i></i><b></b></div>
    @endswitch
    <span class="visual-bottom">{{ $project['visual'] }}</span><span class="visual-number">{{ str_pad((string) $project['number'], 2, '0', STR_PAD_LEFT) }}</span>
</div>
