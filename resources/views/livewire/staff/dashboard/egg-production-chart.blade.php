<div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6 shadow-sm"
    x-data="{
        labels: @js($labels),
        values: @js($values),
        init() {
            const ctx = this.$refs.canvas.getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: this.labels,
                    datasets: [{
                        label: 'Eggs Collected',
                        data: this.values,
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(156, 163, 175, 0.1)' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }
    }"
>
    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Egg Collection Trend (Last 7 Days)</h3>
    <div class="relative h-64 w-full">
        <canvas x-ref="canvas"></canvas>
    </div>
</div>
