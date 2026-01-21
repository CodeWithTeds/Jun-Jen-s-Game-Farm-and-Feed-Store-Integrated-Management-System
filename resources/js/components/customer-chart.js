document.addEventListener('alpine:init', () => {
    Alpine.data('customerSpendingChart', (initialData) => ({
        chart: null,
        
        init() {
            // Initial render
            this.renderChart(initialData);

            // Watch for Livewire updates to the chart data
            // Note: Since Livewire re-renders the DOM, this component might be re-initialized.
            // But if we use wire:ignore on the canvas or container, we might need to listen to events.
            // For now, let's assume Livewire re-initializes this component with new data passed via blade.
        },

        renderChart(data) {
            const ctx = this.$refs.canvas.getContext('2d');
            
            // Cleanup existing chart
            if (this.chart) {
                this.chart.destroy();
            }

            const isDark = document.documentElement.classList.contains('dark');
            const gridColor = isDark ? '#27272a' : '#f4f4f5'; // zinc-800 : zinc-100
            const textColor = '#71717a'; // zinc-500

            this.chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(d => d.date),
                    datasets: [{
                        label: 'Spending',
                        data: data.map(d => d.total),
                        borderColor: '#10b981', // Green-500
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: isDark ? '#18181b' : '#ffffff',
                            titleColor: isDark ? '#e4e4e7' : '#18181b',
                            bodyColor: isDark ? '#a1a1aa' : '#52525b',
                            borderColor: isDark ? '#27272a' : '#e4e4e7',
                            borderWidth: 1,
                            padding: 10,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return 'Spent: ₱' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            grid: { 
                                color: gridColor,
                                borderDash: [4, 4],
                                drawBorder: false
                            },
                            ticks: { 
                                callback: value => '₱' + value,
                                color: textColor,
                                font: { size: 11 }
                            }
                        },
                        x: { 
                            grid: { display: false },
                            ticks: { 
                                color: textColor,
                                font: { size: 11 }
                            }
                        }
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false
                    }
                }
            });
        }
    }));
});
