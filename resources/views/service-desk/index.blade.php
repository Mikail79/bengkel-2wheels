@extends('layouts.app')
@section('title', '2WHEELS HOUSE - Service Desk')

@section('content')
<div class="max-w-7xl mx-auto grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">

    {{-- LEFT COLUMN: Details & Signature (Spans 4) --}}
    <div class="xl:col-span-4 flex flex-col gap-6">
        <div class="glass-panel glow-card animate-entrance delay-2 rounded-xl p-6 relative group">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-racing-red to-transparent opacity-50"></div>
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-headline-md text-headline-md text-text-primary uppercase tracking-tight">Details</h2>
                <span class="font-receipt-mono text-receipt-mono text-text-secondary" id="nota-id">NEW</span>
            </div>
            <div class="flex flex-col gap-5">
                {{-- Customer Search --}}
                <div class="relative">
                    <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Customer / Nopol</label>
                    <input id="customer-search" autocomplete="off" class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-lg px-0 py-2 focus:ring-0 transition-colors placeholder:text-surface-container-highest" type="text" placeholder="Search customer or plate number..."/>
                    <div id="customer-dropdown" class="absolute left-0 right-0 top-full mt-1 bg-surface-container border border-outline-variant rounded-lg shadow-2xl z-30 hidden max-h-60 overflow-y-auto custom-scrollbar"></div>
                    <input type="hidden" id="selected-nopol" value="">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="relative">
                        <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Admin</label>
                        <select id="sel-admin" class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-md px-0 py-2 focus:ring-0 transition-colors appearance-none">
                            <option value="">Select admin...</option>
                            @foreach($admins as $a)
                                <option value="{{ $a->id_petugas }}">{{ $a->nama }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-0 bottom-2 text-text-secondary pointer-events-none">arrow_drop_down</span>
                    </div>
                    <div class="relative">
                        <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Mechanic</label>
                        <select id="sel-mekanik" class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-md px-0 py-2 focus:ring-0 transition-colors appearance-none">
                            <option value="">Optional...</option>
                            @foreach($mekaniks as $m)
                                <option value="{{ $m->id_petugas }}">{{ $m->nama }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-0 bottom-2 text-text-secondary pointer-events-none">arrow_drop_down</span>
                    </div>
                </div>

                <div class="relative">
                    <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Date</label>
                    <input class="w-full bg-transparent border-0 border-b-2 border-surface-container-highest text-text-primary font-body-md px-0 py-2 focus:ring-0 cursor-default opacity-70" readonly type="text" value="{{ now()->format('d M Y') }}"/>
                </div>

                {{-- Selected Vehicle Display --}}
                <div id="vehicle-display" class="relative mt-2 hidden">
                    <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Vehicle</label>
                    <div class="flex items-center gap-3 bg-[#1A1A1A] p-3 rounded border border-surface-container-highest">
                        <span class="material-symbols-outlined text-text-secondary">two_wheeler</span>
                        <span id="vehicle-text" class="font-receipt-mono text-receipt-mono text-text-primary"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Signature --}}
        <div class="glass-panel glow-card animate-entrance delay-3 rounded-xl p-6 relative">
            <h2 class="font-label-sm text-label-sm text-text-secondary uppercase tracking-widest mb-4">Tanda Terima</h2>
            <div class="w-full h-32 bg-[#121212] rounded border border-surface-container-highest relative cursor-crosshair overflow-hidden group">
                <svg class="absolute top-0 left-0 w-full h-full opacity-60 pointer-events-none animate-float" viewBox="0 0 200 100"><path d="M 20 50 Q 50 20 80 50 T 140 50 Q 160 80 180 30" fill="none" stroke="white" stroke-linecap="round" stroke-width="2"></path></svg>
                <div class="absolute bottom-2 left-4 right-4 border-t border-surface-container-highest/50 border-dashed"></div>
                <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center"><span class="font-label-sm text-label-sm text-text-secondary">Sign Here</span></div>
            </div>
        </div>
    </div>

    {{-- RIGHT COLUMN: Line Items & Summary (Spans 8) --}}
    <div class="xl:col-span-8 flex flex-col gap-6">
        <div class="glass-panel glow-card animate-entrance delay-2 rounded-xl flex flex-col min-h-[400px]" style="overflow: visible !important;">
            <div class="p-6 border-b border-surface-container-highest flex justify-between items-center bg-[#1E1E1E]/40">
                <h2 class="font-headline-md text-headline-md text-text-primary uppercase tracking-tight">Parts & Labor</h2>
                <button id="btn-add-line" onclick="showItemSearch()" class="h-10 px-4 rounded border border-outline-variant text-text-primary font-label-sm text-label-sm uppercase tracking-wider hover:bg-surface-container transition-colors flex items-center gap-2 btn-pulse">
                    <span class="material-symbols-outlined text-sm">add</span> Add Item
                </button>
            </div>

            {{-- Item Search (shown on click) --}}
            <div id="item-search-bar" class="hidden px-6 pt-4 pb-2 border-b border-surface-container-highest/30 relative z-50">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-sm">search</span>
                    <input id="item-search-input" autocomplete="off" class="w-full bg-surface-container-low border border-outline-variant rounded-lg pl-9 pr-4 py-2.5 text-sm text-text-primary focus:border-racing-red focus:ring-1 focus:ring-racing-red outline-none transition-all placeholder:text-text-secondary" placeholder="Search items by name or ID..." type="text"/>
                    <div id="item-dropdown" class="absolute left-0 right-0 top-full mt-1 bg-surface-container border border-outline-variant rounded-lg shadow-2xl z-[100] hidden max-h-60 overflow-y-auto custom-scrollbar"></div>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-6 flex flex-col gap-3 custom-scrollbar">
                <div class="grid grid-cols-12 gap-4 px-4 pb-2 border-b border-surface-container-highest/50 font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">
                    <div class="col-span-5">Description</div>
                    <div class="col-span-2 text-right">Qty</div>
                    <div class="col-span-2 text-right">Unit</div>
                    <div class="col-span-2 text-right">Total</div>
                    <div class="col-span-1"></div>
                </div>
                <div id="line-items-container">
                    {{-- Dynamic rows inserted here --}}
                </div>
                <div id="empty-state" class="py-12 text-center">
                    <span class="material-symbols-outlined text-4xl text-surface-container-highest mb-2">receipt_long</span>
                    <p class="font-body-md text-text-secondary">No items added yet</p>
                </div>
            </div>
        </div>

        {{-- Summary --}}
        <div class="glass-panel glow-card animate-entrance delay-4 rounded-xl p-6 bg-gradient-to-br from-[#1E1E1E]/80 to-[#121212]/90 border-t-2 border-t-surface-container">
            <div class="flex flex-col md:flex-row justify-between items-end gap-6">
                <div class="w-full md:w-1/2 flex flex-col gap-2">
                    <div class="flex justify-between items-center border-b border-surface-container-highest pb-2">
                        <span class="font-body-md text-text-secondary">Subtotal</span>
                        <span id="sum-subtotal" class="font-receipt-mono text-text-primary">0 IDR</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-surface-container-highest pb-2">
                        <span class="font-body-md text-text-secondary">Discount</span>
                        <span id="sum-discount" class="font-receipt-mono text-emerald-success">- 0 IDR</span>
                    </div>
                </div>
                <div class="w-full md:w-1/2 flex flex-col items-end gap-4">
                    <div class="text-right flex flex-col items-end">
                        <span class="font-label-sm text-label-sm text-text-secondary uppercase tracking-widest mb-1">Total Due</span>
                        <div id="sum-grand-total" class="font-display-lg text-display-lg text-racing-red drop-shadow-[0_0_20px_rgba(229,57,53,0.4)] whitespace-nowrap animate-digit-roll">0</div>
                    </div>
                    <button id="btn-complete" onclick="completeTransaction()" disabled class="btn-pulse w-full md:w-auto px-8 h-14 bg-racing-red text-text-primary font-headline-md text-sm uppercase tracking-widest hover:bg-primary-container transition-colors shadow-[0_0_15px_rgba(229,57,53,0.3)] active:scale-95 flex items-center justify-center gap-3 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-racing-red">
                        Complete Transaction <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SUCCESS MODAL --}}
<div id="success-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-background/80 backdrop-blur-sm"></div>
    <div class="glass-panel rounded-xl w-full max-w-sm mx-4 relative z-10 animate-entrance p-8 text-center">
        <div class="w-20 h-20 rounded-full bg-emerald-success/20 flex items-center justify-center mx-auto mb-4"><span class="material-symbols-outlined text-4xl text-emerald-success">check_circle</span></div>
        <h3 class="font-headline-md text-headline-md text-on-surface mb-2">Transaction Saved!</h3>
        <p id="success-nota-id" class="font-receipt-mono text-receipt-mono text-text-secondary mb-6"></p>
        <button onclick="resetForm()" class="w-full h-12 bg-racing-red text-text-primary rounded font-label-sm text-label-sm uppercase tracking-wider hover:bg-primary-container transition-colors">New Transaction</button>
    </div>
</div>
@endsection

@section('scripts')
<script>
const lineItems = [];
let debounceTimer;

// ===== CUSTOMER SEARCH =====
const custInput = document.getElementById('customer-search');
const custDropdown = document.getElementById('customer-dropdown');

function performCustomerSearch(q) {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        fetch(`/api/customers/search?q=${encodeURIComponent(q)}`)
            .then(r => r.json())
            .then(data => {
                if (data.length === 0) {
                    custDropdown.innerHTML = '<div class="px-4 py-3 text-text-secondary font-label-sm">No results found</div>';
                } else {
                    custDropdown.innerHTML = data.map(c => {
                        const motors = (c.motors || []).map(m => `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-tertiary/10 text-tertiary font-label-sm text-xs border border-tertiary/20">${m.nopol}</span>`).join(' ');
                        return `<div class="px-4 py-3 hover:bg-surface-container-high cursor-pointer transition-colors border-b border-surface-container-highest/30" data-customer='${JSON.stringify(c)}'>
                            <div class="font-body-md text-text-primary font-medium">${c.nama}</div>
                            <div class="text-xs text-text-secondary mt-0.5">${c.kontak}</div>
                            <div class="flex flex-wrap gap-1 mt-1.5">${motors || '<span class="text-xs text-text-secondary">No vehicles</span>'}</div>
                        </div>`;
                    }).join('');
                }
                custDropdown.classList.remove('hidden');
                // Dual event: mousedown prevents blur, click for compatibility
                custDropdown.querySelectorAll('[data-customer]').forEach(el => {
                    const handler = function(e) {
                        e.preventDefault();
                        const c = JSON.parse(this.dataset.customer);
                        selectCustomer(c);
                    };
                    el.addEventListener('mousedown', handler);
                    el.addEventListener('click', handler);
                });
            });
    }, 300);
}

custInput.addEventListener('input', function() {
    performCustomerSearch(this.value.trim());
});

custInput.addEventListener('focus', function() {
    performCustomerSearch(this.value.trim());
});

function selectCustomer(c) {
    custInput.value = `${c.nama} — ${c.kontak}`;
    custDropdown.classList.add('hidden');
    const vehDisplay = document.getElementById('vehicle-display');
    if (c.motors && c.motors.length > 0) {
        document.getElementById('selected-nopol').value = c.motors[0].nopol;
        document.getElementById('vehicle-text').textContent = c.motors[0].nopol;
        vehDisplay.classList.remove('hidden');
    } else {
        vehDisplay.classList.add('hidden');
    }
}

document.addEventListener('click', e => {
    if (!custInput.contains(e.target) && !custDropdown.contains(e.target)) custDropdown.classList.add('hidden');
    if (!document.getElementById('item-search-input')?.contains(e.target) && !document.getElementById('item-dropdown')?.contains(e.target)) document.getElementById('item-dropdown')?.classList.add('hidden');
});

// ===== ITEM SEARCH =====
function showItemSearch() {
    document.getElementById('item-search-bar').classList.remove('hidden');
    document.getElementById('item-search-input').focus();
}

const itemInput = document.getElementById('item-search-input');
const itemDropdown = document.getElementById('item-dropdown');

let _searchResults = []; // temp store for search results

function performItemSearch(q) {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        fetch(`/api/barangs/search?q=${encodeURIComponent(q)}`)
            .then(r => r.json())
            .then(data => {
                _searchResults = data;
                if (data.length === 0) {
                    itemDropdown.innerHTML = '<div class="px-4 py-3 text-text-secondary font-label-sm">No items found</div>';
                } else {
                    itemDropdown.innerHTML = data.map((b, idx) => {
                        const badge = b.jenis === 'Part'
                            ? '<span class="px-2 py-0.5 rounded-full bg-tertiary/10 text-tertiary text-xs border border-tertiary/20">Part</span>'
                            : '<span class="px-2 py-0.5 rounded-full bg-emerald-success/10 text-emerald-success text-xs border border-emerald-success/20">Jasa</span>';
                        const stock = b.jenis === 'Part' ? `Stock: ${b.stok}` : '';
                        return `<div class="item-option px-4 py-3 hover:bg-surface-container-high cursor-pointer transition-colors border-b border-surface-container-highest/30 flex justify-between items-center" data-idx="${idx}">
                            <div>
                                <div class="font-body-md text-text-primary font-medium">${b.nama}</div>
                                <div class="text-xs text-text-secondary mt-0.5">${b.id_barang} ${stock ? '· ' + stock : ''}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                ${badge}
                                <span class="font-receipt-mono text-sm text-text-primary">${formatNumber(b.harga_jual)}</span>
                            </div>
                        </div>`;
                    }).join('');
                }
                itemDropdown.classList.remove('hidden');
                // Dual event: mousedown prevents blur, click for compatibility
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
}

itemInput.addEventListener('input', function() {
    performItemSearch(this.value.trim());
});

itemInput.addEventListener('focus', function() {
    performItemSearch(this.value.trim());
});

function addLineItem(barang) {
    // Check if already added
    const existing = lineItems.find(i => i.id_barang === barang.id_barang);
    if (existing) { existing.banyaknya++; } 
    else { lineItems.push({ ...barang, banyaknya: 1 }); }
    
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
    if (item) { item.banyaknya = Math.max(1, parseInt(val) || 1); }
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
            const hargaEfektif = item.harga_jual - (item.harga_jual * item.diskon / 100);
            const subTotal = hargaEfektif * item.banyaknya;
            const badge = item.jenis === 'Part'
                ? '<span class="text-xs text-tertiary">Part</span>'
                : '<span class="text-xs text-emerald-success">Jasa</span>';

            return `<div class="grid grid-cols-12 gap-4 items-center bg-surface-container p-4 rounded-lg border border-surface-container-highest hover:border-outline-variant transition-colors group">
                <div class="col-span-5 flex flex-col">
                    <span class="font-body-lg text-body-lg text-text-primary font-medium">${item.nama}</span>
                    <span class="font-receipt-mono text-xs text-text-secondary mt-1">${item.id_barang} · ${badge}</span>
                </div>
                <div class="col-span-2 text-right">
                    <input type="number" min="1" value="${item.banyaknya}" onchange="updateQty('${item.id_barang}', this.value)" class="w-16 bg-[#1A1A1A] border border-surface-container-highest rounded px-2 py-1 text-center text-text-primary font-body-md focus:border-racing-red focus:ring-0 outline-none ml-auto block"/>
                </div>
                <div class="col-span-2 text-right font-receipt-mono text-sm text-text-secondary">${formatNumber(hargaEfektif)}</div>
                <div class="col-span-2 text-right font-body-lg text-body-lg text-text-primary font-medium">${formatNumber(subTotal)}</div>
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
    let subtotal = 0, discount = 0;
    lineItems.forEach(item => {
        const full = item.harga_jual * item.banyaknya;
        const disc = item.harga_jual * item.diskon / 100 * item.banyaknya;
        subtotal += full;
        discount += disc;
    });
    const grandTotal = subtotal - discount;
    document.getElementById('sum-subtotal').textContent = formatNumber(subtotal) + ' IDR';
    document.getElementById('sum-discount').textContent = '- ' + formatNumber(discount) + ' IDR';
    document.getElementById('sum-grand-total').textContent = formatNumber(grandTotal);
}

function formatNumber(n) {
    return Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// ===== COMPLETE =====
function completeTransaction() {
    const nopol = document.getElementById('selected-nopol').value;
    const admin = document.getElementById('sel-admin').value;
    const mekanik = document.getElementById('sel-mekanik').value;

    if (!nopol) { alert('Please select a customer with a vehicle.'); return; }
    if (!admin) { alert('Please select an admin.'); return; }
    if (lineItems.length === 0) return;

    const payload = {
        nopol, id_petugas_admin: admin, id_petugas_mekanik: mekanik || null,
        items: lineItems.map(i => ({ id_barang: i.id_barang, banyaknya: i.banyaknya }))
    };

    fetch('{{ route("service-desk.store") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify(payload)
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('success-nota-id').textContent = `Nota: ${data.id_nota} — Total: ${formatNumber(data.total)} IDR`;
            document.getElementById('success-modal').classList.remove('hidden');
            document.getElementById('success-modal').classList.add('flex');
        } else {
            alert('Error saving transaction.');
        }
    })
    .catch(() => alert('Network error.'));
}

function resetForm() {
    lineItems.length = 0;
    renderLineItems();
    custInput.value = '';
    document.getElementById('selected-nopol').value = '';
    document.getElementById('vehicle-display').classList.add('hidden');
    document.getElementById('sel-admin').value = '';
    document.getElementById('sel-mekanik').value = '';
    document.getElementById('success-modal').classList.add('hidden');
    document.getElementById('success-modal').classList.remove('flex');
}

// Init glow cards
document.querySelectorAll('.glow-card').forEach(c => {
    c.addEventListener('mousemove', e => { const r=c.getBoundingClientRect(); c.style.setProperty('--mouse-x',`${e.clientX-r.left}px`); c.style.setProperty('--mouse-y',`${e.clientY-r.top}px`); });
});
</script>
@endsection
