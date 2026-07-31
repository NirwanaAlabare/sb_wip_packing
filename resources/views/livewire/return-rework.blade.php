@push('styles')
    <style>
        #product-po + .select2-container .select2-selection__placeholder {
            color: #000 !important;
        }
    </style>
@endpush

<div class="p-3">
    <div class="col-md-12">
        <div class="card h-100">

            <div class="card-header d-flex justify-content-between align-items-center bg-rework text-light">
                <p class="mb-0 fs-5">DEFECT LIST</p>

                <span class="badge bg-light text-dark fs-6">
                    {{ $summary->total() }}
                </span>
            </div>

            <div class="card-body">
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>PO</th>
                            <th>Line</th>
                            <th>Masterplan</th>
                            <th>Size</th>
                            <th>Defect Type</th>
                            <th>Defect Area</th>
                            <th>Gambar</th>
                            <th>Tombol</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($summary->count() < 1)
                            <tr>
                                <td colspan='9'>Defect tidak ditemukan</td>
                            </tr>
                        @else
                            @foreach ($summary as $row)
                                <tr>
                                    <td>{{ $row->updated_at }}</td>
                                    <td>{{ $row->po }}</td>
                                    <td>{{ $row->line_qc_finishing }}</td>
                                    <td>{{ $row->masterplan }}</td>
                                    <td>{{ $row->size }}</td>
                                    <td>{{ $row->defect_type }}</td>
                                    <td>{{ $row->defect_area }}</td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-dark"
                                            wire:click="showDefectAreaImage('{{ $row->gambar }}', {{ $row->defect_area_x }}, {{ $row->defect_area_y }})">
                                            <i class="fa-regular fa-image"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-sm bg-sb-secondary text-light"
                                            onclick="confirmRework({{ $row->id }})">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="mt-2">
                    {{ $summary->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-4">
        <div class="card h-100">

            <div class="card-header d-flex justify-content-between align-items-center bg-rework text-light">
                <p class="mb-0 fs-5">REWORK LIST</p>

                <span class="badge bg-light text-dark fs-6">
                    {{ $summaryRework->total() }}
                </span>
            </div>

            <div class="card-body">
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>PO</th>
                            <th>Line</th>
                            <th>Masterplan</th>
                            <th>Size</th>
                            <th>Defect Type</th>
                            <th>Defect Area</th>
                            <th>Gambar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($summaryRework->count() < 1)
                            <tr>
                                <td colspan='8'>Rework tidak ditemukan</td>
                            </tr>
                        @else
                            @foreach ($summaryRework as $row)
                                <tr>
                                    <td>{{ $row->reworked_at }}</td>
                                    <td>{{ $row->po }}</td>
                                    <td>{{ $row->line_qc_finishing }}</td>
                                    <td>{{ $row->masterplan }}</td>
                                    <td>{{ $row->size }}</td>
                                    <td>{{ $row->defect_type }}</td>
                                    <td>{{ $row->defect_area }}</td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-dark"
                                            wire:click="showDefectAreaImage('{{ $row->gambar }}', {{ $row->defect_area_x }}, {{ $row->defect_area_y }})">
                                            <i class="fa-regular fa-image"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="mt-2">
                    {{ $summaryRework->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<a href="{{ url('/') }}" class="back bg-sb-secondary text-light text-center w-auto">
    <i class="fa-regular fa-reply"></i>
</a>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {

        });


        document.addEventListener("DOMContentLoaded", function () {
        });

        document.addEventListener("livewire:load", function () {
            Livewire.hook('message.processed', (message, component) => {
            });
        });

        Livewire.on('resetSelect2', () => {
        });

        Livewire.on('afterSave', () => {
        });

        Livewire.on('reloadPage', () => {
            location.reload();
        });
        
        // function confirmRework(id) {
        //     Swal.fire({
        //         title: 'Konfirmasi Proses',
        //         text: 'Apakah Anda yakin ingin memproses defect ini ke tahap Rework?',
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#198754',
        //         cancelButtonColor: '#6c757d',
        //         confirmButtonText: 'Ya, lanjutkan',
        //         cancelButtonText: 'Batal'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             Livewire.emit('openDefectModal', id);
        //         }
        //     });
        // }

        function confirmRework(id) {
            Livewire.emit('checkDefectBeforeRework', id);
        }

        Livewire.on('showError', function (message) {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak dapat diproses',
                text: message
            });
        });

        Livewire.on('showConfirmRework', function (id) {
            Swal.fire({
                title: 'Konfirmasi Proses',
                text: 'Apakah Anda yakin ingin memproses defect ini ke tahap Rework?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('openDefectModal', id);
                }
            });
        });
    </script>
@endpush
