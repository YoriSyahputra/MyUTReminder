<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Mata Kuliah & Tugas Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Form ini hanya untuk menambah data baru --}}
                    <form method="POST" action="{{ route('matakuliah.store') }}">
                        @csrf
                        
                        <!-- Pilih Mata Kuliah (Dropdown) -->
                        <div>
                            <x-input-label for="nama_matkul" :value="__('Pilih Mata Kuliah')" />
                            <select name="nama_matkul" id="nama_matkul" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="" disabled selected>-- Pilih Mata Kuliah --</option>
                                @foreach ($daftarMatkul as $matkul)
                                    <option value="{{ $matkul['nama'] }}" data-sks="{{ $matkul['sks'] }}">{{ $matkul['nama'] }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('nama_matkul')" class="mt-2" />
                        </div>

                        <!-- Jumlah SKS (Otomatis) -->
                        <div class="mt-4">
                            <x-input-label for="sks" :value="__('Jumlah SKS')" />
                            <x-text-input id="sks" class="block mt-1 w-full bg-gray-100 dark:bg-gray-800" type="number" name="sks" readonly required />
                            <x-input-error :messages="$errors->get('sks')" class="mt-2" />
                        </div>

                        <!-- Jadwal -->
                        <div class="mt-4">
                            <x-input-label for="jadwal" :value="__('Jadwal (Tanggal dan Jam)')" />
                            <x-text-input id="jadwal" class="block mt-1 w-full" type="datetime-local" name="jadwal" :value="old('jadwal')" required />
                            <x-input-error :messages="$errors->get('jadwal')" class="mt-2" />
                        </div>
                        
                        <!-- Deskripsi Tugas -->
                        <div class="mt-4">
                            <x-input-label for="tugas" :value="__('Deskripsi Tugas')" />
                            <textarea name="tugas" id="tugas" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('tugas') }}</textarea>
                            <x-input-error :messages="$errors->get('tugas')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk mengisi SKS secara otomatis --}}
    <script>
        document.getElementById('nama_matkul').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const sksValue = selectedOption.getAttribute('data-sks');
            document.getElementById('sks').value = sksValue;
        });
    </script>
</x-app-layout>

