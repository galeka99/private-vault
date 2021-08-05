<div class="flex flex-row justify-center items-center text-white divide-x-2 divide-white">
  <a href="{{ $datas->previousPageUrl() }}"
    class=" py-2 px-3 rounded-l {{ $datas->onFirstPage() ? 'bg-blue-300 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700' }}">&#8810;</a>
  @foreach ($datas->getUrlRange(1, $datas->lastPage()) as $page)
    @if ($loop->iteration == $datas->currentPage())
      <a class="bg-blue-300 py-2 px-3 cursor-not-allowed">{{ $loop->iteration }}</a>
    @else
      <a href="{{ $page }}" class="bg-blue-600 hover:bg-blue-700 py-2 px-3">{{ $loop->iteration }}</a>
    @endif
  @endforeach
  <a href="{{ $datas->nextPageUrl() }}"
    class="py-2 px-3 rounded-r {{ $datas->hasMorePages() ? 'bg-blue-600 hover:bg-blue-700' : 'bg-blue-300 cursor-not-allowed' }}">&#8811;</a>
</div>
