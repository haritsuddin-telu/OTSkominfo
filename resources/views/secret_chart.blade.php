@extends('layouts.app')
@section('title', 'Grafik Pesan Rahasia')

<div class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6 text-blue-500">Grafik Jumlah Pesan Rahasia Terkirim</h2>
    <canvas id="secretChart" class="bg-white rounded-lg shadow p-4"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('secretChart').getContext('2d');
    const secretChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Jumlah Pesan Rahasia',
                data: @json($data),
                backgroundColor: 'rgba(90, 116, 234, 0.7)',
                borderColor: 'rgba(90, 116, 234, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: { title: { display: true, text: 'Rentang Waktu' } },
                y: { beginAtZero: true, title: { display: true, text: 'Jumlah Pesan' } }
            }
        }
    });
</script>
