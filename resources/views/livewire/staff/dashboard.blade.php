@assets
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets

<div class="flex h-full w-full flex-1 flex-col gap-8">
    <livewire:staff.dashboard.stats-cards />

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <livewire:staff.dashboard.egg-production-chart />
        <livewire:staff.dashboard.growth-phase-chart />
    </div>

    <livewire:staff.dashboard.recent-activity />
</div>
