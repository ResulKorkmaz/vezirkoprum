@props(['type', 'id', 'class' => ''])

@auth
    <button 
        type="button"
        onclick="openReportModal('{{ $type }}', {{ $id }})"
        class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-500 hover:text-red-600 transition-colors duration-200 {{ $class }}"
        title="Bu içeriği bildir"
    >
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
        </svg>
        Bildir
    </button>
@endauth 