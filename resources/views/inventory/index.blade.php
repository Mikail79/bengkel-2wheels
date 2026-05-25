@extends('layouts.app')

@section('title', '2WHEELS HOUSE - Master Inventory')
@section('meta_description', 'Manage parts and services inventory for 2WHEELS HOUSE workshop')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- PAGE HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 animate-entrance delay-2">
        <div>
            <h2 class="font-headline-lg text-headline-lg text-on-surface uppercase tracking-tight">Master Inventory</h2>
            <p class="font-label-sm text-label-sm text-text-secondary tracking-widest uppercase mt-1">Parts & Services Management</p>
        </div>
        <button id="btn-add-inventory" onclick="openModal()" class="btn-pulse h-12 px-6 bg-racing-red text-text-primary font-label-sm text-label-sm uppercase tracking-widest rounded flex items-center gap-2 shadow-[0_0_15px_rgba(229,57,53,0.3)] hover:bg-primary-container transition-colors active:scale-95 shrink-0">
            <span class="material-symbols-outlined text-lg">add_circle</span>
            Add New
        </button>
    </div>

    {{-- TELEMETRY STATUS ROW --}}
    <div class="glass-panel rounded-xl mb-8 overflow-hidden animate-entrance delay-2 border border-outline-variant/35 bg-[#171717]/80 backdrop-blur-xl">
        <div class="grid grid-cols-2 lg:grid-cols-4 divide-y lg:divide-y-0 lg:divide-x divide-outline-variant/20">
            
            {{-- Stat 1: Total Items --}}
            <div class="p-6 flex flex-col justify-between min-h-[120px] hover:bg-white/[0.01] transition-colors group">
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-[10px] text-text-secondary uppercase tracking-widest">Total Inventory</span>
                    <span class="material-symbols-outlined text-sm text-racing-red opacity-60 group-hover:opacity-100 transition-opacity">inventory_2</span>
                </div>
                <div class="flex items-baseline gap-2 mt-4">
                    <span class="font-receipt-mono text-4xl font-bold text-text-primary tracking-tight select-none" id="stat-total">{{ sprintf('%02d', $barangs->total() ?? 0) }}</span>
                    <span class="font-label-sm text-[10px] text-racing-red uppercase tracking-wider font-semibold">items</span>
                </div>
            </div>

            {{-- Stat 2: Parts --}}
            <div class="p-6 flex flex-col justify-between min-h-[120px] hover:bg-white/[0.01] transition-colors group">
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-[10px] text-text-secondary uppercase tracking-widest">Parts / Components</span>
                    <span class="material-symbols-outlined text-sm text-tertiary opacity-60 group-hover:opacity-100 transition-opacity">build</span>
                </div>
                <div class="flex items-baseline gap-2 mt-4">
                    <span class="font-receipt-mono text-4xl font-bold text-text-primary tracking-tight select-none">{{ sprintf('%02d', $countParts ?? 0) }}</span>
                    <span class="font-label-sm text-[10px] text-tertiary uppercase tracking-wider font-semibold">SKUs</span>
                </div>
            </div>

            {{-- Stat 3: Services --}}
            <div class="p-6 flex flex-col justify-between min-h-[120px] hover:bg-white/[0.01] transition-colors group">
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-[10px] text-text-secondary uppercase tracking-widest">Services / Labor</span>
                    <span class="material-symbols-outlined text-sm text-emerald-success opacity-60 group-hover:opacity-100 transition-opacity">handyman</span>
                </div>
                <div class="flex items-baseline gap-2 mt-4">
                    <span class="font-receipt-mono text-4xl font-bold text-text-primary tracking-tight select-none">{{ sprintf('%02d', $countJasa ?? 0) }}</span>
                    <span class="font-label-sm text-[10px] text-emerald-success uppercase tracking-wider font-semibold">Rates</span>
                </div>
            </div>

            {{-- Stat 4: Low Stock Alert --}}
            <div class="p-6 flex flex-col justify-between min-h-[120px] hover:bg-white/[0.01] transition-colors group">
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-[10px] text-text-secondary uppercase tracking-widest">Low Stock Alerts</span>
                    <span class="material-symbols-outlined text-sm {{ ($lowStock ?? 0) > 0 ? 'text-error animate-pulse' : 'text-text-secondary opacity-60' }} group-hover:opacity-100 transition-opacity">warning</span>
                </div>
                <div class="flex items-baseline gap-2 mt-4">
                    <span class="font-receipt-mono text-4xl font-bold {{ ($lowStock ?? 0) > 0 ? 'text-error drop-shadow-[0_0_8px_rgba(255,180,171,0.4)]' : 'text-text-primary' }} tracking-tight select-none">{{ sprintf('%02d', $lowStock ?? 0) }}</span>
                    <span class="font-label-sm text-[10px] {{ ($lowStock ?? 0) > 0 ? 'text-error' : 'text-text-secondary' }} uppercase tracking-wider font-semibold">Critical</span>
                </div>
            </div>

        </div>
    </div>

    {{-- DATA GRID --}}
    <div class="glass-panel glow-card rounded-xl animate-entrance delay-3 overflow-hidden">

        {{-- Grid Header: Search & Filters --}}
        <div class="p-6 border-b border-surface-container-highest flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-[#1E1E1E]/40">
            <div class="flex items-center gap-3">
                <h3 class="font-headline-md text-headline-md text-text-primary uppercase tracking-tight">Data Grid</h3>
                <span class="bg-surface-container-high text-text-secondary font-label-sm text-label-sm px-2.5 py-1 rounded-full">{{ $barangs->total() ?? 0 }} records</span>
            </div>
            <div class="flex items-center gap-3">
                {{-- Filter Tabs --}}
                <div class="hidden md:flex items-center gap-1 bg-surface-container-low rounded-lg p-1">
                    <a href="{{ route('inventory', ['jenis' => '']) }}" class="px-3 py-1.5 rounded font-label-sm text-label-sm uppercase tracking-wider transition-colors {{ !request('jenis') ? 'bg-surface-container-high text-text-primary' : 'text-text-secondary hover:text-text-primary' }}">All</a>
                    <a href="{{ route('inventory', ['jenis' => 'Part']) }}" class="px-3 py-1.5 rounded font-label-sm text-label-sm uppercase tracking-wider transition-colors {{ request('jenis') === 'Part' ? 'bg-surface-container-high text-text-primary' : 'text-text-secondary hover:text-text-primary' }}">Parts</a>
                    <a href="{{ route('inventory', ['jenis' => 'Jasa']) }}" class="px-3 py-1.5 rounded font-label-sm text-label-sm uppercase tracking-wider transition-colors {{ request('jenis') === 'Jasa' ? 'bg-surface-container-high text-text-primary' : 'text-text-secondary hover:text-text-primary' }}">Services</a>
                </div>
                {{-- Search --}}
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-sm">search</span>
                    <form method="GET" action="{{ route('inventory') }}">
                        <input id="inventory-search" name="search" value="{{ request('search') }}" class="bg-surface-container-low border border-outline-variant rounded-lg pl-9 pr-4 py-2 text-sm text-text-primary focus:border-racing-red focus:ring-1 focus:ring-racing-red outline-none w-48 sm:w-56 transition-all placeholder:text-text-secondary" placeholder="Search items..." type="text"/>
                        @if(request('jenis'))
                            <input type="hidden" name="jenis" value="{{ request('jenis') }}">
                        @endif
                    </form>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-[900px]">
                <thead>
                    <tr class="border-b border-surface-container-highest/50">
                        <th class="text-left px-6 py-4 font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">ID</th>
                        <th class="text-left px-6 py-4 font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">Item Name</th>
                        <th class="text-left px-6 py-4 font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">Type</th>
                        <th class="text-right px-6 py-4 font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">Stock</th>
                        <th class="text-right px-6 py-4 font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">Buy Price</th>
                        <th class="text-right px-6 py-4 font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">Sell Price</th>
                        <th class="text-right px-6 py-4 font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">Disc %</th>
                        <th class="text-center px-6 py-4 font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $index => $barang)
                    <tr class="table-row-glow border-b border-surface-container-highest/30 group cursor-pointer" data-id="{{ $barang->id_barang }}">
                        <td class="px-6 py-4">
                            <span class="font-receipt-mono text-receipt-mono text-text-secondary">{{ $barang->id_barang }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-body-lg text-body-lg text-text-primary font-medium">{{ $barang->nama }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($barang->jenis === 'Part')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-tertiary/10 text-tertiary font-label-sm text-label-sm uppercase tracking-wider border border-tertiary/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                    Part
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-success/10 text-emerald-success font-label-sm text-label-sm uppercase tracking-wider border border-emerald-success/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-success"></span>
                                    Jasa
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($barang->jenis === 'Part')
                                <span class="font-receipt-mono text-receipt-mono {{ $barang->stok <= 5 ? 'text-error font-bold' : 'text-text-primary' }}">{{ number_format($barang->stok) }}</span>
                                @if($barang->stok <= 5)
                                    <span class="material-symbols-outlined text-error text-sm ml-1 align-middle">error</span>
                                @endif
                            @else
                                <span class="font-receipt-mono text-receipt-mono text-text-secondary">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="font-receipt-mono text-receipt-mono text-text-secondary">{{ number_format($barang->harga_beli, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="font-receipt-mono text-receipt-mono text-text-primary">{{ number_format($barang->harga_jual, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($barang->diskon > 0)
                                <span class="font-receipt-mono text-receipt-mono text-emerald-success">{{ $barang->diskon }}%</span>
                            @else
                                <span class="font-receipt-mono text-receipt-mono text-text-secondary">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button onclick="editItem('{{ $barang->id_barang }}')" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-surface-container-high text-text-secondary hover:text-tertiary transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </button>
                                <button onclick="deleteItem('{{ $barang->id_barang }}')" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-error-container/30 text-text-secondary hover:text-error transition-colors" title="Delete">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <span class="material-symbols-outlined text-5xl text-surface-container-highest">inventory_2</span>
                                <p class="font-body-md text-text-secondary">No items found</p>
                                <button onclick="openModal()" class="mt-2 px-4 py-2 rounded bg-surface-container-high text-text-primary font-label-sm text-label-sm uppercase tracking-wider hover:bg-surface-bright transition-colors">
                                    Add your first item
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($barangs->hasPages())
        <div class="px-6 py-4 border-t border-surface-container-highest/50 flex items-center justify-between">
            <div class="font-label-sm text-label-sm text-text-secondary">
                Showing {{ $barangs->firstItem() }} - {{ $barangs->lastItem() }} of {{ $barangs->total() }}
            </div>
            <div class="flex items-center gap-1">
                @if($barangs->onFirstPage())
                    <span class="w-9 h-9 rounded-lg flex items-center justify-center text-surface-container-highest cursor-not-allowed">
                        <span class="material-symbols-outlined text-lg">chevron_left</span>
                    </span>
                @else
                    <a href="{{ $barangs->previousPageUrl() }}" class="w-9 h-9 rounded-lg flex items-center justify-center text-text-secondary hover:bg-surface-container-high hover:text-text-primary transition-colors">
                        <span class="material-symbols-outlined text-lg">chevron_left</span>
                    </a>
                @endif

                @foreach($barangs->getUrlRange(1, $barangs->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="w-9 h-9 rounded-lg flex items-center justify-center font-label-sm text-label-sm transition-colors {{ $page == $barangs->currentPage() ? 'bg-racing-red text-text-primary' : 'text-text-secondary hover:bg-surface-container-high hover:text-text-primary' }}">
                        {{ $page }}
                    </a>
                @endforeach

                @if($barangs->hasMorePages())
                    <a href="{{ $barangs->nextPageUrl() }}" class="w-9 h-9 rounded-lg flex items-center justify-center text-text-secondary hover:bg-surface-container-high hover:text-text-primary transition-colors">
                        <span class="material-symbols-outlined text-lg">chevron_right</span>
                    </a>
                @else
                    <span class="w-9 h-9 rounded-lg flex items-center justify-center text-surface-container-highest cursor-not-allowed">
                        <span class="material-symbols-outlined text-lg">chevron_right</span>
                    </span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

{{-- ============================================================ --}}
{{-- ADD/EDIT MODAL --}}
{{-- ============================================================ --}}
<div id="item-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
    {{-- Overlay --}}
    <div class="absolute inset-0 bg-background/80 backdrop-blur-sm" onclick="closeModal()"></div>
    {{-- Modal Content --}}
    <div class="glass-panel rounded-xl w-full max-w-lg mx-4 relative z-10 animate-entrance overflow-hidden">
        {{-- Modal Top Accent --}}
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-racing-red via-racing-red/50 to-transparent"></div>
        
        <div class="p-6 border-b border-surface-container-highest flex items-center justify-between">
            <h3 id="modal-title" class="font-headline-md text-headline-md text-on-surface uppercase tracking-tight">Add Item</h3>
            <button onclick="closeModal()" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-surface-variant/50 text-text-secondary hover:text-text-primary transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="item-form" method="POST" action="{{ route('inventory.store') }}" class="p-6 flex flex-col gap-5">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div class="grid grid-cols-2 gap-4">
                <div class="relative col-span-1">
                    <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Item ID</label>
                    <input id="f-id" name="id_barang" required class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-md px-0 py-2 focus:ring-0 transition-colors placeholder:text-surface-container-highest" type="text" placeholder="e.g. BRG-001"/>
                </div>
                <div class="relative col-span-1">
                    <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Type</label>
                    <select id="f-jenis" name="jenis" required class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-md px-0 py-2 focus:ring-0 transition-colors appearance-none">
                        <option value="Part">Part</option>
                        <option value="Jasa">Jasa (Service)</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-0 bottom-2 text-text-secondary pointer-events-none">arrow_drop_down</span>
                </div>
            </div>

            <div class="relative">
                <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Item Name</label>
                <input id="f-nama" name="nama" required class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-md px-0 py-2 focus:ring-0 transition-colors placeholder:text-surface-container-highest" type="text" placeholder="Product or service name"/>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="relative">
                    <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Stock</label>
                    <input id="f-stok" name="stok" class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-receipt-mono px-0 py-2 focus:ring-0 transition-colors placeholder:text-surface-container-highest" type="number" min="0" value="0"/>
                </div>
                <div class="relative">
                    <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Buy Price</label>
                    <input id="f-harga-beli" name="harga_beli" class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-receipt-mono px-0 py-2 focus:ring-0 transition-colors placeholder:text-surface-container-highest" type="number" min="0" value="0"/>
                </div>
                <div class="relative">
                    <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Sell Price</label>
                    <input id="f-harga-jual" name="harga_jual" class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-receipt-mono px-0 py-2 focus:ring-0 transition-colors placeholder:text-surface-container-highest" type="number" min="0" value="0"/>
                </div>
            </div>

            <div class="relative w-1/3">
                <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Discount %</label>
                <input id="f-diskon" name="diskon" class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-receipt-mono px-0 py-2 focus:ring-0 transition-colors placeholder:text-surface-container-highest" type="number" min="0" max="100" value="0"/>
            </div>

            <div class="flex items-center justify-end gap-3 mt-4 pt-4 border-t border-surface-container-highest/50">
                <button type="button" onclick="closeModal()" class="h-11 px-6 rounded border border-outline-variant text-text-primary font-label-sm text-label-sm uppercase tracking-wider hover:bg-surface-container transition-colors">
                    Cancel
                </button>
                <button type="submit" class="btn-pulse h-11 px-8 bg-racing-red text-text-primary font-label-sm text-label-sm uppercase tracking-wider rounded shadow-[0_0_15px_rgba(229,57,53,0.3)] hover:bg-primary-container transition-colors active:scale-95 flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">save</span>
                    Save Item
                </button>
            </div>
        </form>
    </div>
</div>

{{-- DELETE CONFIRMATION MODAL --}}
<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-background/80 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
    <div class="glass-panel rounded-xl w-full max-w-sm mx-4 relative z-10 animate-entrance p-6">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-error via-error/50 to-transparent"></div>
        <div class="flex flex-col items-center text-center gap-4">
            <div class="w-16 h-16 rounded-full bg-error-container/30 flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl text-error">delete_forever</span>
            </div>
            <h3 class="font-headline-md text-headline-md text-on-surface">Delete Item?</h3>
            <p class="font-body-md text-text-secondary">This action cannot be undone. The item will be permanently removed from inventory.</p>
            <form id="delete-form" method="POST" class="flex items-center gap-3 w-full mt-2">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="flex-1 h-11 rounded border border-outline-variant text-text-primary font-label-sm text-label-sm uppercase tracking-wider hover:bg-surface-container transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 h-11 bg-error text-on-error rounded font-label-sm text-label-sm uppercase tracking-wider hover:bg-error-container transition-colors active:scale-95">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openModal() {
        const modal = document.getElementById('item-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.getElementById('modal-title').textContent = 'Add Item';
        document.getElementById('item-form').action = '{{ route("inventory.store") }}';
        document.getElementById('form-method').value = 'POST';
        document.getElementById('f-id').readOnly = false;
        document.getElementById('item-form').reset();
    }

    function editItem(id) {
        const row = document.querySelector(`tr[data-id="${id}"]`);
        if (!row) return;
        const modal = document.getElementById('item-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.getElementById('modal-title').textContent = 'Edit Item';
        document.getElementById('item-form').action = `/inventory/${id}`;
        document.getElementById('form-method').value = 'PUT';
        document.getElementById('f-id').value = id;
        document.getElementById('f-id').readOnly = true;
        // Fetch data via AJAX for real app; this is the structural template
    }

    function closeModal() {
        const modal = document.getElementById('item-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function deleteItem(id) {
        const modal = document.getElementById('delete-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.getElementById('delete-form').action = `/inventory/${id}`;
    }

    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Re-init glow cards for dynamically rendered content
    document.querySelectorAll('.glow-card').forEach(card => {
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            card.style.setProperty('--mouse-x', `${e.clientX - rect.left}px`);
            card.style.setProperty('--mouse-y', `${e.clientY - rect.top}px`);
        });
    });
</script>
@endsection
