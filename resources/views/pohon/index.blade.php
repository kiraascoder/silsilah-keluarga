<x-app-layout title="Pohon Silsilah">

    <div class="max-w-7xl mx-auto">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <div class="mb-8 flex items-start justify-between gap-4">

            <div>
                <h1 class="text-3xl font-bold text-slate-900">
                    Pohon Silsilah
                </h1>

                <p class="text-slate-500 mt-1">
                    Struktur hubungan keluarga
                    {{ $keluargaAktif->nama_keluarga }}.
                </p>
            </div>

            <a href="{{ route('anggota.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">

                    <path d="M12 5v14" />
                    <path d="M5 12h14" />

                </svg>

                Tambah Anggota
            </a>

        </div>


        {{-- =========================================================
            KEPALA KELUARGA
        ========================================================== --}}
        @if ($anggotaUtama)
            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Titik Utama
                        </p>

                        <p class="mt-1 text-sm text-slate-500">
                            Pohon dimulai dari anggota utama keluarga.
                        </p>

                    </div>

                    <a href="{{ route('anggota.show', $anggotaUtama->id) }}"
                        class="text-sm font-medium text-blue-600 hover:text-blue-700">

                        Lihat Detail

                    </a>

                </div>

            </div>
        @endif


        {{-- =========================================================
            POHON
        ========================================================== --}}
        <div class="rounded-2xl border border-slate-200 bg-white overflow-hidden">

            <div class="border-b border-slate-200 px-6 py-5">

                <div class="flex items-center justify-between gap-4">

                    <div>

                        <h2 class="text-lg font-bold text-slate-900">
                            Struktur Keluarga
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            {{ $anggota->count() }} anggota terdaftar.
                        </p>

                    </div>

                    <div class="text-xs text-slate-400">
                        Gunakan scroll horizontal untuk melihat pohon yang besar.
                    </div>

                </div>

            </div>


            {{-- Canvas --}}
            <div id="family-tree" class="family-tree-wrapper"></div>

        </div>

    </div>


    <style>
        /* =========================================================
           WRAPPER
        ========================================================== */

        .family-tree-wrapper {
            width: 100%;
            min-height: 700px;
            overflow: auto;
            padding: 80px;
            background:
                radial-gradient(circle at 1px 1px,
                    #e2e8f0 1px,
                    transparent 0);
            background-size: 24px 24px;
        }


        /* =========================================================
           TREE
        ========================================================== */

        .family-tree {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: max-content;
        }


        /* =========================================================
           GENERATION
        ========================================================== */

        .generation-label {
            margin-bottom: 30px;
            text-align: center;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #94a3b8;
        }


        /* =========================================================
           FAMILY UNIT
        ========================================================== */

        .family-unit {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }


        /* =========================================================
           COUPLE
        ========================================================== */

        .couple {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            position: relative;
        }


        .couple-line {
            width: 35px;
            height: 2px;
            background: #94a3b8;
            flex-shrink: 0;
        }


        /* =========================================================
           PERSON CARD
        ========================================================== */

        .person-card {
            width: 190px;
            min-height: 92px;

            background: #ffffff;

            border: 1px solid #cbd5e1;
            border-radius: 16px;

            padding: 12px;

            display: flex;
            align-items: center;
            gap: 12px;

            box-shadow:
                0 4px 12px rgba(15, 23, 42, 0.06);

            text-decoration: none;

            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                transform .2s ease;

            position: relative;
            z-index: 2;
        }


        .person-card:hover {
            border-color: #3b82f6;

            box-shadow:
                0 8px 20px rgba(37, 99, 235, 0.12);

            transform: translateY(-2px);
        }


        /* =========================================================
           PERSON PHOTO
        ========================================================== */

        .person-photo {
            width: 48px;
            height: 48px;

            flex-shrink: 0;

            border-radius: 9999px;

            overflow: hidden;

            background: #f1f5f9;

            display: flex;
            align-items: center;
            justify-content: center;
        }


        .person-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }


        /* =========================================================
           PERSON INFO
        ========================================================== */

        .person-info {
            min-width: 0;
        }


        .person-name {
            font-size: 13px;
            line-height: 1.35;
            font-weight: 700;
            color: #0f172a;

            word-break: break-word;
        }


        .person-generation {
            margin-top: 3px;
            font-size: 11px;
            color: #64748b;
        }


        .person-gender {
            margin-top: 2px;
            font-size: 10px;
            color: #94a3b8;
            text-transform: capitalize;
        }


        /* =========================================================
           CHILDREN AREA
        ========================================================== */

        .family-children {
            position: relative;

            margin-top: 65px;

            display: flex;
            justify-content: center;
            align-items: flex-start;

            gap: 55px;

            padding-top: 42px;
        }


        /* Garis vertikal dari pasangan ke anak */

        .family-children::before {
            content: "";

            position: absolute;

            top: 0;
            left: 50%;

            width: 2px;
            height: 42px;

            background: #94a3b8;

            transform: translateX(-50%);
        }


        /* =========================================================
           GARIS HORIZONTAL ANAK
        ========================================================== */

        .children-horizontal-line {
            position: absolute;

            top: 42px;

            left: 0;
            right: 0;

            height: 2px;

            background: #94a3b8;
        }


        /* =========================================================
           CHILD UNIT
        ========================================================== */

        .child-unit {
            position: relative;

            padding-top: 42px;

            display: flex;
            flex-direction: column;
            align-items: center;
        }


        /* Garis vertikal ke kartu anak */

        .child-unit::before {
            content: "";

            position: absolute;

            top: 0;
            left: 50%;

            width: 2px;
            height: 42px;

            background: #94a3b8;

            transform: translateX(-50%);
        }


        /* =========================================================
           LEVEL GENERATION
        ========================================================== */

        .generation-block {
            display: flex;
            flex-direction: column;
            align-items: center;

            margin-bottom: 70px;
        }


        /* =========================================================
           EMPTY
        ========================================================== */

        .empty-tree {
            min-width: 350px;

            padding: 70px 30px;

            text-align: center;

            color: #94a3b8;
        }


        /* =========================================================
           MOBILE
        ========================================================== */

        @media (max-width: 768px) {

            .family-tree-wrapper {
                padding: 40px;
            }

            .person-card {
                width: 160px;
            }

            .family-children {
                gap: 30px;
            }

        }
    </style>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const treeElement =
                document.getElementById('family-tree');

            const data =
                @json($dataPohon);

            const anggotaUtamaId =
                {{ $anggotaUtama?->id ?? 'null' }};


            /* =====================================================
               MAP ANGGOTA
            ====================================================== */

            const anggotaMap = {};

            data.forEach(function(item) {

                anggotaMap[item.id] = item;

            });


            /* =====================================================
               ESCAPE HTML
            ====================================================== */

            function escapeHtml(value) {

                if (
                    value === null ||
                    value === undefined
                ) {
                    return '';
                }

                return String(value)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');

            }


            /* =====================================================
               GET PERSON
            ====================================================== */

            function getPerson(id) {

                return anggotaMap[id] ?? null;

            }


            /* =====================================================
               PERSON CARD
            ====================================================== */

            function personCard(person) {

                if (!person) {
                    return '';
                }


                const photo = person.foto

                    ?
                    `
                        <img
                            src="${escapeHtml(person.foto)}"
                            alt="${escapeHtml(person.nama)}"
                        >
                    `

                    :
                    `
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            class="h-6 w-6 text-slate-400"
                        >
                            <circle
                                cx="12"
                                cy="8"
                                r="4">
                            </circle>

                            <path
                                d="M5 21a7 7 0 0 1 14 0">
                            </path>
                        </svg>
                    `;


                return `
                    <a
                        href="/anggota-keluarga/${person.id}"
                        class="person-card"
                    >

                        <div class="person-photo">
                            ${photo}
                        </div>

                        <div class="person-info">

                            <div class="person-name">
                                ${escapeHtml(person.nama)}
                            </div>

                            <div class="person-generation">
                                Generasi ${escapeHtml(
                                    person.generasi ?? '-'
                                )}
                            </div>

                            <div class="person-gender">
                                ${escapeHtml(
                                    person.jenis_kelamin ?? ''
                                )}
                            </div>

                        </div>

                    </a>
                `;

            }


            /* =====================================================
               COUPLE
            ====================================================== */

            function coupleHtml(person) {

                if (!person) {
                    return '';
                }


                let html = `
                    <div class="couple">

                        ${personCard(person)}
                `;


                /*
                |--------------------------------------------------------------------------
                | Cari pasangan berdasarkan pasangan_id
                |--------------------------------------------------------------------------
                */

                let pasangan = null;

                if (person.pasangan_id) {

                    pasangan =
                        getPerson(person.pasangan_id);

                }


                /*
                |--------------------------------------------------------------------------
                | Tampilkan pasangan
                |--------------------------------------------------------------------------
                */

                if (pasangan) {

                    html += `
                        <div class="couple-line"></div>

                        ${personCard(pasangan)}
                    `;

                }


                html += `
                    </div>
                `;


                return html;

            }


            /* =====================================================
               GET CHILDREN
            ====================================================== */

            function getChildren(person) {

                if (
                    !person ||
                    !person.anak_ids
                ) {
                    return [];
                }


                return person.anak_ids

                    .map(function(id) {

                        return getPerson(id);

                    })

                    .filter(Boolean)

                    .sort(function(a, b) {

                        const generationA =
                            Number(a.generasi ?? 999);

                        const generationB =
                            Number(b.generasi ?? 999);


                        if (
                            generationA !==
                            generationB
                        ) {

                            return generationA -
                                generationB;

                        }


                        return String(
                            a.nama ?? ''
                        ).localeCompare(
                            String(b.nama ?? '')
                        );

                    });

            }


            /* =====================================================
               GET FAMILY CHILDREN
            ====================================================== */

            function getFamilyChildren(person) {

                if (!person) {
                    return [];
                }


                let children =
                    getChildren(person);


                /*
                |--------------------------------------------------------------------------
                | Anak pasangan
                |--------------------------------------------------------------------------
                */

                if (person.pasangan_id) {

                    const pasangan =
                        getPerson(
                            person.pasangan_id
                        );


                    if (pasangan) {

                        const pasanganChildren =
                            getChildren(pasangan);


                        pasanganChildren.forEach(
                            function(child) {

                                if (
                                    !children.some(
                                        function(item) {
                                            return item.id ===
                                                child.id;
                                        }
                                    )
                                ) {

                                    children.push(child);

                                }

                            }
                        );

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | Hilangkan duplikasi
                |--------------------------------------------------------------------------
                */

                const unique = [];

                const ids = new Set();


                children.forEach(
                    function(child) {

                        if (!ids.has(child.id)) {

                            ids.add(child.id);

                            unique.push(child);

                        }

                    }
                );


                return unique;

            }


            /* =====================================================
               RENDER FAMILY
            ====================================================== */

            function renderFamily(
                personId,
                visited = new Set()
            ) {

                const person =
                    getPerson(personId);


                if (!person) {
                    return '';
                }


                /*
                |--------------------------------------------------------------------------
                | Jangan render orang yang sudah diproses
                |--------------------------------------------------------------------------
                */

                if (visited.has(person.id)) {
                    return '';
                }


                const currentVisited =
                    new Set(visited);

                currentVisited.add(person.id);


                /*
                |--------------------------------------------------------------------------
                | Pasangan
                |--------------------------------------------------------------------------
                */

                let pasangan = null;


                if (person.pasangan_id) {

                    pasangan =
                        getPerson(
                            person.pasangan_id
                        );

                }


                if (pasangan) {

                    currentVisited.add(
                        pasangan.id
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Anak
                |--------------------------------------------------------------------------
                */

                let children =
                    getFamilyChildren(person);


                /*
                |--------------------------------------------------------------------------
                | Hilangkan anggota yang sudah
                | berada pada jalur sebelumnya
                |--------------------------------------------------------------------------
                */

                children =
                    children.filter(
                        function(child) {

                            return !currentVisited.has(
                                child.id
                            );

                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | FAMILY UNIT
                |--------------------------------------------------------------------------
                */

                let html = `
                    <div class="family-unit">

                        ${coupleHtml(person)}
                `;


                /*
                |--------------------------------------------------------------------------
                | Anak
                |--------------------------------------------------------------------------
                */

                if (children.length > 0) {

                    html += `
                        <div class="family-children">

                            <div class="children-horizontal-line"></div>
                    `;


                    children.forEach(
                        function(child) {

                            html += `
                                <div class="child-unit">

                                    ${renderFamily(
                                        child.id,
                                        new Set(currentVisited)
                                    )}

                                </div>
                            `;

                        }
                    );


                    html += `
                        </div>
                    `;

                }


                html += `
                    </div>
                `;


                return html;

            }


            /* =====================================================
               EMPTY STATE
            ====================================================== */

            if (
                !anggotaUtamaId ||
                !anggotaMap[anggotaUtamaId]
            ) {

                treeElement.innerHTML = `
                    <div class="empty-tree">
                        Belum ada data anggota keluarga.
                    </div>
                `;

                return;

            }


            /* =====================================================
               RENDER TREE
            ====================================================== */

            treeElement.innerHTML = `

                <div class="family-tree">

                    <div class="generation-label">
                        Generasi Utama
                    </div>

                    ${renderFamily(
                        anggotaUtamaId,
                        new Set()
                    )}

                </div>

            `;

        });
    </script>

</x-app-layout>
