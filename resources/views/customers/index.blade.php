@extends('layouts.app')
@section('title', '2WHEELS HOUSE - Customers')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- PAGE HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 animate-entrance delay-2">
        <div>
            <h2 class="font-headline-lg text-headline-lg text-on-surface uppercase tracking-tight">Customers</h2>
            <p class="font-label-sm text-label-sm text-text-secondary tracking-widest uppercase mt-1">Customer & Vehicle Registry</p>
        </div>
        <button id="btn-add-customer" onclick="openModal()" class="btn-pulse h-12 px-6 bg-racing-red text-text-primary font-label-sm text-label-sm uppercase tracking-widest rounded flex items-center gap-2 shadow-[0_0_15px_rgba(229,57,53,0.3)] hover:bg-primary-container transition-colors active:scale-95 shrink-0">
            <span class="material-symbols-outlined text-lg">add_circle</span> Add New
        </button>
    </div>

    {{-- DATA GRID --}}
    <div class="glass-panel glow-card rounded-xl animate-entrance delay-3 overflow-hidden">
        <div class="p-6 border-b border-surface-container-highest flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-[#1E1E1E]/40">
            <div class="flex items-center gap-3">
                <h3 class="font-headline-md text-headline-md text-text-primary uppercase tracking-tight">Data Grid</h3>
                <span class="bg-surface-container-high text-text-secondary font-label-sm text-label-sm px-2.5 py-1 rounded-full">{{ $customers->total() }} records</span>
            </div>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-sm">search</span>
                <form method="GET" action="{{ route('customers') }}">
                    <input name="search" value="{{ request('search') }}" class="bg-surface-container-low border border-outline-variant rounded-lg pl-9 pr-4 py-2 text-sm text-text-primary focus:border-racing-red focus:ring-1 focus:ring-racing-red outline-none w-56 transition-all placeholder:text-text-secondary" placeholder="Search customers..." type="text"/>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-[700px]">
                <thead>
                    <tr class="border-b border-surface-container-highest/50">
                        <th class="text-left px-6 py-4 font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">ID</th>
                        <th class="text-left px-6 py-4 font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">Name</th>
                        <th class="text-left px-6 py-4 font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">Contact</th>
                        <th class="text-left px-6 py-4 font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">Vehicles</th>
                        <th class="text-center px-6 py-4 font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $cust)
                    <tr class="table-row-glow border-b border-surface-container-highest/30 group cursor-pointer" data-id="{{ $cust->id_customer }}">
                        <td class="px-6 py-4"><span class="font-receipt-mono text-receipt-mono text-text-secondary">{{ $cust->id_customer }}</span></td>
                        <td class="px-6 py-4"><span class="font-body-lg text-body-lg text-text-primary font-medium">{{ $cust->nama }}</span></td>
                        <td class="px-6 py-4"><span class="font-body-md text-text-secondary">{{ $cust->kontak }}</span></td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1.5">
                                @forelse($cust->motors as $motor)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-tertiary/10 text-tertiary font-label-sm text-label-sm border border-tertiary/20">
                                        <span class="material-symbols-outlined text-xs">two_wheeler</span>
                                        {{ $motor->nopol }}
                                    </span>
                                @empty
                                    <span class="font-label-sm text-label-sm text-text-secondary">—</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button onclick="editCustomer('{{ $cust->id_customer }}', '{{ $cust->nama }}', '{{ $cust->kontak }}')" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-surface-container-high text-text-secondary hover:text-tertiary transition-colors"><span class="material-symbols-outlined text-lg">edit</span></button>
                                <button onclick="deleteItem('{{ $cust->id_customer }}')" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-error-container/30 text-text-secondary hover:text-error transition-colors"><span class="material-symbols-outlined text-lg">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <span class="material-symbols-outlined text-5xl text-surface-container-highest">group</span>
                                <p class="font-body-md text-text-secondary">No customers yet</p>
                                <button onclick="openModal()" class="mt-2 px-4 py-2 rounded bg-surface-container-high text-text-primary font-label-sm text-label-sm uppercase tracking-wider hover:bg-surface-bright transition-colors">Add first customer</button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customers->hasPages())
        <div class="px-6 py-4 border-t border-surface-container-highest/50 flex items-center justify-between">
            <div class="font-label-sm text-label-sm text-text-secondary">Showing {{ $customers->firstItem() }} - {{ $customers->lastItem() }} of {{ $customers->total() }}</div>
            <div class="flex items-center gap-1">
                @if(!$customers->onFirstPage())
                    <a href="{{ $customers->previousPageUrl() }}" class="w-9 h-9 rounded-lg flex items-center justify-center text-text-secondary hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined text-lg">chevron_left</span></a>
                @endif
                @foreach($customers->getUrlRange(1, $customers->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="w-9 h-9 rounded-lg flex items-center justify-center font-label-sm text-label-sm transition-colors {{ $page == $customers->currentPage() ? 'bg-racing-red text-text-primary' : 'text-text-secondary hover:bg-surface-container-high' }}">{{ $page }}</a>
                @endforeach
                @if($customers->hasMorePages())
                    <a href="{{ $customers->nextPageUrl() }}" class="w-9 h-9 rounded-lg flex items-center justify-center text-text-secondary hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined text-lg">chevron_right</span></a>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

{{-- ADD/EDIT MODAL --}}
<div id="item-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-background/80 backdrop-blur-sm" onclick="closeModal()"></div>
    <div class="glass-panel rounded-xl w-full max-w-lg mx-4 relative z-10 animate-entrance overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-racing-red via-racing-red/50 to-transparent"></div>
        <div class="p-6 border-b border-surface-container-highest flex items-center justify-between">
            <h3 id="modal-title" class="font-headline-md text-headline-md text-on-surface uppercase tracking-tight">Add Customer</h3>
            <button onclick="closeModal()" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-surface-variant/50 text-text-secondary hover:text-text-primary transition-colors"><span class="material-symbols-outlined">close</span></button>
        </div>
        <form id="item-form" method="POST" action="{{ route('customers.store') }}" class="p-6 flex flex-col gap-5">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            <div class="relative">
                <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Customer ID</label>
                <input id="f-id" name="id_customer" required class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-md px-0 py-2 focus:ring-0 transition-colors placeholder:text-surface-container-highest" type="text" placeholder="e.g. CUST-001"/>
            </div>
            <div class="relative">
                <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Customer Name</label>
                <input id="f-nama" name="nama" required class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-md px-0 py-2 focus:ring-0 transition-colors placeholder:text-surface-container-highest" type="text" placeholder="Full name"/>
            </div>
            <div class="relative">
                <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Contact (Phone/WA)</label>
                <input id="f-kontak" name="kontak" required class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-md px-0 py-2 focus:ring-0 transition-colors placeholder:text-surface-container-highest" type="text" placeholder="08xx-xxxx-xxxx"/>
            </div>
            {{-- Vehicle (on add) --}}
            <div id="vehicle-section">
                <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Vehicle Plate (Nopol)</label>
                <input name="nopol[]" class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-receipt-mono px-0 py-2 focus:ring-0 transition-colors placeholder:text-surface-container-highest" type="text" placeholder="e.g. B 1234 ABC"/>
            </div>
            <div class="flex items-center justify-end gap-3 mt-4 pt-4 border-t border-surface-container-highest/50">
                <button type="button" onclick="closeModal()" class="h-11 px-6 rounded border border-outline-variant text-text-primary font-label-sm text-label-sm uppercase tracking-wider hover:bg-surface-container transition-colors">Cancel</button>
                <button type="submit" class="btn-pulse h-11 px-8 bg-racing-red text-text-primary font-label-sm text-label-sm uppercase tracking-wider rounded shadow-[0_0_15px_rgba(229,57,53,0.3)] hover:bg-primary-container transition-colors active:scale-95 flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">save</span> Save
                </button>
            </div>
        </form>
    </div>
</div>

{{-- DELETE MODAL --}}
<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-background/80 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
    <div class="glass-panel rounded-xl w-full max-w-sm mx-4 relative z-10 animate-entrance p-6">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-error via-error/50 to-transparent"></div>
        <div class="flex flex-col items-center text-center gap-4">
            <div class="w-16 h-16 rounded-full bg-error-container/30 flex items-center justify-center"><span class="material-symbols-outlined text-3xl text-error">delete_forever</span></div>
            <h3 class="font-headline-md text-headline-md text-on-surface">Delete Customer?</h3>
            <p class="font-body-md text-text-secondary">This will also remove all associated vehicles.</p>
            <form id="delete-form" method="POST" class="flex items-center gap-3 w-full mt-2">
                @csrf @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="flex-1 h-11 rounded border border-outline-variant text-text-primary font-label-sm text-label-sm uppercase tracking-wider hover:bg-surface-container transition-colors">Cancel</button>
                <button type="submit" class="flex-1 h-11 bg-error text-on-error rounded font-label-sm text-label-sm uppercase tracking-wider hover:bg-error-container transition-colors active:scale-95">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openModal() {
    document.getElementById('item-modal').classList.remove('hidden');
    document.getElementById('item-modal').classList.add('flex');
    document.getElementById('modal-title').textContent = 'Add Customer';
    document.getElementById('item-form').action = '{{ route("customers.store") }}';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('f-id').readOnly = false;
    document.getElementById('vehicle-section').style.display = 'block';
    document.getElementById('item-form').reset();
}
function editCustomer(id, nama, kontak) {
    document.getElementById('item-modal').classList.remove('hidden');
    document.getElementById('item-modal').classList.add('flex');
    document.getElementById('modal-title').textContent = 'Edit Customer';
    document.getElementById('item-form').action = `/customers/${id}`;
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('f-id').value = id;
    document.getElementById('f-id').readOnly = true;
    document.getElementById('f-nama').value = nama;
    document.getElementById('f-kontak').value = kontak;
    document.getElementById('vehicle-section').style.display = 'none';
}
function closeModal() { document.getElementById('item-modal').classList.add('hidden'); document.getElementById('item-modal').classList.remove('flex'); }
function deleteItem(id) { document.getElementById('delete-modal').classList.remove('hidden'); document.getElementById('delete-modal').classList.add('flex'); document.getElementById('delete-form').action = `/customers/${id}`; }
function closeDeleteModal() { document.getElementById('delete-modal').classList.add('hidden'); document.getElementById('delete-modal').classList.remove('flex'); }

document.querySelectorAll('.glow-card').forEach(card => {
    card.addEventListener('mousemove', e => { const r = card.getBoundingClientRect(); card.style.setProperty('--mouse-x', `${e.clientX-r.left}px`); card.style.setProperty('--mouse-y', `${e.clientY-r.top}px`); });
});
</script>
@endsection
