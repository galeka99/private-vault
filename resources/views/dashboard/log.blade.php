@extends('template')
@section('title', 'Riwayat Masuk')
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
          <a href="{{ url('/dashboard') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white rounded px-4 py-2">Dashboard</a>
          <a href="{{ url('/logout') }}" class="bg-red-600 hover:bg-red-700 text-white rounded px-4 py-2">Keluar</a>
        </div>
      </div>
    </div>
    <hr class="md:hidden">
    <div class="flex flex-row justify-end md:hidden gap-x-2">
      <a href="{{ url('/dashboard') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white rounded px-4 py-2">Dashboard</a>
      <a href="{{ url('/logout') }}" class="bg-red-600 hover:bg-red-700 text-white rounded px-4 py-2">Keluar</a>
    </div>
  </div>
  <div class="overflow-x-auto w-full">
    <table class="table-auto text-center w-full">
      <thead class="bg-green-600 text-white">
        <tr class="divide-x-2 divide-white">
          <td class="p-2">Alamat IP</td>
          <td class="p-2">Perangkat</td>
          <td class="p-2">Sistem Operasi</td>
          <td class="p-2">Peramban</td>
          <td class="p-2">Waktu</td>
        </tr>
      </thead>
      <tbody class="bg-green-50">
        @foreach ($logs as $log)
          <tr class="hover:bg-green-100 divide-x-2 divide-white">
            <td class="p-2">{{ $log->ip }}</td>
            <td class="p-2">{{ $log->device }}</td>
            <td class="p-2">{{ $log->platform }}</td>
            <td class="p-2">{{ $log->browser }}</td>
            <td class="p-2">{{ $log->created_at }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
