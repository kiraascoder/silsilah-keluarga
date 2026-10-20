<x-app-layout title="Pohon Silsilah">

    <div class="max-w-7xl mx-auto">
        <div class="mb-8 flex items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Pohon Silsilah</h1>
                <p class="text-slate-500 mt-1">Struktur hubungan keluarga {{ $keluargaAktif->nama_keluarga }}.</p>
            </div>
            <a href="{{ route('anggota.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">
                <i data-lucide="plus" class="h-5 w-5"></i>
                Tambah Anggota
            </a>
        </div>

        @if ($anggotaUtama)
            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Titik Utama</p>
                        <p class="mt-1 text-sm text-slate-500">Pohon mengikuti leluhur yang terhubung dengan anggota utama, kemudian menurun ke generasi berikutnya.</p>
                    </div>
                    <a href="{{ route('anggota.show', $anggotaUtama->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">Lihat Detail</a>
                </div>
            </div>
        @endif

        <div class="rounded-2xl border border-slate-200 bg-white overflow-hidden">
            <div class="border-b border-slate-200 px-6 py-5">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Struktur Keluarga</h2>
                        <p class="mt-1 text-sm text-slate-500">{{ $anggota->count() }} anggota terdaftar.</p>
                    </div>
                    <div class="text-xs text-slate-400">Gunakan scroll horizontal untuk melihat pohon yang besar.</div>
                </div>
            </div>
            <div id="family-tree" class="family-tree-wrapper"></div>
        </div>
    </div>

    <style>
        .family-tree-wrapper { width: 100%; min-height: 700px; overflow: auto; padding: 90px 80px 120px; background: radial-gradient(circle at 1px 1px, #e2e8f0 1px, transparent 0); background-size: 24px 24px; }
        .family-tree { display: flex; flex-direction: column; align-items: center; min-width: max-content; }
        .tree-roots { display: flex; align-items: flex-start; justify-content: center; gap: 80px; min-width: max-content; }
        .generation-label { margin-bottom: 30px; text-align: center; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #94a3b8; }
        .root-group { display: flex; flex-direction: column; align-items: center; }
        .family-unit { display: flex; flex-direction: column; align-items: center; position: relative; }
        .couple { display: flex; align-items: stretch; justify-content: center; position: relative; }
        .spouse-unit { display: flex; align-items: center; }
        .couple-line { width: 34px; height: 2px; background: #94a3b8; flex-shrink: 0; align-self: center; }
        .person-card { width: 210px; min-height: 100px; background: #fff; border: 1px solid #cbd5e1; border-radius: 16px; padding: 12px; display: flex; align-items: flex-start; gap: 12px; box-shadow: 0 4px 12px rgba(15, 23, 42, .06); text-decoration: none; transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease; position: relative; z-index: 2; }
        .person-card:hover { border-color: #3b82f6; box-shadow: 0 8px 20px rgba(37, 99, 235, .12); transform: translateY(-2px); }
        .person-photo { width: 48px; height: 48px; flex-shrink: 0; border-radius: 9999px; overflow: hidden; background: #f1f5f9; display: flex; align-items: center; justify-content: center; }
        .person-photo img { width: 100%; height: 100%; object-fit: cover; }
        .person-info { min-width: 0; }
        .person-name { font-size: 13px; line-height: 1.35; font-weight: 700; color: #0f172a; word-break: break-word; }
        .person-generation { margin-top: 3px; font-size: 11px; color: #64748b; }
        .person-gender { margin-top: 2px; font-size: 10px; color: #94a3b8; text-transform: capitalize; }
        .person-description { margin-top: 7px; font-size: 10px; line-height: 1.45; color: #475569; }
        .relationship-badge { display: inline-flex; margin-top: 6px; border-radius: 9999px; padding: 2px 7px; font-size: 9px; font-weight: 700; background: #f1f5f9; color: #64748b; }
        .relationship-badge.current { background: #ecfdf5; color: #047857; }
        .family-children { position: relative; margin-top: 0; display: flex; justify-content: center; align-items: flex-start; gap: 55px; padding-top: 112px; width: max-content; }
        .family-children::before { content: ""; position: absolute; top: 0; left: 50%; width: 2px; height: 112px; background: #94a3b8; transform: translateX(-50%); }
        .children-horizontal-line { position: absolute; top: 112px; left: 0; right: 0; height: 2px; background: #94a3b8; }
        .child-unit { position: relative; padding-top: 44px; display: flex; flex-direction: column; align-items: center; }
        .child-unit::before { content: ""; position: absolute; top: 0; left: 50%; width: 2px; height: 44px; background: #94a3b8; transform: translateX(-50%); }
        .empty-tree { min-width: 350px; padding: 70px 30px; text-align: center; color: #94a3b8; }
        @media (max-width: 768px) { .family-tree-wrapper { padding: 50px 40px 80px; } .person-card { width: 180px; } .family-children { gap: 30px; } }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const treeElement = document.getElementById('family-tree');
            const data = @json($dataPohon);
            const anggotaUtamaId = {{ $anggotaUtama?->id ?? 'null' }};
            const anggotaMap = {};

            data.forEach(function (item) { anggotaMap[item.id] = item; });

            function escapeHtml(value) {
                if (value === null || value === undefined) return '';
                return String(value).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
            }

            function getPerson(id) { return anggotaMap[id] ?? null; }

            function personCard(person, relation) {
                if (!person) return '';
                const photo = person.foto
                    ? `<img src="${escapeHtml(person.foto)}" alt="${escapeHtml(person.nama)}">`
                    : `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-6 w-6 text-slate-400"><circle cx="12" cy="8" r="4"></circle><path d="M5 21a7 7 0 0 1 14 0"></path></svg>`;
                const relationBadge = relation
                    ? `<div><span class="relationship-badge ${relation.status_hubungan === 'suami_istri' ? 'current' : ''}">${relation.status_hubungan === 'mantan' ? 'Mantan Pasangan' : 'Suami / Istri'}</span></div>`
                    : '';
                const description = person.deskripsi
                    ? `<div class="person-description">${escapeHtml(person.deskripsi)}</div>`
                    : '';
                return `<a href="/anggota-keluarga/${person.id}" class="person-card"><div class="person-photo">${photo}</div><div class="person-info"><div class="person-name">${escapeHtml(person.nama)}</div><div class="person-generation">Generasi ${escapeHtml(person.generasi ?? '-')}</div><div class="person-gender">${escapeHtml(person.jenis_kelamin ?? '')}</div>${relationBadge}${description}</div></a>`;
            }

            function getSpouses(person) {
                if (!person || !Array.isArray(person.pasangan)) return [];
                return person.pasangan.map(function (relation) {
                    const spouse = getPerson(relation.id);
                    return spouse ? { person: spouse, relation: relation } : null;
                }).filter(Boolean);
            }

            function coupleHtml(person) {
                let html = `<div class="couple">${personCard(person)}`;
                getSpouses(person).forEach(function (item) {
                    html += `<div class="spouse-unit"><div class="couple-line"></div>${personCard(item.person, item.relation)}</div>`;
                });
                return html + `</div>`;
            }

            function getChildren(person) {
                if (!person || !Array.isArray(person.anak_ids)) return [];
                return person.anak_ids.map(function (id) { return getPerson(id); }).filter(Boolean);
            }

            function getFamilyChildren(person) {
                const children = getChildren(person);
                const seen = new Set(children.map(function (item) { return item.id; }));
                getSpouses(person).forEach(function (item) {
                    getChildren(item.person).forEach(function (child) {
                        if (!seen.has(child.id)) { seen.add(child.id); children.push(child); }
                    });
                });
                return children.sort(function (a, b) {
                    const ga = Number(a.generasi ?? 999), gb = Number(b.generasi ?? 999);
                    if (ga !== gb) return ga - gb;
                    return String(a.nama ?? '').localeCompare(String(b.nama ?? ''));
                });
            }

            function renderFamily(personId, visited = new Set()) {
                const person = getPerson(personId);
                if (!person || visited.has(person.id)) return '';
                const currentVisited = new Set(visited);
                currentVisited.add(person.id);
                getSpouses(person).forEach(function (item) { currentVisited.add(item.person.id); });
                const children = getFamilyChildren(person).filter(function (child) { return !currentVisited.has(child.id); });
                let html = `<div class="family-unit">${coupleHtml(person)}`;
                if (children.length) {
                    html += `<div class="family-children"><div class="children-horizontal-line"></div>`;
                    children.forEach(function (child) { html += `<div class="child-unit">${renderFamily(child.id, new Set(currentVisited))}</div>`; });
                    html += `</div>`;
                }
                return html + `</div>`;
            }

            function findAncestorRoots(startId) {
                const queue = [startId];
                const visited = new Set();
                const roots = [];
                while (queue.length) {
                    const id = queue.shift();
                    if (visited.has(id)) continue;
                    visited.add(id);
                    const person = getPerson(id);
                    if (!person) continue;
                    const parents = Array.isArray(person.orang_tua_ids) ? person.orang_tua_ids.map(getPerson).filter(Boolean) : [];
                    if (!parents.length) { roots.push(person.id); continue; }
                    parents.forEach(function (parent) { if (!visited.has(parent.id)) queue.push(parent.id); });
                }
                return [...new Set(roots)];
            }

            if (!anggotaUtamaId || !anggotaMap[anggotaUtamaId]) {
                treeElement.innerHTML = `<div class="empty-tree">Belum ada data anggota keluarga.</div>`;
                return;
            }

            const roots = findAncestorRoots(anggotaUtamaId);
            const covered = new Set();
            const rootHtml = [];

            roots.forEach(function (rootId) {
                if (covered.has(rootId)) return;
                const root = getPerson(rootId);
                if (!root) return;
                rootHtml.push(`<div class="root-group"><div class="generation-label">Generasi Awal</div>${renderFamily(root.id)}</div>`);
                covered.add(rootId);
                getSpouses(root).forEach(function (item) { covered.add(item.person.id); });
            });

            if (!rootHtml.length) rootHtml.push(renderFamily(anggotaUtamaId));
            treeElement.innerHTML = `<div class="family-tree"><div class="tree-roots">${rootHtml.join('')}</div></div>`;
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    </script>

</x-app-layout>
