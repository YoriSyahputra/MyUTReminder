<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Mata Kuliah & Tugas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <a href="{{ route('matakuliah.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 mb-4">
                        Tambah Mata Kuliah Baru
                    </a>

                    {{-- Bagian ini akan menampilkan semua data dari variabel $mataKuliahs --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($mataKuliahs as $matkul)
                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow">
                                <h3 class="text-lg font-bold">{{ $matkul->nama_matkul }} ({{ $matkul->sks }} SKS)</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Jadwal: {{ \Carbon\Carbon::parse($matkul->jadwal)->format('d F Y, H:i') }}</p>
                                <p class="mt-2"><strong>Tugas:</strong> {{ $matkul->tugas }}</p>
                                <p class="mt-2 text-sm font-semibold">Status: <span class="px-2 py-1 rounded-full {{ $matkul->status == 'Selesai' ? 'bg-green-500 text-white' : 'bg-yellow-500 text-black' }}">{{ $matkul->status }}</span></p>
                            </div>
                        @empty
                            <p>Anda belum menambahkan mata kuliah apapun.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

