@extends('layouts.app')
@section('title', '2WHEELS HOUSE - Inbound PO')

@section('content')
<div class="max-w-7xl mx-auto flex flex-col gap-6">

    {{-- Tabs Navigation --}}
    <div class="flex border-b border-outline-variant/30 gap-6 mb-2">
        <button id="tab-create" onclick="switchTab('create')" class="pb-3 text-headline-md font-bold uppercase tracking-tight border-b-2 border-racing-red text-text-primary transition-all">
            Create Inbound PO
        </button>
        <button id="tab-history" onclick="switchTab('history')" class="pb-3 text-headline-md font-bold uppercase tracking-tight border-b-2 border-transparent text-text-secondary hover:text-text-primary transition-all">
            PO History
        </button>
    </div>

    {{-- TAB 1: CREATE INBOUND PO --}}
    <div id="pane-create" class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">
        
        {{-- LEFT COLUMN: PO Details (Spans 4) --}}
        <div class="xl:col-span-4 flex flex-col gap-6">
            <div class="glass-panel glow-card animate-entrance delay-2 rounded-xl p-6 relative group">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-racing-red to-transparent opacity-50"></div>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-headline-md text-headline-md text-text-primary uppercase tracking-tight">PO Details</h2>
                    <span class="font-receipt-mono text-receipt-mono text-text-secondary" id="faktur-id">NEW</span>
                </div>
                
                <div class="flex flex-col gap-5">
                    {{-- Supplier --}}
                    <div class="relative">
                        <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Supplier</label>
                        <select id="sel-supplier" class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-md px-0 py-2 focus:ring-0 transition-colors appearance-none">
                            <option value="">Select supplier...</option>
                            @foreach($supliers as $s)
                                <option value="{{ $s->id_suplier }}">{{ $s->nama }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-0 bottom-2 text-text-secondary pointer-events-none">arrow_drop_down</span>
                    </div>

                    {{-- Admin / Receiving Clerk --}}
                    <div class="relative">
                        <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Receiving Admin</label>
                        <select id="sel-admin" class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-md px-0 py-2 focus:ring-0 transition-colors appearance-none">
                            <option value="">Select admin...</option>
                            @foreach($petugas as $p)
                                <option value="{{ $p->id_petugas }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-0 bottom-2 text-text-secondary pointer-events-none">arrow_drop_down</span>
                    </div>

                    {{-- Physical Invoice Number --}}
                    <div class="relative">
                        <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Invoice No. (Fisik)</label>
                        <input id="no-faktur" class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-md px-0 py-2 focus:ring-0 transition-colors placeholder:text-surface-container-highest" type="text" placeholder="e.g. INV/2026/05/99"/>
                    </div>

                    {{-- Date Picker --}}
                    <div class="relative">
                        <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Date</label>
                        <input id="po-date" class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-md px-0 py-2 focus:ring-0 transition-colors" type="date" value="{{ date('Y-m-d') }}"/>
                    </div>

                    {{-- Payment Terms & Method --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="relative">
                            <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Termin</label>
                            <input id="po-termin" class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-md px-0 py-2 focus:ring-0 transition-colors placeholder:text-surface-container-highest" type="text" placeholder="e.g. 30 Days"/>
                        </div>
                        <div class="relative">
                            <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Syarat Pembayaran</label>
                            <input id="po-syarat" class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-md px-0 py-2 focus:ring-0 transition-colors placeholder:text-surface-container-highest" type="text" placeholder="e.g. COD / Transfer"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: Parts Items & Totals (Spans 8) --}}
        <div class="xl:col-span-8 flex flex-col gap-6">
            <div class="glass-panel glow-card animate-entrance delay-2 rounded-xl flex flex-col min-h-[400px]" style="overflow: visible !important;">
                <div class="p-6 border-b border-surface-container-highest flex justify-between items-center bg-[#1E1E1E]/40">
                    <h2 class="font-headline-md text-headline-md text-text-primary uppercase tracking-tight">Parts Procurement</h2>
                    <button id="btn-add-line" onclick="showItemSearch()" class="h-10 px-4 rounded border border-outline-variant text-text-primary font-label-sm text-label-sm uppercase tracking-wider hover:bg-surface-container transition-colors flex items-center gap-2 btn-pulse">
                        <span class="material-symbols-outlined text-sm">add</span> Add Part
                    </button>
                </div>

                {{-- Part Search Input --}}
                <div id="item-search-bar" class="hidden px-6 pt-4 pb-2 border-b border-surface-container-highest/30 relative z-50">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-sm">search</span>
                        <input id="item-search-input" autocomplete="off" class="w-full bg-surface-container-low border border-outline-variant rounded-lg pl-9 pr-4 py-2.5 text-sm text-text-primary focus:border-racing-red focus:ring-1 focus:ring-racing-red outline-none transition-all placeholder:text-text-secondary" placeholder="Search parts by name or ID..." type="text"/>
                        <div id="item-dropdown" class="absolute left-0 right-0 top-full mt-1 bg-surface-container border border-outline-variant rounded-lg shadow-2xl z-[100] hidden max-h-60 overflow-y-auto custom-scrollbar"></div>
                    </div>
                </div>

                {{-- Procurement Cart Table --}}
                <div class="flex-1 overflow-y-auto p-6 flex flex-col gap-3 custom-scrollbar">
                    <div class="grid grid-cols-12 gap-4 px-4 pb-2 border-b border-surface-container-highest/50 font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">
                        <div class="col-span-5">Part Description</div>
                        <div class="col-span-2 text-right">Qty</div>
                        <div class="col-span-2 text-right">Unit Buy Price</div>
                        <div class="col-span-2 text-right">Total</div>
                        <div class="col-span-1"></div>
                    </div>
                    <div id="line-items-container">
                        {{-- Dynamic rows inserted here --}}
                    </div>
                    <div id="empty-state" class="py-12 text-center">
                        <span class="material-symbols-outlined text-4xl text-surface-container-highest mb-2">inventory_2</span>
                        <p class="font-body-md text-text-secondary">No parts added yet</p>
                    </div>
                </div>
            </div>

            {{-- Summary & Persistence --}}
            <div class="glass-panel glow-card animate-entrance delay-4 rounded-xl p-6 bg-gradient-to-br from-[#1E1E1E]/80 to-[#121212]/90 border-t-2 border-t-surface-container">
                <div class="flex flex-col md:flex-row justify-between items-end gap-6">
                    {{-- Calculations Details --}}
                    <div class="w-full md:w-1/2 flex flex-col gap-3">
                        <div class="flex justify-between items-center border-b border-surface-container-highest pb-2">
                            <span class="font-body-md text-text-secondary">Subtotal</span>
                            <span id="sum-subtotal" class="font-receipt-mono text-text-primary">0 IDR</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-surface-container-highest pb-2 gap-4">
                            <span class="font-body-md text-text-secondary">Diskon (IDR)</span>
                            <input id="discount-val" oninput="recalcTotals()" type="number" min="0" value="0" class="w-32 bg-[#1A1A1A] border border-surface-container-highest rounded px-2 py-0.5 text-right text-text-primary font-receipt-mono focus:border-racing-red focus:ring-0 outline-none"/>
                        </div>
                        <div class="flex justify-between items-center border-b border-surface-container-highest pb-2 gap-4">
                            <span class="font-body-md text-text-secondary">PPN (IDR)</span>
                            <input id="ppn-val" oninput="recalcTotals()" type="number" min="0" value="0" class="w-32 bg-[#1A1A1A] border border-surface-container-highest rounded px-2 py-0.5 text-right text-text-primary font-receipt-mono focus:border-racing-red focus:ring-0 outline-none"/>
                        </div>
                    </div>

                    {{-- Action Button --}}
                    <div class="w-full md:w-1/2 flex flex-col items-end gap-4">
                        <div class="text-right flex flex-col items-end">
                            <span class="font-label-sm text-label-sm text-text-secondary uppercase tracking-widest mb-1">Total Procurement Cost</span>
                            <div id="sum-grand-total" class="font-display-lg text-display-lg text-racing-red drop-shadow-[0_0_20px_rgba(229,57,53,0.4)] whitespace-nowrap animate-digit-roll">0</div>
                        </div>
                        <button id="btn-complete" onclick="completePO()" disabled class="btn-pulse w-full md:w-auto px-8 h-14 bg-racing-red text-text-primary font-headline-md text-sm uppercase tracking-widest hover:bg-primary-container transition-colors shadow-[0_0_15px_rgba(229,57,53,0.3)] active:scale-95 flex items-center justify-center gap-3 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-racing-red">
                            Save Inbound PO <span class="material-symbols-outlined">arrow_forward</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TAB 2: PO HISTORY --}}
    <div id="pane-history" class="hidden glass-panel glow-card animate-entrance delay-2 rounded-xl p-6 relative group overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#319db6] to-transparent opacity-50"></div>
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-headline-md text-headline-md text-text-primary uppercase tracking-tight">Procurement History Records</h2>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-sm">search</span>
                <input id="history-search" oninput="filterHistory()" class="bg-[#1A1A1A] border border-outline-variant rounded-full pl-9 pr-4 py-1.5 text-sm text-text-primary focus:border-racing-red focus:ring-1 focus:ring-racing-red outline-none w-64 transition-all placeholder:text-text-secondary" placeholder="Search supplier or invoice..."/>
            </div>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="border-b border-surface-container-highest text-left font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">
                        <th class="py-4 px-6">ID Faktur</th>
                        <th class="py-4 px-6">No. Fisik</th>
                        <th class="py-4 px-6">Supplier</th>
                        <th class="py-4 px-6">Date</th>
                        <th class="py-4 px-6 text-right">Items Subtotal</th>
                        <th class="py-4 px-6 text-right">Total Cost</th>
                        <th class="py-4 px-6">Clerk</th>
                    </tr>
                </thead>
                <tbody id="history-table-body" class="divide-y divide-surface-container-highest/30">
                    @forelse($fakturs as $f)
                        <tr class="table-row-glow hover:bg-surface-container-high/30 transition-colors font-body-md text-text-primary" 
                            data-search-terms="{{ strtolower($f->id_faktur . ' ' . $f->no_faktur . ' ' . ($f->suplier->nama ?? '')) }}">
                            <td class="py-4 px-6 font-receipt-mono text-text-secondary">{{ $f->id_faktur }}</td>
                            <td class="py-4 px-6">{{ $f->no_faktur ?? '-' }}</td>
                            <td class="py-4 px-6 font-semibold">{{ $f->suplier->nama ?? 'Unknown' }}</td>
                            <td class="py-4 px-6">{{ $f->tanggal->format('d M Y') }}</td>
                            <td class="py-4 px-6 text-right font-receipt-mono text-text-secondary">{{ number_format($f->sub_total, 0, ',', '.') }}</td>
                            <td class="py-4 px-6 text-right font-receipt-mono font-semibold text-racing-red">{{ number_format($f->total, 0, ',', '.') }}</td>
                            <td class="py-4 px-6 text-sm text-text-secondary">{{ $f->petugas->nama ?? 'Unknown' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-text-secondary font-body-md">No procurement history found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- SUCCESS MODAL --}}
<div id="success-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-background/80 backdrop-blur-sm"></div>
    <div class="glass-panel rounded-xl w-full max-w-sm mx-4 relative z-10 animate-entrance p-8 text-center">
        <div class="w-20 h-20 rounded-full bg-emerald-success/20 flex items-center justify-center mx-auto mb-4">
            <span class="material-symbols-outlined text-4xl text-emerald-success">check_circle</span>
        </div>
        <h3 class="font-headline-md text-headline-md text-on-surface mb-2">PO Saved Successfully!</h3>
        <p id="success-po-id" class="font-receipt-mono text-receipt-mono text-text-secondary mb-6"></p>
        <button onclick="location.reload()" class="w-full h-12 bg-racing-red text-text-primary rounded font-label-sm text-label-sm uppercase tracking-wider hover:bg-primary-container transition-colors">Okay</button>
    </div>
</div>
@endsection

@section('scripts')
<script>
const lineItems = [];
let debounceTimer;

// ===== TAB SWITCHING =====
function switchTab(tab) {
    const paneCreate = document.getElementById('pane-create');
    const paneHistory = document.getElementById('pane-history');
    const tabCreate = document.getElementById('tab-create');
    const tabHistory = document.getElementById('tab-history');

    if (tab === 'create') {
        paneCreate.classList.remove('hidden');
        paneHistory.classList.add('hidden');
        tabCreate.className = "pb-3 text-headline-md font-bold uppercase tracking-tight border-b-2 border-racing-red text-text-primary transition-all";
        tabHistory.className = "pb-3 text-headline-md font-bold uppercase tracking-tight border-b-2 border-transparent text-text-secondary hover:text-text-primary transition-all";
    } else {
        paneCreate.classList.add('hidden');
        paneHistory.classList.remove('hidden');
        tabHistory.className = "pb-3 text-headline-md font-bold uppercase tracking-tight border-b-2 border-racing-red text-text-primary transition-all";
        tabCreate.className = "pb-3 text-headline-md font-bold uppercase tracking-tight border-b-2 border-transparent text-text-secondary hover:text-text-primary transition-all";
    }
}

// ===== ITEM SEARCH (Only parts with jenis === 'Part') =====
function showItemSearch() {
    document.getElementById('item-search-bar').classList.remove('hidden');
    document.getElementById('item-search-input').focus();
}

const itemInput = document.getElementById('item-search-input');
const itemDropdown = document.getElementById('item-dropdown');
let _searchResults = [];

itemInput.addEventListener('input', function() {
    clearTimeout(debounceTimer);
    const q = this.value.trim();
    if (q.length < 1) { itemDropdown.classList.add('hidden'); return; }
    debounceTimer = setTimeout(() => {
        fetch(`/api/barangs/search?q=${encodeURIComponent(q)}`)
            .then(r => r.json())
            .then(data => {
                // Filter parts only
                _searchResults = data.filter(item => item.jenis === 'Part');
                
                if (_searchResults.length === 0) {
                    itemDropdown.innerHTML = '<div class="px-4 py-3 text-text-secondary font-label-sm">No parts found</div>';
                } else {
                    itemDropdown.innerHTML = _searchResults.map((b, idx) => {
                        return `<div class="item-option px-4 py-3 hover:bg-surface-container-high cursor-pointer transition-colors border-b border-surface-container-highest/30 flex justify-between items-center" data-idx="${idx}">
                            <div>
                                <div class="font-body-md text-text-primary font-medium">${b.nama}</div>
                                <div class="text-xs text-text-secondary mt-0.5">${b.id_barang} · Stock: ${b.stok}</div>
                            </div>
                            <span class="font-receipt-mono text-sm text-text-primary">${formatNumber(b.harga_beli)}</span>
                        </div>`;
                    }).join('');
                }
                itemDropdown.classList.remove('hidden');
                
                // Attach events
                itemDropdown.querySelectorAll('.item-option').forEach(el => {
                    const handler = function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        const idx = parseInt(this.dataset.idx);
                        if (_searchResults[idx]) addLineItem(_searchResults[idx]);
                    };
                    el.addEventListener('mousedown', handler);
                    el.addEventListener('click', handler);
                });
            });
    }, 200);
});

// Close dropdown on click outside
document.addEventListener('click', e => {
    if (!itemInput.contains(e.target) && !itemDropdown.contains(e.target)) {
        itemDropdown.classList.add('hidden');
    }
});

function addLineItem(barang) {
    const existing = lineItems.find(i => i.id_barang === barang.id_barang);
    if (existing) {
        existing.qty++;
    } else {
        lineItems.push({
            id_barang: barang.id_barang,
            nama: barang.nama,
            harga_beli: barang.harga_beli || 0,
            qty: 1
        });
    }
    itemInput.value = '';
    itemDropdown.classList.add('hidden');
    renderLineItems();
}

function removeLineItem(id) {
    const idx = lineItems.findIndex(i => i.id_barang === id);
    if (idx !== -1) lineItems.splice(idx, 1);
    renderLineItems();
}

function updateQty(id, val) {
    const item = lineItems.find(i => i.id_barang === id);
    if (item) {
        item.qty = Math.max(1, parseInt(val) || 1);
    }
    renderLineItems();
}

function updatePrice(id, val) {
    const item = lineItems.find(i => i.id_barang === id);
    if (item) {
        item.harga_beli = Math.max(0, parseInt(val) || 0);
    }
    renderLineItems();
}

function renderLineItems() {
    const container = document.getElementById('line-items-container');
    const empty = document.getElementById('empty-state');

    if (lineItems.length === 0) {
        container.innerHTML = '';
        empty.classList.remove('hidden');
        document.getElementById('btn-complete').disabled = true;
    } else {
        empty.classList.add('hidden');
        document.getElementById('btn-complete').disabled = false;

        container.innerHTML = lineItems.map(item => {
            const totalLine = item.harga_beli * item.qty;
            return `<div class="grid grid-cols-12 gap-4 items-center bg-surface-container p-4 rounded-lg border border-surface-container-highest hover:border-outline-variant transition-colors group">
                <div class="col-span-5 flex flex-col">
                    <span class="font-body-lg text-body-lg text-text-primary font-medium">${item.nama}</span>
                    <span class="font-receipt-mono text-xs text-text-secondary mt-1">${item.id_barang}</span>
                </div>
                <div class="col-span-2 text-right">
                    <input type="number" min="1" value="${item.qty}" onchange="updateQty('${item.id_barang}', this.value)" class="w-16 bg-[#1A1A1A] border border-surface-container-highest rounded px-2 py-1 text-center text-text-primary font-body-md focus:border-racing-red focus:ring-0 outline-none ml-auto block"/>
                </div>
                <div class="col-span-2 text-right">
                    <input type="number" min="0" value="${item.harga_beli}" onchange="updatePrice('${item.id_barang}', this.value)" class="w-24 bg-[#1A1A1A] border border-surface-container-highest rounded px-2 py-1 text-right text-text-primary font-body-md focus:border-racing-red focus:ring-0 outline-none ml-auto block font-receipt-mono"/>
                </div>
                <div class="col-span-2 text-right font-body-lg text-body-lg text-text-primary font-medium font-receipt-mono">${formatNumber(totalLine)}</div>
                <div class="col-span-1 text-center">
                    <button onclick="removeLineItem('${item.id_barang}')" class="w-7 h-7 rounded flex items-center justify-center opacity-0 group-hover:opacity-100 hover:bg-error-container/30 text-text-secondary hover:text-error transition-all">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
            </div>`;
        }).join('');
    }

    recalcTotals();
}

function recalcTotals() {
    let subtotal = 0;
    lineItems.forEach(item => {
        subtotal += item.harga_beli * item.qty;
    });

    const disc = Math.max(0, parseInt(document.getElementById('discount-val').value) || 0);
    const ppn = Math.max(0, parseInt(document.getElementById('ppn-val').value) || 0);
    const grand = Math.max(0, subtotal - disc + ppn);

    document.getElementById('sum-subtotal').textContent = formatNumber(subtotal) + ' IDR';
    document.getElementById('sum-grand-total').textContent = formatNumber(grand);
}

function formatNumber(n) {
    return Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// ===== COMPLETE INBOUND PO =====
function completePO() {
    const suplier = document.getElementById('sel-supplier').value;
    const admin = document.getElementById('sel-admin').value;
    const noFaktur = document.getElementById('no-faktur').value.trim();
    const date = document.getElementById('po-date').value;
    const termin = document.getElementById('po-termin').value.trim();
    const syarat = document.getElementById('po-syarat').value.trim();
    const diskon = parseInt(document.getElementById('discount-val').value) || 0;
    const ppn = parseInt(document.getElementById('ppn-val').value) || 0;

    if (!suplier) { alert('Please select a Supplier.'); return; }
    if (!admin) { alert('Please select a Receiving Admin.'); return; }
    if (!date) { alert('Please select a Date.'); return; }
    if (lineItems.length === 0) return;

    const payload = {
        id_suplier: suplier,
        id_petugas: admin,
        no_faktur: noFaktur || null,
        tanggal: date,
        termin: termin || null,
        syarat_pembayaran: syarat || null,
        diskon: diskon,
        ppn: ppn,
        items: lineItems.map(i => ({
            id_barang: i.id_barang,
            qty: i.qty,
            harga_beli: i.harga_beli
        }))
    };

    fetch('{{ route("inbound-po.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(payload)
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('success-po-id').textContent = `Faktur: ${data.id_faktur} — Total: ${formatNumber(data.total)} IDR`;
            document.getElementById('success-modal').classList.remove('hidden');
            document.getElementById('success-modal').classList.add('flex');
        } else {
            alert('Error saving Inbound PO.');
        }
    })
    .catch(() => alert('Network error.'));
}

// ===== FILTER PO HISTORY =====
function filterHistory() {
    const query = document.getElementById('history-search').value.toLowerCase().trim();
    const rows = document.querySelectorAll('#history-table-body tr');

    rows.forEach(row => {
        const terms = row.getAttribute('data-search-terms');
        if (!terms) return;
        if (terms.includes(query)) {
            row.classList.remove('hidden');
        } else {
            row.classList.add('hidden');
        }
    });
}
</script>
@endsection
