@extends('layouts.app')
@section('title', '2WHEELS HOUSE - Staff')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 animate-entrance delay-2">
        <div>
            <h2 class="font-headline-lg text-headline-lg text-on-surface uppercase tracking-tight">Staff</h2>
            <p class="font-label-sm text-label-sm text-text-secondary tracking-widest uppercase mt-1">Admin & Mechanic Management</p>
        </div>
        <button onclick="openModal()" class="btn-pulse h-12 px-6 bg-racing-red text-text-primary font-label-sm text-label-sm uppercase tracking-widest rounded flex items-center gap-2 shadow-[0_0_15px_rgba(229,57,53,0.3)] hover:bg-primary-container transition-colors active:scale-95 shrink-0">
            <span class="material-symbols-outlined text-lg">add_circle</span> Add New
        </button>
    </div>

    {{-- TELEMETRY STATUS ROW --}}
    <div class="glass-panel rounded-xl mb-8 overflow-hidden animate-entrance delay-2 border border-outline-variant/35 bg-[#171717]/80 backdrop-blur-xl">
        <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-outline-variant/20">
            
            {{-- Stat 1: Total Staff --}}
            <div class="p-6 flex flex-col justify-between min-h-[120px] hover:bg-white/[0.01] transition-colors group">
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-[10px] text-text-secondary uppercase tracking-widest">Active Staff</span>
                    <span class="material-symbols-outlined text-sm text-racing-red opacity-60 group-hover:opacity-100 transition-opacity">groups</span>
                </div>
                <div class="flex items-baseline gap-2 mt-4">
                    <span class="font-receipt-mono text-4xl font-bold text-text-primary tracking-tight select-none">{{ sprintf('%02d', $staff->total() ?? 0) }}</span>
                    <span class="font-label-sm text-[10px] text-racing-red uppercase tracking-wider font-semibold">personnel</span>
                </div>
            </div>

            {{-- Stat 2: Admin --}}
            <div class="p-6 flex flex-col justify-between min-h-[120px] hover:bg-white/[0.01] transition-colors group">
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-[10px] text-text-secondary uppercase tracking-widest">Administrative</span>
                    <span class="material-symbols-outlined text-sm text-tertiary opacity-60 group-hover:opacity-100 transition-opacity">admin_panel_settings</span>
                </div>
                <div class="flex items-baseline gap-2 mt-4">
                    <span class="font-receipt-mono text-4xl font-bold text-text-primary tracking-tight select-none">{{ sprintf('%02d', $countAdmin ?? 0) }}</span>
                    <span class="font-label-sm text-[10px] text-tertiary uppercase tracking-wider font-semibold">admins</span>
                </div>
            </div>

            {{-- Stat 3: Mechanics --}}
            <div class="p-6 flex flex-col justify-between min-h-[120px] hover:bg-white/[0.01] transition-colors group">
                <div class="flex items-center justify-between">
                    <span class="font-label-sm text-[10px] text-text-secondary uppercase tracking-widest">Mechanics / Technicians</span>
                    <span class="material-symbols-outlined text-sm text-emerald-success opacity-60 group-hover:opacity-100 transition-opacity">engineering</span>
                </div>
                <div class="flex items-baseline gap-2 mt-4">
                    <span class="font-receipt-mono text-4xl font-bold text-text-primary tracking-tight select-none">{{ sprintf('%02d', $countMekanik ?? 0) }}</span>
                    <span class="font-label-sm text-[10px] text-emerald-success uppercase tracking-wider font-semibold">engineers</span>
                </div>
            </div>

        </div>
    </div>

    {{-- DATA GRID --}}
    <div class="glass-panel glow-card rounded-xl animate-entrance delay-3 overflow-hidden">
        <div class="p-6 border-b border-surface-container-highest flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-[#1E1E1E]/40">
            <div class="flex items-center gap-3">
                <h3 class="font-headline-md text-headline-md text-text-primary uppercase tracking-tight">Data Grid</h3>
                <span class="bg-surface-container-high text-text-secondary font-label-sm text-label-sm px-2.5 py-1 rounded-full">{{ $staff->total() }} records</span>
            </div>
            <div class="flex items-center gap-3">
                <div class="hidden md:flex items-center gap-1 bg-surface-container-low rounded-lg p-1">
                    <a href="{{ route('staff', ['jabatan' => '']) }}" class="px-3 py-1.5 rounded font-label-sm text-label-sm uppercase tracking-wider transition-colors {{ !request('jabatan') ? 'bg-surface-container-high text-text-primary' : 'text-text-secondary hover:text-text-primary' }}">All</a>
                    <a href="{{ route('staff', ['jabatan' => 'Admin']) }}" class="px-3 py-1.5 rounded font-label-sm text-label-sm uppercase tracking-wider transition-colors {{ request('jabatan') === 'Admin' ? 'bg-surface-container-high text-text-primary' : 'text-text-secondary hover:text-text-primary' }}">Admin</a>
                    <a href="{{ route('staff', ['jabatan' => 'Mekanik']) }}" class="px-3 py-1.5 rounded font-label-sm text-label-sm uppercase tracking-wider transition-colors {{ request('jabatan') === 'Mekanik' ? 'bg-surface-container-high text-text-primary' : 'text-text-secondary hover:text-text-primary' }}">Mechanic</a>
                </div>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary text-sm">search</span>
                    <form method="GET" action="{{ route('staff') }}">
                        <input name="search" value="{{ request('search') }}" class="bg-surface-container-low border border-outline-variant rounded-lg pl-9 pr-4 py-2 text-sm text-text-primary focus:border-racing-red focus:ring-1 focus:ring-racing-red outline-none w-48 transition-all placeholder:text-text-secondary" placeholder="Search staff..."/>
                        @if(request('jabatan'))<input type="hidden" name="jabatan" value="{{ request('jabatan') }}">@endif
                    </form>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full min-w-[600px]">
                <thead>
                    <tr class="border-b border-surface-container-highest/50">
                        <th class="text-left px-6 py-4 font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">ID</th>
                        <th class="text-left px-6 py-4 font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">Name</th>
                        <th class="text-left px-6 py-4 font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">Role</th>
                        <th class="text-center px-6 py-4 font-label-sm text-label-sm text-text-secondary uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff as $s)
                    <tr class="table-row-glow border-b border-surface-container-highest/30 group cursor-pointer">
                        <td class="px-6 py-4"><span class="font-receipt-mono text-receipt-mono text-text-secondary">{{ $s->id_petugas }}</span></td>
                        <td class="px-6 py-4"><span class="font-body-lg text-body-lg text-text-primary font-medium">{{ $s->nama }}</span></td>
                        <td class="px-6 py-4">
                            @if($s->jabatan === 'Admin')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-tertiary/10 text-tertiary font-label-sm text-label-sm uppercase tracking-wider border border-tertiary/20"><span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>Admin</span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-success/10 text-emerald-success font-label-sm text-label-sm uppercase tracking-wider border border-emerald-success/20"><span class="w-1.5 h-1.5 rounded-full bg-emerald-success"></span>Mekanik</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button onclick="editStaff('{{ $s->id_petugas }}', '{{ $s->nama }}', '{{ $s->jabatan }}')" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-surface-container-high text-text-secondary hover:text-tertiary transition-colors"><span class="material-symbols-outlined text-lg">edit</span></button>
                                <button onclick="deleteItem('{{ $s->id_petugas }}')" class="w-8 h-8 rounded-lg flex items-center justify-center hover:bg-error-container/30 text-text-secondary hover:text-error transition-colors"><span class="material-symbols-outlined text-lg">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-16 text-center"><div class="flex flex-col items-center gap-3"><span class="material-symbols-outlined text-5xl text-surface-container-highest">badge</span><p class="font-body-md text-text-secondary">No staff yet</p><button onclick="openModal()" class="mt-2 px-4 py-2 rounded bg-surface-container-high text-text-primary font-label-sm text-label-sm uppercase tracking-wider hover:bg-surface-bright transition-colors">Add first staff</button></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($staff->hasPages())
        <div class="px-6 py-4 border-t border-surface-container-highest/50 flex items-center justify-between">
            <div class="font-label-sm text-label-sm text-text-secondary">Showing {{ $staff->firstItem() }} - {{ $staff->lastItem() }} of {{ $staff->total() }}</div>
            <div class="flex items-center gap-1">
                @foreach($staff->getUrlRange(1, $staff->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="w-9 h-9 rounded-lg flex items-center justify-center font-label-sm text-label-sm transition-colors {{ $page == $staff->currentPage() ? 'bg-racing-red text-text-primary' : 'text-text-secondary hover:bg-surface-container-high' }}">{{ $page }}</a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

{{-- ADD/EDIT MODAL --}}
<div id="item-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-background/80 backdrop-blur-sm" onclick="closeModal()"></div>
    <div class="glass-panel rounded-xl w-full max-w-md mx-4 relative z-10 animate-entrance overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-racing-red via-racing-red/50 to-transparent"></div>
        <div class="p-6 border-b border-surface-container-highest flex items-center justify-between">
            <h3 id="modal-title" class="font-headline-md text-headline-md text-on-surface uppercase tracking-tight">Add Staff</h3>
            <button onclick="closeModal()" class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-surface-variant/50 text-text-secondary hover:text-text-primary transition-colors"><span class="material-symbols-outlined">close</span></button>
        </div>
        <form id="item-form" method="POST" action="{{ route('staff.store') }}" class="p-6 flex flex-col gap-5">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            <div class="relative">
                <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Staff ID</label>
                <input id="f-id" name="id_petugas" required class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-md px-0 py-2 focus:ring-0 transition-colors placeholder:text-surface-container-highest" type="text" placeholder="e.g. PTG-001"/>
            </div>
            <div class="relative">
                <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Full Name</label>
                <input id="f-nama" name="nama" required class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-md px-0 py-2 focus:ring-0 transition-colors placeholder:text-surface-container-highest" type="text" placeholder="Staff name"/>
            </div>
            <div class="relative">
                <label class="font-label-sm text-label-sm text-text-secondary uppercase mb-2 block">Role</label>
                <select id="f-jabatan" name="jabatan" required class="w-full bg-[#1A1A1A] border-0 border-b-2 border-surface-container-highest focus:border-racing-red text-text-primary font-body-md px-0 py-2 focus:ring-0 transition-colors appearance-none">
                    <option value="Admin">Admin</option>
                    <option value="Mekanik">Mekanik</option>
                </select>
                <span class="material-symbols-outlined absolute right-0 bottom-2 text-text-secondary pointer-events-none">arrow_drop_down</span>
            </div>
            <div class="flex items-center justify-end gap-3 mt-4 pt-4 border-t border-surface-container-highest/50">
                <button type="button" onclick="closeModal()" class="h-11 px-6 rounded border border-outline-variant text-text-primary font-label-sm text-label-sm uppercase tracking-wider hover:bg-surface-container transition-colors">Cancel</button>
                <button type="submit" class="btn-pulse h-11 px-8 bg-racing-red text-text-primary font-label-sm text-label-sm uppercase tracking-wider rounded shadow-[0_0_15px_rgba(229,57,53,0.3)] hover:bg-primary-container transition-colors active:scale-95 flex items-center gap-2"><span class="material-symbols-outlined text-lg">save</span> Save</button>
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
            <h3 class="font-headline-md text-headline-md text-on-surface">Delete Staff?</h3>
            <form id="delete-form" method="POST" class="flex items-center gap-3 w-full mt-2">@csrf @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="flex-1 h-11 rounded border border-outline-variant text-text-primary font-label-sm text-label-sm uppercase tracking-wider hover:bg-surface-container transition-colors">Cancel</button>
                <button type="submit" class="flex-1 h-11 bg-error text-on-error rounded font-label-sm text-label-sm uppercase tracking-wider hover:bg-error-container transition-colors active:scale-95">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openModal() { document.getElementById('item-modal').classList.remove('hidden'); document.getElementById('item-modal').classList.add('flex'); document.getElementById('modal-title').textContent='Add Staff'; document.getElementById('item-form').action='{{ route("staff.store") }}'; document.getElementById('form-method').value='POST'; document.getElementById('f-id').readOnly=false; document.getElementById('item-form').reset(); }
function editStaff(id,nama,jabatan) { document.getElementById('item-modal').classList.remove('hidden'); document.getElementById('item-modal').classList.add('flex'); document.getElementById('modal-title').textContent='Edit Staff'; document.getElementById('item-form').action=`/staff/${id}`; document.getElementById('form-method').value='PUT'; document.getElementById('f-id').value=id; document.getElementById('f-id').readOnly=true; document.getElementById('f-nama').value=nama; document.getElementById('f-jabatan').value=jabatan; }
function closeModal() { document.getElementById('item-modal').classList.add('hidden'); document.getElementById('item-modal').classList.remove('flex'); }
function deleteItem(id) { document.getElementById('delete-modal').classList.remove('hidden'); document.getElementById('delete-modal').classList.add('flex'); document.getElementById('delete-form').action=`/staff/${id}`; }
function closeDeleteModal() { document.getElementById('delete-modal').classList.add('hidden'); document.getElementById('delete-modal').classList.remove('flex'); }
document.querySelectorAll('.glow-card').forEach(c=>{c.addEventListener('mousemove',e=>{const r=c.getBoundingClientRect();c.style.setProperty('--mouse-x',`${e.clientX-r.left}px`);c.style.setProperty('--mouse-y',`${e.clientY-r.top}px`);});});
</script>
@endsection
