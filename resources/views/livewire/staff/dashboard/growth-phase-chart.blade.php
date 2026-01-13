<div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6 shadow-sm"
    x-data="{
        statusData: @js($fowlStatus),
        init() {
            const ctx = this.$refs.canvas.getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(this.statusData),
                    datasets: [{
                        data: Object.values(this.statusData),
                        backgroundColor: [
                            '#10b981', '#ef4444', '#f59e0b', '#6366f1', '#8b5cf6', '#ec4899', '#06b6d4'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: { boxWidth: 12 }
                        }
                    }
                }
            });
        }
    }"
>
    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Game Fowl Growth Phase</h3>
    <div class="relative h-64 w-full flex justify-center">
        <canvas x-ref="canvas"></canvas>
    </div>
</div>
