document.addEventListener('alpine:init', () => {
    Alpine.data('customerSpendingChart', (initialData) => ({
        chart: null,
        
        init() {
            this.renderChart(initialData);
        },

        renderChart(data) {
            const ctx = this.$refs.canvas.getContext('2d');
            
            if (this.chart) {
                this.chart.destroy();
            }

            const isDark = document.documentElement.classList.contains('dark');
            const gridColor = isDark ? '#27272a' : '#f4f4f5';
            const textColor = '#71717a';

            this.chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(d => d.date),
                    datasets: [{
                        label: 'Spending',
                        data: data.map(d => d.total),
                        backgroundColor: '#2d9a85',
                        borderColor: '#247969',
                        borderWidth: 1,
                        borderRadius: 6,
                        barPercentage: 0.8,
                        categoryPercentage: 0.9
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
                                callback: value => '₱' + (value >= 1000 ? (value/1000) + 'k' : value),
                                color: textColor,
                                font: { size: 11 }
                            }
                        },
                        x: { 
                            grid: { display: false },
                            ticks: { 
                                color: textColor,
                                font: { size: 10 },
                                maxRotation: 45,
                                minRotation: 0
                            }
                        }
                    }
                }
            });
        }
    }));

    Alpine.data('productCategoryChart', (initialData) => ({
        chart: null,
        init() {
            this.renderChart(initialData);
        },
        renderChart(data) {
            const ctx = this.$refs.canvas.getContext('2d');
            if (this.chart) this.chart.destroy();
            const isDark = document.documentElement.classList.contains('dark');
            this.chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data.map(d => d.category),
                    datasets: [{
                        data: data.map(d => d.val),
                        backgroundColor: ['#059669', '#6ee7b7', '#10b981'],
                        borderWidth: 0,
                        hoverOffset: 12
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: isDark ? '#18181b' : '#ffffff',
                            titleColor: isDark ? '#e4e4e7' : '#18181b',
                            borderColor: isDark ? '#27272a' : '#e4e4e7',
                            borderWidth: 1,
                            padding: 10,
                            displayColors: false
                        }
                    }
                }
            });
        }
    }));
});
