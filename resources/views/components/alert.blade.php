@if (session('alert'))
  <div
    class="animate__animated animate__backInRight alert bg-{{ session('alert') == 'success' ? 'green' : 'red' }}-600 text-white rounded shadow-xl py-2 px-5">
    {{ session('message') }}</div>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => {
        document.querySelector('div.alert').classList.toggle('animate__backOutRight');
      }, 5000);
    });
  </script>
@endif
