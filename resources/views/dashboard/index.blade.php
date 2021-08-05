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
          <a href="{{ url('/dashboard/log') }}"
            class="bg-purple-600 hover:bg-purple-700 text-white rounded px-4 py-2">Riwayat</a>
          <a href="{{ url('/logout') }}" class="bg-red-600 hover:bg-red-700 text-white rounded px-4 py-2">Keluar</a>
        </div>
      </div>
    </div>
    <hr class="md:hidden">
    <div class="flex flex-row justify-end md:hidden gap-x-2">
      <button id="add-button" class="bg-green-600 hover:bg-green-700 text-white text-center rounded px-4 py-2">Tambah
        Baru</button>
      <a href="{{ url('/dashboard/log') }}"
        class="bg-purple-600 hover:bg-purple-700 text-white text-center rounded px-4 py-2">Riwayat</a>
      <a href="{{ url('/logout') }}"
        class="bg-red-600 hover:bg-red-700 text-white text-center rounded px-4 py-2">Keluar</a>
    </div>
  </div>
  <form class="flex flex-row justify-end mb-3" action="{{ url('/dashboard') }}" method="GET">
    <input type="text" name="q"
      class="bg-white border-2 border-r-0 border-gray-200 focus:border-blue-600 focus:outline-none w-full lg:w-1/4 rounded-l px-3 py-2"
      placeholder="Pencarian" value="{{ request()->get('q') }}">
    <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-r"><img src="{{ asset('img/search.svg') }}"
        alt="search icon" class="text-white w-4 h-4"></button>
    @if (request()->has('q'))
      <a href="{{ url('/dashboard') }}"
        class="flex flex-col justify-center items-center bg-red-600 hover:bg-red-700 text-white rounded-full px-3 py-2 ml-2">
        <img src="{{ asset('img/refresh-outline.svg') }}" alt="" width="24" height="24">
      </a>
    @endif
  </form>
  <div class="w-full overflow-x-auto pb-3">
    <table class="table-auto w-full text-center divide-y-2 divide-white">
      <thead class="bg-blue-600 text-white uppercase">
        <tr class="divide-x-2 divide-white">
          <th class="p-2">No</th>
          <th class="p-2">Judul</th>
          <th class="p-2">Username</th>
          <th class="p-2">Kata Sandi</th>
        </tr>
      </thead>
      <tbody id="account-list" class="bg-blue-50 divide-y-2 divide-white">
        @if ($accounts->total() == 0)
          <tr>
            @if (request()->has('q'))
              <td colspan="6" class="p-2 uppercase text-center">Tidak ditemukan akun dengan kata kunci
                '{{ request()->get('q') }}'</td>
            @else
              <td colspan="6" class="p-2 uppercase text-center">Belum ada akun ditambahkan</td>
            @endif
          </tr>
        @else
          @foreach ($accounts as $account)
            <tr class="divide-x-2 divide-white cursor-pointer hover:bg-blue-100" data-id="{{ $account->id }}"
              data-password="{{ Crypt::decryptString($account->password) }}">
              <td class="p-2">{{ $loop->iteration }}</td>
              <td class="p-2">{{ $account->title }}</td>
              <td class="p-2">{{ $account->username }}</td>
              <td class="p-2">{{ str_repeat('*', strlen(Crypt::decryptString($account->password))) }}</td>
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
        <input type="text" name="title"
          class="bg-white border-2 border-gray-200 focus:border-blue-600 focus:outline-none rounded w-full py-2 px-3 mb-1"
          placeholder="Judul Akun" required>
        <span class="text-xs text-gray-500 w-full ml-2 mb-3">Misal: Google, Amazon, Facebook, Steam, dll.</span>
        <input type="text" name="username"
          class="bg-white border-2 border-gray-200 focus:border-blue-600 focus:outline-none rounded w-full py-2 px-3 mb-3"
          placeholder="Username" required>
        <div class="flex flex-row items-center w-full mb-5">
          <input type="password" name="password"
            class="bg-white border-2 border-gray-200 focus:border-blue-600 focus:outline-none rounded w-full py-2 px-3"
            placeholder="Kata Sandi" required>
          <div id="hide-show-password-1" class="py-2 px-4 cursor-pointer">
            <img id="hidden-password-1" class="" src="{{ asset('img/eye-off-outline.svg') }}" alt="" width="24"
              height="24">
            <img id="show-password-1" class="hidden" src="{{ asset('img/eye-outline.svg') }}" alt="" width="24"
              height="24">
          </div>
        </div>
        <button type="submit"
          class="bg-blue-600 hover:bg-blue-700 py-2 px-3 text-white font-semibold rounded w-full mb-2">Tambahkan
          Akun</button>
        <button type="button" id="close-modal"
          class="bg-red-600 hover:bg-red-700 py-2 px-3 text-white font-semibold rounded w-full">Batal</button>
      </form>
    </div>
  </div>
  <div id="edit-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-10 overflow-y-auto w-screen h-screen">
    <div class="flex flex-col justify-center items-center w-screen min-h-screen p-3">
      <div
        class="flex flex-col justify-center items-center bg-white w-1/1 rounded shadow-lg w-full md:w-1/2 lg:w-1/3 p-3">
        <form id="edit-form" method="POST" class="flex flex-col justify-center items-center w-full">
          @csrf
          @method('PUT')
          <span class="text-lg font-semibold text-center mb-5">Detail Akun</span>
          <input type="text" name="title"
            class="bg-white border-2 border-gray-200 focus:border-blue-600 focus:outline-none rounded w-full py-2 px-3 mb-3"
            placeholder="Judul Akun" required>
          <input type="text" name="username"
            class="bg-white border-2 border-gray-200 focus:border-blue-600 focus:outline-none rounded w-full py-2 px-3 mb-3"
            placeholder="Username" required>
          <div class="flex flex-row items-center w-full mb-5">
            <input type="password" name="password"
              class="bg-white border-2 border-gray-200 focus:border-blue-600 focus:outline-none rounded w-full py-2 px-3"
              placeholder="Kata Sandi" required>
            <div id="hide-show-password-2" class="py-2 px-4 cursor-pointer">
              <img id="hidden-password-2" class="" src="{{ asset('img/eye-off-outline.svg') }}" alt="" width="24"
                height="24">
              <img id="show-password-2" class="hidden" src="{{ asset('img/eye-outline.svg') }}" alt="" width="24"
                height="24">
            </div>
          </div>
          <button type="submit"
            class="bg-green-600 hover:bg-green-700 py-2 px-3 text-white font-semibold rounded w-full mb-2">Perbarui
            Akun</button>
        </form>
        <form id="delete-form" method="POST" class="flex flex-col justify-center items-center w-full">
          @csrf
          @method('DELETE')
          <button type="submit"
            class="bg-red-600 hover:bg-red-700 py-2 px-3 text-white font-semibold rounded w-full mb-2">Hapus Akun</button>
        </form>
        <button type="button" id="close-edit-modal"
          class="bg-blue-600 hover:bg-blue-700 py-2 px-3 text-white font-semibold rounded w-full">Tutup</button>
      </div>
    </div>
  </div>
  </div>
  <script>
    const addModal = document.querySelector('div#add-modal');
    const editModal = document.querySelector('div#edit-modal');

    document.querySelectorAll('button#add-button').forEach(el => {
      el.addEventListener('click', () => {
        addModal.classList.toggle('hidden');
        document.querySelector('form#add-form input[name="title"]').focus();
      });
    });

    document.querySelector('button#close-modal').addEventListener('click', () => {
      addModal.classList.toggle('hidden');
    });

    document.querySelector('button#close-edit-modal').addEventListener('click', () => {
      editModal.classList.toggle('hidden');
    });

    document.querySelector('div#hide-show-password-1').addEventListener('click', () => {
      const input = document.querySelector('form#add-form div input[name="password"]');
      document.querySelector('img#hidden-password-1').classList.toggle('hidden');
      document.querySelector('img#show-password-1').classList.toggle('hidden');
      if (input.getAttribute('type') == 'password') {
        input.setAttribute('type', 'text');
      } else {
        input.setAttribute('type', 'password');
      }
    });

    document.querySelector('div#hide-show-password-2').addEventListener('click', () => {
      const input = document.querySelector('form#edit-form div input[name="password"]');
      document.querySelector('img#hidden-password-2').classList.toggle('hidden');
      document.querySelector('img#show-password-2').classList.toggle('hidden');
      if (input.getAttribute('type') == 'password') {
        input.setAttribute('type', 'text');
      } else {
        input.setAttribute('type', 'password');
      }
    });

    document.querySelectorAll('tbody#account-list tr').forEach(el => {
      const formEditElement = document.querySelector('form#edit-form');
      const formDeleteElement = document.querySelector('form#delete-form');

      el.addEventListener('click', () => {
        const row = el.children;
        const id = el.dataset.id;
        const password = el.dataset.password;

        formDeleteElement.setAttribute('action', `{{ url('/dashboard/delete') }}/${id}`);
        formEditElement.setAttribute('action', `{{ url('/dashboard/update') }}/${id}`);
        formEditElement.querySelector('input[name="title"]').value = row[1].innerText;
        formEditElement.querySelector('input[name="username"]').value = row[2].innerText;
        formEditElement.querySelector('input[name="password"]').value = password;

        editModal.classList.toggle('hidden');
      });
    });
  </script>
@endsection
