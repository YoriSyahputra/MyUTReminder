<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="parent max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- ========== KONTEN BOX 1 (Progress & SKS) ========== --}}
        <div class="div1 flex flex-col justify-between">
            @if($totalMataKuliah > 0)
                <div>
                    <h3 class="text-lg font-bold mb-4">Progress & SKS</h3>
                    <div class="relative mx-auto" style="max-width: 250px;">
                        <canvas id="progressChart"></canvas>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <div class="stat-item">
                        <p class="text-2xl font-bold">{{ $totalSks }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total SKS Semester</p>
                    </div>
                    <div class="stat-item mt-2">
                        <p class="text-2xl font-bold">{{ $totalMataKuliah }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah Mata Kuliah</p>
                    </div>
                </div>
            @else
                <div class="flex flex-col items-center justify-center h-full">
                     <h3 class="text-lg font-bold mb-2">Belum Ada Data</h3>
                     <p class="text-sm text-gray-500 dark:text-gray-400 text-center">Tambahkan mata kuliah terlebih dahulu untuk melihat progress Anda.</p>
                     <a href="{{ route('matakuliah.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Tambah Mata Kuliah
                    </a>
                </div>
            @endif
        </div>

        {{-- ========== KONTEN BOX 2 (Analisis Tugas Interaktif) ========== ---}}
        <div class="div2 flex flex-col">
            @if($totalMataKuliah > 0)
            <h3 class="text-lg font-bold mb-4">Analisis Tren Tugas</h3>
            <div class="filters-container flex flex-wrap gap-4 items-start mb-4">
                <div class="time-filter flex-grow-[2] flex gap-x-2">
                    <div>
                        <label for="month-filter" class="block text-sm font-medium mb-1">Bulan:</label>
                        <select id="month-filter" class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm pl-3 pr-10 py-2 text-left focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></select>
                    </div>
                    <div>
                        <label for="year-filter" class="block text-sm font-medium mb-1">Tahun:</label>
                        <select id="year-filter" class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm pl-3 pr-10 py-2 text-left focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></select>
                    </div>
                </div>
                <div class="matkul-filter flex-grow-[3]">
                    <label class="block text-sm font-medium mb-1">Mata Kuliah & Status:</label>
                    <div id="matkul-filter-dropdown" class="relative">
                        <button id="matkul-filter-button" type="button" class="relative w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                          <span class="flex items-center"><span class="ml-1 block truncate button-text">Filter Pilihan</span></span>
                          <span class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                          </span>
                        </button>
                        <div id="matkul-filter-panel" class="absolute mt-1 w-96 max-w-sm rounded-md bg-white dark:bg-gray-700 shadow-lg z-10 hidden">
                           <div class="flex">
                                <div class="w-2/3 border-r border-gray-200 dark:border-gray-600">
                                    <ul class="max-h-56 rounded-l-md py-1 text-base overflow-auto focus:outline-none sm:text-sm">
                                        @foreach($uniqueMataKuliahsForFilter as $matkul)
                                        <li class="text-gray-900 dark:text-gray-200 cursor-default select-none relative py-2 pl-3 pr-9 hover:bg-gray-100 dark:hover:bg-gray-800">
                                          <div class="flex items-center">
                                            <input id="matkul-{{ $loop->index }}" name="matakuliah" type="checkbox" value="{{ $matkul->nama_matkul }}" class="matkul-checkbox h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:bg-gray-800 dark:border-gray-600 rounded" checked>
                                            <label for="matkul-{{ $loop->index }}" class="ml-3 block font-normal truncate cursor-pointer flex-1">{{ $matkul->nama_matkul }}</label>
                                          </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="w-1/3 p-2">
                                    <h4 class="text-xs font-bold uppercase text-gray-400 dark:text-gray-500 px-2 mb-1">Status</h4>
                                    <ul>
                                        <li><a href="#" class="status-option-inline text-sm block w-full text-left p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-800" data-status="Semua">Semua</a></li>
                                        <li><a href="#" class="status-option-inline text-sm block w-full text-left p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-800 active" data-status="Belum Selesai">Belum Selesai</a></li>
                                        <li><a href="#" class="status-option-inline text-sm block w-full text-left p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-800" data-status="Selesai">Selesai</a></li>
                                    </ul>
                                </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            <p id="dynamic-summary" class="text-sm text-gray-600 dark:text-gray-300 mb-2 h-5"></p>
            <div class="flex-grow relative">
                 <canvas id="timeSeriesChart"></canvas>
            </div>
            @else
            <div class="flex items-center justify-center h-full">
                <p class="text-gray-500">Data tugas akan muncul di sini setelah Anda menambahkannya.</p>
            </div>
            @endif
        </div>
        
        {{-- ========== KONTEN BOX 3 (Tenggat Waktu Terdekat) ========== --}}
        <div class="div3 flex flex-col">
            <h3 class="text-lg font-bold mb-4">Tenggat Terdekat</h3>
            <div id="upcoming-tasks-list" class="space-y-4 overflow-y-auto pr-2">
                {{-- Daftar tugas akan diisi oleh JavaScript --}}
            </div>
        </div>
        
        {{-- ========== KONTEN BOX 4 (Aksi Cepat) ========== --}}
        <div class="div4 flex items-center justify-center gap-4">
            <a href="{{ route('matakuliah.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                Tambah Tugas
            </a>
            <a href="{{ route('matakuliah.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Lihat Semua
            </a>
        </div>

        {{-- ========== KONTEN BOX 5 (Daftar Rinci Tugas) ========== --}}
        <div class="div5 flex flex-col">
            <h3 class="text-lg font-bold mb-4">Daftar Rinci Tugas (Belum Selesai)</h3>
            <div class="flex-grow overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Tugas</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Mata Kuliah</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tenggat</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tasks-table-body" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        {{-- Baris tabel akan diisi oleh JavaScript --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <style>
        .parent {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            /* --- PERBAIKAN UTAMA CSS --- */
            grid-template-rows: 1fr 1fr 1fr auto minmax(0, 2fr);
            gap: 16px;
            padding: 20px;
            min-height: 80vh;
        }
        .div1, .div2, .div3, .div4, .div5 { background-color: #ffffff; border-radius: 20px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); padding: 20px; transition: all 0.3s ease; }
        @media (prefers-color-scheme: dark) { .div1, .div2, .div3, .div4, .div5 { background-color: rgb(31, 41, 55); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3); color: #ffffff; } }
        
        .div1 { grid-area: 1 / 1 / 5 / 2; }
        .div2 { grid-area: 1 / 2 / 5 / 5; }
        .div3 { 
            grid-area: 1 / 5 / 4 / 6;
            min-height: 0; /* <-- Ini penting agar overflow bekerja */
        }
        .div4 { grid-area: 4 / 5 / 5 / 6; }
        .div5 { 
            grid-area: 5 / 1 / 6 / 6;
            min-height: 0; /* Mencegah bug flexbox/grid di row terakhir */
        }

        .status-option-inline.active { background-color: rgb(79 70 229 / 1); color: white; }
        .dark .status-option-inline.active { background-color: rgb(79 70 229 / 1); }
        @media (max-width: 768px) { .parent { grid-template-columns: 1fr; grid-template-rows: auto; } .div1, .div2, .div3, .div4, .div5 { grid-column: 1 / -1; grid-row: auto; } }
    </style>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- ================= SCRIPT 1: UNTUK BOX 1 (PROGRESS & SKS) ================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if($totalMataKuliah > 0)
                const progressCtx = document.getElementById('progressChart').getContext('2d');
                const textColor = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'rgba(255, 255, 255, 0.8)' : 'rgba(0, 0, 0, 0.8)';
                new Chart(progressCtx, { type: 'doughnut', data: { labels: ['Selesai', 'Belum Selesai'], datasets: [{ label: 'Status Tugas', data: [{{ $tugasSelesai }}, {{ $tugasBelumSelesai }}], backgroundColor: ['rgba(75, 192, 192, 0.7)', 'rgba(255, 99, 132, 0.7)'], borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'], borderWidth: 1 }] }, options: { responsive: true, cutout: '70%', plugins: { legend: { position: 'bottom', labels: { color: textColor, boxWidth: 20, padding: 20 } } } } });
            @endif
        });
    </script>
    
    {{-- ================= SCRIPT 2: UNTUK BOX 2 (CHART INTERAKTIF & FILTER) ================= --}}
    <script>
        let allTasks = []; // Dibuat global agar bisa diakses script lain
        let updateDashboard; // Dibuat global agar bisa diakses script lain

        document.addEventListener('DOMContentLoaded', function () {
            @if($totalMataKuliah > 0)
                allTasks = @json($allMataKuliahsForJs).map(task => {
                    task.jadwalDate = new Date(task.jadwal);
                    return task;
                });

                let selectedStatus = 'Belum Selesai';
                let timeFilteredTasks = [];
                const chartCtx = document.getElementById('timeSeriesChart').getContext('2d');
                const summaryEl = document.getElementById('dynamic-summary');
                const matkulCheckboxes = document.querySelectorAll('.matkul-checkbox');
                const textColor = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'rgba(255, 255, 255, 0.8)' : 'rgba(0, 0, 0, 0.8)';
                const monthFilter = document.getElementById('month-filter');
                const yearFilter = document.getElementById('year-filter');
                const statusOptionsInline = document.querySelectorAll('.status-option-inline');

                const colorPalette = [
                    'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'
                ];

                const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                const currentMonth = new Date().getMonth();
                const currentYear = new Date().getFullYear();
                monthNames.forEach((month, index) => { monthFilter.options[monthFilter.options.length] = new Option(month, index); });
                monthFilter.value = currentMonth;
                for (let i = currentYear - 2; i <= currentYear + 2; i++) { yearFilter.options[yearFilter.options.length] = new Option(i, i); }
                yearFilter.value = currentYear;
                
                const timeSeriesChart = new Chart(chartCtx, {
                    type: 'line', data: { labels: [], datasets: [] },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        scales: { y: { beginAtZero: true, ticks: { color: textColor, stepSize: 1 } }, x: { ticks: { color: textColor } } },
                        plugins: {
                            legend: { display: true, position: 'bottom', labels: { color: textColor } },
                            tooltip: {
                                callbacks: {
                                    title: function(context) { return `Tugas Tanggal ${context[0].label}`; },
                                    label: function(context) {
                                        const matkulName = context.dataset.label;
                                        const day = parseInt(context.label, 10);
                                        const tasksOnDay = timeFilteredTasks.filter(t => t.nama_matkul === matkulName && t.jadwalDate.getDate() === day);
                                        return tasksOnDay.map(t => `  - ${t.tugas}`);
                                    }
                                }
                            }
                        }
                    }
                });

                updateDashboard = function() {
                    const selectedMatkuls = Array.from(matkulCheckboxes).filter(cb => cb.checked).map(cb => cb.value);
                    const selectedMonth = parseInt(monthFilter.value, 10);
                    const selectedYear = parseInt(yearFilter.value, 10);
                    timeFilteredTasks = allTasks.filter(task => {
                        const statusMatch = (selectedStatus === 'Semua') ? true : (task.status === selectedStatus);
                        const courseMatch = selectedMatkuls.includes(task.nama_matkul);
                        const timeMatch = task.jadwalDate.getMonth() === selectedMonth && task.jadwalDate.getFullYear() === selectedYear;
                        return statusMatch && courseMatch && timeMatch;
                    });
                    const daysInMonth = new Date(selectedYear, selectedMonth + 1, 0).getDate();
                    const chartLabels = Array.from({ length: daysInMonth }, (_, i) => i + 1);
                    const newDatasets = [];
                    selectedMatkuls.forEach((matkul, index) => {
                        const dataForMatkul = Array(daysInMonth).fill(0);
                        const tasksForMatkul = timeFilteredTasks.filter(t => t.nama_matkul === matkul);
                        tasksForMatkul.forEach(task => {
                            const dayOfMonth = task.jadwalDate.getDate();
                            if (dayOfMonth > 0 && dayOfMonth <= daysInMonth) { dataForMatkul[dayOfMonth - 1] += 1; }
                        });
                        newDatasets.push({
                            label: matkul, data: dataForMatkul,
                            borderColor: colorPalette[index % colorPalette.length],
                            fill: false, tension: 0.1
                        });
                    });
                    timeSeriesChart.data.labels = chartLabels;
                    timeSeriesChart.data.datasets = newDatasets;
                    timeSeriesChart.update();
                    updateSummary(selectedMatkuls, timeFilteredTasks);
                    updateUpcomingTasks(allTasks);
                    updateTasksTable(allTasks);
                }
                
                function updateSummary(selectedMatkuls, tasks) {
                    const totalTugas = tasks.length;
                    summaryEl.innerText = `Ditemukan ${totalTugas} tugas untuk ${selectedMatkuls.length} mata kuliah terpilih.`;
                }
                
                const matkulFilterDropdown = document.getElementById('matkul-filter-dropdown');
                const matkulFilterButton = document.getElementById('matkul-filter-button');
                const matkulFilterPanel = document.getElementById('matkul-filter-panel');
                matkulFilterButton.addEventListener('click', () => matkulFilterPanel.classList.toggle('hidden'));
                window.addEventListener('click', (e) => { 
                    if (!matkulFilterDropdown.contains(e.target)) { matkulFilterPanel.classList.add('hidden'); }
                });

                function updateButtonText(selectedMatkuls) {
                    const buttonTextEl = matkulFilterButton.querySelector('.button-text');
                    if (selectedMatkuls.length === matkulCheckboxes.length) { buttonTextEl.innerText = 'Semua Mata Kuliah'; } 
                    else if (selectedMatkuls.length > 0) { buttonTextEl.innerText = `${selectedMatkuls.length} Matkul Dipilih`; } 
                    else { buttonTextEl.innerText = 'Tidak Ada Pilihan'; }
                }

                monthFilter.addEventListener('change', updateDashboard);
                yearFilter.addEventListener('change', updateDashboard);
                matkulCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', () => {
                        updateButtonText(Array.from(matkulCheckboxes).filter(cb => cb.checked));
                        updateDashboard();
                    });
                });
                statusOptionsInline.forEach(option => {
                    option.addEventListener('click', (e) => {
                        e.preventDefault();
                        selectedStatus = e.target.dataset.status;
                        statusOptionsInline.forEach(opt => opt.classList.remove('active'));
                        e.target.classList.add('active');
                        updateDashboard();
                    });
                });

                document.querySelector('.status-option-inline[data-status="Belum Selesai"]').classList.add('active');
                updateButtonText(Array.from(matkulCheckboxes).filter(cb => cb.checked));
                updateDashboard();
            @endif
        });
    </script>
    
    {{-- ================= SCRIPT 3: UNTUK BOX 3 (TENGGAT TERDEKAT) ================= --}}
    <script>
        function formatTimeRemaining(taskDate) {
            const now = new Date();
            const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            const deadline = new Date(taskDate.getFullYear(), taskDate.getMonth(), taskDate.getDate());
            const diffTime = deadline - today;
            const diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays < 0) return 'Telah Lewat';
            if (diffDays === 0) return 'Hari ini';
            if (diffDays === 1) return 'Besok';
            return `dalam ${diffDays} hari`;
        }

        function updateUpcomingTasks(tasks) {
            const upcomingTasksContainer = document.getElementById('upcoming-tasks-list');
            if (!upcomingTasksContainer) return;
            upcomingTasksContainer.innerHTML = '';
            const now = new Date();
            const upcoming = tasks
                .filter(task => task.status === 'Belum Selesai' && task.jadwalDate >= now)
                .sort((a, b) => a.jadwalDate - b.jadwalDate)
                .slice(0, 4);
            if (upcoming.length === 0) {
                upcomingTasksContainer.innerHTML = `<p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada tugas mendatang.</p>`;
                return;
            }
            upcoming.forEach(task => {
                const timeRemaining = formatTimeRemaining(task.jadwalDate);
                const taskElement = `
                    <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50">
                        <div class="flex justify-between items-center">
                            <p class="font-bold text-sm truncate">${task.tugas}</p>
                            <span class="text-xs font-semibold px-2 py-1 rounded-full ${timeRemaining === 'Hari ini' || timeRemaining === 'Besok' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'}">${timeRemaining}</span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">${task.nama_matkul}</p>
                    </div>
                `;
                upcomingTasksContainer.innerHTML += taskElement;
            });
        }
    </script>

    {{-- ================= SCRIPT 4: UNTUK BOX 5 (TABEL TUGAS INTERAKTIF) ================= --}}
    <script>
        function formatDate(taskDate) {
            let date = new Date(taskDate);
            return `${date.getDate().toString().padStart(2, '0')}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getFullYear()}`;
        }

        function attachEventListeners() {
            const tableBody = document.getElementById('tasks-table-body');
            
            tableBody.addEventListener('change', function(e) {
                if (e.target.matches('.task-status-checkbox')) {
                    handleStatusChange(e);
                }
            });

            tableBody.addEventListener('click', function(e) {
                if (e.target.matches('.delete-task-button')) {
                    handleDeleteTask(e);
                }
            });
        }

        function handleStatusChange(e) {
            const taskId = e.target.dataset.taskId;
            const newStatus = e.target.checked ? 'Selesai' : 'Belum Selesai';

            fetch(`/matakuliah/${taskId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const taskIndex = allTasks.findIndex(t => t.id == taskId);
                    if(taskIndex !== -1) {
                        allTasks[taskIndex].status = newStatus;
                    }
                    updateDashboard(); 
                } else {
                    alert('Gagal memperbarui status.');
                    e.target.checked = !e.target.checked;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan.');
                e.target.checked = !e.target.checked;
            });
        }

        function handleDeleteTask(e) {
            e.preventDefault();
            const button = e.currentTarget;
            const taskId = button.dataset.taskId;
            
            if (confirm('Apakah Anda yakin ingin menghapus tugas ini?')) {
                fetch(`/matakuliah/${taskId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const taskIndex = allTasks.findIndex(t => t.id == taskId);
                        if(taskIndex !== -1) {
                            allTasks.splice(taskIndex, 1);
                        }
                        updateDashboard();
                    } else {
                        alert(data.message || 'Gagal menghapus tugas.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus tugas.');
                });
            }
        }

        function updateTasksTable(tasks) {
            const tableBody = document.getElementById('tasks-table-body');
            if (!tableBody) return;

            const unfinishedTasks = tasks
                .filter(task => task.status === 'Belum Selesai')
                .sort((a, b) => a.jadwalDate - b.jadwalDate);

            if (unfinishedTasks.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada tugas yang belum selesai.</td></tr>`;
                return;
            }

            let tableRows = '';
            unfinishedTasks.forEach(task => {
                const editUrl = `{{ url('matakuliah') }}/${task.id}/edit`;
                tableRows += `
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="task-status-checkbox rounded text-indigo-600" data-task-id="${task.id}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">${task.tugas}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">${task.nama_matkul}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">${formatDate(task.jadwalDate)}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-4">
                            <a href="${editUrl}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                            <button data-task-id="${task.id}" class="delete-task-button text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
                        </td>
                    </tr>
                `;
            });
            tableBody.innerHTML = tableRows;
        }

        // Jalankan attachEventListeners sekali saat DOM siap
        document.addEventListener('DOMContentLoaded', attachEventListeners);
    </script>
    @endpush
</x-app-layout>