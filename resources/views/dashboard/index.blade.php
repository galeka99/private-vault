@extends('template')
@section('title', 'Dashboard')
@section('content')
  <div class="flex flex-col shadow-md rounded-lg bg-gray-800 text-white gap-y-5 p-5 mb-5">
    <div class="flex flex-row gap-x-3 md:gap-x-5">
      <img src="{{ auth()->user()->image_url }}" class="rounded-full border-2 xs:w-12 md:w-28 lg:w-36"
        alt="user avatar">
      <div class="flex flex-col gap-y-3">
        <span class="text-xl font-bold">{{ auth()->user()->name }}</span>
        <span class="text-sm">{{ auth()->user()->email }}</span>
        <div class="flex-grow"></div>
        <div class="hidden md:flex flex-row gap-x-2">
          <button id="add-button" class="bg-green-600 hover:bg-green-700 text-white rounded px-4 py-2">Tambah
            Baru</button>
          <a href="{{ url('/logout') }}" class="bg-red-600 hover:bg-red-700 text-white rounded px-4 py-2">Keluar</a>
        </div>
      </div>
    </div>
    <hr class="md:hidden">
    <div class="flex flex-row justify-end md:hidden gap-x-2">
      <button id="add-button" class="bg-green-600 hover:bg-green-700 text-white rounded px-4 py-2">Tambah Baru</button>
      <a href="{{ url('/logout') }}" class="bg-red-600 hover:bg-red-700 text-white rounded px-4 py-2">Keluar</a>
    </div>
  </div>
  <div class="flex flex-row justify-end mb-3">
    <input type="text" name="q"
      class="bg-white border-2 border-r-0 active:border-2 active:border-r-0 border-gray-200 w-full lg:w-1/4 rounded-l px-3 py-2"
      placeholder="Pencarian">
    <button class="px-3 py-2 bg-blue-600 text-white rounded-r"><img src="{{ asset('img/search.svg') }}"
        alt="search icon" class="text-white w-4 h-4"></button>
  </div>
  <div class="w-full overflow-x-auto">
    <table class="table-auto w-full text-center divide-y-2 divide-white">
      <thead class="bg-blue-600 text-white uppercase">
        <tr class="divide-x-2 divide-white">
          <th class="p-2">No</th>
          <th>Judul</th>
          <th>Username</th>
          <th>Kata Sandi</th>
        </tr>
      </thead>
      <tbody class="bg-blue-50 divide-y-2 divide-white">
        @if ($accounts->total() == 0)
          <tr>
            <td colspan="6" class="p-2 uppercase text-center">Belum ada data</td>
          </tr>
        @else
          @foreach ($accounts as $account)
            <tr class="divide-x-2 divide-white cursor-pointer hover:bg-blue-100" data-id="{{ $account->id }}">
              <td class="p-2">{{ $loop->iteration }}</td>
              <td>{{ $account->title }}</td>
              <td>{{ $account->username }}</td>
              <td>{{ Crypt::decryptString($account->password) }}</td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
  </div>
  <div id="add-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-10 overflow-y-auto w-screen h-screen">
    <div class="flex flex-col justify-center items-center w-screen min-h-screen p-3">
      <form id="add-form" action="{{ url('/dashboard/add') }}" method="POST"
        class="flex flex-col justify-center items-center bg-white w-1/1 rounded shadow-lg w-full md:w-1/2 lg:w-1/3 p-3">
        @csrf
        <span class="text-lg font-semibold mb-5">Tambah Akun Baru</span>
        <input type="text" name="title" class="bg-white border-2 border-gray-200 rounded w-full py-2 px-3 mb-1"
          placeholder="Judul Akun" required>
        <span class="text-xs text-gray-500 w-full ml-2 mb-3">Misal: Google, Amazon, Facebook, Steam, dll.</span>
        <input type="text" name="username" class="bg-white border-2 border-gray-200 rounded w-full py-2 px-3 mb-3"
          placeholder="Username" required>
        <input type="text" name="password" class="bg-white border-2 border-gray-200 rounded w-full py-2 px-3 mb-5"
          placeholder="Kata Sandi" required>
        <button type="submit"
          class="bg-blue-600 hover:bg-blue-700 py-2 px-3 text-white font-semibold rounded w-full mb-2">Tambahkan
          Akun</button>
        <button type="button" id="close-modal"
          class="bg-red-600 hover:bg-red-700 py-2 px-3 text-white font-semibold rounded w-full">Batal</button>
      </form>
    </div>
  </div>
  </div>
  <script>
    document.querySelectorAll('button#add-button').forEach(el => {
      el.addEventListener('click', () => {
        const addModal = document.querySelector('div#add-modal');
        addModal.classList.toggle('hidden');
        document.querySelector('form#add-form input[name="title"]').focus();
      });
    });

    document.querySelector('button#close-modal').addEventListener('click', () => {
      const addModal = document.querySelector('div#add-modal');
      addModal.classList.toggle('hidden');
    });
  </script>
@endsection
